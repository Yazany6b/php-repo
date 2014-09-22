<?php
/*
session_save_path("/home/users/web/b1523/ipg.relaxodasoft/cgi-bin/tmp");
session_start();

include_once '../sharedkeys.php';
$loc = WEBSITE_URL . 'login.php';
if(!isset($_SESSION["fname"])){
    
    header( 'Location: '.$loc);
    die();
}
*/
define("IMAGES_LOCATION", "upload/");
define("IMAGES_COUNT", 6);
define("PROJECT_URL", "http://androiddev.relaxodasoft.com/OdaiProject/");
if (isset($_POST["title"]) && isset($_POST["description"])) {
    
    $title = $_POST["title"];
    $description = $_POST["description"];

    $images = storeImages();

    $xml = '<data><title>'.$title.'</title><description>'.$description.'</description><images>';
    for($i = 0 ; $i < count($images);$i++)
        $xml = $xml . '<link><image>' . PROJECT_URL . $images[$i][0] . '</image><thum>' . PROJECT_URL .$images[$i][1].'</thum></link>';
    
    $xml = $xml . '</images></data>';

    //str_replace(" ", "_", $xml);
    file_put_contents("mydata.txt", $xml);

    $registatoin_ids = getReceivers();

    if(count($registatoin_ids) == 0){
        header( 'Location:http://androiddev.relaxodasoft.com/OdaiProject/index.php?message=No%20Users%20Found');
        return;
    }
    
/*    for ($index = 0; $index < count($registatoin_ids); $index++) {
        echo $registatoin_ids[$index] . "<br>";
    }*/

//$log = ">>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>\n";
//$log = //$log . date('l jS \of F Y h:i:s A') . "\r\n";
    if(count($registatoin_ids) > 1000){
//$log = //$log . "Send More The 1000 Person\r\n";
        $count = count($registatoin_ids);
        $index = 0;
//$log = //$log . "Total Count : $count \r\n";
        while($count > 1000){
            $regs = array();
//$log = //$log . "Sending From $index \r\n";
            for($i = $index; $i < $index + 1000 ; $i++)
                $regs[] = $registatoin_ids[$i];
             
             $index += 1000;
             $count -= 1000;
//$log = //$log . "Sending To The Group\r\n";
             include_once './GCM.php';
             $gcm = new GCM();
             $result = $gcm->send_notification($regs, array("price" => $xml));
             $no_regs = decodeResult($result, $regs);
             
             unset($gcm);
//$log = //$log . "The Send Result is : [$result]\r\n\r\n";
             sleep(60);//Sleep One Minute
         }
//$log = //$log . "Sending Extra People about : $count \r\n";

            $regs = array();
            for($i = $index; $i < $index + $count; $i++)
                $regs[] = $registatoin_ids[$i];
         
             if(count($regs) > 0){
             include_once './GCM.php';
             $gcm = new GCM();
             $result = $gcm->send_notification($regs, array("price" => $xml));
             unset($gcm);
//$log = //$log . "Extra Send Result is [$result]\r\n";
             }

//$log = //$log . "================================================================\r\n\r\n";
//file_put_contents("log.txt", //$log);
    header( 'Location:http://androiddev.relaxodasoft.com/OdaiProject/index.php?message=The%20Message%20Was%20Sent');
exit();die();
    }

//$log = //$log . "Normal Send\r\n";
    include_once './GCM.php';
    $gcm = new GCM();

    $result = $gcm->send_notification($registatoin_ids, array("price" => $xml));
//$log = //$log . "Normal Send Result : [$result]\r\n";
//$log = //$log . "================================================================\r\n\r\n";
//file_put_contents("log.txt", //$log,FILE_APPEND);
    header( 'Location:http://androiddev.relaxodasoft.com/OdaiProject/index.php?message=The%20Message%20Was%20Sent');
echo "Sent Successfully <br>";
}

function getFileExtension($filename){
    $ext = explode(".", $filename);
    $ext = end($ext);
    return strtolower($ext);
}

function loadImage($filename){
    $ext = getFileExtension($filename);
    switch ($ext){
        case 'jpg':
            return imagecreatefromjpeg($filename);
            break;
        case 'jpg':
            return imagecreatefromjpeg($filename);
            break;
        case 'png':
            return imagecreatefrompng($filename);
            break;
        case 'gif':
            return imagecreatefromgif($filename);
            break;
        case 'bmp':
            return imagecreatefromwbmp($filename);
            break;
    }
    
    return null;
}

function createImage($width , $height){
    return imagecreate($width, $height);
}

function createImageTrueColor($width , $height){
    return imagecreatetruecolor($width, $height);
}

function saveImage($image , $filename){
    $ext = getFileExtension($filename);
    switch ($ext){
        case 'jpg':
            return imagejpeg($image, $filename);
            break;
        case 'jpeg':
            return imagejpeg($image, $filename);
            break;
        case 'png':
            return imagepng($image, $filename);
            break;
        case 'gif':
            return imagegif($image, $filename);
            break;
        case 'bmp':
            return imagewbmp($image, $filename);
            break;
    }
}

