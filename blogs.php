<?php
  require_once("connect.php");
  $dbname = "PHPBlog";

  $conn = new mysqli($servername, $username, $password, $dbname);

  $index_uri = $_SERVER["REQUEST_URI"];
  $index_uri = explode("/", $index_uri);

  $sql = "CREATE TABLE IF NOT EXISTS Blogs (
  id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  blogtitle VARCHAR(60) NOT NULL,
  blogcontent MEDIUMTEXT,
  userid INT(6) UNSIGNED NOT NULL,
  reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (userid) REFERENCES Users (id) ON DELETE CASCADE
  )";

  if ($conn->query($sql) === TRUE) {
  } else {
    echo "Error creating table: " . $conn->error;
  }

  $loggedInUser = $_COOKIE["LOGIN_USER"];

  $sql = "SELECT id, blogtitle, blogcontent, userid from Blogs";
  $resultBlogs = $conn->query($sql);

  $sql = "SELECT id, fullname from Users";
  $resultUsers = $conn->query($sql);

  $blogs = "";

  if ($resultBlogs->num_rows > 0) {
    while($rowBlogs = $resultBlogs->fetch_assoc()) {
      $id = $rowBlogs["id"];
      $blogtitle = $rowBlogs["blogtitle"];
      $blogcontent = $rowBlogs["blogcontent"];
      $userid = $rowBlogs["userid"];
      $resultUsers->data_seek(0);
      if ($resultUsers->num_rows > 0) {
        while($rowUsers = $resultUsers->fetch_assoc()) {
          if ($rowUsers["id"]==$userid) {
            $userfullname = $rowUsers["fullname"];
          }
        }
      }
      if ($loggedInUser == $userid) {
        $blogs .= <<<EOD
        <a href="/$index_uri[1]/view-blog?blogid=$id" style="text-decoration: none; color: #000">
          <div class="blogContainer">
            <div>
              <h3 class="text-truncate" style="max-width: 75vw;">$blogtitle</h3>
              <p class="text-truncate" style="max-width: 75vw;">$blogcontent</p>
              <p class="text-truncate" style="max-width: 75vw;">Written by: $userfullname</p>
            </div>
            <div class="ms-auto">
              <form class="mx-0 px-0" method="POST" action="/$index_uri[1]/update-blog">
                <button class="btn btn-outline-warning mb-2" name="BlogID" value="$id">Edit</button>
              </form>
              <form class="mx-0 px-0" method="POST" action="/$index_uri[1]/backend-delete-blog">
                <button class="btn btn-outline-danger" name="BlogID" value="$id">Delete</button>
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
              <h3 class="text-truncate" style="max-width: 75vw;">$blogtitle</h3>
              <p class="text-truncate" style="max-width: 75vw;">$blogcontent</p>
              <p class="text-truncate" style="max-width: 75vw;">Written by: $userfullname</p>
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
    <link href="styles/blogs.css" rel="stylesheet">

  </head>
  <body>
    <?php include_once("header.php")?>
    <div class="container-fluid mt-5">
      <h2 class="text-center mb-3">Blogs</h2>
      <?php echo $blogs?>
    </div>
  </body>
</html>