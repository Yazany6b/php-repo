<?php
/*
session_start();
include_once './sharedkeys.php';
$loc = WEBSITE_URL . 'login.php';
if (!isset($_SESSION["fname"])) {

    header('Location: ' . $loc);
    die();
}

if ($_SESSION['startup'] != "./index.php") {
    header('Location: ' . $loc);
    die();
}*/
?>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
        <title>Send A New Subject</title>
        <link rel="shortcut icon" href="../favicon.ico"> 
        <link rel="stylesheet" type="text/css" href="css/demo.css" />
        <link rel="stylesheet" type="text/css" href="css/style4.css" />
        <script src="js/modernizr.custom.04022.js"></script>
        <link href='http://fonts.googleapis.com/css?family=Open+Sans+Condensed:700,300,300italic' rel='stylesheet' type='text/css'>
        <script type="text/javascript" >
            
            function viewMs(){
<?php
if (isset($_GET["message"])) {
    echo "alert('" . $_GET["message"] . "');";
}
?>
                    }

                    function logout(){
                        window.location ='<?php echo 'fuck';/*
include_once './sharedkeys.php';
echo WEBSITE_URL . "kickmeout.php";
*/?>';
               
            }

            function checkByParent(aId, aChecked) {
                var collection = document.getElementById(aId).getElementsByTagName('INPUT');
                for (var x=0; x<collection.length; x++) {
                    if (collection[x].type.toUpperCase()=='CHECKBOX')
                        collection[x].checked = aChecked;
                }
            }        

            function setDivVisiablity(div,vis){
                document.getElementById(div).style.visibility = vis;
            }
            
            function sendMethodChanged(){
                var select = document.getElementById("send_options");
                var send = document.getElementById("send_method");

                var value = select.options[select.selectedIndex].value;
                
                if(value == "region"){
                    setDivVisiablity("regions_div", "visible");
                    setDivVisiablity("langs_div", "collapse");
                    send.value = 2;
                    return;
                }
                
                if(value == "lang"){
                    setDivVisiablity("langs_div", "visible");
                    setDivVisiablity("regions_div", "collapse");
                    send.value = 3;
                    return;
                }
                
                if(value == "toall"){
                    setDivVisiablity("langs_div", "collapse");
                    setDivVisiablity("regions_div", "collapse");
                    send.value = 1;
                    return;
                }
                
                

            }
        </script>
    </head>
    <body onload="viewMs();">
        <form method="post" action="send_message.php" enctype="multipart/form-data">
            <input type="hidden" value="1" name="send_method" id="send_method"/>
            <div class="container">	
                <header>
                    <h1>Send a new subject</h1>
                    <h2>Total Users : <?php 
                            include_once './db_functions.php';
                            $db = new DB_Functions();
                            echo $db->getUsersCount();
                    ?></h2>
                    <br><br><br><br>
                </header>
                <section class="tabs">
                    <input id="tab-1" style="opacity: 0;" type="radio" name="radio-set" class="tab-selector-1" checked="checked" />
                    <label for="tab-1" class="tab-label-1">Info</label>

                    <input id="tab-2" style="opacity: 0;" type="radio" name="radio-set" class="tab-selector-2" />
                    <label for="tab-2" class="tab-label-2">Images</label>

                    <input id="tab-3" style="opacity: 0;" type="radio" name="radio-set" class="tab-selector-3" />
                    <label for="tab-3" class="tab-label-3">Users</label>

                    <div class="clear-shadow"></div>

                    <div class="content">
                        <div class="content-1">
                            <h3>Title</h3>
                            <p><input type="text" name="title" size="85" style="z-index: 90;"></p>
                            <h3>Description</h3>
                            <p><textarea name="description" rows="15" cols="87"></textarea></p>
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
                            $langs = $db->getAllLangs();
                            ?>
                            <h3>Send To People</h3>
                            <p><select id="send_options" name="send_options" onchange="sendMethodChanged();">
                                    <option value="toall">To All</option>
                                    <option value="region">Regions</option>
                                    <option value="lang">Languages</option>
                                </select></p>
                                <br>
                            <p>
                            <span id="regions_div" style="visibility: collapse;overflow:scroll; width: 550px;height: 400px;"><table><tr>
                                    <?php
                                    $index = 0;
                                    while ($row = mysql_fetch_array($regions)) {
                                        $desc = $row["description"];
                                        $id = $row["region_id"];
                                        $index++;
                                        echo "<td><input type=\"checkbox\" name=\"region-$desc-$id\"/>$desc</td>";
                                        if ($index % 8 == 0) {
                                            echo "</tr><tr>";
                                        }
                                    }
                                    ?>
                                </tr>
                            </table></span>
                            </p> 
                            <p>
                            <span id="langs_div" style="visibility: collapse;overflow:scroll; width: 550px;height: 400px;"><table><tr>
                                    <?php
                                    $index = 0;
                                    while ($row = mysql_fetch_array($langs)) {
                                        $desc = $row["description"];
                                        $id = $row["lang_id"];
                                        $index++;
                                        echo "<td><input type=\"checkbox\" name=\"lang-$desc-$id\"/>$desc</td>";
                                        if ($index % 8 == 0) {
                                            echo "</tr><tr>";
                                        }
                                    }
                                    ?>
                                </tr>
                            </table></span>
                            </p>
                        </div>
                    </div>

                </section>
            </div>
            <input type="button" onclick="logout();" value="Logout" style="position: absolute;left: 900px;top: 600px;" />
            <input type="submit" style="position: absolute;left: 1000px;top: 600px;" /> 
        </form>
    </body>
</html>	