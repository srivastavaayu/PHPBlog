<?php
  require_once("connect.php");
  $dbname = "PHPBlog";

  $conn = new mysqli($servername, $username, $password, $dbname);

  $sql = "CREATE TABLE IF NOT EXISTS Users (
  id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  fullname VARCHAR(60) NOT NULL,
  email VARCHAR(50),
  username VARCHAR(50),
  password VARCHAR(50),
  reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
  )";

  if ($conn->query($sql) === TRUE) {
  } else {
    echo "Error creating table: " . $conn->error;
  }

  $fullname = $_POST["FullNameInput"];
  $email = $_POST["EmailInput"];
  $username = $_POST["UsernameInput"];
  $password = $_POST["PasswordInput"];
  $reenterpassword = $_POST["ReenterPasswordInput"];

  $sql = "INSERT INTO Users (fullname, email, username, password) VALUES ('$fullname', '$email', '$username', '$password')";

  if ($conn->query($sql) === TRUE) {
  } else {
    echo "Error creating table: " . $conn->error;
  }

  $index_uri = $_SERVER["REQUEST_URI"];
  $index_uri = explode("/", $index_uri);
  header('Location: /'.$index_uri[1]);
?>