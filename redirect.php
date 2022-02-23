<?php

  $index_uri = $_SERVER["REQUEST_URI"];
  $index_uri = explode("/", $index_uri);

  if ((!isset($_SESSION["LOGIN_STATUS"])) or $_SESSION["LOGIN_STATUS"] == false) {
    header('Location: /'.$index_uri[1]);
  }

?>