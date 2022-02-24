<?php

  require_once("session.php");
  require_once("./queries/users-table.php");

  $info = "";

  function ValidateInput($input) {
    $input = trim($input);
    $input = stripslashes($input);
    $input = htmlspecialchars($input);
    return $input;
  }

  if($_SERVER["REQUEST_METHOD"]=="POST") {
    $fullname = ValidateInput($_POST["FullNameInput"]);
    $email = ValidateInput($_POST["EmailInput"]);
    $username = ValidateInput($_POST["UsernameInput"]);
    $password = ValidateInput($_POST["PasswordInput"]);
    $reenterpassword = ValidateInput($_POST["ReenterPasswordInput"]);
    if(empty($fullname)) {
      $info = "Fullname cannot be empty!";
    }
    else if (empty($email) or !(preg_match("/\S+@\S+\.\S+/", $email))) {
      $info = "Email address is not valid! Please check again.";
    }
    else if (empty($username) or !(preg_match("/[A-Za-z0-9]+/", $username))) {
      $info = "Username is not valid! Please check again.";
    }
    else if (empty($password) or !(preg_match("/^(?=.*?[A-Z])(?=(.*[a-z]){1,})(?=(.*[\d]){1,})(?=(.*[\W]){1,})(?!.*\s).{8,}$/", $password))) {
      $info = "Password is not valid! Please try another one.";
    }
    else {
      $registrationIssue = 0;

      if ($resultUsers -> num_rows > 0) {
        while($rowUsers = $resultUsers -> fetch_assoc()) {
          if (($rowUsers["email"] == $email) || ($rowUsers["username"] == $username)) {
              $info = "Email and/or username already exists! Please select a different one.";
              $registrationIssue = 1;
              break;
          }
        }
      }
      if($registrationIssue == 0) {
        if ($password === $reenterpassword) {

          $homeUrl = $index_uri[1];

          $password = password_hash($password, PASSWORD_DEFAULT);

          $sql = "INSERT INTO Users (fullname, email, username, password) VALUES ('$fullname', '$email', '$username', '$password')";

          if ($conn->query($sql) === TRUE) {
          } else {
            echo "Error creating table: " . $conn->error;
          }

          echo <<<EOD
          <script>
            alert("User has been registered successfully.");
            window.location.href = "/$homeUrl/login"
          </script>
EOD;

        }
        else {
          $info = "Password and re-entered password do not match! Please try again.";
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
    <link href="styles/authentication.css" rel="stylesheet">
  </head>
  <body>
    <div class="background-wallpaper"></div>
    <?php include_once("header.php")?>
    <main class="main container-fluid mt-3">
      <h2 class="text-center mb-3">Register</h2>
      <div style="color: orange; font-weight: 500; font-size: 1rem" class="text-center mb-3 mt-3"><?php echo $info ?></div>
      <form class="mb-5" method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>">
        <div class="form-floating mb-3">
          <input type="text" class="form-control" id="FullNameInput" name="FullNameInput" value="<?php echo isset($_POST["FullNameInput"]) ? $_POST["FullNameInput"] : "" ?>" placeholder="Full Name" pattern="[A-Za-z0-9 ]+" required>
          <label for="FullNameInput">Full Name*</label>
        </div>
        <div class="form-floating mb-3">
          <input type="email" class="form-control" id="EmailInput" name="EmailInput" value="<?php echo isset($_POST["EmailInput"]) ? $_POST["EmailInput"] : "" ?>" placeholder="Email" pattern="\S+@\S+\.\S+" required>
          <label for="EmailInput">Email Address*</label>
        </div>
        <div class="form-floating mb-3">
          <input type="text" class="form-control" id="UsernameInput" name="UsernameInput" value="<?php echo isset($_POST["UsernameInput"]) ? $_POST["UsernameInput"] : "" ?>" placeholder="Username" pattern="[A-Za-z0-9]+" required>
          <label for="UsernameInput">Username*</label>
        </div>
        <small class="px-4">Note: The password must contain atleast 8 characters including an uppercase character, a lowercase character, a digit and a special symbol.</small>
        <div class="form-floating mb-3 mt-3">
          <input type="password" class="form-control" id="PasswordInput" name="PasswordInput" placeholder="Password" pattern="^(?=.*?[A-Z])(?=(.*[a-z]){1,})(?=(.*[\d]){1,})(?=(.*[\W]){1,})(?!.*\s).{8,}$" required>
          <label for="PasswordInput">Password*</label>
        </div>
        <div class="form-floating mb-3">
          <input type="password" class="form-control" id="ReenterPasswordInput" name="ReenterPasswordInput" placeholder="Re-enter Password" required>
          <label for="ReenterPasswordInput">Re-enter Password*</label>
        </div>
        <br />
        <div class="d-flex justify-content-end">
        <a href="<?php echo "/".$index_uri[1]."/login" ?>" ><button type="button" class="btn btn-primary">Already have an account? Login here!</button></a>
        <button type="submit" class="btn btn-success ms-2">Register</button></div>
      </form>
    </main>
    <script>
      document.addEventListener("visibilitychange", function() {
        if (document.visibilityState === 'visible') {
          setInterval(() => {
            let data = 1;
            const dataToStimulate = new Blob([JSON.stringify(data)], {type : 'application/json'});
            navigator.sendBeacon('/PHPBlog/log-status.php', dataToStimulate);
          }, 15000);
        }
      });
    </script>
  </body>
</html>