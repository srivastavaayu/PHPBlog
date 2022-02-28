<?php

  require_once("../general.php");
  require_once("header.php");

  function returnUsers($result) {
    global $apex_index_uri;

    $headerView = returnHeader();

    $users = "";

    if ($result -> num_rows > 0) {
      while($row = $result -> fetch_assoc()) {
        $userId = $row["id"];
        $userFullName = $row["fullname"];
        $userUsername = $row["username"];
        $userLastActivityTime = $row["last_activity_time"];
        if (time() - $userLastActivityTime > 20) {
          $users .= <<<EOD
          <tr>
            <td>$userId</td>
            <td>$userFullName</td>
            <td>$userUsername</td>
            <td><span class="badge bg-danger">Offline</span></td>
          </tr>
EOD;
        }
        else {
          $users .= <<<EOD
          <tr>
            <td>$userId</td>
            <td>$userFullName</td>
            <td>$userUsername</td>
            <td><span class="badge bg-success">Online</span></td>
          </tr>
EOD;
        }

      }
    }

    $view = <<<EOD
      <!DOCTYPE html>
      <html>
        <head>
          <title>PHP Blog - Users</title>
          <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
          <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
          <link href="../styles/general.css" rel="stylesheet">
        </head>
        <body>
          <div class="background-wallpaper"></div>
          $headerView
          <main class="main container-fluid mt-3">
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
                $users
              </tbody>
            </table>
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