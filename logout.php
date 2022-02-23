<?php
  require_once("session.php");
  require_once("redirect.php");

  $_SESSION["LOGIN_STATUS"] = false;
  $_SESSION["LOGIN_USER"] = -1;

  session_unset();
  session_destroy();
  header('Location: /'.$index_uri[1]);
?>