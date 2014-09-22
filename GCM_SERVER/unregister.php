<?php

// response json
$json = array();

/**
 * Registering a user device
 * Store reg id in users table
 */
if (isset($_POST["regId"])) {
    $gcm_regid = $_POST["regId"]; // GCM Registration ID

    // Store user details in db
    include_once './db_functions.php';
    include_once './GCM.php';

    $db = new DB_Functions();

    $res = $db->deleteUser($gcm_regid);

    $registatoin_ids = array($gcm_regid);
    $message = array("Price" => "<data><title>Unregister</title> <description>You'ar now unrgistered for the app you will no longer receive any notifications.</description></data>");

    $result = $gcm->send_notification($registatoin_ids, $message);

    echo $result;
} else {
    // user details missing
}
?>		