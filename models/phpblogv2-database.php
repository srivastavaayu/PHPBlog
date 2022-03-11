<?php

  function connectDatabase() {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $databasename = "PHPBlogv2";

    try {
      $conn = new mysqli($servername, $username, $password);

      $sql = "CREATE DATABASE IF NOT EXISTS $databasename";

      $conn -> query($sql);

      $conn = new mysqli($servername, $username, $password, $databasename);
      $returnValue = [TRUE, $conn];
    }
    catch (mysqli_sql_exception $exception) {
      $returnValue = [FALSE];

    }
    return $returnValue;
  }

?>