<?php

  require_once("../general.php");
  require_once("header.php");

  function returnBlogs($resultBlogs, $resultUsers, $loggedInUser, $info) {
    global $apex_index_uri;

    $headerView = returnHeader();

    $blogs = "";
    if ($resultBlogs -> num_rows > 0) {
      while($rowBlogs = $resultBlogs -> fetch_assoc()) {
        $blogId = $rowBlogs["id"];
        $blogTitle = $rowBlogs["blogtitle"];
        $blogContent = $rowBlogs["blogcontent"];
        $userId = $rowBlogs["userid"];
        $resultUsers -> data_seek(0);

        if ($resultUsers -> num_rows > 0) {
          while($rowUsers = $resultUsers -> fetch_assoc()) {
            if ($rowUsers["id"] == $userId) {
              $userFullName = $rowUsers["fullname"];
            }
          }
        }

        if ($loggedInUser == $userId) {
          $blogs .= <<<EOD
            <a href="/$apex_index_uri/controllers/blog?blogid=$blogId" style="text-decoration: none; color: #000">
              <div class="blogContainer">
                <div>
                  <small class="text-truncate" style="max-width: 75vw; line-height: 1.5">Author: <span style="font-weight: 500">$userFullName (You)<span></small>
                  <h3 class="text-truncate" style="max-width: 75vw; line-height: 1.5">$blogTitle</h3>
                  <p class="text-truncate" style="max-width: 75vw; line-height: 1.5">$blogContent</p>
                </div>
                <div class="actionButtons text-end">
                  <form class="d-inline-block" method="GET" action="/$apex_index_uri/controllers/update-blog">
                    <button class="btn btn-warning me-2" name="blogid" value="$blogId">Edit</button>
                  </form>
                  <form class="d-inline-block" method="POST" action="/$apex_index_uri/controllers/blogs">
                    <button class="btn btn-danger" name="blogid" value="$blogId">Delete</button>
                  </form>
                </div>
              </div>
            </a>
EOD;
        }
        else {
          $blogs .= <<<EOD
            <a href="/$apex_index_uri/controllers/blog?blogid=$blogId" style="text-decoration: none; color: #000">
              <div class="blogContainer">
                <div>
                  <small class="text-truncate" style="max-width: 75vw; line-height: 1.5">Author: <span style="font-weight: 500">$userFullName</span></small>
                  <h3 class="text-truncate" style="max-width: 75vw; line-height: 1.5">$blogTitle</h3>
                  <p class="text-truncate" style="max-width: 75vw; line-height: 1.5">$blogContent</p>
                </div>
              </div>
            </a>
EOD;
        }
      }
    }

    $view = <<<EOD
      <!DOCTYPE html>
      <html>
        <head>
          <title>PHP Blog - Blogs</title>
          <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
          <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
          <link href="../styles/general.css" rel="stylesheet">
          <link href="../styles/blogs.css" rel="stylesheet">
        </head>
        <body>
          <div class="background-wallpaper"></div>
          $headerView
          <main class="main container-fluid mt-3 mb-3">
            <h2 class="text-center mb-3">Blogs</h2>
            <div style="color: orange; font-weight: 500; font-size: 1rem" class="text-center mb-3 mt-3">$info</div>
            $blogs
          </div>
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