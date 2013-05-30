<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Object
 *
 * @author max
 */
abstract class Object {

    protected $id;
    protected $schema;

    public function __construct($id, $schema) {
        $this->id = $id;
        $this->schema = $schema;
    }

    public static abstract function loadById($id);
    
    
    public abstract static function getFromStd($std);
    
    public static function executeQuery($sql, $params) {
        $rg = Registry::getInstance();
        $db = $rg->db;
        $stmt = $db->prepare($sql);
        $stmt->execute($params);
        if (!$stmt) {
            return false;
        }
        return $stmt;
    }

    public function delete() {
        $rg = Registry::getInstance();
        $db = $rg->db;
        $db->deleteObject(Schema::USERS, $this->id);
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

}

?>
