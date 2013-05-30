<?php
class Bootstrap {

    public function __construct() {
        if (Settings::DEBUG) {
            $this->debug();
        }
        $this->loadSite();
        $this->output();
    }

    public function loadSite() {
        $registry = Registry::getInstance();
        $registry->uri = Utils::parseURI();
        $registry->db = new DB();
        $registry->isGet = ($_SERVER["REQUEST_METHOD"] == "GET");
        $registry->isAjax = isset($_GET[AJAX_INDICATOR]);
        $registry->user=$this->authentication();
        
        $registry->access_manager=  AccessManager::getInstance();
        if (class_exists($registry->uri->controller, true)) {
            $controller = $this->findController($registry->uri->controller, $registry->uri->action, $registry->isAjax);
        } else {
            $controller = $this->findController("Index", 'index');
            Utils::debug("Class {$registry->uri->controller} does not exist using Index instead");
        }
        $registry->controller = $controller;
    }

    public function findController($name, $action, $isAjax = false) {
        try {
            //Only controller classes are allowed on the url string
            if (is_subclass_of($name, "Controller")) {
                return new $name($action, $isAjax);
            }
            return new Index('index');
        } catch (Exception $ex) {
            return new Index('index');
        }
    }
    public function authentication(){
        return new GuestUser();
    }
    public function output() {
        $registry = Registry::getInstance();
        $registry->controller->output();
    }

    public function debug() {
        error_reporting(E_ALL);
        ini_set('display_errors', 'On');
    }

}

?>
