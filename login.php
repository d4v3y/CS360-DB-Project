<?php
session_start();
   
   include("includes/dbconn.php");
   include("functions.php");

   $con = new mysqli($servername, $username, "", "db2", $sqlport, $socket);

   if ($con->connect_error) {
      die("Failed to connect: " . $con->connect_error);
   }
    
   if ($_SERVER['REQUEST_METHOD'] == "POST") {
        
        // Something was posted
        $user_name = $_POST['user_name'];
        $password = $_POST['password'];

        if (!empty($user_name) && !empty($password)) {

            // Read from database
            $query = "select * 
                      from Pharmacy p 
                      where Username = '$user_name' 
                      UNION
                      select * 
                      from Provider v 
                      where Username = '$user_name'";
            
            $result = mysqli_query($con, $query);
            
            if ($result) {
             
                if ($result && mysqli_num_rows($result) > 0) {
                    $user_data = mysqli_fetch_assoc($result);
             
                    if ($user_data['Password'] === $password && $user_data["UserType"] === "Pharmacist") {
                        $_SESSION['Username'] = $user_data['Username'];
                        header("Location: pharmacyHome.php");
                        die;
                    } else if ($user_data['Password'] === $password && $user_data["UserType"] == "Doctor") {
                        $_SESSION['Username'] = $user_data['Username'];
                        header("Location: doctorHome.php");
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
    
    <link rel="icon" href="health_icon16x16.png" type="image/png" sizes="16x16">
    <link rel="icon" href="health_icon32x32.png" type="image/png" sizes="32x32">
    <link rel="stylesheet" href="css/login.css">
    
    <title>My Patient Portal Login</title>
</head>
<body>

    <!-- Page Wrapper -->
    <div id="page-container">

        <!-- Top Banner -->
        <nav id="welcome-banner">
            <a href="login.php">MyHealthPortal</a>
        </nav>

        <!-- Content Wrapper -->
        <div id="content-wrap">

            <!-- Login Box -->
            <div class="card">
                <form autocomplete="off" method="post">
                    <div id="box-name">Welcome, Login!</div>
                    
                    <div class="group">
                        <input type="text" name="user_name" required="required" /><span class="highlight"></span><span class="bar"></span>
                        <label>Username</label>
                    </div>
                    <div class="group">
                        <input type="password" name="password" required="required" /><span class="highlight"></span><span class="bar"></span>
                        <label>Password</label>
                    </div>
    
                    <div class="btn-box">
                        <button class="btn btn-login" type="submit">Login</button>
                    </div>

                    <a id="signup-btn" href="signup.php">Don't have an account? Click to signup</a>
                </form>
            </div>

        </div>

        <!-- Footer -->
        <footer id="footer">
            <p>Created by Dawson, Matt, and Davey</p>
        </footer>
    </div>
</body>
</html>