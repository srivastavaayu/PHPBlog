<?php
$servername = "localhost";
$username = "root";
$password = "";

$conn = new mysqli($servername, $username, $password);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
$sql = "CREATE DATABASE IF NOT EXISTS PHPBlog";
if ($conn->query($sql) === TRUE) {
} else {
  echo "Error creating database: " . $conn->error;
}
?>