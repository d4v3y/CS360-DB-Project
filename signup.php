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
        $userId = $_POST['userId'];
        $user_name = $_POST['user_name'];
        $password = $_POST['password'];
        $name = $_POST['name'];
        $street = $_POST['street'];
        $city = $_POST['city'];
        $state = $_POST['state'];
        $zip = $_POST['zip'];
        $user_type = $_POST['user_type'];

        if (!empty($user_name) && !empty($password) && !empty($name) && !empty($street) && !empty($city) && !empty($state) && !empty($zip) && !empty($user_type)) {

            // Save to database
            if ($user_type === "Pharmacist") {
                $query = "insert into Pharmacy (PharmacyID, Username, Password, Name, Street, City, State, Zip, UserType) values ('$userId', '$user_name', '$password', '$name', '$street', '$city', '$state', '$zip', '$user_type')";
                
                mysqli_query($con, $query);

                header("Location: login.php");
                die;
            } else if ($user_type === "Doctor") {
                
                $query = "insert into Provider (ProviderID, Username, Password, Name, Street, City, State, Zip, UserType) values ('$userId', '$user_name', '$password', '$name', '$street', '$city', '$state', '$zip', '$user_type')";
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
    <h1>Sign Up</h1>
</head>
<body>
    <div id="box">
        <form method="post">
            <div style="font-size: 20px;margin: 10px;">Please enter your personal information below to get started</div>
            
            <label for="user_type">Choose your profession:</label>
            <select name="user_type" id="user_type">
                <option disabled selected value> -- select an option -- </option>
                <option value="Pharmacist">Pharmacist</option>
                <option value="Doctor">Doctor</option>
            </select>
            <br><br>
            <input type="text" name="userId" placeholder="User ID"><br><br>
            <input type="text" name="user_name" placeholder="Username"><br><br>
            <input type="password" name="password" placeholder="Password" minlength="8"><br><br>
            <input type="text" name="name" placeholder="Name"><br><br>
            <input type="text" name="street" placeholder="Street"><br><br>
            <input type="text" name="city" placeholder="City"><br><br>
            <input type="text" name="state" placeholder="State"><br><br>
            <input type="text" name="zip" placeholder="Zip Code"><br><br>

            <input type="submit" value="Signup"><br><br>
            <a href="login.php">Click to login</a>
        </form>
    </div>
</body>
</html>
