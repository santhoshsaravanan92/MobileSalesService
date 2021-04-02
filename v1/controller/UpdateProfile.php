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

if ($_SERVER['REQUEST_METHOD'] !== 'PUT') {
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
    !isset($rawData->mobile)) {
    UtilityFunction::sendResponse(false, 400, "Not all the required details are sent in the request body ");
    exit;
}

if (strlen($rawData->email) < 1 ||
    strlen($rawData->companyname) < 1 ||
    strlen($rawData->name) < 1 ||
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
$mobile = trim($rawData->mobile);
$address = trim($rawData->address);
$gst = trim($rawData->gst);
$landline = trim($rawData->landline);
$website = trim($rawData->website);
$accountNumber = trim($rawData->accountnumber);
$branchName = trim($rawData->branchname);
$bankName = trim($rawData->bankname);
$ifsc = trim($rawData->ifsc);
$id = trim($rawData->id);

try {
    $updateQuery = $writeDb->prepare('update profile set Name = :name, Company=:company, Email=:email, Mobile=:mobile, Address=:address, GST=:gst, Landline=:landline, Website=:website, AccountNumber=:accountnumber, BranchName=:branchname, Bankname=:bankname, Ifsc=:ifsc where ID=:id');
    $updateQuery->bindParam(':name', $name, PDO::PARAM_STR);
    $updateQuery->bindParam(':company', $companyname, PDO::PARAM_STR);
    $updateQuery->bindParam(':email', $email, PDO::PARAM_STR);
    $updateQuery->bindParam(':mobile', $mobile, PDO::PARAM_STR);
    $updateQuery->bindParam(':address', $address, PDO::PARAM_STR);
    $updateQuery->bindParam(':gst', $gst, PDO::PARAM_STR);
    $updateQuery->bindParam(':landline', $landline, PDO::PARAM_STR);
    $updateQuery->bindParam(':website', $website, PDO::PARAM_STR);
    $updateQuery->bindParam(':accountnumber', $accountNumber, PDO::PARAM_STR);
    $updateQuery->bindParam(':branchname', $branchName, PDO::PARAM_STR);
    $updateQuery->bindParam(':bankname', $bankName, PDO::PARAM_STR);
    $updateQuery->bindParam(':ifsc', $ifsc, PDO::PARAM_STR);
    $updateQuery->bindParam(':id', $id, PDO::PARAM_INT);

    $updateQuery->execute();
    if ($updateQuery->rowCount() === 0) {
        UtilityFunction::sendResponse(false, 500, "Trouble updating user account. Please try again later.");
        exit;
    }
    UtilityFunction::sendResponse(true, 200, "Account Updated Successfully");
    exit;
} catch (PDOException $ex) {
    error_log("Database query error " . $ex, 0);
    UtilityFunction::sendResponse(false, 500, "Trouble updating user account. Please try again later. ". $ex);
    exit;
}