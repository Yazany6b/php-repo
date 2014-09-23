<?php
define("LOCAL",true);
if(LOCAL){
    define("WEBSITE_URL", "http://localhost/php-repo/GCM_SERVER/");
    define("IMAGES_LOCATION", "upload/");
    define("IMAGES_COUNT", 6);
    define("PROJECT_URL", "http://localhost/php-repo/GCM_SERVER/");
}  else {
    define("WEBSITE_URL", "http://www.relaxodasoft.freeiz.com/");
    define("IMAGES_LOCATION", "upload/");
    define("IMAGES_COUNT", 6);
    define("PROJECT_URL", "http://androiddev.relaxodasoft.com/OdaiProject/");
}
?>
