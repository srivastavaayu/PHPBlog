<?php

  require_once("session.php");
  require_once("./queries/users-table.php");

  $info = "";

  if($_SERVER["REQUEST_METHOD"]=="POST") {
    $username = $_POST["UsernameInput"];
    $password = $_POST["PasswordInput"];

    echo "inside post";

    if ($resultUsers -> num_rows > 0) {
      while($rowUsers = $resultUsers->fetch_assoc()) {
        if($rowUsers["username"]==$username) {
          if(password_verify($password, $rowUsers["password"])) {
            $_SESSION["LOGIN_STATUS"] = true;
            $_SESSION["LOGIN_USER"] = $rowUsers["id"];
            header('Location: /'.$index_uri[1]);
          }
          else {
            $info = "Incorrect credentials! Please check your username and/or password.";
            break;
          }
        }
      }
    }
    else {
      $info = "Username does not exist! Please create an account.";
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
      <h2 class="text-center mb-3">Login</h2>
      <div style="color: orange; font-weight: 500; font-size: 1rem" class="text-center mb-3 mt-3"><?php echo $info ?></div>
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
        <a href="<?php echo "/".$index_uri[1]."/register" ?>" ><button type="button" class="btn btn-primary">New to PHP Blog? Register here!</button></a>
        <button type="submit" class="btn btn-success ms-2">Login</button></div>
      </form>
    </main>
    <script>
      document.addEventListener("DOMContentLoaded", function() {
        setInterval(() => {
          let data = 1;
          const dataToStimulate = new Blob([JSON.stringify(data)], {type : 'application/json'});
          navigator.sendBeacon('/PHPBlog/log-status.php', dataToStimulate);
        }, 15000);
      });
    </script>
  </body>
</html>