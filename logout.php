<?php
  $index_uri = $_SERVER["REQUEST_URI"];
  $index_uri = explode("/", $index_uri);
  setcookie("LOGIN_STATUS", "", time()-3600, "/", "", 0);
  setcookie("LOGIN_USER", "", time()-3600, "/", "", 0);
  header('Location: /'.$index_uri[1]);
?>