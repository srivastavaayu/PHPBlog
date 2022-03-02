<?php

  require_once("session.php");
  require_once("../general.php");
  require_once("redirect.php");
  require_once("../views/404.php");

  $session = startSession();

  if ($session[0] === FALSE) {
    $view = return404();
  }
  else {
    $_SESSION["LOGIN_STATUS"] = FALSE;
    $_SESSION["LOGIN_USER"] = -1;

    session_unset();
    session_destroy();
    header('Location: /'.$index_uri[1]);
  }

  echo $view;

?>