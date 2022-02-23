<?php

  require_once("session.php");
  require_once("./queries/users-table.php");
  require_once("redirect.php");


  $info = "";

  if($_SERVER["REQUEST_METHOD"]=="POST") {
    $id = (int) $_POST["UserID"];
    $oldpassword = $_POST["OldPasswordInput"];
    $newpassword = $_POST["NewPasswordInput"];
    $reenternewpassword = $_POST["ReenterNewPasswordInput"];

    if ($newpassword != $reenternewpassword) {
      $info = "New password does not match re-entered password.";
      echo '<script>alert("New password does not match re-entered password.")</script>';
    }
    else {
      if($resultUsers -> num_rows>0) {
        while($rowUsers = $resultUsers -> fetch_assoc()) {
          if($rowUsers["id"] == $id) {
            if(password_verify($oldpassword, $rowUsers["password"])) {
              $newpassword = password_hash($newpassword, PASSWORD_DEFAULT);
              $sql = "UPDATE Users SET password='$newpassword' WHERE id=$id;";

              if ($conn->query($sql) === TRUE) {
                $info = "Password changed successfully.";
                echo '<script>alert("Password changed successfully.")</script>';
                break;
              } else {
                echo "Error executing query. " . $conn->error;
              }
            }
            else {
              $info = "Current password does not match.";
              break;
            }
          }
        }
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
      <h2 class="text-center mb-3">Update Password</h2>
      <div style="color: red; font-weight: 500; font-size: 1rem" class="text-center mb-3 mt-3"><?php echo $info ?></div>
      <form class="mb-5" method="POST" action=<?php echo $_SERVER["PHP_SELF"]?>>
        <div class="form-floating mb-3">
          <input type="password" class="form-control" id="OldPasswordInput" name="OldPasswordInput" placeholder="Current Password" required>
          <label for="OldPasswordInput">Current Password</label>
        </div>
        <div class="form-floating mb-3">
          <input type="password" class="form-control" id="NewPasswordInput" name="NewPasswordInput" pattern="^(?=.*?[A-Z])(?=(.*[a-z]){1,})(?=(.*[\d]){1,})(?=(.*[\W]){1,})(?!.*\s).{8,}$" placeholder="New Password" required>
          <label for="NewPasswordInput">New Password</label>
        </div>
        <small class="px-4">Note: The password must contain uppercase characters, lowercase characters, digits and special symbols.</small>
        <div class="form-floating mb-3 mt-3">
          <input type="password" class="form-control" id="ReenterNewPasswordInput" name="ReenterNewPasswordInput" placeholder="Re-enter New Password" required>
          <label for="ReenterNewPasswordInput">Re-enter New Password</label>
        </div>
        <div class="d-flex justify-content-end">
        <a href=<?php echo "/$index_uri[1]" ?>><button type="button" class="btn btn-danger">Cancel</button></a>
        <button type="submit" class="btn btn-success ms-2" name="UserID" value="<?php echo $loggedInUser ?>">Update Password</button><div>
      </form>
    </main>
  </body>
</html>