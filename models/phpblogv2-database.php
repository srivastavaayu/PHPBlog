<?php

  function connectDatabase() {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $databasename = "PHPBlogv2";

    $conn = new mysqli($servername, $username, $password);

    $sql = "CREATE DATABASE IF NOT EXISTS $databasename";

    if ($conn -> query($sql) === TRUE) {
      $conn = new mysqli($servername, $username, $password, $databasename);
      $returnValue = [TRUE, $conn];
      return $returnValue;
    }
    else {
      $returnValue = [FALSE];
      return $returnValue;
    }
  }

?>