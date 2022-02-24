<?php

  require_once("session.php");

?>
<!DOCTYPE html>
<html>
  <head>
    <title>PHP Blog</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="styles/general.css" rel="stylesheet">
  </head>
  <body>
    <div class="background-wallpaper"></div>
    <div class="container-fluid mt-3 text-center">
      <h2 class="mb-3">The resource could not be found!</h2>
      <h4>Please try again later.</h4>
      <div>
        <a href=<?php echo "/$index_uri[1]" ?>><button class="btn btn-primary mt-5" type="button">Navigate to Home</button></a>
      </div>
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