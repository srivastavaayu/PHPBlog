<?php
  $loggedInUser = $_COOKIE["LOGIN_USER"];

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

  function changePassword($id, $oldpassword, $newpassword) {
    global $conn;
    $sql = "SELECT id, password FROM Users";
    $result = $conn->query($sql);
    if($result->num_rows>0) {
      while($row = $result->fetch_assoc()) {
        if($row["id"]==$id) {
          if($row["password"]==$oldpassword) {
            $sql = "UPDATE Users SET password='$newpassword' WHERE id=$id;";
            if ($conn->query($sql) === TRUE) {
            } else {
              echo "Error executing query. " . $conn->error;
            }
          }
          else {
            $info = "Current password does not match.";
          }
        }
      }
    }
  }

  $info = "";

  if($_SERVER["REQUEST_METHOD"]=="POST") {
    $id = (int) $_POST["UserID"];
    $oldpassword = $_POST["OldPasswordInput"];
    $newpassword = $_POST["NewPasswordInput"];
    $reenternewpassword = $_POST["ReenterNewPasswordInput"];

    if ($newpassword != $reenternewpassword) {
      $info = "New password does not match re-entered password.";
    }
    else {
      changePassword($id, $oldpassword, $newpassword);
      $info = "Password changed successfully.";
    }
  }

  $index_uri = $_SERVER["REQUEST_URI"];
  $index_uri = explode("/", $index_uri);
?>
<!DOCTYPE html>
<html>
  <head>
    <title>PHP Blog</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="styles/profile.css" rel="stylesheet">

  </head>
  <body>
    <?php include_once("header.php")?>
    <main class="main container-fluid mt-5">
      <h2 class="text-center mb-3">Update Password</h2>
      <form method="POST" action=<?php echo $_SERVER["PHP_SELF"]?>>
        <div class="form-floating mb-3">
          <input type="password" class="form-control" id="OldPasswordInput" name="OldPasswordInput" placeholder="Current Password">
          <label for="OldPasswordInput">Current Password</label>
        </div>
        <div class="form-floating mb-3">
          <input type="password" class="form-control" id="NewPasswordInput" name="NewPasswordInput" placeholder="New Password">
          <label for="NewPasswordInput">New Password</label>
        </div>
        <div class="form-floating mb-3">
          <input type="password" class="form-control" id="ReenterNewPasswordInput" name="ReenterNewPasswordInput" placeholder="Re-enter New Password">
          <label for="ReenterNewPasswordInput">Re-enter New Password</label>
        </div>
        <small class="mb-2"><?php echo $info ?></small><br />
        <a href=""><button type="button" class="btn btn-outline-primary">Cancel</button></a>
        <button type="submit" class="btn btn-primary ms-auto" name="UserID" value="<?php echo $loggedInUser ?>">Update Password</button>
      </form>
    </main>
  </body>
</html>