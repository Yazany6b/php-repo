<?php

// response json
$json = array();

/**
 * Registering a user device
 * Store reg id in users table
 */
date_default_timezone_set('UTC');

if (isset($_REQUEST["oldregId"]) && isset($_REQUEST["regId"])) {

    $gcm_regid = $_REQUEST["regId"]; 
    $oldgcm_regid = $_REQUEST["oldregId"]; 
    
    include_once './db_functions.php';
    //include_once './GCM.php';

    $db = new DB_Functions();
    //$gcm = new GCM();
    
    if($db->updateRegistrationId($oldgcm_regid, $gcm_regid) > 0){
        die('1');
    }
    
    $result = "------------------------------------------------------------------\n";
    $result .= "FAIL to update reg at " . date("Y-m-d H:i:s") . "\n";
    $result .= "OLD : " . $oldgcm_regid . "\n";    
    $result .= "NEW : " . $gcm_regid . "\n";

    file_put_contents("updates_log.log", $result, FILE_APPEND | LOCK_EX);

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
    $registatoin_ids = array($gcm_regid);

    include './sharedkeys.php';

    $xml = new SimpleXMLElement('<data/>');

    $xml->addChild('title',"Welcome");
    $xml->addChild('description',"Thank you for installing the app you will now receive a notifications that carries the most amazing news , places and other stuff.");

    $image = $xml->addChild('images');

    $link = $image->addChild('link');
          
    $link->addChild('image',PROJECT_URL . "1.JPG");
    $link->addChild('thum',PROJECT_URL . "thum_1.JPG");

    $link = $image->addChild('link');
          
    $link->addChild('image',PROJECT_URL . "2.JPG");
    $link->addChild('thum',PROJECT_URL . "thum_2.JPG");

    $link = $image->addChild('link');
          
    $link->addChild('image',PROJECT_URL . "3.JPG");
    $link->addChild('thum',PROJECT_URL . "thum_3.JPG");

    $message = array("price" => $xml);

	var_dump($message);
	
    $result = $gcm->send_notification($registatoin_ids,$message);

    echo $result;
} else {
    // user details missing
}
?>		