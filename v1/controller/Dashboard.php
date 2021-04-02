<?php
require_once '../utilities/DBUtils.php';
require_once '../utilities/UtilityFunctions.php';
require_once '../model/Dashboard.php';

try {
    $writeDb = DBUtils::connectWriteDB();
    $readDb = DBUtils::connectReadDB();
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
if (!isset($rawData->from) ||
    !isset($rawData->to)) {
    UtilityFunction::sendResponse(false, 400, "Not all the required details are sent in the request body ");
    exit;
}
if (strlen($rawData->from) < 1 ||
    strlen($rawData->to) < 1) {
    UtilityFunction::sendResponse(false, 400, "All the details are mandatory");
    exit;
}

$from = trim($rawData->from);
$to = trim($rawData->to);

try {
    $sql = $readDb->prepare("SELECT count(*) as totalcount, sum(Price) as totalamount FROM activities where Category = 'in' and type = 'sales in' and Date between :from and :to");
    $sql->bindParam(':from', $from, PDO::PARAM_STR);
    $sql->bindParam(':to', $to, PDO::PARAM_STR);
    $sql->execute();

    $sql1 = $readDb->prepare("SELECT count(*) as totalcount, sum(Price) as totalamount FROM activities where Category = 'out' and type = 'sales out' and Date between :from and :to");
    $sql1->bindParam(':from', $from, PDO::PARAM_STR);
    $sql1->bindParam(':to', $to, PDO::PARAM_STR);
    $sql1->execute();

    $sql2 = $readDb->prepare("SELECT count(*) as totalcount, sum(Price) as totalamount FROM activities where Category = 'in' and type = 'service in' and Date between :from and :to");
    $sql2->bindParam(':from', $from, PDO::PARAM_STR);
    $sql2->bindParam(':to', $to, PDO::PARAM_STR);
    $sql2->execute();

    $sql3 = $readDb->prepare("SELECT count(*) as totalcount, sum(Price) as totalamount FROM activities where Category = 'out' and type = 'service out' and Date between :from and :to");
    $sql3->bindParam(':from', $from, PDO::PARAM_STR);
    $sql3->bindParam(':to', $to, PDO::PARAM_STR);
    $sql3->execute();

    $sql4 = $readDb->prepare("SELECT sum(price) as totalexpense FROM `expense` where date between :from and :to");
    $sql4->bindParam(':from', $from, PDO::PARAM_STR);
    $sql4->bindParam(':to', $to, PDO::PARAM_STR);
    $sql4->execute();


    $dashboardArray = array();
    $data = new Dashboard();
    while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
        $data->setSalesInCount($row['totalcount']);
        $data->setSalesInAmount($row['totalamount']);
    }
    while ($row = $sql1->fetch(PDO::FETCH_ASSOC)) {
        $data->setSalesOutCount($row['totalcount']);
        $data->setSalesOutAmount($row['totalamount']);
    }
    while ($row = $sql2->fetch(PDO::FETCH_ASSOC)) {
        $data->setServiceInCount($row['totalcount']);
        $data->setServiceInAmount($row['totalamount']);
    }
    while ($row = $sql3->fetch(PDO::FETCH_ASSOC)) {
        $data->setServiceOutCount($row['totalcount']);
        $data->setServiceOutAmount($row['totalamount']);
    }
    while ($row = $sql4->fetch(PDO::FETCH_ASSOC)) {
        $data->setTotalExpense($row['totalexpense']);
    }
    $dashboardArray[] = UtilityFunction::getDashboardDataArray($data);
    UtilityFunction::sendResponse(true, 200, "dashboard found", true, $dashboardArray);
    exit;
} catch (PDOException $ex) {
    error_log("Database query error " . $ex, 0);
    UtilityFunction::sendResponse(false, 500, "Trouble dashboard activities details. Please try again later. " . $ex);
    exit;
}
