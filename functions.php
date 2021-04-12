<?php

function check_login($con) {

    if (isset($_SESSION['PharmacyID'])) {

        $id = $_SESSION['PharmacyID'];
        $query = "select * from pharmacy where PharmacyID = '$id' limit 1";

        $result = mysqli_query($con, $query);
        if ($result && mysqli_num_rows($result) > 0) {
            $user_data = mysqli_fetch_assoc($result);
            return $user_data;
        }
    }

    // Redirect to login
    header("Location: login.php");
    die;
}