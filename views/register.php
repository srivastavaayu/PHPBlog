<?php

  require_once("../general.php");
  require_once("header.php");

  function returnRegister($info) {
    global $apex_index_uri;

    $headerView = returnHeader();

    $view = <<<EOD
      <!DOCTYPE html>
        <html>
          <head>
            <title>PHP Blog - Register</title>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
            <link href="../styles/general.css" rel="stylesheet">
          </head>
          <body>
            <div class="background-wallpaper"></div>
            $headerView
            <main class="main container-fluid mt-3" style="width: 70%">
              <h2 class="text-center mb-3">Register</h2>
              <div style="color: orange; font-weight: 500; font-size: 1rem" class="text-center mb-3 mt-3">$info</div>
              <form class="mb-5" method="POST" action="/$apex_index_uri/controllers/register">
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
                <a href="/$apex_index_uri/controllers/login" ><button type="button" class="btn btn-primary">Already have an account? Login here!</button></a>
                <button type="submit" class="btn btn-success ms-2">Register</button></div>
              </form>
            </main>
            <script>
              document.addEventListener("DOMContentLoaded", function() {
                setInterval(() => {
                  let data = 1;
                  const dataToStimulate = new Blob([JSON.stringify(data)], {type : 'application/json'});
                  navigator.sendBeacon('/$apex_index_uri/log-status.php', dataToStimulate);
                }, 15000);
              });
            </script>
          </body>
        </html>
EOD;

    return $view;
  }

?>