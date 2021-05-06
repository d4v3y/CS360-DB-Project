<?php
session_start();
    
    error_reporting(0);
    include("includes/dbconn.php");
    include("functions.php");

    $con = new mysqli($servername, $username, "", "db1", $sqlport, $socket);

    if ($con->connect_error) 
    {
      die("Failed to connect: " . $con->connect_error);
    }
 
    $user_data = check_login($con);
    $result1 = null;
    $result2 = null;
    $result3 = null;

    if ($_SERVER['REQUEST_METHOD'] == "POST")
    {
        $referralId = $_POST['referral_id'];
        $patientId = $_POST['patient_id'];

        if (!empty($referralId) && empty($patient_id))
        {
            $query1 = "select *
                       from Purchases
                       where ReferralID = '$referralId'";
            $result1 = mysqli_query($con, $query1);
            if (!$result1)
            {
                echo "Could not successfully run query from DB: " . mysql_error();
            }
            
            if ($result1)
            {
                if ($result1 && mysqli_num_rows($result1) > 0)
                {
                    echo"<table border='1'>";
                    echo"<tr><td>Referral ID</td><td>Insurance ID</td><td>Drug ID</td><td>Patient ID</td><td>Total Cost</td></tr>\n";
                    while($row = mysqli_fetch_assoc($result1))
                    {
                        echo"<tr><td>{$row['ReferralID']}</td><td>{$row['InsuranceID']}</td><td>{$row['DrugID']}</td><td>{$row['PatientID']}</td><td>{$row['Cost']}</td></tr>\n";
                    }
                    echo"</table>";
                    
                    //$search_data = mysqli_fetch_assoc($result1);
                }
            }
        }

        else if (empty($referralId) && !empty($patientId))
        {
            $query2 = "select *
                       from Purchases
                       where PatientID = '$patientId'";
            $result2 = mysqli_query($con, $query2);

            if (!$result2)
            {
                echo "Could not successfully run query from DB: " . mysql_error();
            }
            
            if ($result2)
            {
                if ($result2 && mysqli_num_rows($result2) > 0)
                {
                    echo"<table border='1'>";
                    echo"<tr><td>Patient ID</td><td>Insurance ID</td><td>Drug ID</td><td>Referral ID</td><td>Total Cost</td></tr>\n";
                    while($row = mysqli_fetch_assoc($result2))
                    {
                        echo"<tr><td>{$row['PatientID']}</td><td>{$row['InsuranceID']}</td><td>{$row['DrugID']}</td><td>{$row['ReferralID']}</td><td>{$row['Cost']}</td></tr>\n";
                    }
                    echo"</table>";

                    //$search_data = mysqli_fetch_assoc($result2);
                }
            }           
        }

        else if (!empty($referralId) && !empty($patientId))
        {
            $query3 = "select *
                       from Purchases
                       where ReferralID = '$referralId' AND PatientID = '$patientId'";
            $result3 = mysqli_query($con, $query3);
            if (!$result3)
            {
                echo "Could not successfully run query from DB: " . mysql_error();
            }
            
            if ($result3)
            {
                if ($result3 && mysqli_num_rows($result3) > 0)
                {
                    echo"<table border='1'>";
                    echo"<tr><td>Patient ID</td><td>Insurance ID</td><td>Drug ID</td><td>Referral ID</td><td>Total Cost</td></tr>\n";
                    while($row = mysqli_fetch_assoc($result3))
                    {
                        echo"<tr><td>{$row['PatientID']}</td><td>{$row['InsuranceID']}</td><td>{$row['DrugID']}</td><td>{$row['ReferralID']}</td><td>{$row['Cost']}</td></tr>\n";
                    }
                    echo"</table>";

                    //$search_data = mysqli_fetch_assoc($result2);
                }
            }           
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="/css/pharmacy.css">

    <link rel="icon" href="/health_icon16x16.png"/ type="image/png" sizes="16x16">
    <link rel="icon" href="/health_icon32x32.png"/ type="image/png" sizes="32x32">


    <title>Patient Purchase History</title>
</head>
<body>

    <!-- Page Wrapper -->
    <div id="page-container">
        
        <!-- Sidebar -->
        <div id="sidebar">
            <div class="section">
                <div id="greeting"><span id="greeting-text">Welcome,<br><?php echo $user_data['Name'];?> Pharmacy!</span></div>
                <div> <a class="item" href="pharmacyHome.php">Home</a></div>
                <div> <a class="item" href="pharmSell.php">Patient Purchase</a></div>
                <div> <a class="item" href="pharmHistory.php" id="selected">Purchase History</a></div>
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
                <a id="logo" href="pharmacyHome.php">MyHealthPortal</a>
            </div>

            <div id="data-info">
                <!-- Data Entry Box -->
                <div class="card">
                    <form autocomplete="off" method="post">
                        <div id="box-name">Please fill in at least one of the fields below:</div>
                
                        <div class="group">
                            <input type="text" name="referral_id" required="required" /><span class="highlight"></span><span class="bar"></span>
                            <label>Referral ID</label>
                        </div>
                        <div class="group">
                            <input type="text" name="patient_id" required="required" /><span class="highlight"></span><span class="bar"></span>
                            <label>Patient ID</label>
                        </div>
        
                        <div class="btn-box">
                            <button class="btn btn-login" type="submit">Submit</button>
                        </div>
                    </form>
                </div>

                <!-- Output Information from Queries -->
                <div class="card">
                        <div id="text"><span id="output-information">Purchase History<br>Referral ID: <?php echo $search_data['ReferralID'];?></span></div>
                        <div id="text"><span id="output-information">Patient ID: <?php echo $search_data['PatientID'];?></span></div>
                        <div id="text"><span id="output-information">Insurance ID: <?php echo $search_data['InsuranceID'];?></span></div>
                        <div id="text"><span id="output-information">Drug ID: <?php echo $search_data['DrugID'];?></span></div>
                        <div id="text"><span id="output-information">Total Cost: $<?php echo $search_data['Cost'];?></span></div>
                </div>
                
                <!-- Footer -->
                <div id="footer">
                    <p>Created by Dawson, Matt, and Davey</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>