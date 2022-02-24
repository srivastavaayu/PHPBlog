<?php

  require_once("session.php");
  require_once("./queries/users-table.php");
  require_once("./queries/blogs-table.php");
  require_once("redirect.php");

  $info = "";

  if($_SERVER["REQUEST_METHOD"]=="POST") {
    $blogid = $_POST["blogid"];

    $sql = "DELETE FROM Blogs WHERE id=$blogid";

    if ($conn->query($sql) === TRUE) {
    } else {
      echo "Error executing query. " . $conn->error;
    }

    $info = "Blog has been deleted successfully.";
  }

  $sql = "SELECT id, blogtitle, blogcontent, userid from Blogs";
  $resultBlogs = $conn->query($sql);

  $blogs = "";

  if ($resultBlogs -> num_rows > 0) {
    while($rowBlogs = $resultBlogs -> fetch_assoc()) {
      $id = $rowBlogs["id"];
      $blogtitle = $rowBlogs["blogtitle"];
      $blogcontent = $rowBlogs["blogcontent"];
      $userid = $rowBlogs["userid"];
      $resultUsers -> data_seek(0);
      if ($resultUsers -> num_rows > 0) {
        while($rowUsers = $resultUsers -> fetch_assoc()) {
          if ($rowUsers["id"] == $userid) {
            $userfullname = $rowUsers["fullname"];
          }
        }
      }
      if ($loggedInUser == $userid) {
        $PHPSELFSERVER = htmlspecialchars($_SERVER['PHP_SELF']);
        $blogs .= <<<EOD
        <a href="/$index_uri[1]/view-blog?blogid=$id" style="text-decoration: none; color: #000">
          <div class="blogContainer">
            <div>
              <small class="text-truncate" style="max-width: 75vw; line-height: 1.5">Author: <span style="font-weight: 500">$userfullname (You)<span></small>
              <h3 class="text-truncate" style="max-width: 75vw; line-height: 1.5">$blogtitle</h3>
              <p class="text-truncate" style="max-width: 75vw; line-height: 1.5">$blogcontent</p>
            </div>
            <div class="actionButtons text-end">
              <form class="d-inline-block" method="GET" action="/$index_uri[1]/update-blog">
                <button class="btn btn-warning me-2" name="blogid" value="$id">Edit</button>
              </form>
              <form class="d-inline-block" method="POST" action="$PHPSELFSERVER">
                <button class="btn btn-danger" name="blogid" value="$id">Delete</button>
              </form>
            </div>
          </div>
        </a>
EOD;
      }
      else {
        $blogs .= <<<EOD
        <a href="/$index_uri[1]/view-blog?blogid=$id" style="text-decoration: none; color: #000">
          <div class="blogContainer">
            <div>
              <small class="text-truncate" style="max-width: 75vw; line-height: 1.5">Author: <span style="font-weight: 500">$userfullname</span></small>
              <h3 class="text-truncate" style="max-width: 75vw; line-height: 1.5">$blogtitle</h3>
              <p class="text-truncate" style="max-width: 75vw; line-height: 1.5">$blogcontent</p>
            </div>
          </div>
        </a>
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
    <link href="styles/blogs.css" rel="stylesheet">

  </head>
  <body>
    <div class="background-wallpaper"></div>
    <?php include_once("header.php")?>
    <main class="main container-fluid mt-3 mb-3">
      <h2 class="text-center mb-3">Blogs</h2>
      <div style="color: orange; font-weight: 500; font-size: 1rem" class="text-center mb-3 mt-3"><?php echo $info ?></div>
      <?php echo $blogs?>
    </div>
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