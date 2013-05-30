<?php

abstract class Controller {

    protected $view;
    protected $isAjax;
    protected $restricted;
    protected $isGet;

    public function __construct($action, $isAjax = false) {
        $this->restricted = array('output');
        if (method_exists($this, $action) && !in_array($action, $this->restricted)) {
            //only public methods can be called
            $reflection = new ReflectionMethod($this, $action);
            if (!$reflection->isPublic()) {
                $action = 'index';
            }
        } else {
            $action = 'index';
        }
        $this->isAjax = $isAjax;
        $rg = Registry::getInstance();
        $this->isGet = $rg->isGet;
        $this->$action();
    }

    public function index() {
        $this->view = new PageNotFoundView();
    }

    public function output() {
        if ($this->view) {
            if ($this->isGet) {
                print $this->view->get();
            } else {
                print $this->view->post();
            }
        }
        Utils::debug("Output class " . get_class($this));
    }

}

?>
