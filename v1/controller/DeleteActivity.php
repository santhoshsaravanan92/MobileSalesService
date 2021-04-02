<?php
require_once '../utilities/DBUtils.php';
require_once '../utilities/UtilityFunctions.php';

try {
    $writeDb = DBUtils::connectWriteDB();
    $readDb = DBUtils::connectReadDB();
} catch (PDOException $ex) {
    error_log("Error while connecting to DB " . $ex, 0);
    UtilityFunction::sendResponse(false, 500, "Database Connection Error");
    exit;
}

if (array_key_exists('id', $_GET)) {
    $id = $_GET['id'];
    if ($id == '' || !is_numeric($id)) {
        UtilityFunction::sendResponse(false, 400, "Id is required and it should be a numeric");
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
        try {
            $sql = $writeDb->prepare('delete from activities where ID= :id');
            $sql->bindParam(':id', $id, PDO::PARAM_INT);

            $sql->execute();
            if ($sql->rowCount() === 0) {
                UtilityFunction::sendResponse(false, 404, "activities not found in the application");
                exit;
            }
            UtilityFunction::sendResponse(true, 200, "activities deleted successfully");
            exit;
        } catch (PDOException $ex) {
            error_log("Database query error " . $ex, 0);
            UtilityFunction::sendResponse(false, 500, "Trouble fetching activity details. Please try again later. " . $ex);
            exit;
        }
    } else {
        UtilityFunction::sendResponse(false, 405, "Request Method not allowed");
        exit;
    }
}
