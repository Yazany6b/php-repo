<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Path
 *
 * @author Yazany6b
 */
class Path {
    
    public static function getFileNameWithoutExtension($file_name){
        $parts = explode(".", $file_name);
        $name = "";
        for ($index = 0; $index < count($parts) - 1; $index++) {
            $name = $name . $parts[$index];
        }
        
        return $name;
    }
    
    public static function getFileName($file_name){
        $arr = explode("/", $file_name);
        return end($arr);
    }
    public static function getExtension($file_name){
        $arr = explode(".", $file_name);
        return end($arr);
    }
    
    public static function getParentDirectory($file_name){
        $array = explode("/", $file_name);
        $dic = "";
        for ($index = 0; $index < count($array) - 1; $index++) {
            $dic = $dic . $array[$index] . "/"; 
        }
        return $dic;
    }
    
}

?>
