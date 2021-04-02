<?php


require_once('DBUtils.php');
require_once('../model/Response.php');

try{
    $writedb = DBUtils::connectWriteDB();
    $readdb = DBUtils::connectReadDB();
}
catch(Exception $ex) {
    $response = new Resposnse();    
    $responseObj->setSuccess(false);
    $responseObj->sethttpStatusCode(500);
    $responseObj->addMessage("Database connection error");
    $responseObj->send();
    exit;
}