<?php

$result = '{"multicast_id":4752544907718759968,"success":625,"failure":375,"canonical_ids":35,"results":[{"message_id":"0:1375038977402749%00ee7487f9fd7ecd"},{"error":"InvalidRegistration"},{"message_id":"0:1375038977403789%00ee7487f9fd7ecd"},{"error":"NotRegistered"},{"message_id":"0:1375038977403783%00ee7487f9fd7ecd"},{"message_id":"0:1375038977442825%00ee7487f9fd7ecd"}]}';
$regs = array();
$regs [] = 1;
$regs [] = 2;
$regs [] = 3;
$regs [] = 4;
$regs [] = 5;
$regs [] = 6;

decodeResult($result, $regs);
function decodeResult($result , $regs) {
    $no_regs = array();
    
    $json = json_decode($result,true);
    $result = $json["results"];
    
    for ($index = 0; $index < count($result); $index++) {
        if(isset($result[$index]["error"]))
            $no_regs[] = $regs[$index];
    }
    echo "Values<br>";
    foreach ($no_regs as $value) {
        echo "$value<br>";
    }
}
?>
