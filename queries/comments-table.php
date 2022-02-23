<?php
  require_once("phpblog-database.php");

  $sql = "CREATE TABLE IF NOT EXISTS Comments (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    comment VARCHAR(60) NOT NULL,
    blogid INT(6) UNSIGNED NOT NULL,
    userid INT(6) UNSIGNED NOT NULL,
    timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (blogid) REFERENCES Blogs (id) ON DELETE CASCADE,
    FOREIGN KEY (userid) REFERENCES Users (id) ON DELETE CASCADE
  )";

  if ($conn->query($sql) === TRUE) {
  } else {
    echo "Error creating table: " . $conn->error;
  }

  $sql = "SELECT id, comment, blogid, userid from Comments";
  $resultComments = $conn->query($sql);

?>