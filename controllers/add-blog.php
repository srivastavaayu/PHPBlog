<?php

  require_once("session.php");
  require_once("../general.php");
  require_once("redirect.php");
  require_once("../models/blogs-table.php");
  require_once("../views/add-blog.php");
  require_once("../views/404.php");

  $session = startSession();

  $view = null;

  if ($session[0] === FALSE) {
    $view = return404();
  }
  else {
    $info = "";

    if (isset($_SESSION["LOGIN_STATUS"]) and $_SESSION["LOGIN_STATUS"] and $_SERVER["REQUEST_METHOD"] == "POST") {
      $blogTitle = $_POST["BlogTitleInput"];
      $blogContent = $_POST["BlogContentInput"];

      if($blogTitle == "" or $blogContent == "") {
        $info = "Blog Title and Content cannot be empty!";
      }
      else {
        $result = addSpecificBlogData($blogTitle, $blogContent, $session[1]);

        if ($result === FALSE) {
          $view = return404();
        }
        else {
          echo <<<EOD
            <script>
              alert("Blog has been added successfully.");
              window.location.href = "/$apex_index_uri/controllers/blogs";
            </script>
EOD;
        }
      }

      $view = returnAddBlog($info);
    }
    else {
      $view = returnAddBlog($info);
    }
  }

  echo $view;

?>