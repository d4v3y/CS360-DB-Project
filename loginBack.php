<?php
session_start();
   
   include("includes/dbconn.php");
   include("functions.php");

   $con = new mysqli($servername, $username, "", "db1", $sqlport, $socket);

   if ($con->connect_error) {
      die("Failed to connect: " . $con->connect_error);
   }
    
   if ($_SERVER['REQUEST_METHOD'] == "POST") {
        
        // Something was posted
        $user_name = $_POST['user_name'];
        $password = $_POST['password'];

        if (!empty($user_name) && !empty($password)) {

            // Read from database
            $query1 = "select * from Pharmacy where Username = '$user_name' limit 1";
            $query2 = "select * from Provider where Username = '$user_name' limit 1";
            $result1 = mysqli_query($con, $query1);
            $result2 = mysqli_query($con, $query2);
            
            if ($result1) {
             
                if ($result1 && mysqli_num_rows($result1) > 0) {
                    $user_data = mysqli_fetch_assoc($result1);
             
                    if ($user_data['Password'] === $password) {
             
                        $_SESSION['Username'] = $user_data['Username'];
                        header("Location: pharmacyHome.php");
                        die;
                    }
                }
            } else if ($result2){
               if ($result2 && mysqli_num_rows($result2) > 0) {
                     $user_data = mysqli_fetch_assoc($result2);
 
                     if ($user_data['Password'] === $password) {
 
                         $_SESSION['Username'] = $user_data['Username'];
                         header("Location: doctorHome.php");
                         die;
                     }
                 }
             }
            echo "First Wrong username or password!"; 
        } else {
            echo "Second Wrong username or password!";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="health_icon16x16.png" type="image/png" sizes="16x16">
    <link rel="icon" href="health_icon32x32.png" type="image/png" sizes="32x32">
    <title>My Patient Portal Login</title>
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
