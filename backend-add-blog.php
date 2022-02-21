<?php
  require_once("connect.php");
  $dbname = "PHPBlog";

  $conn = new mysqli($servername, $username, $password, $dbname);

  $sql = "CREATE TABLE IF NOT EXISTS Blogs (
  id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  blogtitle VARCHAR(60) NOT NULL,
  blogcontent MEDIUMTEXT,
  userid INT(6) UNSIGNED NOT NULL,
  reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (userid) REFERENCES Users (id) ON DELETE CASCADE
  )";

  if ($conn->query($sql) === TRUE) {
  } else {
    echo "Error creating table: " . $conn->error;
  }

  $blogtitle = $_POST["BlogTitleInput"];
  $blogcontent = $_POST["BlogContentInput"];
  $userid = (int) $_COOKIE['LOGIN_USER'];


  $sql = "INSERT INTO Blogs (blogtitle, blogcontent, userid) VALUES ('$blogtitle', '$blogcontent', $userid)";

  if ($conn->query($sql) === TRUE) {
  } else {
    echo "Error creating table: " . $conn->error;
  }

  $index_uri = $_SERVER["REQUEST_URI"];
  $index_uri = explode("/", $index_uri);
  header('Location: /'.$index_uri[1]);
?>