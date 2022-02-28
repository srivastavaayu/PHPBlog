<?php

  session_start();

  require_once("../general.php");
  require_once("../models/users-table.php");


  function startSession() {

    global $apex_index_uri;

    if (isset($_SESSION["LOGIN_USER"]) and $_SESSION["LOGIN_USER"] != -1) {
      $loggedInUser = isset($_SESSION["LOGIN_USER"]) ? $_SESSION["LOGIN_USER"] : null;

      $currentTime = time();

      $result = getSpecificUserLastActivityTimeData($loggedInUser);

      if ($result[0] === FALSE) {
        $returnValue = [FALSE];
        return $returnValue;
      }

      if ($result[1] -> num_rows == 1) {
        $row = $result[1] -> fetch_assoc();
        $lastActivityTimeOfLoggedInUser = $row["last_activity_time"];
      }

      if (($currentTime - $lastActivityTimeOfLoggedInUser) > 900) {
        header('Location: /'.$apex_index_uri.'/controllers/logout');
      }

      $response = setSpecificUserLastActivityTimeData($loggedInUser, $currentTime);

      if ($response[0] === TRUE) {
        $returnValue = [TRUE, $loggedInUser];
        return $returnValue;
      }
      else {
        $returnValue = [FALSE];
        return $returnValue;
      }
    }
  }

?>