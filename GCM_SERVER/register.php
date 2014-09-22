<?php

// response json
$json = array();

/**
 * Registering a user device
 * Store reg id in users table
 */

if (isset($_POST["oldregId"]) && isset($_POST["regId"])) {
    
    $gcm_regid = $_POST["regId"]; 
    $oldgcm_regid = $_POST["oldregId"]; 
    
    include_once './db_functions.php';
    //include_once './GCM.php';

    $db = new DB_Functions();
    //$gcm = new GCM();
    
    if($db->updateRegistrationId($oldgcm_regid, $gcm_regid) > 0){
        die('1');
    }
    
    die('0');
}

if (isset($_POST["name"]) && isset($_POST["email"]) && isset($_POST["regId"])) {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $gcm_regid = $_POST["regId"]; // GCM Registration ID
    $lang = isset($_POST["lang"]) ? $_POST["lang"] : "unkown";
    $region = isset($_POST["region"]) ? $_POST["region"] : "unkown";

    // Store user details in db
    include_once './db_functions.php';
    include_once './GCM.php';

    $db = new DB_Functions();
    $gcm = new GCM();

    $res = $db->storeUser($name, $email, $gcm_regid,$region,$lang);
    return;
    $registatoin_ids = array($gcm_regid);
    $message = array("Price" => "<data><title>Welcome</title> <description>Thank you for installing the app you will now receive a notifications that carries the most amazing news , places and other stuff.</description></data>");

    $result = $gcm->send_notification($registatoin_ids, $message);

    echo $result;
} else {
    // user details missing
}
?>		