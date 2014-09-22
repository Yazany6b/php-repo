<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Directory
 *
 * @author Yazany6b
 */
class File {
    
    private $extension;
    private $directory;
    private $name;

    public function __construct($filename) {
        $info = explode("/", $filename);
         
        $this->name = end($info);
        
        $this->directory = "";
        for ($index = 0; $index < count($info) - 1; $index++) {
            $this->directory = $this->directory . $info[$index] . "/";
        }
        
        $this->extension = strtolower(end(explode(".", $this->name)));
    }
    
    function getName(){
        return $this->name;
    }
    
    public function getExtension() {
        return $this->extension;
    }

    public function getDirectory() {
        return $this->directory;
    }

    function getNameWithoutExtension(){
        trim($this->name, "." . $this->extension);
    }
    
    function getNonExistName() {
        $name = $this->getNameWithoutExtension();
        $temp = $name;
        $index = 0;
        if(file_exists($this->directory . $temp . "." . $this->extension)){
            $temp = $name ."_".$index;
            $index++;
        }
        
        return $this->directory . $temp . "." . $this->extension;
    }
}

?>
