<?php
session_start();

    include("includes/dbconn.php");
    include("functions.php");

    $con = new mysqli($servername, $username, "", "db2", $sqlport, $socket);
    
    $user_data = check_login($con);

    $user_name = $_GET['user_name'];

    $dbquery = "select PatientID from Purchases where PharmacyID = 
                  select PharmacyID from Pharmacy where Username = '$user_name' ";

    $result = mysqli_query($con, $dbquery);
    $user_data = mysqli_fetch_assoc($result);
    echo $user_data;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="/css/main.css">

    <title>My Patient Portal</title>
</head>
<body>
    <a href="logout.php">Logout</a>

    <header>
        <nav>
            <li><a href="index.php">Home</a></li>
            <li><a href="purchases.php">Purchase History</a></li>
            <li><a href="insurance.php">Insurance Info</a></li>
        </nav>
    </header>

    <p>Show previous patients that dealt has a corrilation with the pharamacy.</p>

     <section>
     
     </section>
</body>
</html>
