<?php
require_once '../utilities/DBUtils.php';
require_once '../utilities/UtilityFunctions.php';
require_once '../model/Profile.php';

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

    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        try {
            $sql = $readDb->prepare('select * from profile where ID= :id');
            $sql->bindParam(':id', $id, PDO::PARAM_INT);

            $sql->execute();
            if ($sql->rowCount() === 0) {
                UtilityFunction::sendResponse(false, 404, "User not found in the application");
                exit;
            }
            $data = new Profile();
            while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
                $data->setId($row['ID']);
                $data->setEmail($row['Name']);
                $data->setCompany($row['Company']);
                $data->setName($row['Email']);
                $data->setMobile($row['Mobile']);
                $data->setAddress($row['Address']);
                $data->setGST($row['GST']);
                $data->setLandline($row['Landline']);
                $data->setWebsite($row['Website']);
                $data->setAccountNumber($row['AccountNumber']);
                $data->setBranchName($row['Branchname']);
                $data->setBankName($row['Bankname']);
                $data->setIfsc($row['Ifsc']);
            }
            UtilityFunction::sendResponse(true, 200, "user found", true, json_encode($data));
            exit;

        } catch (PDOException $ex) {
            error_log("Database query error " . $ex, 0);
            UtilityFunction::sendResponse(false, 500, "Trouble fetching user details. Please try again later. " . $ex);
            exit;
        }
    } else {
        UtilityFunction::sendResponse(false, 405, "Request Method not allowed");
        exit;
    }
}
