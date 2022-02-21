<?php
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
      <div class="container-fluid mt-5 mx-4">
        <h2 class="text-center mb-3">$blogtitle</h2>
        <h5 class="text-center">$userfullname</h3>
        <p>$blogcontent</p>
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
    <?php echo $blog?>
  </body>
</html>