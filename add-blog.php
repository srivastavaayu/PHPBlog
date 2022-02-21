<?php
  $index_uri = $_SERVER["REQUEST_URI"];
  $index_uri = explode("/", $index_uri);
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
      <h2 class="text-center mb-3">Add Blog</h2>
      <form method="POST" action="backend-add-blog.php">
        <div class="form-floating mb-3">
          <input type="text" class="form-control" id="BlogTitleInput" name="BlogTitleInput" placeholder="Blog Title">
          <label for="BlogTitleInput">Blog Title</label>
        </div>
        <div class="form-floating mb-3">
          <textarea class="form-control" id="BlogContentInput" name="BlogContentInput" placeholder="Blog Content" style="height: 50vh"></textarea>
          <label for="BlogContentInput">Blog Content</label>
        </div>
        <a href=<?php echo "/$index_uri[1]" ?>><button type="button" class="btn btn-outline-danger">Cancel</button></a>
        <button type="submit" class="btn btn-primary ms-auto">Add Blog</button>
      </form>
    </main>
  </body>
</html>