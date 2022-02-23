<?php
  require_once("connect.php");
  $dbname = "PHPBlog";

  $index_uri = $_SERVER["REQUEST_URI"];
  $index_uri = explode("/", $index_uri);

  $conn = new mysqli($servername, $username, $password, $dbname);

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

  $info = "";

  if($_SERVER["REQUEST_METHOD"]=="POST") {
    $username = $_POST["UsernameInput"];
    $password = $_POST["PasswordInput"];

    $sql = "SELECT id, username, password from Users";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
      while($row = $result->fetch_assoc()) {
        if($row["username"]==$username) {
          if(password_verify($password, $row["password"])) {
            $_SESSION["LOGIN_STATUS"] = true;
            $_SESSION["LOGIN_USER"] = $row["id"];
            // setcookie("LOGIN_STATUS", true, time()+31536000, "/", "", 1);
            // setcookie("LOGIN_USER", $row["id"], time()+31536000, "/", "", 1);
            header('Location: /'.$index_uri[1]);
          }
          else {
            $info = "Incorrect credentials! Please check your username and/or password.";
            echo '<script>alert("Incorrect credentials! Please check your username and/or password.")</script>';
            break;
          }
        }
      }
    }
    else {
      $info = "Username does not exist! Please create an account.";
      echo '<script>alert("Username does not exist! Please create an account.")</script>';
    }
  }
?>

<!DOCTYPE html>
<html>
  <head>
    <title>PHP Blog</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="styles/authentication.css" rel="stylesheet">

  </head>
  <body>
    <?php include_once("header.php")?>
    <main class="main container-fluid mt-5">
      <h2 class="text-center mb-3">Login</h2>
      <div style="color: red; font-weight: 500; font-size: 1rem" class="text-center mb-3 mt-3"><?php echo $info ?></div>
      <form class="mb-5" method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>">
        <div class="form-floating mb-3">
          <input type="text" class="form-control" id="UsernameInput" name="UsernameInput" placeholder="Username" pattern="[A-Za-z0-9]+" required>
          <label for="UsernameInput">Username*</label>
        </div>
        <div class="form-floating mb-3">
          <input type="password" class="form-control" id="PasswordInput" name="PasswordInput" placeholder="Password" required>
          <label for="PasswordInput">Password*</label>
        </div>
        <div class="d-flex justify-content-end">
        <a href="<?php echo "/".$index_uri[1]."/register" ?>" ><button type="button" class="btn btn-outline-primary">New to PHP Blog? Register here!</button></a>
        <button type="submit" class="btn btn-primary ms-2">Login</button></div>
      </form>
    </main>
  </body>
</html>