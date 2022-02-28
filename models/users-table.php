<?php

  require_once("phpblogv2-database.php");

  $conn;

  function createUsersTable() {
    global $conn;

    $databaseConnection = connectDatabase();

    if ($databaseConnection[0] === TRUE) {
      $conn = $databaseConnection[1];
    }
    else {
      $returnValue = [FALSE];
      return $returnValue;
    }

    $sql = "CREATE TABLE IF NOT EXISTS Users (
      id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
      fullname VARCHAR(60) NOT NULL,
      email VARCHAR(60),
      username VARCHAR(60),
      password VARCHAR(255),
      last_activity_time INT(12) UNSIGNED,
      timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )";

    if ($conn -> query($sql) === FALSE) {
      $returnValue = [FALSE];
      return $returnValue;
    }
  }

  function getAllUsersData() {
    global $conn;

    $tableCreation = createUsersTable();

    if ($tableCreation[0] === FALSE) {
      $returnValue = [FALSE];
      return $returnValue;
    }

    $sql = "SELECT id, fullname, email, username, password, last_activity_time FROM Users ORDER BY id;";

    $result = $conn -> query($sql);

    $returnValue = [TRUE, $result];
    return $returnValue;
  }

  function getSpecificUserData($userField, $userIdentifier) {
    global $conn;

    $tableCreation = createUsersTable();

    if ($tableCreation[0] === FALSE) {
      $returnValue = [FALSE];
      return $returnValue;
    }

    $sql = "SELECT id, fullname, email, username, password, last_activity_time FROM Users WHERE $userField = $userIdentifier ORDER BY id;";

    $result = $conn -> query($sql);

    $returnValue = [TRUE, $result];
    return $returnValue;
  }

  function getSpecificUserPasswordData($userField, $userIdentifier) {
    global $conn;

    $tableCreation = createUsersTable();

    if ($tableCreation[0] === FALSE) {
      $returnValue = [FALSE];
      return $returnValue;
    }

    //TODO: Check to see if we can include quotes in data
    $sql = "SELECT id, password FROM Users WHERE $userField = $userIdentifier ORDER BY id;";

    $result = $conn -> query($sql);

    $returnValue = [TRUE, $result];
    return $returnValue;
  }

  function getSpecificUserLastActivityTimeData($userIdentifier) {
    global $conn;

    $tableCreation = createUsersTable();

    if ($tableCreation[0] === FALSE) {
      $returnValue = [FALSE];
      return $returnValue;
    }

    $sql = "SELECT last_activity_time FROM Users WHERE id = $userIdentifier ORDER BY id;";

    $result = $conn -> query($sql);

    $returnValue = [TRUE, $result];
    return $returnValue;
  }

  function addSpecificUser($userFullName, $userEmail, $userUsername, $userPassword) {
    global $conn;

    $tableCreation = createUsersTable();

    if ($tableCreation[0] === FALSE) {
      $returnValue = [FALSE];
      return $returnValue;
    }

    $sql = "INSERT INTO Users (fullname, email, username, password) VALUES ('$userFullName', '$userEmail', '$userUsername', '$userPassword');";

    if ($conn -> query($sql) === TRUE) {
      $returnValue = [TRUE];
      return $returnValue;
    }
    else {
      $returnValue = [FALSE];
      return $returnValue;
    }
  }

  function setSpecificUserData($updateFieldsandValues, $userIdentifier) {
    global $conn;

    $tableCreation = createUsersTable();

    if ($tableCreation[0] === FALSE) {
      $returnValue = [FALSE];
      return $returnValue;
    }

    $toUpdateValues = "";
    foreach ($updateFieldsandValues as $field => $value) {
      $toUpdateValues .= "$field = $value, ";
    }

    $toUpdateValues = substr($toUpdateValues, 0, strlen($toUpdateValues)-2);

    $sql = "UPDATE Users SET $toUpdateValues WHERE id = $userIdentifier;";

    if ($conn -> query($sql) === TRUE) {
      $returnValue = [TRUE];
      return $returnValue;
    }
    else {
      $returnValue = [FALSE];
      return $returnValue;
    }
  }

  function setSpecificUserPasswordData($userIdentifier, $userNewPassword) {
    global $conn;

    $tableCreation = createUsersTable();

    if ($tableCreation[0] === FALSE) {
      $returnValue = [FALSE];
      return $returnValue;
    }

    $sql = "UPDATE Users SET password=$userNewPassword WHERE id = $userIdentifier;";

    if ($conn -> query($sql) === TRUE) {
      $returnValue = [TRUE];
      return $returnValue;
    }
    else {
      $returnValue = [FALSE];
      return $returnValue;
    }
  }

  function setSpecificUserLastActivityTimeData($userIdentifier, $currentTime) {
    global $conn;

    $tableCreation = createUsersTable();

    if ($tableCreation[0] === FALSE) {
      $returnValue = [FALSE];
      return $returnValue;
    }

    $sql = "UPDATE Users SET last_activity_time=$currentTime WHERE id = $userIdentifier;";

    if ($conn -> query($sql) === TRUE) {
      $returnValue = [TRUE];
      return $returnValue;
    }
    else {
      $returnValue = [FALSE];
      return $returnValue;
    }
  }

?>