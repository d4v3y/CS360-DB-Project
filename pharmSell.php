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

        if (!empty($referralId))
        {
            echo "1";
            $query1 = "select *
                      from Referral r
                      where ReferralID = '$referralId'";
            echo "2";
            $result1 = mysqli_query($con, $query1);
            echo "3";

            if (!$result1)
            {
                echo "Could not successfully run query from DB: " . mysql_error();
            }
            
            if (mysql_num_rows($result1) == 0)
            {
                echo "No rows found, nothing to print";
            }
            
            if ($result1)
            {
                echo "4";
                if ($result1 && mysqli_num_rows($result1) > 0)
                {
                    echo "hello";
                    $search_data1 = mysqli_fetch_assoc($result1);
                }
	    	$query2 = "select *
			   from Drugs
			   where DrugID IN (
				select DrugID
				from Referral
				where ReferralID = '$referralId')";
		    $result2 = mysqli_query($con, $query2);

		    if (!$result2) 
		    {
                echo "Could not successfully run query from DB: " . mysql_error();
            }

		    if ($result2)
		    {
		        if ($result2 && mysqli_num_rows($result2) > 0)
                {
                    echo "Made it to result 2"; 
			        $search_data2 = mysqli_fetch_assoc($result2);
                }
		    }
	    	
                $query3 = "select *
			              from Patients
			              where PatientID IN (
				          select PatientID
				          from Referral
				          where ReferralID = '$referralId')";
		        $result3 = mysqli_query($con, $query3);
		
                if (!$result3) 
		        {
                    echo "Could not successfully run query from DB: " . mysql_error();
                }
		
                if ($result3)
		        {
		            if ($result3 && mysqli_num_rows($result3) > 0)
                    {
                        echo "Made it to result 3"; 
			            $search_data3 = mysqli_fetch_assoc($result3);
                    }
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


    <title>Patient Order</title>
</head>
<body>

    <!-- Page Wrapper -->
    <div id="page-container">
        
        <!-- Sidebar -->
        <div id="sidebar">
            <div class="section">
                <div id="greeting"><span id="greeting-text">Welcome,<br><?php echo $user_data['Name'];?> Pharmacy!</span></div>
                <div> <a class="item" href="pharmacyHome.php">Home</a></div>
                <div> <a class="item" href="pharmSell.php" id="selected">Patient Purchase</a></div>
                <div> <a class="item" href="pharmHistory.php">Purchase History</a></div>
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

            <!-- Output Information from Queries -->
            <div id="data-info">
            	<!-- Data Entry -->
            	<div class="card">
                	<form autocomplete="off" method="post">
                    		<div id="box-name">Please enter the referral information below:</div>
        
                    		<div class="group">
                        		<input type="text" name="referral_id" required="required" /><span class="highlight"></span><span class="bar"></span>
                    			<label>Referral ID</label>
                            </div>
    
                    		<div class="btn-box">
                        		<button class="btn btn-login" type="submit">Submit</button>
                    		</div>
                	</form>
            	</div>
            
                <div class="card">
                    <div id="text"><span id="output-information">Referral Information<br>Referral ID: <?php echo $search_data1['ReferralID'];?></span></div>
                    <div id="text"><span id="output-information">Patient ID: <?php echo $search_data1['PatientID'];?></span></div>
                    <div id="text"><span id="output-information">Drug ID: <?php echo $search_data1['DrugID'];?></span></div>
                    <div id="text"><span id="output-information">Quantity: <?php echo $search_data1['Quantity'];?></span></div>
                </div>
                <div class="card">
                    <div id="text"><span id="output-information"><br>Prescription Information<br>Drug Id: <?php echo $search_data2['Drug'];?></span></div>
                    <div id="text"><span id="output-information">Prescription Name: <?php echo $search_data2['Name'];?></span></div>
                    <div id="text"><span id="output-information">Prescription Type: <?php echo $search_data2['Type'];?></span></div>
                    <div id="text"><span id="output-information">Market Cost: $<?php echo $search_data2['Cost'];?></span></div>
                </div>
                <div class="card">
                    <div id="text"><span id="output-information"><br>Patient Information<br>Patient Name: <?php echo $search_data3['Last Name']; echo ", "; echo $search_data3['First Name'];?></span></div>
                    <div id="text"><span id="output-information">Patient Insurance ID: <?php echo $search_data3['InsurancID'];?></span></div>
                    <div id="text"><span id="output-information">Patient Address: <?php echo $search_data3['Street']; echo $search_data3['City']; echo $search_data3['State']; echo $search_data3['Zip'];?></span></div>
                </div>
    
                <!-- This Button will eventually write the transaction to the "purchases" database -->
                <div class="btn-box">
                    <button class="btn btn-login" type="submit">Record Transaction</button>
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