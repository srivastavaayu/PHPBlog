<?php

  require_once("session.php");
  require_once("./queries/users-table.php");

  $info = "";

  if($_SERVER["REQUEST_METHOD"]=="POST") {
    $fullname = $_POST["FullNameInput"];
    $email = $_POST["EmailInput"];
    $username = $_POST["UsernameInput"];
    $password = $_POST["PasswordInput"];
    $reenterpassword = $_POST["ReenterPasswordInput"];

    $registrationIssue = 0;

    if ($resultUsers -> num_rows > 0) {
      while($rowUsers = $resultUsers -> fetch_assoc()) {
        if (($rowUsers["email"] == $email) || ($rowUsers["username"] == $username)) {
            $info = "Email and/or username already exists! Please select a different one.";
            echo '<script>alert("Email and/or username already exists! Please select a different one.")</script>';
            $registrationIssue = 1;
            break;
        }
      }
    }
    if($registrationIssue == 0) {
      if ($password === $reenterpassword) {
        $password = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO Users (fullname, email, username, password) VALUES ('$fullname', '$email', '$username', '$password')";

        if ($conn->query($sql) === TRUE) {
        } else {
          echo "Error creating table: " . $conn->error;
        }

        echo '<script>alert("User has been registered successfully.")</script>';

      }
      else {
        $info = "Password and re-entered password do not match! Please try again.";
        echo '<script>alert("Password and re-entered password do not match! Please try again.")</script>';
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
    <link href="styles/authentication.css" rel="stylesheet">
  </head>
  <body>
    <div class="background-wallpaper"></div>
    <?php include_once("header.php")?>
    <main class="main container-fluid mt-3">
      <h2 class="text-center mb-3">Register</h2>
      <div style="color: red; font-weight: 500; font-size: 1rem" class="text-center mb-3 mt-3"><?php echo $info ?></div>
      <form class="mb-5" method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>">
        <div class="form-floating mb-3">
          <input type="text" class="form-control" id="FullNameInput" name="FullNameInput" placeholder="Full Name" pattern="[A-Za-z0-9 ]+" required>
          <label for="FullNameInput">Full Name*</label>
        </div>
        <div class="form-floating mb-3">
          <input type="email" class="form-control" id="EmailInput" name="EmailInput" placeholder="Email" pattern="\S+@\S+\.\S+" required>
          <label for="EmailInput">Email Address*</label>
        </div>
        <div class="form-floating mb-3">
          <input type="text" class="form-control" id="UsernameInput" name="UsernameInput" placeholder="Username" pattern="[A-Za-z0-9]+" required>
          <label for="UsernameInput">Username*</label>
        </div>
        <div class="form-floating mb-3">
          <input type="password" class="form-control" id="PasswordInput" name="PasswordInput" placeholder="Password" pattern="^(?=.*?[A-Z])(?=(.*[a-z]){1,})(?=(.*[\d]){1,})(?=(.*[\W]){1,})(?!.*\s).{8,}$" required>
          <label for="PasswordInput">Password*</label>
        </div>
        <small class="px-4">Note: The password must contain uppercase characters, lowercase characters, digits and special symbols.</small>
        <div class="form-floating mb-3 mt-3">
          <input type="password" class="form-control" id="ReenterPasswordInput" name="ReenterPasswordInput" placeholder="Re-enter Password" required>
          <label for="ReenterPasswordInput">Re-enter Password*</label>
        </div>
        <br />
        <div class="d-flex justify-content-end">
        <a href="<?php echo "/".$index_uri[1]."/login" ?>" ><button type="button" class="btn btn-primary">Already have an account? Login here!</button></a>
        <button type="submit" class="btn btn-success ms-2">Register</button></div>
      </form>
    </main>
  </body>
</html>