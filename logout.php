<?php
session_start();

if (isset($_SESSION['Username'])) {
    unset($_SESSION['Username']);
}

header("Location: index.php");
die;
