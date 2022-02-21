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

  $id = (int) $_POST["UserID"];
  $fullname = $_POST["FullNameInput"];
  $email = $_POST["EmailInput"];
  $username = $_POST["UsernameInput"];


  $sql = "UPDATE Users SET fullname='$fullname', email='$email', username='$username' WHERE id=$id;";
  if ($conn->query($sql) === TRUE) {
  } else {
    echo "Error executing query. " . $conn->error;
  }

  $index_uri = $_SERVER["REQUEST_URI"];
  $index_uri = explode("/", $index_uri);
  header('Location: /'.$index_uri[1]);
?>