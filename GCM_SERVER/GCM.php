<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of GCM
 *
 * @author Ravi Tamada
 */
class GCM {

    //put your code here
    // constructor
    function __construct() {
        
    }

    /**
     * Sending Push Notification
     */
    public function send_notification($registatoin_ids, $message) {
        // include config
        include_once './config.php';

        // Set POST variables
        $url = 'https://android.googleapis.com/gcm/send';

        $fields = array(
            'registration_ids' => $registatoin_ids,
            'data' => $message,
        );

print "Prepare the fields <br>";

        $headers = array(
            'Authorization: key=' . GOOGLE_API_KEY,
            'Content-Type: application/json'
        );
        // Open connection
        $ch = curl_init();
print "Curl inited <br>";
        // Set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $url);

        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

print "curl enabled <br>";

        // Disabling SSL Certificate support temporarly
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

        // Execute post
        $result = curl_exec($ch);
        if (!isset($result) || $result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }

        // Close connection
        curl_close($ch);

        print "The GUrl Result --------------------------------- <br>";
	var_dump($result);

	print "<br>--------------------------------Curl closed<br>";

        return $result;
    }

}

?>
