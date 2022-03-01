<?php

  require_once("session.php");
  require_once("../general.php");
  require_once("../models/users-table.php");
  require_once("../views/login.php");
  require_once("../views/404.php");

  $session = startSession();

  $view = null;

  if ($session[0] === FALSE) {
    $view = return404();
  }
  else {
    $info = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $authUsername = $_POST["UsernameInput"];
      $authPassword = $_POST["PasswordInput"];

      $result = getSpecificUserPasswordData("username", "'$authUsername'");

      if ($result[0] === FALSE) {
        $view = return404();
      }
      else {
        if ($result[1] -> num_rows == 1) {
          $row = $result[1] -> fetch_assoc();
          if (password_verify($authPassword, $row["password"])) {
            $_SESSION["LOGIN_STATUS"] = TRUE;
            $_SESSION["LOGIN_USER"] = $row["id"];
            $currentTime = time();

            $response = setSpecificUserLastActivityTimeData($row["id"], $currentTime);
            if ($response === FALSE) {
              $view = return404();
            }
            else {
              header('Location: /'.$index_uri[1].'/controllers/index');
            }
          }
          else {
            $info = "Incorrect credentials! Please check your username and/or password.";
          }
        }
        else {
          $info = "Username does not exist! Please create an account.";
        }
      }

      $view = returnLogin($info);
    }
    else {
      $view = returnLogin($info);
    }
  }

  echo $view;

?>