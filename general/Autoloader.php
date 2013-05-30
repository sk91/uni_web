<?php

/**
 * Autoloader. Automatically loads classes in predefined folders 
 */
class Autoloader {

    /**
     * Registers our custom autoloading functions
     */
    public function __construct() {
        spl_autoload_register(array($this, 'controller'));
        spl_autoload_register(array($this, 'view'));
        spl_autoload_register(array($this, 'model'));
        spl_autoload_register(array($this, 'general'));
        spl_autoload_register(array($this, 'view'));
    }

    //general function to load a class
    private function loadClass($path, $className) {
        $filename = $filename = $path . DS . $className . ".php";
        if (file_exists($filename)) {
            require_once($filename);
        }
    }

    //controller classes
    private function controller($className) {
        $this->loadClass('controller', $className);
    }

    //view classes
    private function view($className) {
        $this->loadClass(SITE_VIEWS, $className);
        $this->loadClass(SITE_VIEW_HELPERS, $className);
        $this->loadClass(SITE_VIEWS.DS."interfaces", $className);
        $this->loadClass(SITE_TEMPLATES , $className);
    }

    //model classes
    private function model($className) {
        $this->loadClass('model', $className);
    }

    //general classes
    private function general($className) {
        $this->loadClass('general',$className);
    }

}

?>
