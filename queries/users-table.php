<?php
  require_once("phpblog-database.php");

  $sql = "CREATE TABLE IF NOT EXISTS Users (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    fullname VARCHAR(60) NOT NULL,
    email VARCHAR(60),
    username VARCHAR(60),
    password VARCHAR(255),
    last_activity_time INT(12) UNSIGNED,
    timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
  )";

  if ($conn->query($sql) === TRUE) {
  } else {
    echo "Error creating table: " . $conn->error;
  }

  $sql = "SELECT id, fullname, email, username, password, last_activity_time from Users";
  $resultUsers = $conn->query($sql);

?>