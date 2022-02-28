<?php

  require_once("../general.php");
  require_once("header.php");

  function returnViewBlog($resultBlog, $resultUsers, $resultComments, $loggedInUser) {
    global $apex_index_uri;

    $headerView = returnHeader();

    $blog = "";

    if ($resultBlog[1] -> num_rows == 1) {
      $rowBlog = $resultBlog[1] -> fetch_assoc();
      $blogId = $rowBlog["id"];
      $blogTitle = $rowBlog["blogtitle"];
      $blogContent = $rowBlog["blogcontent"];
      $blogTimestamp = $rowBlog["timestamp"];
      if ($resultUsers[1] -> num_rows > 0) {
        while ($rowUser = $resultUsers[1] -> fetch_assoc()) {
          if ($rowUser["id"] === $rowBlog["userid"]) {
            $blogUserFullName = $rowUser["fullname"];
          }
        }
      }
      $blog .= <<<EOD
        <div class="d-flex justify-content-between">
        <div>
        <h2 class="mb-3">$blogTitle</h2>
        <h5>$blogUserFullName</h3>
        </div>
        <small>$blogTimestamp</small>
        </div>
        <p class="blogContentContainer p-3 my-4 text-break">$blogContent</p>
EOD;
    }

    $comments = "";

    if ($resultComments[1] -> num_rows > 0) {
      while ($rowComment = $resultComments[1] -> fetch_assoc()) {
        $commentId = $rowComment["id"];
        $commentContent = $rowComment["comment"];
        $resultUsers[1] -> data_seek(0);
        if ($resultUsers[1] -> num_rows > 0) {
          while ($rowUser = $resultUsers[1] -> fetch_assoc()) {
            if ($rowUser["id"] === $rowComment["userid"]) {
              $commentUserFullName = $rowUser["fullname"];
            }
          }
        }

        if ($loggedInUser == $rowComment["userid"]) {
          $comments .= <<<EOD
            <div class="commentContainer mt-1">
              <div>
                <p>$commentContent</p>
                <small>- $commentUserFullName</small>
              </div>
              <div class="actionButtons text-end">
                <form class="d-inline-block" method="POST" action="/$apex_index_uri/controllers/view-blog?blogid=$blogId">
                  <input type="hidden" name="commentid" value="$commentId"/>
                  <button class="btn btn-danger" name="commentAction" value="delete">Delete Comment</button>
                </form>
              </div>
            </div>
EOD;
        }
        else {
          $comments .= <<<EOD
            <div class="commentContainer mt-1">
              <div>
                <p>$commentContent</p>
                <small>- $commentUserFullName</small>
              </div>
            </div>
EOD;
        }
      }
    }

    if ($comments != "") {
      $commentsHeading = <<<EOD
        <h3>Comments</h3>
EOD;
      $comments = $commentsHeading.$comments;
  }

    $view = <<<EOD
      <!DOCTYPE html>
      <html>
        <head>
          <title>PHP Blog - View Blog - $blogTitle</title>
          <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
          <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
          <link href="../styles/general.css" rel="stylesheet">
          <link href="../styles/blogs.css" rel="stylesheet">
        </head>
        <body>
          <div class="background-wallpaper"></div>
          $headerView
          <main class="main container-fluid mt-3 px-4 my-4">
            $blog
            <form method="POST" action="/$apex_index_uri/controllers/view-blog?blogid=$blogId">
              <div class="form-floating mb-3">
                <textarea class="form-control" id="AddCommentInput" name="AddCommentInput" placeholder="Add Comment" style="height: 10vh" required></textarea>
                <label for="AddCommentInput">Add Comment</label>
              </div>
              <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-success">Add Comment</button>
              </div>
            </form>
            <div class="mt-3">
              $comments
            </div>
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