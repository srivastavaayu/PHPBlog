<?php
  require_once("connect.php");
  require_once("redirect.php");

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

  $sql = "SELECT id, fullname, username, last_activity_time from Users";
  $result = $conn->query($sql);

  $users = "";

  if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
      $id = $row["id"];
      $fullname = $row["fullname"];
      $username = $row["username"];
      $lastActivityTime = $row["last_activity_time"];
      if (time() - $lastActivityTime > 900) {
        $users .= <<<EOD
        <tr>
          <td>$id</td>
          <td>$fullname</td>
          <td>$username</td>
          <td><span class="badge bg-danger">Offline</span></td>
        </tr>
EOD;
      }
      else {
        $users .= <<<EOD
        <tr>
          <td>$id</td>
          <td>$fullname</td>
          <td>$username</td>
          <td><span class="badge bg-success">Online</span></td>
        </tr>
EOD;
      }

    }
  }
?>

<!DOCTYPE html>
<html>
  <head>
    <title>PHP Blog</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="styles/users.css" rel="stylesheet">

  </head>
  <body>
    <?php include_once("header.php")?>
    <div class="container-fluid mt-5">
      <h2 class="text-center mb-3">Users</h2>
      <table class="table align-middle">
        <thead>
          <tr>
            <th>User ID</th>
            <th>Name</th>
            <th>Username</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          <?php echo $users?>
        </tbody>
      </table>
    </div>
  </body>
</html>