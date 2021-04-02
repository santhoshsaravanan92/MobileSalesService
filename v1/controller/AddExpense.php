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

if (!isset($rawData->date) ||
    !isset($rawData->category) ||
    !isset($rawData->price) ||
    !isset($rawData->notes) ||
    !isset($rawData->createdby)) {
    UtilityFunction::sendResponse(false, 400, "Not all the required details are sent in the request body ");
    exit;
}

if (strlen($rawData->date) < 1 ||
    strlen($rawData->category) < 1 ||
    strlen($rawData->price) < 1 ||
    strlen($rawData->notes) < 1 ||
    strlen($rawData->createdby) < 1) {
    UtilityFunction::sendResponse(false, 400, "All the details are mandatory");
    exit;
}

$date = trim($rawData->date);
$category = trim($rawData->category);
$price = trim($rawData->price);
$notes = trim($rawData->notes);
$createdby = trim($rawData->createdby);

try {
    $insertQuery = $writeDb->prepare('INSERT INTO `expense`(`date`, `category`, `price`, `notes`, `createdby`) VALUES (:date, :category, :price, :notes, :createdby)');
    $insertQuery->bindParam(':date', $date, PDO::PARAM_STR);
    $insertQuery->bindParam(':category', $category, PDO::PARAM_STR);
    $insertQuery->bindParam(':price', $price, PDO::PARAM_STR);
    $insertQuery->bindParam(':notes', $notes, PDO::PARAM_STR);
    $insertQuery->bindParam(':createdby', $createdby, PDO::PARAM_STR);
    $insertQuery->execute();
    if ($insertQuery->rowCount() === 0) {
        UtilityFunction::sendResponse(false, 500, "Trouble creating expense. Please try again later.");
        exit;
    }
    UtilityFunction::sendResponse(true, 201, "Expense Created Successfully");
    exit;
} catch (PDOException $ex) {
    $writeDb->rollBack();
    error_log("Database query error " . $ex, 0);
    UtilityFunction::sendResponse(false, 500, "Trouble creating expense. Please try again later. " . $ex);
    exit;
}
