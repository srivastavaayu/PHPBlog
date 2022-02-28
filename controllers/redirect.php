<?php

  require_once("session.php");
  require_once("../general.php");

  $session = startSession();

  if ((!(isset($_SESSION["LOGIN_STATUS"]))) or $_SESSION["LOGIN_STATUS"] == FALSE) {
    header('Location: /'.$apex_index_uri);
  }

?>