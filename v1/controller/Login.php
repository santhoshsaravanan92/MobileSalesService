<?php
require_once '../utilities/DBUtils.php';
require_once '../utilities/UtilityFunctions.php';

try {
    $writeDb = DBUtils::connectWriteDB();
} catch (PDOException $ex) {
    error_log("Error while connecting to DB " . $ex, 0);
    UtilityFunction::sendResponse(false, 500, "Database Connection Error");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    UtilityFunction::sendResponse(false, 405, "Requested method not allowed");
    exit;
}

if ($_SERVER['CONTENT_TYPE'] !== 'application/json') {
    UtilityFunction::sendResponse(false, 400, "Not a valid JSON");
    exit;
}

$rawPostData = file_get_contents('php://input');

if (!$rawData = json_decode($rawPostData)) {
    UtilityFunction::sendResponse(false, 400, "Not a valid JSON");
    exit;
}

if (!isset($rawData->email) ||
    !isset($rawData->password)) {
    UtilityFunction::sendResponse(false, 400, "Not all the required details are sent in the request body ");
    exit;
}

if (strlen($rawData->email) < 1 ||
    strlen($rawData->password) < 1) {
    UtilityFunction::sendResponse(false, 400, "All the details are mandatory");
    exit;
}

if (!filter_var($rawData->email, FILTER_VALIDATE_EMAIL)) {
    UtilityFunction::sendResponse(false, 400, "Not a valid email");
    exit;
}

$email = trim($rawData->email);
$sql = $writeDb->prepare('select Email, Password, IsSlave from login where Email = :email');
$sql->bindParam(':email', $email, PDO::PARAM_STR);
$sql->execute();

if ($sql->rowCount() === 0) {
    UtilityFunction::sendResponse(false, 401, "Invalid Username and password");
    exit;
}

$row = $sql->fetch(PDO::FETCH_ASSOC);
if (!password_verify($rawData->password, $row['Password'])) {
    UtilityFunction::sendResponse(false, 401, "Invalid Username and password");
    exit;
}

$a = base64_encode(bin2hex(openssl_random_pseudo_bytes(30)) . time() . "gotecdevelopersteam");

UtilityFunction::sendResponse(true, 200, "Login Success", true, $a);
