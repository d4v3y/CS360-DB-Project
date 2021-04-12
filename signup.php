<?php
session_start();

    include("connection.php");
    include("functions.php");

    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        
        // Something was posted
        $user_name = $_POST['user_name'];
        $password = $_POST['password'];

        if (!empty($user_name) && !empty($password)) {

            // Save to database
            $query = "insert into pharmacy (PharmacyID, Password) values ('$user_name', '$password')";

            mysqli_query($con, $query);

            header("Location: login.php");
            die;
        } else {
            echo "Please enter some valid information!";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Patient Protal Signup</title>
</head>
<body>
    <div id="box">
        <form method="post">
            <div style="font-size: 20px;margin: 10px;">Signup</div>
            
            <input type="text" name="user_name"placeholder="Username"><br><br>
            <input type="text" name="password"placeholder="Password"><br><br>

            <input type="submit" value="Signup"><br><br>
            <a href="login.php">Click to login</a>
        </form>
    </div>
</body>
</html>