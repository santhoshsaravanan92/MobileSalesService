<?php

  require_once('Response.php');

  $responseObj = new Response();
  $responseObj->setSuccess(true);
  $responseObj->sethttpStatusCode(200);
  $responseObj->addMessage("Welcome message 1");
  $responseObj->addMessage("Welcome message 2");
  $responseObj->send();

?>
