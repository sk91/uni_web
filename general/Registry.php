<?php

/**
 * Registry class used to hold global objects
 *
 * @author max
 */
class Registry {

    private static $instance;
    private $registry;

    private function __construct() {
        $this->registry=array();
    }
    
    public static function getInstance(){
        if(!isset(self::$instance)){
            self::$instance=new self();
        }
        return self::$instance;
    }
    
    
    public function __set($name, $value) {
        $this->registry[$name]=$value;
    }
    
    public function __get($name) {
        return $this->registry[$name];
    }
}

?>
