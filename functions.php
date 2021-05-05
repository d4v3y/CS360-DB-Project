<?php

function check_login($con) {

    if (isset($_SESSION['Username'])) {

        $id = $_SESSION['Username'];
        $query = "select *
                      from Pharmacy p
                      where Username = '$id'
                      UNION
                      select *
                      from Provider v
                      where Username = '$id'";
        
        $result = mysqli_query($con, $query);
        if ($result && mysqli_num_rows($result) > 0) {
            $user_data = mysqli_fetch_assoc($result);
            return $user_data;
        }
    }

    // Redirect to login
    header("Location: index.php");
    die;

}
