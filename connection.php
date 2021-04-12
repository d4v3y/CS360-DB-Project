<?php
$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "cs360project";

if (!$con = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname)) {
    die("Failed to connect!");
}