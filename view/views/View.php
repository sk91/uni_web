<?php
    
    abstract class View{
        protected $viewHelper;
        public function __construct($viewHelper=null) {
            $this->viewHelper=$viewHelper;
        }
        
        protected function generalVars(){
            return array();
        }
        
        public abstract function get();
        
        public abstract function post();
        
    }
?>
