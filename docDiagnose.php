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


    <title>Diagnose Patient</title>
</head>
<body>

    <!-- Page Wrapper -->
    <div id="page-container">

        <!-- Sidebar -->
        <div id="sidebar">
            <div class="section">
                <div id="greeting"><span id="greeting-text">Welcome,<br>Dr. <?php echo $user_data['Name'];?>!</span></div>
                <div> <a class="item" href="doctorHome.php">Home</a></div>
                <div> <a class="item" href="docPatients.php">Patient Info</a></div>
                <div> <a class="item" href="docDiagnose.php" id="selected">Diagnose Patient</a></div>
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

        <div id="data-info"
        <!-- Data Entry -->
        <div class="card" style="padding-right:60px;">
            <form autocomplete="off" method="post">
                <div id="box-name">Please enter the prescription name below to search:</div>

                <div class="group">
                    <input type="text" name="drug_name" required="required" /><span class="highlight"></span><span class="bar"></span>
                        <label>Medication Name</label>
                </div>

                <div class="btn-box">
                    <button class="btn btn-login" type="submit">Submit</button>
                </div>
            </form>
        </div>
        <div class="card">
            <form autocomplete="off" method="post">
                <div id="box-name">Please fill out the patient referral form below:</div>

                <div class="group">
                    <input type="text" name="drug_id" required="required" /><span class="highlight"></span><span class="bar"></span>
                        <label>Prescription ID</label>
                </div>
                <div class="group">
                    <input type="text" name="quantity" required="required" /><span class="highlight"></span><span class="bar"></span>
                        <label>Quantity</label>
                </div>
                <div class="group">
                    <input type="text" name="user_name" required="required" /><span class="highlight"></span><span class="bar"></span>
                        <label>Your Username</label>
                </div>
                <div class="group">
                    <input type="text" name="patient_id" required="required" /><span class="highlight"></span><span class="bar"></span>
                        <label>Patient ID</label>
                </div>
                <div class="group">
                    <input type="text" name="symptom" required="required" /><span class="highlight"></span><span class="bar"></span>
                        <label>Symptoms</label>
                </div>

                <div class="btn-box">
                    <button class="btn btn-login" type="submit">Submit</button>
                </div>
            </form>
        </div>
        <div class="card">
            <?php
                $result1 = null;
                $result2 = null;

                if ($_SERVER['REQUEST_METHOD'] == "POST")
                {
                    $drugName = $_POST['drug_name'];
                    $drugId = $_POST['drug_id'];
                    $quantity = $_POST['quantity'];
                    $userName = $_POST['user_name'];
                    $patientId = $_POST['patient_id'];
                    $symptom = $_POST['symptom'];

                    if (!empty($drugName))
                    {
                        $query1 = "select *
                                from Drugs
                                where Name = '$drugName'";
                        $result1 = mysqli_query($con, $query1);

                        if (!$result1)
                        {
                            echo "Could not successfully run query from DB: " . mysql_error();
                        }

                        if ($result1)
                        {
                            if ($result1 && mysqli_num_rows($result1) > 0)
                            {
                                echo"<table id='table' border='1'>";
                                echo"<tr><td>Prescription Name</td><td>Prescription ID</td><td>Type</td><td>Cost</td></tr>\n";
                                while($row = mysqli_fetch_assoc($result1)) {
                                    echo"<tr><td>{$row['Name']}</td><td>{$row['DrugID']}</td><td>{$row['Type']}</td><td>{$row['Cost']}</td></tr>\n";
                                }
                                echo"</table>";
                            }
                        }
                    }

                    if (!empty($drugId) && !empty($quantity) && !empty($userName) && !empty($patientId) && !empty($symptom))
                    {
                        $query2 = "INSERT INTO Referral (Username, PatientID, Symptom, DrugID, Quantity) VALUES ('$userName', $patientId, '$symptom', $drugId, $quantity)";
                        $result2 = mysqli_query($con, $query2);

                        if ($result2) {
                            echo "New record created successfully";
                        } else {
                            echo "Error: " . $query2 . "<br>" . mysqli_error($con);
                        }
                    }
                }
            ?>
        </div>
     </div>
   </div>
        <!-- Footer -->
        <div id="footer">
            <p>Created by Dawson, Matt, and Davey</p>
        </div>
    </div>
</body>
</html>
