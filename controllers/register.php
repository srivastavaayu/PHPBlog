<?php

  require_once("session.php");
  require_once("../general.php");
  require_once("../models/users-table.php");
  require_once("../models/blogs-table.php");
  require_once("../views/register.php");
  require_once("../views/404.php");

  $session = startSession();

  $view = null;

  if ($session[0] === FALSE) {
    $view = return404();
  }
  else {
    $info = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $createFullName = $_POST["FullNameInput"];
      $createEmail = $_POST["EmailInput"];
      $createUsername = $_POST["UsernameInput"];
      $createPassword = $_POST["PasswordInput"];
      $createReenterPassword = $_POST["ReenterPasswordInput"];

      $result = getAllUsersData();

      if ($result[0] === FALSE) {
        $view = return404();
      }
      else {
        if (empty($createFullName)) {
          $info = "Fullname cannot be empty!";
        }
        else if (empty($createEmail) or !(preg_match("/\S+@\S+\.\S+/", $createEmail))) {
          $info = "Email address is not valid! Please check again.";
        }
        else if (empty($createUsername) or !(preg_match("/[A-Za-z0-9]+/", $createUsername))) {
          $info = "Username is not valid! Please check again.";
        }
        else if (empty($createPassword) or !(preg_match("/^(?=.*?[A-Z])(?=(.*[a-z]){1,})(?=(.*[\d]){1,})(?=(.*[\W]){1,})(?!.*\s).{8,}$/", $createPassword))) {
          $info = "Password is not valid! Please try another one.";
        }
        else {
          $registrationIssue = 0;

          if ($result[1] -> num_rows > 0) {
            while($row = $result[1] -> fetch_assoc()) {
              if (($row["email"] == $createEmail) or ($row["username"] == $createUsername)) {
                  $info = "Email and/or username already exists! Please select a different one.";
                  $registrationIssue = 1;
                  break;
              }
            }
          }
          if ($registrationIssue == 0) {
            if ($createPassword === $createReenterPassword) {
              $createPassword = password_hash($createPassword, PASSWORD_DEFAULT);

              $response = addSpecificUser($createFullName, $createEmail, $createUsername, $createPassword);

              $info = $response[1];
              if ($response[0] === TRUE) {
                echo <<<EOD
                <script>
                  alert("$info");
                  window.location.href = "/$apex_index_uri/controllers/login";
                </script>
EOD;
              }

            }
            else {
              $info = "Password and re-entered password do not match! Please try again.";
            }
          }
        }
      }

      $view = returnRegister($info);
    }
    else {
      $view = returnRegister($info);
    }
  }

  echo $view;

?>