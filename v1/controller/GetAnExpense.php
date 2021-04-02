<?php
require_once '../utilities/DBUtils.php';
require_once '../utilities/UtilityFunctions.php';
require_once '../model/Expense.php';

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
    if (array_key_exists('id', $_GET)) {
        $id = $_GET['id'];
        if ($id == '' || !is_numeric($id)) {
            UtilityFunction::sendResponse(false, 400, "Id is required and it should be a numeric");
            exit;
        }

        $sql = $readDb->prepare('select * from expense where id = :id order by CreatedDate desc');
        $sql->bindParam(':id', $id, PDO::PARAM_INT);
        $sql->execute();

        if ($sql->rowCount() === 0) {
            UtilityFunction::sendResponse(false, 404, "expense not found in the application");
            exit;
        }

        $expensesArray = array();
        while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
            $data = new Expense();
            $data->setId($row['id']);
            $data->setDate($row['date']);
            $data->setCategory($row['category']);
            $data->setPrice($row['price']);
            $data->setNotes($row['notes']);
            $expensesArray[] = UtilityFunction::getExpensesArray($data);
        }
        UtilityFunction::sendResponse(true, 200, "Expense details found", true, $expensesArray);
        exit;
    }
} catch (PDOException $ex) {
    error_log("Database query error " . $ex, 0);
    UtilityFunction::sendResponse(false, 500, "Trouble fetching expense details. Please try again later. " . $ex);
    exit;
}
