<?php

class DB_Functions {

    private $db;
    private $connection;
    //put your code here
    // constructor
    function __construct() {
        include_once './db_connect.php';
        // connecting to database
        $this->db = new DB_Connect();
        $this->connection = $this->db->connect();
    }

    // destructor
    function __destruct() {
        
    }

    /**
     * Storing new user
     * returns user details
     */
    public function storeUser($name, $email, $gcm_regid,$region,$lang) {
        
        $region = strtolower(trim($region));
        $result = mysql_query("select id from region where description = '$region';",$this->connection);
        
        $region_id = 0;
        
        if(mysql_num_rows($result)){

            while ($row = mysql_fetch_array($result)){
                $region_id = $row["region_id"];
            }

        }else{

            mysql_query("insert into regions(description) values('$region')",$this->connection) or die(mysql_error());
            $region_id = mysql_insert_id();
        }

        $lang = strtolower(trim($lang));
        $result = mysql_query("select lang_id from langs where description = '$lang';",$this->connection);
        
        $lang_id = 0;
        
        if(mysql_num_rows($result)){

            while ($row = mysql_fetch_array($result)){
                $lang_id = $row["lang_id"];
            }

        }else{

            mysql_query("insert into langs(description) values('$lang')",$this->connection) or die(mysql_error());
            $lang_id = mysql_insert_id();
        }
        
        // insert user into database
        $result = mysql_query("INSERT INTO devices(name, email, registration_id, region_id,lang_id) VALUES('$name', '$email', '$gcm_regid', $region_id,$lang_id);",$this->connection) or die(mysql_error());

        if ($result) {
            // get user details
            $id = mysql_insert_id(); // last inserted id
            $result = mysql_query("SELECT * FROM devices WHERE id = $id",$this->connection) or die(mysql_error());

            // return user details
            if (mysql_num_rows($result) > 0) {
                return mysql_fetch_array($result);
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function deleteUser($regid) {
        $result = mysql_query("Delete FROM devices WHERE registration_id = '$regid';");
        return $result;
    }

    /**
     * Get user by email and password
     */
    public function getUserByEmail($email) {
        $result = mysql_query("SELECT * FROM devices WHERE email = '$email' LIMIT 1");
        return $result;
    }
    
    public function getUsersByRegionId($region_id) {
        $result = mysql_query("SELECT registration_id devices WHERE region_id = $region_id;");
        return $result;
    }

    public function getUsersByLangId($lang_id) {
        $result = mysql_query("SELECT registration_id FROM devices WHERE lang_id = $lang_id;");
        return $result;
    }

    /**
     * Getting all users
     */
    public function getAllUsers() {
        $result = mysql_query("select * FROM devices;");
        return $result;
    }

    /**
     * Check user is existed or not
     */
    public function isUserExisted($email) {
        $result = mysql_query("SELECT email from devices WHERE email = '$email'");
        $no_of_rows = mysql_num_rows($result);
        if ($no_of_rows > 0) {
            // user existed
            return true;
        } else {
            // user not existed
            return false;
        }
    }
    /**
     * Getting All regions
     */
    public function getAllRegions(){
        $result = mysql_query("select * FROM regions");
        return $result;
    }

    /**
     * Getting All langs
     */
    public function getAllLangs(){
        $result = mysql_query("select * FROM langs");
        return $result;
    }
    public function login($username,$password) {
        $password = md5($password);
        $result = mysql_query("select * FROM users where username='$username' and password='$password'");
        
        return $result;
    }
    
    public function getUsersCount(){
        $arr = mysql_fetch_array(mysql_query("select count(registration_id) FROM devices;"));
        return $arr[0];
    }
    
    function updateRegistrationId($oldid,$newid) {
        mysql_query("update devices set registration_id='$newid' where registration_id='$oldid';");
        return mysql_affected_rows();
    }
    
    function close(){
        mysql_close();
    }
}

?>	