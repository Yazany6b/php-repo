<?php

session_start();

if(isset($_POST['login']) && isset($_POST['password'])){

    include_once './db_functions.php';
    $db = new DB_Functions();
    
    $result = $db->login($_POST['login'], $_POST['password']);
    include './sharedkeys.php';
    if($result == null)
    {
        $_SESSION['respons'] = "Wrong username or password!!";
        header("Location:" . PROJECT_URL . "login.php");
        die();
    }
    
/*    $row = mysql_fetch_array($result);
    
    $_SESSION['fname'] = $row['fname'];
    $_SESSION['lname'] = $row['lname'];
    $_SESSION['status'] = $row['status'];
    $_SESSION['startup'] = $row['startup'];
    $loc = $row['startup'];*/

    $_SESSION['fname'] = "AppUser";
    $_SESSION['lname'] = "Anonymus";
    $_SESSION['status'] = "ADMIN";
    $_SESSION['startup'] = "index.php";
    $loc = PROJECT_URL .  "index.php";

    header("Location:" . $loc);
}

?>
