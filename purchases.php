<?php
session_start();

    include("connection.php");
    include("functions.php");

    $user_data = check_login($con);
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

    <p>Patient purchase history goes here.</p>
</body>
</html>