<?php

  require_once("session.php");
  require_once("../general.php");
  require_once("redirect.php");
  require_once("../models/users-table.php");
  require_once("../views/update-password.php");
  require_once("../views/404.php");

  $session = startSession();

  $view = null;

  if ($session[0] === FALSE) {
    $view = return404();
  }
  else {
    $info = "";

    if (isset($_SESSION["LOGIN_STATUS"]) and $_SESSION["LOGIN_STATUS"] and $_SERVER["REQUEST_METHOD"] == "POST") {
      $updateOldPassword = $_POST["OldPasswordInput"];
      $updateNewPassword = $_POST["NewPasswordInput"];
      $updateNewReenterPassword = $_POST["ReenterNewPasswordInput"];

      $result = getSpecificUserPasswordData("id", $session[1]);

      if ($result[0] == FALSE) {
        $view = return404();
      }
      else {
        if (empty($updateOldPassword)) {
          $info = "Old Password field cannot be empty!";
        }
        else if (empty($updateNewPassword) or !(preg_match("/^(?=.*?[A-Z])(?=(.*[a-z]){1,})(?=(.*[\d]){1,})(?=(.*[\W]){1,})(?!.*\s).{8,}$/", $updateNewPassword))) {
          $info = "New Password is not valid! Please check again.";
        }
        else if ($updateNewPassword != $updateNewReenterPassword) {
          $info = "New password does not match re-entered password!";
        }
        else {
          if ($result[1] -> num_rows == 1) {
            $row = $result[1] -> fetch_assoc();

            if (password_verify($updateOldPassword, $row["password"])) {
              $updateNewPassword = password_hash($updateNewPassword, PASSWORD_DEFAULT);

              $response = setSpecificUserPasswordData($session[1], "'$updateNewPassword'");

              if ($response === FALSE) {
              $view = return404();
              }
              else {
                echo <<<EOD
                  <script>
                    alert("Password has been updated successfully!");
                  </script>
EOD;
                $info = "Password has been updated successfully!";
              }
            }
            else {
              $info = "Current password does not match! Please check and try again.";
            }
          }
        }
      }
    }

    if(!$view) {
      $view = returnUpdatePassword($session[1], $info);
    }
  }

  echo $view;

?>