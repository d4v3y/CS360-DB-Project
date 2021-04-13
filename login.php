<?php
session_start();
    include("connection.php");
    include("functions.php");

    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        
        // Something was posted
        $user_name = $_POST['user_name'];
        $password = $_POST['password'];

        if (!empty($user_name) && !empty($password)) {

            // Read from database
            $query = "select * from pharmacy where PharmacyID = '$user_name' limit 1";
            $result = mysqli_query($con, $query);
            if ($result) {
                if ($result && mysqli_num_rows($result) > 0) {
                    $user_data = mysqli_fetch_assoc($result);
                    
                    if ($user_data['Password'] === $password) {
                        $_SESSION['PharmacyID'] = $user_data['PharmacyID'];
                        header("Location: index.php");
                        die;
                    }
                }
            }
            echo "Wrong username or password!"; 
        } else {
            echo "Wrong username or password!";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Patient Portal Login</title>
    <link rel="icon" href="health_icon16x16.png" type="image/png" sizes="16x16">
    <link rel="icon" href="health_icon32x32.png" type="image/png" sizes="32x32">
</head>
<body>
    <div id="box">
        <form method="post">
            <div style="font-size: 20px;margin: 10px;">Login</div>
            
            <input type="text" name="user_name" placeholder="Username"><br><br>
            <input type="password" name="password" placeholder="Password"><br><br>

            <input type="submit" value="Login"><br><br>
            <a href="signup.php">Click to signup</a>
        </form>
    </div>
</body>
</html>