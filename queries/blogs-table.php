<?php
  require_once("phpblog-database.php");

  $sql = "CREATE TABLE IF NOT EXISTS Blogs (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    blogtitle VARCHAR(60) NOT NULL,
    blogcontent MEDIUMTEXT,
    userid INT(6) UNSIGNED NOT NULL,
    timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (userid) REFERENCES Users (id) ON DELETE CASCADE
  )";

  if ($conn->query($sql) === TRUE) {
  } else {
    echo "Error creating table: " . $conn->error;
  }

  $sql = "SELECT id, blogtitle, blogcontent, userid from Blogs";
  $resultBlogs = $conn->query($sql);

?>