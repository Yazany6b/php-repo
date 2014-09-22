<?php

session_destroy();
unset($_SESSION['fname']);
unset($_SESSION['lname']);
unset($_SESSION['status']);
unset($_SESSION['startup']);

include_once './sharedkeys.php';
header("Loaction:" . WEBSITE_URL . "login.php");
?>
