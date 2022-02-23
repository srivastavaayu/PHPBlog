<?php
  require_once("connect.php");

  $dbname = "PHPBlog";

  $conn = new mysqli($servername, $username, $password, $dbname);

  $index_uri = $_SERVER["REQUEST_URI"];
  $index_uri = explode("/", $index_uri);

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

  $sql = "SELECT id, fullname from Users";
  $result = $conn->query($sql);

  $loggedInUser = isset($_SESSION["LOGIN_USER"]) ? $_SESSION["LOGIN_USER"] : null;
  // $loggedInUser = isset($_COOKIE["LOGIN_USER"]) ? $_COOKIE["LOGIN_USER"] : null;

  $userfullname = null;

  if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
      if ($row["id"]==$loggedInUser) {
        $userfullname = $row["fullname"];
      }
    }
  }

?><!DOCTYPE html>
<html>
  <head>
    <title>PHP Blog</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  </head>
  <body>
    <?php include_once("header.php")?>
    <h3 class="text-center mt-5"><?php echo (isset($userfullname) ? "Hello, ".$userfullname."!" : "Welcome to PHP Blog!")  ?></h3>
  </body>
</html>