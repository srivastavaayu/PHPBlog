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
      $returnValue = FALSE;
      return $returnValue;
    }

    try {
      $sql = "CREATE TABLE IF NOT EXISTS Users (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        fullname VARCHAR(60) NOT NULL,
        email VARCHAR(60),
        username VARCHAR(60),
        password VARCHAR(255),
        last_activity_time INT(12) UNSIGNED,
        timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
      )
      ENGINE = INNODB";

      $conn -> query($sql);

      $returnValue = TRUE;
    }
    catch (mysqli_sql_exception $exception) {
      $returnValue = FALSE;
    }

    return $returnValue;
  }

  function getAllUsersData() {
    global $conn;

    $tableCreation = createUsersTable();

    if ($tableCreation === FALSE) {
      $returnValue = [FALSE];
      return $returnValue;
    }

    try {
      $sql = "SELECT id, fullname, email, username, password, last_activity_time FROM Users ORDER BY id;";

      $result = $conn -> query($sql);

      $returnValue = [TRUE, $result];
    }
    catch (mysqli_sql_exception $exception) {
      $returnValue = [FALSE];
    }
    return $returnValue;
  }

  function getSpecificUserData($userField, $userIdentifier) {
    global $conn;

    $tableCreation = createUsersTable();

    if ($tableCreation === FALSE) {
      $returnValue = [FALSE];
      return $returnValue;
    }

    try {
      $sql = "SELECT id, fullname, email, username, password, last_activity_time FROM Users WHERE $userField = $userIdentifier ORDER BY id;";

      $result = $conn -> query($sql);

      $returnValue = [TRUE, $result];
    }
    catch (mysqli_sql_exception $exception) {
      $returnValue = [FALSE];
    }
    return $returnValue;
  }

  function getSpecificUserPasswordData($userField, $userIdentifier) {
    global $conn;

    $tableCreation = createUsersTable();

    if ($tableCreation === FALSE) {
      $returnValue = [FALSE];
      return $returnValue;
    }

    try {
      $sql = "SELECT id, password FROM Users WHERE $userField = $userIdentifier ORDER BY id;";

      $result = $conn -> query($sql);

      $returnValue = [TRUE, $result];
    }
    catch (mysqli_sql_exception $exception) {
      $returnValue = [FALSE];
    }
    return $returnValue;
  }

  function getSpecificUserLastActivityTimeData($userIdentifier) {
    global $conn;

    $tableCreation = createUsersTable();

    if ($tableCreation === FALSE) {
      $returnValue = [FALSE];
      return $returnValue;
    }

    try {
      $sql = "SELECT last_activity_time FROM Users WHERE id = $userIdentifier ORDER BY id;";

      $result = $conn -> query($sql);

      $returnValue = [TRUE, $result];
    }
    catch (mysqli_sql_exception $exception) {
      $returnValue = [FALSE];
    }
    return $returnValue;
  }

  function addSpecificUser($userFullName, $userEmail, $userUsername, $userPassword) {
    global $conn;

    $tableCreation = createUsersTable();

    if ($tableCreation === FALSE) {
      $returnValue = [FALSE];
      return $returnValue;
    }

    try {
        $conn -> begin_transaction();

        $sql = "INSERT INTO Users (fullname, email, username, password) VALUES ('$userFullName', '$userEmail', '$userUsername', '$userPassword');";
        $conn -> query($sql);

        $conn -> commit();

        $returnValue = [TRUE, "User has been added successfully!"];
    }
    catch (mysqli_sql_exception $exception) {
        $conn -> rollback();

        $returnValue = [FALSE, "An error occurred! Please try again."];
    }

    return $returnValue;
  }

  function setSpecificUserData($updateFieldsandValues, $userIdentifier) {
    global $conn;

    $tableCreation = createUsersTable();

    if ($tableCreation === FALSE) {
      $returnValue = FALSE;
      return $returnValue;
    }

    try {
      $toUpdateValues = "";
      foreach ($updateFieldsandValues as $field => $value) {
        $toUpdateValues .= "$field = $value, ";
      }

      $toUpdateValues = substr($toUpdateValues, 0, strlen($toUpdateValues)-2);

      $sql = "UPDATE Users SET $toUpdateValues WHERE id = $userIdentifier;";

      $conn -> query($sql);

      $returnValue = TRUE;
    }
    catch (mysqli_sql_exception $exception) {
      $returnValue = FALSE;
    }
    return $returnValue;
  }

  function setSpecificUserPasswordData($userIdentifier, $userNewPassword) {
    global $conn;

    $tableCreation = createUsersTable();

    if ($tableCreation === FALSE) {
      $returnValue = FALSE;
      return $returnValue;
    }

    try {
      $sql = "UPDATE Users SET password=$userNewPassword WHERE id = $userIdentifier;";

      $conn -> query($sql);

      $returnValue = TRUE;
    }
    catch (mysqli_sql_exception $exception) {
      $returnValue = FALSE;
    }
    return $returnValue;
  }

  function setSpecificUserLastActivityTimeData($userIdentifier, $currentTime) {
    global $conn;

    $tableCreation = createUsersTable();

    if ($tableCreation === FALSE) {
      $returnValue = FALSE;
      return $returnValue;
    }

    try {
      $sql = "UPDATE Users SET last_activity_time=$currentTime WHERE id = $userIdentifier;";

      $conn -> query($sql);

      $returnValue = TRUE;
    }
    catch (mysqli_sql_exception $exception) {
      $returnValue = FALSE;
    }
    return $returnValue;
  }

?>