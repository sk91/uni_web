<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of GetView
 *
 * @author max
 */
abstract class FrontView extends View{
    
    protected $template;
    
    public function post(){
        return $this->get();
    }
    
    
    public function render(){
        return $this->template->render();
    }
}

?>
