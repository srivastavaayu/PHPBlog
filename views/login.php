<?php

  require_once("../general.php");
  require_once("header.php");

  function returnLogin($info) {
    global $apex_index_uri;

    $headerView = returnHeader();

    $view = <<<EOD
      <!DOCTYPE html>
      <html>
        <head>
          <title>PHP Blog - Login</title>
          <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
          <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
          <link href="../styles/general.css" rel="stylesheet">
        </head>
        <body>
          <div class="background-wallpaper"></div>
          $headerView
          <main class="main container-fluid mt-3" style="width: 70%">
            <h2 class="text-center mb-3">Login</h2>
            <div style="color: orange; font-weight: 500; font-size: 1rem" class="text-center mb-3 mt-3">$info</div>
            <form class="mb-5" method="POST" action="/$apex_index_uri/controllers/login">
              <div class="form-floating mb-3">
                <input type="text" class="form-control" id="UsernameInput" name="UsernameInput" placeholder="Username" pattern="[A-Za-z0-9]+" required>
                <label for="UsernameInput">Username*</label>
              </div>
              <div class="form-floating mb-3">
                <input type="password" class="form-control" id="PasswordInput" name="PasswordInput" placeholder="Password" required>
                <label for="PasswordInput">Password*</label>
              </div>
              <div class="d-flex justify-content-end">
              <a href="/$apex_index_uri/controllers/register"><button type="button" class="btn btn-primary">New to PHP Blog? Register here!</button></a>
              <button type="submit" class="btn btn-success ms-2">Login</button></div>
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