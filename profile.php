<?php

  require_once("session.php");
  require_once("./queries/users-table.php");
  require_once("redirect.php");

  $info = "";

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = (int) $_POST["UserID"];
    $fullname = $_POST["FullNameInput"];
    $email = $_POST["EmailInput"];
    $username = $_POST["UsernameInput"];

    $sql = "UPDATE Users SET fullname='$fullname', email='$email', username='$username' WHERE id=$id;";

    if ($conn->query($sql) === TRUE) {
      $info = "Profile has been updated successfully.";
      echo '<script>alert("Profile has been updated successfully.")</script>';
    } else {
      echo "Error executing query. " . $conn->error;
    }

  }

  $sql = "SELECT id, fullname, email, username, password, last_activity_time from Users";
  $resultUsers = $conn->query($sql);

  if ($resultUsers -> num_rows > 0) {
    while($rowUsers = $resultUsers -> fetch_assoc()) {
      if($rowUsers["id"] == $loggedInUser) {
        $fullname = $rowUsers["fullname"];
        $email = $rowUsers["email"];
        $username = $rowUsers["username"];
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
    <link href="styles/general.css" rel="stylesheet">
    <link href="styles/profile.css" rel="stylesheet">
  </head>
  <body>
    <div class="background-wallpaper"></div>
    <?php include_once("header.php")?>
    <main class="main container-fluid mt-3">
      <h2 class="text-center mb-3">Profile</h2>
      <div style="color: red; font-weight: 500; font-size: 1rem" class="text-center mb-3 mt-3"><?php echo $info ?></div>
      <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>">
        <div class="form-floating mb-3">
          <input type="text" class="form-control" id="FullNameInput" name="FullNameInput" placeholder="Full Name" value="<?php echo $fullname ?>" pattern="[A-Za-z0-9 ]+">
          <label for="FullNameInput">Full Name</label>
        </div>
        <div class="form-floating mb-3">
          <input type="email" class="form-control" id="EmailInput" name="EmailInput" placeholder="Email" value="<?php echo $email ?>" pattern="\S+@\S+\.\S+">
          <label for="EmailInput">Email Address</label>
        </div>
        <div class="form-floating mb-3">
          <input type="text" class="form-control" id="UsernameInput" name="UsernameInput" placeholder="Username" value="<?php echo $username ?>" pattern="[A-Za-z0-9]+">
          <label for="UsernameInput">Username</label>
        </div>
        <div class="d-flex justify-content-end">
        <a href=<?php echo "/$index_uri[1]" ?>><button type="button" class="btn btn-danger">Cancel</button></a>
        <button type="submit" class="btn btn-success ms-2" name="UserID" value="<?php echo $loggedInUser ?>">Update Profile</button></div>
      </form>
    </main>
  </body>
</html>