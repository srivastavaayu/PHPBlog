<?php

  require_once("../general.php");
  require_once("header.php");

  function returnIndex($userDetails) {
    global $apex_index_uri;

    $headerView = returnHeader();

    if($userDetails[0]) {
      $userFullName = $userDetails[1];
      $view = <<<EOD
      <!DOCTYPE html>
      <html>
        <head>
          <title>PHP Blog</title>
          <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
          <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
          <link href="../styles/general.css" rel="stylesheet">
          <link href="../styles/index.css" rel="stylesheet">
        </head>
        <body>
          <div class="background-wallpaper"></div>
          $headerView
          <h3 class="text-center mt-5">Hello, <span class="userGreeting">$userFullName</span>!</h3>
        </body>
        <script>
          document.addEventListener("DOMContentLoaded", function() {
            setInterval(() => {
              let data = 1;
              const dataToStimulate = new Blob([JSON.stringify(data)], {type : 'application/json'});
              navigator.sendBeacon('/$apex_index_uri/log-status.php', dataToStimulate);
            }, 15000);
          });
        </script>
      </html>
EOD;
    return $view;
    }
    else {
      $view = <<<EOD
        <!DOCTYPE html>
        <html>
          <head>
            <title>PHP Blog</title>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
            <link href="../styles/general.css" rel="stylesheet">
            <link href="../styles/index.css" rel="stylesheet">
          </head>
          <body>
            <div class="background-wallpaper"></div>
            $headerView
            <h3 class="text-center mt-5">Welcome to <span class="userGreeting">PHP Blog</span>!</h3>
          </body>
          <script>
            document.addEventListener("DOMContentLoaded", function() {
              setInterval(() => {
                let data = 1;
                const dataToStimulate = new Blob([JSON.stringify(data)], {type : 'application/json'});
                navigator.sendBeacon('/$apex_index_uri/log-status.php', dataToStimulate);
              }, 15000);
            });
          </script>
        </html>
EOD;
      return $view;
    }
  }

?>