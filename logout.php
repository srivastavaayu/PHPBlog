<?php
  require_once("connect.php");
  require_once("redirect.php");

  $index_uri = $_SERVER["REQUEST_URI"];
  $index_uri = explode("/", $index_uri);

  $_SESSION["LOGIN_STATUS"] = false;
  $_SESSION["LOGIN_USER"] = -1;

  // setcookie("LOGIN_STATUS", "", time()-3600, "/", "", 0);
  // setcookie("LOGIN_USER", "", time()-3600, "/", "", 0);
  session_unset();
  session_destroy();
  header('Location: /'.$index_uri[1]);
?>