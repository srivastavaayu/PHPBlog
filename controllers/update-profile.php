<?php

  require_once("session.php");
  require_once("../general.php");
  require_once("redirect.php");
  require_once("../models/users-table.php");
  require_once("../views/update-profile.php");
  require_once("../views/404.php");

  $session = startSession();

  $view = null;

  if ($session[0] === FALSE) {
    $view = return404();
  }
  else {
    $info = "";

    $result = getSpecificUserData("id", $session[1]);

    if ($result[0] == FALSE) {
      $view = return404();
    }

    if ($result[1] -> num_rows == 1) {
      $row = $result[1] -> fetch_assoc();
      $currentFullName = $row["fullname"];
      $currentEmail = $row["email"];
      $currentUsername = $row["username"];
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $updateFullName = $_POST["FullNameInput"];
      $updateEmail = $_POST["EmailInput"];
      $updateUsername = $_POST["UsernameInput"];
      $updateFieldsandValues = ["fullname" => "'$updateFullName'", "email" => "'$updateEmail'", "username" => "'$updateUsername'"];

      $result = getAllUsersData();

      if ($result[0] === FALSE) {
        $view = return404();
      }
      else {
        if (empty($updateFullName)) {
          $info = "Fullname cannot be empty!";
        }
        else if (empty($updateEmail) or !(preg_match("/\S+@\S+\.\S+/", $updateEmail))) {
          $info = "Email address is not valid! Please check again.";
        }
        else if (empty($updateUsername) or !(preg_match("/[A-Za-z0-9]+/", $updateUsername))) {
          $info = "Username is not valid! Please check again.";
        }
        else {
          $registrationIssue = 0;

          if ($result[1] -> num_rows > 0) {
            if ($updateUsername == $currentUsername) {
              if ($updateEmail == $currentEmail) {
                $response = setSpecificUserData($updateFieldsandValues, $session[1]);

                if ($response) {
                  echo <<<EOD
                    <script>
                      alert("User has been updated successfully.");
                    </script>
EOD;
                  $info = "User has been updated successfully!";
                }
              }
              else {
                $result[1] -> data_seek(0);
                while($row = $result[1] -> fetch_assoc()) {
                  if ($row["email"] == $updateEmail) {
                      $info = "Email already exists! Please select a different one.";
                      $registrationIssue = 1;
                      break;
                  }
                }
                if ($registrationIssue == 0) {
                  $response = setSpecificUserData($updateFieldsandValues, $session[1]);

                  if ($response) {
                    echo <<<EOD
                      <script>
                        alert("User has been updated successfully.");
                      </script>
EOD;
                    $info = "User has been updated successfully!";
                  }
                }
              }
            }
            else if ($updateEmail == $currentEmail) {
              if ($updateUsername == $currentUsername) {
                $response = setSpecificUserData($updateFieldsandValues, $session[1]);

                if ($response) {
                  echo <<<EOD
                    <script>
                      alert("User has been updated successfully.");
                    </script>
EOD;
                  $info = "User has been updated successfully!";
                }
              }
              else {
                $result[1] -> data_seek(0);
                while($row = $result[1] -> fetch_assoc()) {
                  if ($row["username"] == $updateUsername) {
                      $info = "Username already exists! Please select a different one.";
                      $registrationIssue = 1;
                      break;
                  }
                }
                if ($registrationIssue == 0) {
                  $response = setSpecificUserData($updateFieldsandValues, $session[1]);

                  if ($response) {
                    echo <<<EOD
                      <script>
                        alert("User has been updated successfully.");
                      </script>
EOD;
                    $info = "User has been updated successfully!";
                  }
                }
              }
            }
            else {
              $result[1] -> data_seek(0);
              while($row = $result[1] -> fetch_assoc()) {
                if (($row["username"] == $updateUsername) or ($row["email"] == $updateEmail)) {
                    $info = "Email and/or username already exists! Please select a different one.";
                    $registrationIssue = 1;
                    break;
                }
              }
              if ($registrationIssue == 0) {
                $response = setSpecificUserData($updateFieldsandValues, $session[1]);

                if ($response) {
                  echo <<<EOD
                    <script>
                      alert("User has been updated successfully.");
                    </script>
EOD;
                  $info = "User has been updated successfully!";
                }
              }
            }
          }
        }
      }
    }

    $result = getSpecificUserData("id", $session[1]);

    if ($result[0] == FALSE) {
      $view = return404();
    }

    if(!$view) {
      $view = returnUpdateProfile($result[1], $session[1], $info);
    }
  }

  echo $view;

?>