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
    !isset($rawData->type) ||
    !isset($rawData->category) ||
    !isset($rawData->model) ||
    !isset($rawData->imei) ||
    !isset($rawData->storage) ||
    !isset($rawData->ram) ||
    !isset($rawData->color) ||
    !isset($rawData->phone) ||
    !isset($rawData->price) ||
    !isset($rawData->client) ||
    !isset($rawData->addedby)) {
    UtilityFunction::sendResponse(false, 400, "Not all the required details are sent in the request body ");
    exit;
}

if (strlen($rawData->date) < 1 ||
    strlen($rawData->type) < 1 ||
    strlen($rawData->category) < 1 ||
    strlen($rawData->model) < 1 ||
    strlen($rawData->imei) < 1 ||
    strlen($rawData->storage) < 1 ||
    strlen($rawData->ram) < 1 ||
    strlen($rawData->color) < 1 ||
    strlen($rawData->phone) < 1 ||
    strlen($rawData->price) < 1 ||
    strlen($rawData->client) < 1 ||
    strlen($rawData->addedby) < 1) {
    UtilityFunction::sendResponse(false, 400, "All the details are mandatory");
    exit;
}

$date = trim($rawData->date);
$type = trim($rawData->type);
$category = trim($rawData->category);
$model = trim($rawData->model);
$imei = trim($rawData->imei);
$storage = trim($rawData->storage);
$ram = trim($rawData->ram);
$color = trim($rawData->color);
$phone = trim($rawData->phone);
$price = trim($rawData->price);
$client = trim($rawData->client);
$addedby = trim($rawData->addedby);
$notes = trim($rawData->notes);

try {
    $insertQuery = $writeDb->prepare('INSERT INTO `activities`(`Date`, `Type`, `Category`, `Model`, `IMEI`, `Storage`, `RAM`, `Color`, `Client`, `Phone`, `Price`, `Notes`, `AddedBy`) VALUES (:date,:type,:category,:model,:imei,:storage,:ram,:color,:client,:phone,:price,:notes,:addedby)');

    $insertQuery->bindParam(':date', $date, PDO::PARAM_STR);
    $insertQuery->bindParam(':type', $type, PDO::PARAM_STR);
    $insertQuery->bindParam(':category', $category, PDO::PARAM_STR);
    $insertQuery->bindParam(':model', $model, PDO::PARAM_STR);
    $insertQuery->bindParam(':imei', $imei, PDO::PARAM_STR);
    $insertQuery->bindParam(':storage', $storage, PDO::PARAM_STR);
    $insertQuery->bindParam(':ram', $ram, PDO::PARAM_STR);
    $insertQuery->bindParam(':color', $color, PDO::PARAM_STR);
    $insertQuery->bindParam(':client', $client, PDO::PARAM_STR);
    $insertQuery->bindParam(':phone', $phone, PDO::PARAM_STR);
    $insertQuery->bindParam(':price', $price, PDO::PARAM_STR);
    $insertQuery->bindParam(':notes', $notes, PDO::PARAM_STR);
    $insertQuery->bindParam(':addedby', $addedby, PDO::PARAM_STR);
    
    $insertQuery->execute();
    if ($insertQuery->rowCount() === 0) {
        UtilityFunction::sendResponse(false, 500, "Trouble creating Activities. Please try again later.");
        exit;
    }

    UtilityFunction::sendResponse(true, 201, "Activities Created Successfully");
    exit;
} catch (PDOException $ex) {
    error_log("Database query error " . $ex, 0);
    UtilityFunction::sendResponse(false, 500, "Trouble creating activities. Please try again later. ". $ex);
    exit;
}
