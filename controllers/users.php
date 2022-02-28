<?php

  require_once("session.php");
  require_once("../general.php");
  require_once("redirect.php");
  require_once("../models/users-table.php");
  require_once("../views/users.php");
  require_once("../views/404.php");

  $session = startSession();

  $view = null;

  if ($session[0] === FALSE) {
    $view = return404();
  }
  else {
    $result = getAllUsersData();

    if ($result[0] == FALSE) {
      $view = return404();
    }
  }

  if (!$view) {
    $view = returnUsers($result[1]);
  }

  echo $view;

?>