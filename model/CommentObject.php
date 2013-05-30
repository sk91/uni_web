<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Comment
 *
 * @author max
 */
class CommentObject extends Object {

    const COMMENTS_ALLOWED = 1;
    const COMMENTS_NOT_ALLOWED = 0;

    protected $post_id;
    protected $author_id;
    protected $content;
    protected $date;

    function __construct($id, $post_id, $author_id, $content, $date) {
        parent::__construct($id, Schema::COMMENTS);
        $this->post_id = $post;
        $this->author_id = $author_id;
        $this->content = $content;
        $this->date = $date;
    }

    public function save() {
        $sql = "UPDATE {$this->schema} SET
            post_id=?,
            author_id=?,
            content='?',
            submit_date='?'
           WHERE id=?;
        ";
        $params = array($this->post_id, $this->author_id, $this->content, $this->date);
        $stmt = self::executeQuery($sql, $params);
        return (!$stmt) ? false : true;
    }

    public static function create($post_id, $author_id, $content) {
        $sql = "INSERT INTO " . Schema::COMMENTS . " (post_id,author_id,content) VALUES (?,?,'?');";
        $params = array($post_id, $author_id, $content);
        $rg = Registry::getInstance();
        $db = $rg->db;
        $stmt = $db->prepare($sql);
        $stmt->execute($params);
        //check for errors
        if (!$stmt) {
            $errorInfo = $db->errorInfo();
            Utils::debug("<p>Error inserting Comment: " . $errorInfo[2]);
            throw new Exception("Error inserting comment"); // some other error
        }
        //return a user object
        $id = $db->lastInsertId();
        return self::loadById($id);
    }

    public static function loadById($id) {
        $sql = "SELECT * FROM " . Schema::COMMENTS . "WHERE id=?";
        $params = array($id);

        $stmt = self::executeQuery($sql, $params);

        if ($stmt) {
            $comment = $stmt->fetch(PDO::FETCH_OBJ);
            return self::getFromStd($std);
        }
        return false;
    }

    public function getPost_id() {
        return $this->post_id;
    }

    public function setPost_id($post_id) {
        $this->post_id = $post_id;
    }

    public function getAuthor_id() {
        return $this->author_id;
    }

    public function setAuthor_id($author_id) {
        $this->author_id = $author_id;
    }

    public function getContent() {
        return $this->content;
    }

    public function setContent($content) {
        $this->content = $content;
    }

    public function getDate() {
        return $this->date;
    }

    public function setDate($date) {
        $this->date = $date;
    }

    public static function getFromStd($std) {
        return new CommentObject($std->id, $std->post_id, $std->author_id, $std->submit_date);
    }

}

?>
