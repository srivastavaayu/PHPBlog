<?php
  require_once("phpblogv2-database.php");

  $conn;


  function createBlogsTable() {
    global $conn;

    $databaseConnection = connectDatabase();

    if ($databaseConnection[0] === TRUE) {
      $conn = $databaseConnection[1];
    }
    else {
      $returnValue = FALSE;
      return $returnValue;
    }

    $sql = "CREATE TABLE IF NOT EXISTS Blogs (
      id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
      blogtitle VARCHAR(60) NOT NULL,
      blogcontent MEDIUMTEXT,
      userid INT(6) UNSIGNED NOT NULL,
      timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
      FOREIGN KEY (userid) REFERENCES Users (id) ON DELETE CASCADE
    )
    ENGINE = INNODB";

    if ($conn -> query($sql) === TRUE) {
      $returnValue = TRUE;
      return $returnValue;
    }
    else {
      $returnValue = FALSE;
      return $returnValue;
    }
  }

  function getAllBlogsData($sortBehaviour) {
    global $conn;

    $tableCreation = createBlogsTable();

    if ($tableCreation === FALSE) {
      $returnValue = [FALSE];
      return $returnValue;
    }

    $sql = "SELECT id, blogtitle, blogcontent, userid, timestamp from Blogs ORDER BY id $sortBehaviour";

    $result = $conn -> query($sql);

    $returnValue = [TRUE, $result];
    return $returnValue;

  }

  function getSpecificBlogData($blogField, $blogIdentifier) {
    global $conn;

    $tableCreation = createBlogsTable();

    if ($tableCreation === FALSE) {
      $returnValue = [FALSE];
      return $returnValue;
    }

    $sql = "SELECT id, blogtitle, blogcontent, userid, timestamp from Blogs WHERE $blogField = $blogIdentifier ORDER BY id;";

    $result = $conn -> query($sql);

    $returnValue = [TRUE, $result];
    return $returnValue;
  }

  function addSpecificBlogData($blogTitle, $blogContent, $userId) {
    global $conn;

    $tableCreation = createBlogsTable();

    if ($tableCreation === FALSE) {
      $returnValue = FALSE;
      return $returnValue;
    }

    $sql = "INSERT INTO Blogs (blogtitle, blogcontent, userid) VALUES ('$blogTitle', '$blogContent', $userId);";

    if ($conn -> query($sql) === TRUE) {
      $returnValue = TRUE;
      return $returnValue;
    }
    else {
      $returnValue = FALSE;
      return $returnValue;
    }
  }

  function removeSpecificBlogData($blogIdentifier) {
    global $conn;

    $tableCreation = createBlogsTable();

    if ($tableCreation === FALSE) {
      $returnValue = FALSE;
      return $returnValue;
    }

    $sql = "DELETE FROM Blogs WHERE id=$blogIdentifier";

    if ($conn -> query($sql) === TRUE) {
      $returnValue = TRUE;
      return $returnValue;
    }
    else {
      $returnValue = FALSE;
      return $returnValue;
    }
  }

  function setSpecificBlogData($blogIdentifier, $blogTitle, $blogContent) {
    global $conn;

    $tableCreation = createBlogsTable();

    if ($tableCreation === FALSE) {
      $returnValue = FALSE;
      return $returnValue;
    }

    $sql = "UPDATE Blogs SET blogtitle='$blogTitle', blogcontent='$blogContent' WHERE id=$blogIdentifier";

    if ($conn -> query($sql) === TRUE) {
      $returnValue = TRUE;
      return $returnValue;
    }
    else {
      $returnValue = FALSE;
      return $returnValue;
    }
  }

?>