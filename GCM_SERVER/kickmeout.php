<?php

session_destroy();
unset($_SESSION['fname']);
unset($_SESSION['lname']);
unset($_SESSION['status']);
unset($_SESSION['startup']);

include_once './sharedkeys.php';
header("Location:" .PROJECT_URL . "login.php");
?>
