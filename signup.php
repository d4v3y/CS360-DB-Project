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
        $user_type = $_POST['user_type'];
        $user_name = $_POST['user_name'];
        $password = $_POST['password'];
        $name = $_POST['name'];
        $street = $_POST['street'];
        $city = $_POST['city'];
        $state = $_POST['state'];
        $zip = $_POST['zip'];

        if (!empty($user_name) && !empty($password) && !empty($name) && !empty($street) && !empty($city) && !empty($state) && !empty($zip) && !empty($user_type)) {

            // Save to database
            if ($user_type === "Pharmacist") {
                $query = "insert into Pharmacy (UserType, Username, Password, Name, Street, City, State, Zip) values ('$user_type', '$user_name', '$password', '$name', '$street', '$city', '$state', '$zip')";
                
                mysqli_query($con, $query);

                header("Location: login.php");
                die;
            } else if ($user_type === "Doctor") {
                
                $query = "insert into Provider (UserType, Username, Password, Name, Street, City, State, Zip) values ('$user_type', '$user_name', '$password', '$name', '$street', '$city', '$state', '$zip')";
                mysqli_query($con, $query);

                header("Location: login.php");
                die;
            }
        } else {
            echo "Please enter valid information!";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>My Patient Portal Signup</title>

    <link rel="stylesheet" href="css/signup.css">
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

            <!-- Signup Box -->
            <div class="card">
                <form autocomplete="off" method="post">
                    <div id="box-name">Signup!</div>
                    <!-- <div style="font-size: 16px;">Please enter your personal information below to get started.</div> -->

                    <div class="select">
                        <select class="select-text" name="user_type" id="user_type" required>
                            <option disabled selected value></option>
                            <option disabled value> -- select an option -- </option>
                            <option value="Pharmacist">Pharmacist</option>
                            <option value="Doctor">Doctor</option>
                        </select>
                        <span class="select-highlight"></span>
                        <span class="select-bar"></span>
                        <label class="select-label">Choose your profession:</label>
                    </div>

                    <div class="group">
                        <input type="text" name="user_name" required="required" />
                        <!-- <span class="highlight"></span> -->
                        <span class="bar"></span>
                        <label>Username</label>
                    </div>
                    <div class="group">
                        <input type="password" name="password" required="required" minlength="8" /><span class="highlight"></span><span class="bar"></span>
                        <label>Password</label>
                    </div>
                    <div class="group">
                        <input type="text" name="name" required="required" /><span class="highlight"></span><span class="bar"></span>
                        <label>Name</label>
                    </div>
                    <div class="group">
                        <input type="text" name="street" required="required" /><span class="highlight"></span><span class="bar"></span>
                        <label>Street</label>
                    </div>
                    <div class="group">
                        <input type="text" name="city" required="required" /><span class="highlight"></span><span class="bar"></span>
                        <label>City</label>
                    </div>
                    <div class="group">
                        <input type="text" name="state" required="required" /><span class="highlight"></span><span class="bar"></span>
                        <label>State</label>
                    </div>
                    <div class="group">
                        <input type="text" name="zip" required="required" /><span class="highlight"></span><span class="bar"></span>
                        <label>Zip Code</label>
                    </div>

                    <div class="btn-box">
                        <button class="btn btn-login" type="submit">Signup</button>
                    </div>

                    <a id="signup-btn" href="login.php">Already have an account? Click to login</a>
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
