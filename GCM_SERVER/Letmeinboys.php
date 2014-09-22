<?php

//session_save_path("");
session_start();

include './sharedkeys.php';

if(isset($_SESSION['startup'])){
    header("Location: " . WEBSITE_URL . $_SESSION['startup']);
}

if(isset($_POST['username']) && isset($_POST['password'])){
    include_once './db_functions.php';
    $db = new DB_Functions();
    
    $result = $db->login($_POST['username'], $_POST['password']);
    
    if($result == null){
        header("Location:" . WEBSITE_URL . "login.php");
    }
   
    $user_page = "login.php";
    
    while ($row = mysql_fetch_array($result)) {
        $_SESSION['fname'] = $row['fname'];
        $_SESSION['lname'] = $row['lname'];
        $_SESSION['status'] = $row['status'];
        $_SESSION['startup'] = $row['startup'];
        $user_page = $row['startup'];
    }
    
    header("Location:" . WEBSITE_URL . $user_page);
}else{
    header("Location:" . WEBSITE_URL . "login.php");
}

?>
