<?php
  require_once("connect.php");
  $dbname = "PHPBlog";

  $index_uri = $_SERVER["REQUEST_URI"];
  $index_uri = explode("/", $index_uri);

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

  $username = $_POST["UsernameInput"];
  $password = $_POST["PasswordInput"];

  $sql = "SELECT id, username, password from Users";
  $result = $conn->query($sql);

  $creds_mismatch = 1;

  if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
      if($row["username"]==$username) {
        if($row["password"]==$password) {
          $creds_mismatch = 0;
          echo var_dump($row);
          setcookie("LOGIN_STATUS", true, time()+31536000, "/", "", 1);
          setcookie("LOGIN_USER", $row["id"], time()+31536000, "/", "", 1);
          header('Location: /'.$index_uri[1]);
        }
      }
    }
  } else {
    echo "Error creating table: " . $conn->error;
    header('Location: /'.$index_uri[1].'/404');

  }
  if ($creds_mismatch == 1) {
    header('Location: /'.$index_uri[1].'/404');
  }
?>