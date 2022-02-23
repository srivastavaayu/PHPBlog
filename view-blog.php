<?php
  require_once("connect.php");
  require_once("redirect.php");

  $dbname = "PHPBlog";

  $conn = new mysqli($servername, $username, $password, $dbname);

  $sql = "CREATE TABLE IF NOT EXISTS Blogs (
  id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  blogtitle VARCHAR(60) NOT NULL,
  blogcontent MEDIUMTEXT,
  userid INT(6) UNSIGNED NOT NULL,
  timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (userid) REFERENCES Users (id) ON DELETE CASCADE
  )";

  if ($conn->query($sql) === TRUE) {
  } else {
    echo "Error creating table: " . $conn->error;
  }

  $sql = "CREATE TABLE IF NOT EXISTS Comments (
  id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  comment VARCHAR(60) NOT NULL,
  blogid INT(6) UNSIGNED NOT NULL,
  userid INT(6) UNSIGNED NOT NULL,
  timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (blogid) REFERENCES Blogs (id) ON DELETE CASCADE,
  FOREIGN KEY (userid) REFERENCES Users (id) ON DELETE CASCADE
  )";

  if ($conn->query($sql) === TRUE) {
  } else {
    echo "Error creating table: " . $conn->error;
  }

  if($_SERVER["REQUEST_METHOD"]=="POST") {
    $comment = $_POST["AddCommentInput"];
    $blogid = $_GET["blogid"];
    $userid = $_SESSION["LOGIN_USER"];
    // $userid = $_COOKIE["LOGIN_USER"];

    $sql = "INSERT INTO Comments (comment, blogid, userid) VALUES ('$comment', $blogid, $userid);";

    if ($conn->query($sql) === TRUE) {
      echo '<script>alert("Comment has been added successfully.")</script>';
    } else {
      echo "Error executing query. " . $conn->error;
    }

  }

  $sql = "SELECT id, blogtitle, blogcontent, userid from Blogs";
  $resultBlogs = $conn->query($sql);

  $sql = "SELECT id, fullname from Users";
  $resultUsers = $conn->query($sql);

  $blogid = $_GET["blogid"];

  $blog = "";

  for ($blogIter = 0; $blogIter < $resultBlogs->num_rows; $blogIter++) {
    $rowBlogs = $resultBlogs->fetch_assoc();
    if ($rowBlogs["id"] == $blogid) {
      $blogtitle = $rowBlogs["blogtitle"];
      $blogcontent = $rowBlogs["blogcontent"];
      if ($resultUsers->num_rows > 0) {
        while($rowUsers = $resultUsers->fetch_assoc()) {
          if ($rowUsers["id"]==$rowBlogs["userid"]) {
            $userfullname = $rowUsers["fullname"];
          }
        }
      }
      $blog .= <<<EOD
        <h2 class="text-center mb-3">$blogtitle</h2>
        <h5 class="text-center">$userfullname</h3>
        <p class="blogContentContainer p-3 my-4 text-break">$blogcontent</p>
EOD;
    }
  }

  $comments = "";

  $sql = "SELECT comment, blogid, userid from Comments";
  $resultComments = $conn->query($sql);

  $resultBlogs->data_seek(0);

  for ($commentIter = 0; $commentIter < $resultComments->num_rows; $commentIter++) {
    $rowComments = $resultComments->fetch_assoc();
    if ($rowComments["blogid"] == $blogid) {
      $comment = $rowComments["comment"];
      $resultUsers->data_seek(0);
      if ($resultUsers->num_rows > 0) {
        while($rowUsers = $resultUsers->fetch_assoc()) {
          if ($rowUsers["id"]==$rowComments["userid"]) {
            $userfullname = $rowUsers["fullname"];
          }
        }
      }
      $comments .= <<<EOD
        <div class="commentContainer mt-1">
          <h4>$comment</h4>
          <p>$userfullname</p>
        </div>
EOD;
    }
  }

  $index_uri = $_SERVER["REQUEST_URI"];
  $index_uri = explode("/", $index_uri);
?>

<!DOCTYPE html>
<html>
  <head>
    <title>PHP Blog</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="styles/blogs.css" rel="stylesheet">
  </head>
  <body>
    <?php include_once("header.php")?>
    <div class="container-fluid mt-5 px-4 my-4">
      <?php echo $blog?>
      <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])."?blogid=".$blogid ;?>">
        <div class="form-floating mb-3">
          <textarea class="form-control" id="AddCommentInput" name="AddCommentInput" placeholder="Add Comment" style="height: 10vh" required></textarea>
          <label for="AddCommentInput">Add Comment</label>
        </div>
        <div class="d-flex justify-content-end">
          <button type="submit" class="btn btn-primary">Add Comment</button>
        </div>
      </form>
      <div class="mt-3">
        <h3>Comments</h3>
        <?php echo $comments ?>
      </div>
    </div>

  </body>
</html>