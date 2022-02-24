<?php
  session_start();
  require_once("./queries/users-table.php");

  $index_uri = $_SERVER["REQUEST_URI"];
  $index_uri = explode("/", $index_uri);

  if (isset($_SESSION["LOGIN_USER"]) and $_SESSION["LOGIN_USER"]!=-1) {

    $loggedInUser = isset($_SESSION["LOGIN_USER"]) ? $_SESSION["LOGIN_USER"] : null;

    $currTime = time();
    $userid = $_SESSION["LOGIN_USER"];

    $sql = "SELECT last_activity_time from Users WHERE id=$userid";
    $resultUsers = $conn->query($sql);

    if ($resultUsers -> num_rows > 0) {
      while($rowUsers = $resultUsers -> fetch_assoc()) {
        $lastActivityTime = $rowUsers["last_activity_time"];
      }
    }

    if ($currTime - $lastActivityTime > 900) {
      header('Location: /'.$index_uri[1].'/logout');
    }

    $sql = "UPDATE Users SET last_activity_time=$currTime WHERE id=$userid;";

    if ($conn->query($sql) === TRUE) {
    } else {
      echo "Error executing query. " . $conn->error;
    }
  }

  $sql = "SELECT id, fullname, email, username, password, last_activity_time from Users";
  $resultUsers = $conn->query($sql);

?>