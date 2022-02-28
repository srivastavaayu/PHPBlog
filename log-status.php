<?php

  session_start();
  require_once("models/users-table.php");

  if (isset($_SESSION["LOGIN_USER"]) and $_SESSION["LOGIN_USER"]!=-1) {
    $currentTime = time();
    $userid = $_SESSION["LOGIN_USER"];

    $response = setSpecificUserLastActivityTimeData($userid, $currentTime);

    if ($response[0] == FALSE) {
      echo "failed";
    }
  }

?>