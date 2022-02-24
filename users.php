<?php

  require_once("session.php");
  require_once("./queries/users-table.php");
  require_once("redirect.php");

  $users = "";

  if ($resultUsers -> num_rows > 0) {
    while($rowUsers = $resultUsers -> fetch_assoc()) {
      $id = $rowUsers["id"];
      $fullname = $rowUsers["fullname"];
      $username = $rowUsers["username"];
      $lastActivityTime = $rowUsers["last_activity_time"];
      if (time() - $lastActivityTime > 20) {
        $users .= <<<EOD
        <tr>
          <td>$id</td>
          <td>$fullname</td>
          <td>$username</td>
          <td><span class="badge bg-danger">Offline</span></td>
        </tr>
EOD;
      }
      else {
        $users .= <<<EOD
        <tr>
          <td>$id</td>
          <td>$fullname</td>
          <td>$username</td>
          <td><span class="badge bg-success">Online</span></td>
        </tr>
EOD;
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
    <link href="styles/users.css" rel="stylesheet">

  </head>
  <body>
    <div class="background-wallpaper"></div>
    <?php include_once("header.php")?>
    <div class="container-fluid mt-3">
      <h2 class="text-center mb-3">Users</h2>
      <table class="table table-striped table-hover align-middle text-center">
        <thead>
          <tr>
            <th>User ID</th>
            <th>Name</th>
            <th>Username</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          <?php echo $users?>
        </tbody>
      </table>
    </div>
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