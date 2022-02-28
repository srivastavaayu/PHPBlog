<?php

  require_once("session.php");
  require_once("../general.php");
  require_once("../models/users-table.php");
  require_once("../views/index.php");
  require_once("../views/404.php");

  $session = startSession();

  $view = null;

  if ($session[0] === FALSE) {
    $view = return404();
  }
  else {
    $userDetails = [FALSE];

    if(isset($_SESSION["LOGIN_USER"]) and $_SESSION["LOGIN_USER"] != -1) {
      $result = getSpecificUserData("id", $_SESSION["LOGIN_USER"]);

      if ($result[0]) {
        if ($result[1] -> num_rows == 1) {
          $row = $result[1] -> fetch_assoc();
          $userDetails = [TRUE, $row["fullname"]];
        }
      }

      $view = returnIndex($userDetails);
    }
    else {
      $view = returnIndex($userDetails);
    }
  }

  echo $view;

?>