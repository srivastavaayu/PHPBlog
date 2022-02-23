<?php

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

?>