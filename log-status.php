<?php

  session_start();
  require_once("./queries/users-table.php");

  if (isset($_SESSION["LOGIN_USER"]) and $_SESSION["LOGIN_USER"]!=-1) {

    $loggedInUser = isset($_SESSION["LOGIN_USER"]) ? $_SESSION["LOGIN_USER"] : null;

    $currTime = time();
    $userid = $_SESSION["LOGIN_USER"];

    $sql = "UPDATE Users SET last_activity_time=$currTime WHERE id=$userid;";

    if ($conn->query($sql) === TRUE) {
    } else {
      echo "Error executing query. " . $conn->error;
    }
  }

?>