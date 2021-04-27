<?php
$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "db2";

$mysqli = new mysqli("localhost","root","","db2");

// Check connection
if ($mysqli -> connect_errno) {
  echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
  exit();
}

/*** WIP: This almost connects to the shared server. ***/
// $dbhost = "localhost";
// $dbuser = "httpdh33";
// $dbname = "db1";
// $dbport = "3339";
// $dbsocket = "/vols/sdb37/httpdh33_db/httpdh33_db.sock";

// $conn = new mysqli($dbhost, $dbuser, "", $dbname, $dbport, $dbsocket);

// if (!$con = mysqli_connect($dbhost, $dbuser, "", $dbname, $dbport, $dbsocket)) {
//     die("You messed up!");
// }
