<?php

  require_once("session.php");
  require_once("../general.php");
  require_once("redirect.php");
  require_once("../models/users-table.php");
  require_once("../models/blogs-table.php");
  require_once("../models/comments-table.php");
  require_once("../views/blog.php");
  require_once("../views/404.php");

  $session = startSession();

  $view = null;

  if ($session[0] === FALSE) {
    $view = return404();
  }
  else {
    $info = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      if ((isset($_POST["commentAction"])) and ($_POST["commentAction"] == "delete")) {
        $commentId = $_POST["commentid"];

        $response = removeSpecificCommentData($commentId);

        if ($response === TRUE) {
          echo <<<EOD
          <script>
            alert("Comment has been deleted successfully.");
          </script>
EOD;
        }
        else {
          $view = return404();
        }
      }
      else {
        $commentContent = $_POST["AddCommentInput"];
        $blogId = $_GET["blogid"];

        $response = addSpecificCommentData($commentContent, $blogId, $session[1]);

        if ($response === TRUE) {
          echo <<<EOD
          <script>
            alert("Comment has been added successfully.");
          </script>
EOD;
        }
        else {
          $view = return404();
        }
      }

    }

    $blogId = $_GET["blogid"];

    $resultBlog = getSpecificBlogData("id", $blogId);

    if ($resultBlog[0] === FALSE) {
      $view = return404();
    }

    if ($resultBlog[1] -> num_rows == 1) {
      $rowBlog = $resultBlog[1] -> fetch_assoc();
      $userId = $rowBlog["id"];
    }

    $resultBlog[1] -> data_seek(0);

    $resultUsers = getAllUsersData();

    if ($resultUsers[0] === FALSE) {
      $view = return404();
    }

    $resultComments = getSpecificCommentsData("blogid", $blogId);

    if ($resultComments[0] === FALSE) {
      $view = return404();
    }

    if (!$view) {
      $view = returnBlog($resultBlog, $resultUsers, $resultComments, $session[1]);
    }

  }

  echo $view;

?>