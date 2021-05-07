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


    <title>Patient Info</title>
</head>
<body>

    <!-- Page Wrapper -->
    <div id="page-container">

        <!-- Sidebar -->
        <div id="sidebar">
            <div class="section">
                <div id="greeting"><span id="greeting-text">Welcome,<br>Dr. <?php echo $user_data['Name'];?>!</span></div>
                <div> <a class="item" href="doctorHome.php">Home</a></div>
                <div> <a class="item" href="docPatients.php" id="selected">Patient Info</a></div>
                <div> <a class="item" href="docDiagnose.php">Diagnose Patient</a></div>
            </div>

            <div class="section">
                <div class="btn-box">
                    <a class="btn btn-logout" href="logout.php">logout</a>
                </div>
            </div>
        </div>

        <div id="content-wrap">

        <!-- Top Banner -->
        <div id="welcome-banner">
            <a id="logo" href="doctorHome.php">MyHealthPortal</a>
        </div>

        <div id="data-info">

            <div class="card">
                <form autocomplete="off" method="post">
                    <div id="box-name">Please enter the patient's information below:</div>

                    <div class="group">
                        <input type="text" name="patient_Fname" required="required" /><span class="highlight"></span><span class="bar"></span>
                        <label>First Name</label>
                    </div>
                    <div class="group">
                        <input type="text" name="patient_Lname" required="required" /><span class="highlight"></span><span class="bar"></span>
                        <label>Last Name</label>
                    </div>

                    <div class="btn-box">
                        <button class="btn btn-login" type="submit">Submit</button>
                    </div>
                </form>
            </div>

            <div class="card">
                <?php  
                    $result1 = null;

                    if ($_SERVER['REQUEST_METHOD'] == "POST")
                    {
                        $patientFname = $_POST['patient_Fname'];
                        $patientLname = $_POST['patient_Lname'];

                        if (!empty($patientFname) && !empty($patientLname))
                        {
                            $query1 = "select *
                                    from Patients p
                                    where `First Name` = '$patientFname' AND `Last Name` = '$patientLname'";
                            $result1 = mysqli_query($con, $query1);

                            if (!$result1)
                            {
                                echo "Could not successfully run query from DB: " . mysql_error();
                            }

                            if ($result1)
                            {
                                if ($result1 && mysqli_num_rows($result1) > 0)
                                {
                                    echo"<table class='card' border='1'>";
                                    echo"<tr><td>First Name</td><td>Last Name</td><td>Patient ID</td><td>Insurance ID</td><td>Age</td></tr>\n";
                                    while($row = mysqli_fetch_assoc($result1))
                                    {
                                        echo"<tr><td>{$row['First Name']}</td><td>{$row['Last Name']}</td><td>{$row['PatientID']}</td><td>{$row['InsurancID']}</td><td>{$row['Age']}</td></tr>\n";
                                    }
                                    echo"</table>";
                                    //$search_data1 = mysqli_fetch_assoc($result1);
                                }
                            }

                            $query2 = "select *
                                        from Referral
                                        where PatientID IN (
                                        select PatientID
                                        from Patients p
                                        where `First Name` = '$patientFname' AND `Last Name` = '$patientLname')";
                            $result2 = mysqli_query($con, $query2);

                            if (!$result2)
                            {
                                echo "Could not successfully run query from DB: " . mysql_error();
                            }

                            if ($result2)
                            {
                                if ($result2 && mysqli_num_rows($result2) > 0)
                                {
                                    echo"<table class='card' border='1'>";
                                    echo"<tr><td>Referral ID</td><td>Patient ID</td><td>Drug ID</td><td>Quantity</td><td>Symptoms</td></tr>\n";
                                    while($row = mysqli_fetch_assoc($result2))
                                    {
                                        echo"<tr><td>{$row['ReferralID']}</td><td>{$row['PatientID']}</td><td>{$row['DrugID']}</td><td>{$row['Quantity']}</td><td>{$row['Symptom']}</td></tr>\n";
                                    }
                                    echo"</table>";
                                    //$search_data2 = mysqli_fetch_assoc($result2);
                                }
                            }
                        }
                    }
                ?>
        </div>

        <!-- Footer -->
        <div id="footer">
            <p>Created by Dawson, Matt, and Davey</p>
        </div>
    </div>
</body>
</html>
