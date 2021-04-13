<?php
$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "cs360project";

if (!$con = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname)) {
    die("Failed to connect!");
}

/*** WIP: This almost connects to the shared server. ***/
// $dbhost = "localhost";
// $dbuser = "httpdh33";
// $dbname = "db1";
// $dbport = "3339";
// $dbsocket = "/vols/sdb37/httpdh33_db/httpdh33_db.sock";

// $conn = new mysqli($dbhost, $dbuser, "", $dbname, $dbport, $dbsocket);

// if (!$con = mysqli_connect($dbhost, $dbuser, "", $dbname, $dbport, $dbsocket)) {
//     die("Failed to connect!");
// }
