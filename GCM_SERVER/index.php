<?php
session_start();
include_once './sharedkeys.php';
$loc = 'login.php';
if(!isset($_SESSION["fname"])){
    header( 'Location: ' . PROJECT_URL .$loc);
    die();
}

if($_SESSION['startup'] != "index.php"){
    header( 'Location: '.$loc);
    die();    
}

?>
<html lang="en">
<head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
        <title>Send A New Subject</title>
        <link rel="shortcut icon" href="../favicon.ico"> 
        <link rel="stylesheet" type="text/css" href="css/demo.css" />
        <link rel="stylesheet" type="text/css" href="css/style4.css" />
        <script type="text/javascript" src="js/modernizr.custom.04022.js"></script>
        <link href='http://fonts.googleapis.com/css?family=Open+Sans+Condensed:700,300,300italic' rel='stylesheet' type='text/css'>
        <script type="text/javascript" >
            
            function viewMs(){
                <?php
                    if(isset($_GET["message"])){
                        echo "alert('" . $_GET["message"] . "');";
                    }
                ?>
            }
            
            function logout(){
                window.location ='<?php
                    include_once './sharedkeys.php';
                    echo WEBSITE_URL . "kickmeout.php";
                ?>';
               
            }
            
            function byteCount(s) {
                return encodeURI(s).split(/%..|./).length - 1;
            }
            
            var bytesViewer;
            var area;
            
            function pageLoaded(){
                viewMs();
                
                area = document.getElementById("myTextArea");
                bytesViewer = document.getElementById("bytesView");
                if (area.addEventListener) {
                  area.addEventListener('onkeyup', function() {
                      bytesViewer.innerHTML = bytesCount(area.value.length);
                  }, false);
                } else if (area.attachEvent) {
                  area.attachEvent('onchange', function() {
                    bytesViewer.innerHTML = bytesCount(area.value.length);
                  });
                }
            }
            
        </script>
    </head>
    <body onload="pageLoaded();">
        <form method="post" action="send_message.php" enctype="multipart/form-data">
        <div class="container">	
            <header>
                <h1>Send a new subject</h1>
                <br><br>
                <h3>Users Count 
                    <?php 
                                    include_once './db_functions.php';
                                    $db = new DB_Functions();
                                    print $db->getUsersCount();
                                    $db->close()
                    ?>
                </h3>
                <br>
                <h3>Total of bytes : <span id="bytesView">0</span> / 4096</h3>
                <br>
            </header>
            <section class="tabs">
                <input id="tab-1" style="opacity: 0;" type="radio" name="radio-set" class="tab-selector-1" checked="checked" />
                <label for="tab-1" class="tab-label-1">Info</label>

                <input id="tab-2" style="opacity: 0;" type="radio" name="radio-set" class="tab-selector-2" />
                <label for="tab-2" class="tab-label-2">Images</label>

                <input id="tab-3" style="opacity: 0;" type="radio" name="radio-set" class="tab-selector-3" />
                <label for="tab-3" class="tab-label-3">Regions</label>

                <div class="clear-shadow"></div>
                
                    <div class="content">
                        <div class="content-1">
                            <h3>Title</h3>
                            <p><input type="text" name="title" size="85" style="z-index: 90;"></p>
                            <h3>Description</h3>
                            <p><textarea id="myTextArea" name="description" rows="15" cols="87"></textarea></p>
                        </div>
                        <div class="content-2" style="overflow:scroll; width: 550px;height: 400px;">
                            <h3>First Image</h3>
                            <p><input type="file" name="image1"></p>
                            <h3>Second Image</h3>
                            <p><input type="file" name="image2"></p>
                            <h3>Third Image</h3>
                            <p><input type="file" name="image3"></p>
                            <h3>Fourth Image</h3>
                            <p><input type="file" name="image4"></p>
                            <h3>Fifth Image</h3>
                            <p><input type="file" name="image5"></p>
                            <h3>Sixth Image</h3>
                            <p><input type="file" name="image6"></p>
                        </div>
                        <div class="content-3">
                            <?php
                                include_once './db_functions.php';
                                $db = new DB_Functions();
                                $regions = $db->getAllRegions();
                            ?>
                            <h3>Send To People</h3>
                            <p><input type="checkbox" name="toall"/>Send To All</p>
                            <p>
                            <table><tr>
                                <?php
                                    $index = 0;
                                    while ($row = mysql_fetch_array($regions)){
                                        $desc = $row["description"];
                                        $id = $row["region_id"];
                                        $index ++;
                                        echo "<td><input type=\"checkbox\" name=\"region-$desc-$id\"/>$desc</td>";
                                        if($index % 8 == 0){
                                            echo "</tr><tr>";
                                        }
                                    }
                                ?>
                            </tr>
                            </table>
                            </p> 
                        </div>
                    </div>
                
            </section>
        </div>
            <input type="button" onclick="logout();" value="Logout" style="position: absolute;left: 960px;top: 560px;" />
        <input type="submit" style="position: absolute;left: 1000px;top: 560px;" /> 
        </form>
    </body>
</html>