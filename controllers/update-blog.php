<?php

  require_once("session.php");
  require_once("../general.php");
  require_once("redirect.php");
  require_once("../models/blogs-table.php");
  require_once("../views/update-blog.php");
  require_once("../views/404.php");

  $session = startSession();

  $view = null;

  if ($session[0] === FALSE) {
    $view = return404();
  }
  else {
    $info = "";

    $blogId = $_GET["blogid"];

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $blogTitle = $_POST["BlogTitleInput"];
      $blogContent = $_POST["BlogContentInput"];

      if($blogTitle == "" or $blogContent == "") {
        $info = "Blog Title and Content cannot be empty!";
      }
      else {
        $response = setSpecificBlogData($blogId, $blogTitle, $blogContent);

        if ($response[0] === FALSE) {
          $view = return404();
        }
        else {
          echo <<<EOD
            <script>
              alert("Blog has been updated successfully.");
              window.location.href = "/$apex_index_uri/controllers/blogs"
            </script>
EOD;
        }
      }
    }

    $result = getSpecificBlogData("id", $blogId);

    if ($result[0] == FALSE) {
      $view = return404();
    }

    if (!$view) {
      $view = returnUpdateBlog($result, $blogId, $info);
    }
  }

  echo $view;

?>