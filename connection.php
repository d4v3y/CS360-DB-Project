<?php
$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "cs360project";

$con = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

if ($con->connect_error) {
    die("Failed to connect!");
}

/*** WIP: This almost connects to the shared server. ***/
// $dbhost = "localhost";
// $dbuser = "httpdh33";
// $dbname = "db2";
// $dbport = "3339";
// $dbsocket = "/vols/sdb37/httpdh33_db/httpdh33_db.sock";

// if (!$con = mysqli_connect($dbhost, $dbuser, "", $dbname, $dbport, $dbsocket)) {
//     die("Failed to connect!");
// }