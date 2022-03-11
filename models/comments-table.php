<?php

  require_once("phpblogv2-database.php");

  $conn;

  function createCommentsTable() {
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
      $sql = "CREATE TABLE IF NOT EXISTS Comments (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        comment VARCHAR(60) NOT NULL,
        blogid INT(6) UNSIGNED NOT NULL,
        userid INT(6) UNSIGNED NOT NULL,
        timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (blogid) REFERENCES Blogs (id) ON DELETE CASCADE,
        FOREIGN KEY (userid) REFERENCES Users (id) ON DELETE CASCADE
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

  function getAllCommentsData() {
    global $conn;

    $tableCreation = createCommentsTable();

    if ($tableCreation === FALSE) {
      $returnValue = [FALSE];
      return $returnValue;
    }

    try {
      $sql = "SELECT id, comment, blogid, userid from Comments ORDER BY id";

      $result = $conn -> query($sql);

      $returnValue = [TRUE, $result];
    }
    catch (mysqli_sql_exception $exception) {
      $returnValue = FALSE;
    }
    return $returnValue;
  }

  function getSpecificCommentsData($commentField, $commentIdentifer) {
    global $conn;

    $tableCreation = createCommentsTable();

    if ($tableCreation === FALSE) {
      $returnValue = [FALSE];
      return $returnValue;
    }

    try {
      $sql = "SELECT id, comment, blogid, userid FROM Comments WHERE $commentField = $commentIdentifer ORDER BY id;";

      $result = $conn -> query($sql);

      $returnValue = [TRUE, $result];
    }
    catch (mysqli_sql_exception $exception) {
      $returnValue = [FALSE];
    }
    return $returnValue;
  }

  function addSpecificCommentData($commentContent, $blogId, $userId) {
    global $conn;

    $tableCreation = createCommentsTable();

    if ($tableCreation === FALSE) {
      $returnValue = FALSE;
      return $returnValue;
    }

    try {
      $sql = "INSERT INTO Comments (comment, blogid, userid) VALUES ('$commentContent', $blogId, $userId);";

      $conn -> query($sql);

      $returnValue = TRUE;
    }
    catch (mysqli_sql_exception $exception) {
      $returnValue = FALSE;
    }
    return $returnValue;
  }

  function removeSpecificCommentData($commentIdentifier) {
    global $conn;

    $tableCreation = createCommentsTable();

    if ($tableCreation === FALSE) {
      $returnValue = FALSE;
      return $returnValue;
    }

    try {
      $sql = "DELETE FROM Comments WHERE id=$commentIdentifier";

      $conn -> query($sql);

      $returnValue = TRUE;
    }
    catch (mysqli_sql_exception $exception) {
      $returnValue = FALSE;
    }
    return $returnValue;
  }

?>