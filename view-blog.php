<?php

  require_once("session.php");
  require_once("./queries/blogs-table.php");
  require_once("./queries/comments-table.php");
  require_once("redirect.php");

  if (isset($_SESSION["LOGIN_STATUS"]) and $_SESSION["LOGIN_STATUS"] and $_SERVER["REQUEST_METHOD"]=="POST") {
    if (isset($_POST["commentAction"]) and $_POST["commentAction"] == "delete") {
      $commentId = (int) $_POST["commentid"];
      $sql = "DELETE FROM Comments WHERE id=$commentId;";

      if ($conn->query($sql) === TRUE) {
        echo '<script>alert("Comment has been deleted successfully.")</script>';
      } else {
        echo "Error executing query. " . $conn->error;
      }
    }
    else {
      $comment = $_POST["AddCommentInput"];
      $blogid = $_GET["blogid"];
      $userid = $_SESSION["LOGIN_USER"];

      $sql = "INSERT INTO Comments (comment, blogid, userid) VALUES ('$comment', $blogid, $userid);";

      if ($conn->query($sql) === TRUE) {
        echo '<script>alert("Comment has been added successfully.")</script>';
      } else {
        echo "Error executing query. " . $conn->error;
      }
    }
  }

  $blogid = $_GET["blogid"];

  $blog = "";

  $sql = "SELECT id, comment, blogid, userid from Comments";
  $resultComments = $conn->query($sql);

  for ($blogIter = 0; $blogIter < $resultBlogs -> num_rows; $blogIter++) {
    $rowBlogs = $resultBlogs -> fetch_assoc();
    if ($rowBlogs["id"] == $blogid) {
      $blogtitle = $rowBlogs["blogtitle"];
      $blogcontent = $rowBlogs["blogcontent"];
      $timestamp = $rowBlogs["timestamp"];
      if ($resultUsers -> num_rows > 0) {
        while($rowUsers = $resultUsers -> fetch_assoc()) {
          if ($rowUsers["id"] == $rowBlogs["userid"]) {
            $userfullname = $rowUsers["fullname"];
          }
        }
      }
      $blog .= <<<EOD
        <div class="d-flex justify-content-between">
        <div>
        <h2 class="mb-3">$blogtitle</h2>
        <h5>$userfullname</h3>
        </div>
        <small>$timestamp</small>
        </div>
        <p class="blogContentContainer p-3 my-4 text-break">$blogcontent</p>
EOD;
    }
  }

  $comments = "";

  $resultBlogs->data_seek(0);
  $resultUsers->data_seek(0);

  $PHPSELFSERVER = htmlspecialchars($_SERVER['PHP_SELF'])."?blogid=".$blogid;

  for ($commentIter = 0; $commentIter < $resultComments->num_rows; $commentIter++) {
    $rowComments = $resultComments->fetch_assoc();
    if ($rowComments["blogid"] == $blogid) {
      $commentId = $rowComments["id"];
      $comment = $rowComments["comment"];
      $resultUsers -> data_seek(0);
      if ($resultUsers -> num_rows > 0) {
        while($rowUsers = $resultUsers -> fetch_assoc()) {
          if ($rowUsers["id"] == $rowComments["userid"]) {
            $userfullname = $rowUsers["fullname"];
          }
        }
      }
      if ($loggedInUser == $rowComments["userid"]) {
        $comments .= <<<EOD
          <div class="commentContainer mt-1">
            <div>
              <p>$comment</p>
              <small>- $userfullname</small>
            </div>
            <div class="actionButtons text-end">
              <form class="d-inline-block" method="POST" action="$PHPSELFSERVER">
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
              <p>$comment</p>
              <small>- $userfullname</small>
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
    <div class="container-fluid mt-3 px-4 my-4">
      <?php echo $blog?>
      <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])."?blogid=".$blogid ;?>">
        <div class="form-floating mb-3">
          <textarea class="form-control" id="AddCommentInput" name="AddCommentInput" placeholder="Add Comment" style="height: 10vh" required></textarea>
          <label for="AddCommentInput">Add Comment</label>
        </div>
        <div class="d-flex justify-content-end">
          <button type="submit" class="btn btn-success">Add Comment</button>
        </div>
      </form>
      <div class="mt-3">
        <?php echo $comments ?>
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