<?php
  $index_uri = $_SERVER["REQUEST_URI"];
  $index_uri = explode("/", $index_uri);
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
      <div id="LoginDiv">
        <h2 class="text-center mb-3">Login</h2>
        <form method="POST" action="login.php">
          <div class="form-floating mb-3">
            <input type="text" class="form-control" id="UsernameInput" name="UsernameInput" placeholder="Username">
            <label for="UsernameInput">Username</label>
          </div>
          <div class="form-floating mb-3">
            <input type="password" class="form-control" id="PasswordInput" name="PasswordInput" placeholder="Password">
            <label for="PasswordInput">Password</label>
          </div>
          <button type="button" class="btn btn-outline-primary" onclick="changeAuthenticationType()">New to PHP Blog? Register here!</button>
          <button type="submit" class="btn btn-primary">Login</button>
        </form>
      </div>
      <div id="RegisterDiv">
        <h2 class="text-center mb-3">Register</h2>
        <form method="POST" action="register.php">
          <div class="form-floating mb-3">
            <input type="text" class="form-control" id="FullNameInput" name="FullNameInput" placeholder="Full Name">
            <label for="FullNameInput">Full Name</label>
          </div>
          <div class="form-floating mb-3">
            <input type="email" class="form-control" id="EmailInput" name="EmailInput" placeholder="Email">
            <label for="EmailInput">Email Address</label>
          </div>
          <div class="form-floating mb-3">
            <input type="text" class="form-control" id="UsernameInput" name="UsernameInput" placeholder="Username">
            <label for="UsernameInput">Username</label>
          </div>
          <div class="form-floating mb-3">
            <input type="password" class="form-control" id="PasswordInput" name="PasswordInput" placeholder="Password">
            <label for="PasswordInput">Password</label>
          </div>
          <div class="form-floating mb-3">
            <input type="password" class="form-control" id="ReenterPasswordInput" name="ReenterPasswordInput" placeholder="Re-enter Password">
            <label for="ReenterPasswordInput">Re-enter Password</label>
          </div>
          <button type="button" class="btn btn-outline-primary" onclick="changeAuthenticationType()">Already have an account? Login here!</button>
          <button type="submit" class="btn btn-primary ms-auto">Register</button>
        </form>
      </div>
    </main>

    <script type="text/javascript">
      let authenticationType="login";
      function changeAuthenticationType() {
        if(authenticationType=="login") {
          document.getElementById("LoginDiv").style.display="none";
          document.getElementById("RegisterDiv").style.display="block";
          authenticationType="register";
        }
        else {
          document.getElementById("RegisterDiv").style.display="none";
          document.getElementById("LoginDiv").style.display="block";
          authenticationType="login";
        }
      }
    </script>
  </body>
</html>