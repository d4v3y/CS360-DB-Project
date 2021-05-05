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

    <link rel="stylesheet" href="./css/doctor.css">

    <link rel="icon" href="/health_icon16x16.png"/ type="image/png" sizes="16x16">
    <link rel="icon" href="/health_icon32x32.png"/ type="image/png" sizes="32x32">

    <title>Patient Perscribe</title>
</head>
<body>

    <!-- Page Wrapper -->
    <div id="page-container">
        
        <!-- Sidebar -->
        <div id="sidebar">
            <div class="section">
                <div id="greeting"><span id="greeting-text">Welcome,<br>Dr. <?php echo $user_data['Name'];?>!</span></div>
                <div> <a class="item" href="doctorHome.php">Home</a></div>
                <div> <a class="item" href="docPatients.php">Patient Info</a></div>
                <div> <a class="item" href="docDiagnose.php">Diagnose Patient</a></div>
                <div> <a class="item" href="docPrescribe.php" id="selected">Patient Services</a></div>
            </div>

            <div class="section">
                <div class="btn-box">
                    <a class="btn btn-logout" href="logout.php">logout</a>
                </div>
            </div>
        </div>

        <!-- Top Banner -->
        <div id="welcome-banner">
            <a id="logo" href="doctorHome.php">MyHealthPortal</a>
        </div>
        
        <!-- Footer -->
        <div id="footer">
            <p>Created by Dawson, Matt, and Davey</p>
        </div>
    </div>
</body>
</html>