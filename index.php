<?php

  require_once("session.php");
  require_once("./queries/users-table.php");

  if ($resultUsers -> num_rows > 0) {
    while($rowUsers = $resultUsers -> fetch_assoc()) {
      if ($rowUsers["id"] == $loggedInUser) {
        $userFullname = $rowUsers["fullname"];
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
    <link href="styles/index.css" rel="stylesheet">
  </head>
  <body>
    <div class="background-wallpaper"></div>
    <?php include_once("header.php")?>
    <h3 class="text-center mt-5"><?php echo (isset($userFullname) ? 'Hello, <span class="userGreeting">'.$userFullname.'</span>!' : 'Welcome to <span class="userGreeting">PHP Blog</span>!')  ?></h3>
  </body>
</html>