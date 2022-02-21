<?php
  $index_uri = $_SERVER["REQUEST_URI"];
  $index_uri = explode("/", $index_uri);

  $updateBlogId = $_POST["BlogID"];
  require_once("connect.php");
  $dbname = "PHPBlog";

  $conn = new mysqli($servername, $username, $password, $dbname);

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

  $sql = "SELECT id, blogtitle, blogcontent, userid from Blogs";
  $resultBlogs = $conn->query($sql);


  for ($blogIter = 0; $blogIter < $resultBlogs->num_rows; $blogIter++) {
    $rowBlogs = $resultBlogs->fetch_assoc();
    if ($rowBlogs["id"] == $updateBlogId) {
      $blogtitle = $rowBlogs["blogtitle"];
      $blogcontent = $rowBlogs["blogcontent"];
    }
  }
?>
<!DOCTYPE html>
<html>
  <head>
    <title>PHP Blog</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  </head>
  <body>
    <?php include_once("header.php")?>
    <main class="main container-fluid mt-5" style="width: 70%">
      <h2 class="text-center mb-3">Update Blog</h2>
      <form method="POST" action="backend-update-blog.php">
        <div class="form-floating mb-3">
          <input type="text" class="form-control" id="BlogTitleInput" name="BlogTitleInput" placeholder="Blog Title" value="<?php echo $blogtitle ?>">
          <label for="BlogTitleInput">Blog Title</label>
        </div>
        <div class="form-floating mb-3">
          <textarea class="form-control" id="BlogContentInput" name="BlogContentInput" placeholder="Blog Content" style="height: 50vh"><?php echo $blogcontent ?></textarea>
          <label for="BlogContentInput">Blog Content</label>
        </div>
        <a href=<?php echo "/$index_uri[1]" ?>><button type="button" class="btn btn-outline-danger">Cancel</button></a>
        <button type="submit" class="btn btn-primary ms-auto" name="BlogID" value=<?php echo $updateBlogId ?>>Update Blog</button>
      </form>
    </main>
  </body>
</html>