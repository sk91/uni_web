<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TagObject
 *
 * @author max
 */
class TagObject extends Object {

    private $name;

    public function __construct($id, $name) {
        parent::__construct($id, Schema::TAGS);
        $this->name = $name;
    }

    public static function getFromStd($std) {
        new TagObject($std->id, $std->name);
    }

    public function save() {
        $sql = "UPDATE {$this->schema} SET
            name='?'
           WERE id=?;
        ";
        $params = array($this->name, $this->id);
        $stmt = self::executeQuery($sql, $params);
        return (!$stmt) ? false : true;
    }

    public static function create($name) {
        $sql = "INSERT INTO " . Schema::TAGS . " (name) VALUES('?');";
        $params = array($name);
        $rg = Registry::getInstance();
        $db = $rg->db;
        $stmt = $db->prepare($sql);
        $stmt->execute($params);

        if (!$stmt) {
            return false;
        }
        $id = $db->lastInsertId();
        return new TagObject($id, $name);
    }

    public static function loadById($id) {
        $sql = "SELECT * FROM " . Schema::TAGS . "WHERE id=?";
        $params = array($id);

        $stmt = self::executeQuery($sql, $params);

        if ($stmt) {
            $tag = $stmt->fetch(PDO::FETCH_OBJ);
            return self::getFromStd($tag);
        }
        return false;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

}

?>
