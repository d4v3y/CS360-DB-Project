<?php
$servername = "localhost";
$username = "username";
$password = "password";

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Patient Portal</title>

    <link rel="stylesheet" href="../css/patient.css">
</head>
<body>
    <section id="testText">
        <p class="patientGreeting">This is going to be the <span>patient portal</span>!</p>
        <a href="../index.php">Click to home</a>
    </section>
</body>
</html>