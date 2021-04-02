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
    !isset($rawData->companyname) ||
    !isset($rawData->name) ||
    !isset($rawData->password) ||
    !isset($rawData->mobile)) {
    UtilityFunction::sendResponse(false, 400, "Not all the required details are sent in the request body ");
    exit;
}

if (strlen($rawData->email) < 1 ||
    strlen($rawData->companyname) < 1 ||
    strlen($rawData->name) < 1 ||
    strlen($rawData->password) < 1 ||
    strlen($rawData->mobile) < 1) {
    UtilityFunction::sendResponse(false, 400, "All the details are mandatory");
    exit;
}

if (!filter_var($rawData->email, FILTER_VALIDATE_EMAIL)) {
    UtilityFunction::sendResponse(false, 400, "Not a valid email");
    exit;
}

if (strlen($rawData->mobile) < 10 || strlen($rawData->mobile) > 10) {
    UtilityFunction::sendResponse(false, 400, "Not a valid mobile number");
    exit;
}

$email = trim($rawData->email);
$companyname = trim($rawData->companyname);
$name = trim($rawData->name);
$password = $rawData->password;
$mobile = $rawData->mobile;
try {
    $sql = $writeDb->prepare('select Email from profile where Email = :email and Company= :company');
    $sql->bindParam(':email', $email, PDO::PARAM_STR);
    $sql->bindParam(':company', $companyname, PDO::PARAM_STR);

    $sql->execute();
    if ($sql->rowCount() !== 0) {
        UtilityFunction::sendResponse(false, 409, "User with the same email id for the company already registered");
        exit;
    }
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    $writeDb->beginTransaction();
    $insertQuery = $writeDb->prepare('insert into profile (Name, Company, Email, Mobile) values(:name, :company, :email, :mobile)');
    $insertQuery->bindParam(':name', $name, PDO::PARAM_STR);
    $insertQuery->bindParam(':company', $companyname, PDO::PARAM_STR);
    $insertQuery->bindParam(':email', $email, PDO::PARAM_STR);
    $insertQuery->bindParam(':mobile', $mobile, PDO::PARAM_STR);
    $insertQuery->execute();
    if ($insertQuery->rowCount() === 0) {
        UtilityFunction::sendResponse(false, 500, "Trouble creating user account. Please try again later.");
        exit;
    }

    $loginInsert = $writeDb->prepare('insert into login (Email, Password) values(:email, :password)');
    $loginInsert->bindParam(':email', $email, PDO::PARAM_STR);
    $loginInsert->bindParam(':password', $passwordHash, PDO::PARAM_STR);
    $loginInsert->execute();
    if ($loginInsert->rowCount() === 0) {
        UtilityFunction::sendResponse(false, 500, "Trouble creating user account. Please try again later.");
        exit;
    }
    $writeDb->commit();
    UtilityFunction::sendResponse(true, 201, "Account Created Successfully");
    exit;
} catch (PDOException $ex) {
    $writeDb->rollBack();
    error_log("Database query error " . $ex, 0);
    UtilityFunction::sendResponse(false, 500, "Trouble creating user account. Please try again later. ". $ex);
    exit;
}
