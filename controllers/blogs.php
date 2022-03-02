<?php

  require_once("session.php");
  require_once("../general.php");
  require_once("redirect.php");
  require_once("../models/users-table.php");
  require_once("../models/blogs-table.php");
  require_once("../views/blogs.php");
  require_once("../views/404.php");

  $session = startSession();

  $view = null;

  if ($session[0] === FALSE) {
    $view = return404();
  }
  else {
    $info = "";
    $sortBehaviour = "ASC";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      if (isset($_POST["sortBehaviour"])) {
        $sortBehaviour = $_POST["sortBehaviour"];
      }
      else {
        $blogId = $_POST["blogid"];

        $result = removeSpecificBlogData($blogId);

        if ($result === FALSE) {
          $view = return404();
        }

        $info = "Blog has been deleted successfully.";
      }
    }

    $resultBlogs = getAllBlogsData($sortBehaviour);

    if ($resultBlogs[0] === FALSE) {
      $view = return404();
    }

    $resultUsers = getAllUsersData();

    if ($resultUsers[0] === FALSE) {
      $view = return404();
    }

    if (!$view) {
      $view = returnBlogs($resultBlogs[1], $resultUsers[1], $session[1], $info, $sortBehaviour);
    }
  }

  echo $view;

?>