<?php

  require_once("session.php");
  require_once("./queries/blogs-table.php");
  require_once("redirect.php");

  $info = "";

  if (isset($_SESSION["LOGIN_STATUS"]) and $_SESSION["LOGIN_STATUS"] and $_SERVER["REQUEST_METHOD"] == "POST") {
    $blogtitle = $_POST["BlogTitleInput"];
    $blogcontent = $_POST["BlogContentInput"];
    $userid = (int) $_SESSION['LOGIN_USER'];

    $homeUrl = $index_uri[1];

    $sql = "INSERT INTO Blogs (blogtitle, blogcontent, userid) VALUES ('$blogtitle', '$blogcontent', $userid)";

    if ($conn->query($sql) === TRUE) {
    } else {
      echo "Error creating table: " . $conn->error;
    }

    $info = "Blog has been added successfully.";

    echo <<<EOD
          <script>
            alert("Blog has been added successfully.");
            window.location.href = "/$homeUrl/blogs"
          </script>
EOD;

  }

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
    <?php include_once("header.php")?>
    <main class="main container-fluid mt-3" style="width: 70%">
      <h2 class="text-center mb-3">Add Blog</h2>
      <div style="color: orange; font-weight: 500; font-size: 1rem" class="text-center mb-3 mt-3"><?php echo $info ?></div>
      <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>">
        <div class="form-floating mb-3">
          <input type="text" class="form-control" id="BlogTitleInput" name="BlogTitleInput" placeholder="Blog Title" required>
          <label for="BlogTitleInput">Blog Title</label>
        </div>
        <div class="form-floating mb-3">
          <textarea class="form-control" id="BlogContentInput" name="BlogContentInput" placeholder="Blog Content" style="height: 50vh" required></textarea>
          <label for="BlogContentInput">Blog Content</label>
        </div>
        <div class="d-flex justify-content-end">
        <a href=<?php echo "/$index_uri[1]" ?>><button type="button" class="btn btn-danger">Cancel</button></a>
        <button type="submit" class="btn btn-success ms-2">Add Blog</button></div>
      </form>
    </main>
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