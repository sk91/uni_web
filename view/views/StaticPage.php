<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of StaticView
 *
 * @author max
 */
class StaticPage extends FrontView{
    
  
    protected $template_file;
    
    public function __construct($page) {
        parent::__construct();
        $this->template_file = $page;
    }
    
    public function get() {
        $this->template = new Template($this->template_file);
        return $this->render();
    }
}

?>
