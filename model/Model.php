<?php
    class Model{
        
        protected $registry;
        protected $db;
        
        public function __construct() {
            $this->registry=  Registry::getInstance();
            $this->db=$this->registry->db;
        }
    }
?>
