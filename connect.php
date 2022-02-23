<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "PHPBlog";

$conn = new mysqli($servername, $username, $password);

$sql = "CREATE DATABASE IF NOT EXISTS PHPBlog";
if ($conn->query($sql) === TRUE) {
} else {
  echo "Error creating database: " . $conn->error;
}

$conn = new mysqli($servername, $username, $password, $dbname);

if (isset($_SESSION["LOGIN_USER"]) and $_SESSION["LOGIN_USER"]!=-1) {
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

  $currTime = time();
  $userid = $_SESSION["LOGIN_USER"];

  $sql = "UPDATE Users SET last_activity_time=$currTime WHERE id=$userid;";

  if ($conn->query($sql) === TRUE) {
  } else {
    echo "Error executing query. " . $conn->error;
  }
}
?>