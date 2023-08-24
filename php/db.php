<?php

require_once __DIR__ . '/../php/config.php';


$conn = mysqli_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASS, MYSQL_DB, MYSQL_PORT);

// Check connection
if (!$conn) {
  die("DB Connection failed: " . mysqli_connect_error());
}

?>