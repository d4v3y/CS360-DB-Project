<?php
session_start();
   
    error_reporting(0);
    include("includes/dbconn.php");
    include("functions.php");
 
    $con = new mysqli($servername, $username, "", "db1", $sqlport, $socket);

    if ($con->connect_error) {
      die("Failed to connect: " . $con->connect_error);
    }
 
     $user_data = check_login($con);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="/css/main.css">

    <link rel="icon" href="/health_icon16x16.png"/ type="image/png" sizes="16x16">
    <link rel="icon" href="/health_icon32x32.png"/ type="image/png" sizes="32x32">


    <title>Presribe Patient</title>
</head>
<body>
    <a href="logout.php">Logout</a>

    <header>
        <nav>
            <li><a href="doctorHome.php">Home</a></li>
            <li><a href="docPatients.php">Patients Info</a></li>
            <li><a href="docDiagnose.php">Diagnose</a></li>
            <li><a href="docPrescribe.php">Patient Services</a></li>
        </nav>
    </header>

    <h1>Presribe patient with either medicine, tests, or services.</h1>

</body>
</html>
