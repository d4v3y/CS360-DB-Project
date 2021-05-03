<?php

function check_login($con) {

    if (isset($_SESSION['PharmacyID'])) {

        $id = $_SESSION['PharmacyID'];
        $query = "select *
                      from Pharmacy p
                      where PharmacyID = '$id'
                      UNION
                      select *
                      from Provider v
                      where ProviderID = '$id'";
        
        $result = mysqli_query($con, $query);
        if ($result && mysqli_num_rows($result) > 0) {
            $user_data = mysqli_fetch_assoc($result);
            return $user_data;
        }
    } else if (isset($_SESSION['Provider'])) {

        $id = $_SESSION['Provider'];
        $query = "select *
                      from Pharmacy p
                      where PharmacyID = '$id'
                      UNION
                      select *
                      from Provider v
                      where ProviderID = '$id'";
        
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
