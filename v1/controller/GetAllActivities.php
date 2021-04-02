<?php
require_once '../utilities/DBUtils.php';
require_once '../utilities/UtilityFunctions.php';
require_once '../model/Activities.php';

try {
    $writeDb = DBUtils::connectWriteDB();
    $readDb = DBUtils::connectReadDB();
} catch (PDOException $ex) {
    error_log("Error while connecting to DB " . $ex, 0);
    UtilityFunction::sendResponse(false, 500, "Database Connection Error");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    UtilityFunction::sendResponse(false, 405, "Requested method not allowed");
    exit;
}

try {
    $sql = $readDb->prepare('select * from activities order by AddedDate desc');
    $sql->execute();

    if ($sql->rowCount() === 0) {
        UtilityFunction::sendResponse(false, 404, "Activities not found in the application");
        exit;
    }
    
    $activitiesArray = array();
    while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
        $data = new Activities();
        $data->setID($row['id']);
        $data->setDate($row['Date']);
        $data->setType($row['Type']);
        $data->setCategory($row['Category']);
        $data->setModel($row['Model']);
        $data->setImei($row['IMEI']);
        $data->setStorage($row['Storage']);
        $data->setRam($row['RAM']);
        $data->setColor($row['Color']);
        $data->setClient($row['Client']);
        $data->setPhone($row['Phone']);
        $data->setPrice($row['Price']);
        $data->setNotes($row['Notes']);
        $data->setAddedby($row['AddedBy']);

        $activitiesArray[] = UtilityFunction::getActivitiesArray($data);
    }
    UtilityFunction::sendResponse(true, 200, "Activities found", true, $activitiesArray);
    exit;

} catch (PDOException $ex) {
    error_log("Database query error " . $ex, 0);
    UtilityFunction::sendResponse(false, 500, "Trouble fetching activities details. Please try again later. " . $ex);
    exit;
}