<?php
session_start();

if (isset($_SESSION['PharmacyID'])) {
    unset($_SESSION['PharmacyID']);
}

header("Location: login.php");
die;