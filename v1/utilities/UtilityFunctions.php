<?php
require_once('../model/Response.php');
require_once('../model/Activities.php');
require_once('../model/Expense.php');
class UtilityFunction {
    public static function sendResponse($isSuccess, $statucCode, $message, $isDataAvailable = false, $data = '') {
        $responseObj = new Response();    
        $responseObj->setSuccess($isSuccess);
        $responseObj->sethttpStatusCode($statucCode);
        $responseObj->addMessage($message);
        if($isDataAvailable) {
            $responseObj->setData($data);
        }
        $responseObj->send();
    }

    public static function getActivitiesArray(Activities $data){
        $activitiesArray = array();
        $activitiesArray['id'] = $data->getID();
        $activitiesArray['Date'] = $data->getDate();
        $activitiesArray['Type'] = $data->getType();
        $activitiesArray['Category'] = $data->getCategory();
        $activitiesArray['Model'] = $data->getModel();
        $activitiesArray['IMEI'] = $data->getImei();
        $activitiesArray['Storage'] = $data->getStorage();
        $activitiesArray['RAM'] = $data->getRam();
        $activitiesArray['Color'] = $data->getColor();
        $activitiesArray['Client'] = $data->getClient();
        $activitiesArray['Phone'] = $data->getPhone();
        $activitiesArray['Notes'] = $data->getNotes();
        $activitiesArray['AddedBy'] = $data->getAddedby();
        return $activitiesArray;
    } 

    public static function getExpensesArray(Expense $data) {
        $expensesArray = array();
        $expensesArray['id'] = $data->getId();
        $expensesArray['date'] = $data->getDate();
        $expensesArray['category'] = $data->getCategory();
        $expensesArray['price'] = $data->getPrice();
        $expensesArray['notes'] = $data->getNotes();

        return $expensesArray;
    }

    public static function getDashboardDataArray(Dashboard $data) {
        $dashboardArray = array();
        $dashboardArray['salesincount'] = $data->getSalesInCount();
        $dashboardArray['salesoutamount'] = $data->getSalesOutAmount();
        $dashboardArray['salesoutcount'] = $data->getSalesOutCount();
        $dashboardArray['salesinamount'] = $data->getSalesInAmount();
        $dashboardArray['serviceincount'] = $data->getServiceInCount();
        $dashboardArray['serviceinamount'] = $data->getServiceInAmount();
        $dashboardArray['serviceoutcount'] = $data->getServiceOutCount();
        $dashboardArray['serviceoutamount'] = $data->getServiceOutAmount();
        $dashboardArray['totalexpense'] = $data->getTotalExpense();

        return $dashboardArray;
    }
}