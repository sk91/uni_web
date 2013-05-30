<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UserObject
 *
 * @author max
 */
class UserObject extends Object {

    private $email;
    private $password;
    private $privilages;

    function __construct($id, $email, $password, $privilages) {
        parent::__construct($id,  Schema::USERS);
        $this->email = $email;
        $this->password = $password;
        $this->privilages = $privilages;
    }

    public static function create($email, $password, $privilages) {

        //encript password
        $password = self::encriptPassword($password);
        //get db
        $rg = Registry::getInstance();
        $db = $rg->db;
        //prepare sql statement
        $sql = "INSERT INTO " . Schema::USERS . " SET email='?',password='?',privileges='?'";
        $params = array($email, $password, $privilages);
        $stmt = $db->prepare($sql);
        $stmt->execute($params);
        //check for errors
        if (!$stmt) {
            $errorInfo = $db->errorInfo();
            if ($errorInfo[0] == "23000") { ///sql duplicate unique key status
                Utils::debug("<p>User exists: " . $errorInfo[2]);
                throw new EmailExistsException();
            }
            Utils::debug("<p>Error inserting user: " . $errorInfo[2]);
            throw new Exception("Error inserting user"); // some other error
        }
        //return a user object
        $id = $db->lastInsertId();
        return new UserObject($id, $email, $password, $privilages);
    }

    public static function getUserByEmail($email) {
        return self::loadBy('email', $email);
    }

    public static function loadById($id) {
        return self::loadBy('id', $id);
    }

    private static function loadBy($param, $value) {
        $sql = "SELECT * FROM " . Schema::USERS . " WHERE $param='?'";
        $stmt = self::executeQuery($sql, array($value));
        if (!$stmt) {
            return false;
        }
        $usr = $stmt->fetch(PDO::FETCH_OBJ);
        return self::getFromStd($usr);
    }

    public function save() {
        $sql = "UPDATE {$this->schema} SET email='?',password='?',privilages=? WHERE id=?";
        $params = array($email, $password, $privilages, $id);
        return !self::executeQuery($sql, $params) ? false : true;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getPrivilages() {
        return $this->privilages;
    }

    public function checkPassword($password) {
        return $this->password == self::encriptPassword($password);
    }

    public function hasPrivilage($privilage) {
        return $this->privilages & $privilage > 0 || $this->privilages & AccessManager::STAFF>0;
    }

    private static function encriptPassword($password) {
        $salt = self::generateRandomSalt(10);
        return "sha1$" . $salt . "$" . sha1($password . $salt);
    }

    private static function generateRandomSalt($length) {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%&*?";
        $charsNum = strlen($chars);
        $salt = "";
        for ($i = 0; $i < $length; $i++) {
            $randomChar = $mt_rand(0, $charsNum - 1);
            $salt.=$chars{$randomChar};
        }
        return $salt;
    }

    public function getPassword() {
        return $this->password;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    public static function getFromStd($std) {
        return new UserObject($std->id, $std->email, $std->password, $std->privilages);
    }

}

?>
