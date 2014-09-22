<?php
/**
 * Database config variables
 */
define("LOCAL", true);
if(LOCAL){
    define("DB_HOST", "localhost");
    define("DB_USER", "root");
    define("DB_PASSWORD", "");
    define("DB_DATABASE", "test");
}else{
    define("DB_HOST", "31.170.160.108");
    define("DB_USER", "a8448311_root");
    define("DB_PASSWORD", "relax1root");
    define("DB_DATABASE", "a8448311_relax1");
}



/*
 * Google API Key
 */
define("GOOGLE_API_KEY", "AIzaSyAbliOAKgseRu_A6guJNKmtSZgYNY1bK7g"); // Place your Google API Key
?>