function createThum($image_dic , $image_file_name,$width,$height){

    $image = loadImage($image_dic . $image_file_name);
    $thum = createImageTrueColor($width, $height);
    
    $source_imagex = imagesx($image);
    $source_imagey = imagesy($image);
    imagecopyresized($thum, $image, 0, 0, 0, 0, 
				$width, $height, $source_imagex, $source_imagey);
    
    saveImage($thum, $image_dic . "thum_" . $image_file_name);
    
    return $image_dic . "thum_" . $image_file_name;
}

function storeImage($image) {
    //echo "+----------------------------------------------------------------------------+<br>";
    //echo "Start Storing [$image]<br>";
    include_once './Path.php';
    $file_name = Path::getFileNameWithoutExtension($_FILES[$image]['name']);
    //echo "The Sent File Name [$file_name]<br>";
    $name = $file_name;
    include_once './Path.php';
    $extension = Path::getExtension($_FILES[$image]['name']);
    //echo "The File Extension [$extension]<br>";
    
    $index = 0;
    //echo "Checking File Existance<br>";
    while (file_exists(IMAGES_LOCATION . $name . "." . $extension)) {
        $name = $file_name . "_" . $index;
        $index++;
    }
    $file_name = str_replace(' ', '_', $name . "." . $extension);
    //echo "The Aproved File Name [$file_name]<br>";
    $picture = IMAGES_LOCATION . $file_name;
    
    //echo "Move From Upload To [$picture]<br>";
    move_uploaded_file($_FILES[$image]["tmp_name"], $picture);
    
    $thum = createThum(IMAGES_LOCATION,$file_name,100,100);
//    echo "A Thum Created At [$thum]<br>";
  //  echo "Save The Info<br>";
    
    $result = array($picture,$thum);
    //echo ">>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>><br>";
    return $result;
}


function storeImages() {
    //echo "------------------------------------------<br>";
    $array = array();
    
    for ($index = 1; $index <= count($_FILES); $index++) {
        if(isset($_FILES["image".$index]) && $_FILES["image".$index]["name"] != null){
            $array[] = storeImage("image".$index);
        }
    }

    return $array;
}

function getReceivers(){
    $receivers = array();
    include_once './db_functions.php';
    $db = new DB_Functions();

    $send_method = $_POST["send_method"];
    
    switch ($send_method){
        case 1:
            $result = $db->getAllUsers();
            while ($row = mysql_fetch_array($result)){
                $receivers[] = $row["registration_id"];
            }
            break;
        case 2:
            $users = getRegions();
            for ($i = 0;$i < count($users);$i++){

                $subusers = $db->getUsersByRegionId($users[$i]);

                while ($row = mysql_fetch_array($subusers)){
                    $receivers [] = $row["registration_id"];
                }
            }
/*
            if(count($receivers) == 0){
                $result = $db->getAllUsers();
                while ($row = mysql_fetch_array($result)){
                    $receivers[] = $row["registration_id"];
                }
            }*/
            break;
            
        case 3:
            $users = getLangs();
            for ($i = 0;$i < count($users);$i++){

                $subusers = $db->getUsersByLangId($users[$i]);

                while ($row = mysql_fetch_array($subusers)){
                    $receivers [] = $row["registration_id"];
                }
            }
/*
            if(count($receivers) == 0){
                $result = $db->getAllUsers();
                while ($row = mysql_fetch_array($result)){
                    $receivers[] = $row["registration_id"];
                }
            }*/
            break;
    }
    
    return $receivers;
}

function getRegions(){
    //echo "Get Regions;";
    $regions = array();
    foreach ($_POST as $key => $value){
        $exp = explode("-", $key);
        if(count($exp) == 3){
            //echo " 3 Splits;<br> $exp[0] - $exp[1] - $exp[2]";
            if($exp[0] == "region"){
                //echo " A region[$exp[2]]";
                $regions[] = $exp[2];
            }
        }
    }
    return $regions;
}

function getLangs(){
    //echo "Get Regions;";
    $langs = array();
    foreach ($_POST as $key => $value){
        $exp = explode("-", $key);
        if(count($exp) == 3){
            //echo " 3 Splits;<br> $exp[0] - $exp[1] - $exp[2]";
            if($exp[0] == "lang"){
                //echo " A region[$exp[2]]";
                $langs[] = $exp[2];
            }
        }
    }
    return $langs;
}

function decodeResult($result , $regs ,$db) {
    $no_regs = array();
    
    $json = json_decode($result,true);
    $result = $json["results"];
    
    for ($index = 0; $index < count($result); $index++) {
        if(isset($result[$index]["error"]))
            $no_regs[] = $regs[$index];
    }
    
    foreach ($no_regs as $regid) {
        $db->deleteUser($regid);
    }
}

?>
					