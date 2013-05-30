<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PostObject
 *
 * @author max
 */
class PostObject extends Object {

    const CONTENT_TYPE_POST = 0;

    protected $status;
    protected $staffOnly;
    protected $title;
    protected $excerpt;
    protected $content;
    protected $createDate;
    protected $publish_date;
    protected $commentCount;
    protected $commentStatus;
    protected $author;
    protected $meta;
    protected static $type = self::CONTENT_TYPE_POST;

    function __construct($id, $status, $staffOnly, $title, $excerpt, $content, $author, $createDate, $commentCount, $commentStatus, $publish_date, $meta) {
        parent::__construct($id, Schema::POSTS);
        $this->status = $status;
        $this->staffOnly = $staffOnly;
        $this->title = $title;
        $this->excerpt = $excerpt;
        $this->content = $content;
        $this->createDate = $createDate;
        $this->publish_date = $publish_date;
        $this->commentCount = $commentCount;
        $this->commentStatus = $commentStatus;
        $this->author = $author;
        $this->meta = $meta;
    }

    public static function loadById($id) {
        $sql = "SELECT * FROM " . Schema::POSTS . " WHERE id='?'";
        $stmt = self::executeQuery($sql, array($id));
        if (!$stmt) {
            return false;
        }
        $post = $stmt->fetch(PDO::FETCH_OBJ);
        return self::getFromStd($post);
    }

    public static function getFromStd($std) {
        return new PostObject(
                        $std->id,
                        $std->status,
                        $std->staff_only,
                        $std->title,
                        $std->excerpt,
                        $std->content,
                        $std->author,
                        $std->create_date,
                        $std->comment_count,
                        $std->comments_status,
                        $std->publish_date,
                        $std->meta
        );
    }

    public static function create($status, $staffOnly, $title, $excerpt, $content, $meta, $commentCount, $commentStatus) {
        $rg = Registry::getInstance();
        $db = $rg->db;
        $author = $rg->user->getId();

        $sql = "INSERT INTO " . Schema::POSTS . " (type,status,staff_only,title,excerpt,content,meta,author,comment_count,comment_status) VALUES(?,?,?,?,'?','?','?','?',?,?,?)";
        $params = array(self::$type, $status, $staffOnly, $title, $excerpt, $content, $commentCount, $commentStatus);
        $stmt = $db->prepare($sql);
        $stmt->execute($params);
        if (!$stmt) {
            $errorInfo = $db->errorInfo();
            Utils::debug("<p>Error inserting post: " . $errorInfo[2]);
            throw new Exception("Error inserting post"); // some other error
        }
        //return a user object
        $id = $db->lastInsertId();
        return self::loadById($id);
    }

    public function save() {
        $rg = Registry::getInstance();
        $db = $rg->db;
        $sql = "UPDATE " . Schema::POSTS . " SET 
           status=?,
           staff_only=?,
           title='?',
           excerpt='?',
           content='?',
           comment_count='?',
           comment_status='?',
           meta='?',
           create_date=?,
           publish_date=?,
           author='?',
           WHERE id=?;
        ";
        $params = array(
            $this->status,
            $this->staffOnly,
            $this->title,
            $this->excerpt,
            $this->content,
            $this->commentCount,
            $this->meta,
            $this->createDate,
            $this->publish_date,
            $this->author,
            $this->id
        );
        $stmt = $db->prepare($sql);
        $stmt->execute($params);
        if (!$stmt) {
            return false;
        }
        return true;
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getStatus() {
        return $this->status;
    }

    public function setStatus($status) {
        $this->status = $status;
    }

    public function isStaffOnly() {
        return $this->staffOnly;
    }

    public function setStaffOnly($staffOnly) {
        $this->staffOnly = $staffOnly;
    }

    public function getTitle() {
        return $this->title;
    }

    public function setTitle($title) {
        $this->title = $title;
    }

    public function getExcerpt() {
        return $this->excerpt;
    }

    public function setExcerpt($excerpt) {
        $this->excerpt = $excerpt;
    }

    public function getContent() {
        return $this->content;
    }

    public function setContent($content) {
        $this->content = $content;
    }

    public function getPublishDate() {
        return $this->publish_date;
    }

    public function setPublishDate($publish_date) {
        $this->publish_date = $publish_date;
    }

    public function getCreateDate() {
        return $this->createDate;
    }

    public function setCreateDate($createDate) {
        $this->createDate = $createDate;
    }

    public function getCommentCount() {
        return $this->commentCount;
    }

    public function setCommentCount($commentCount) {
        $this->commentCount = $commentCount;
    }

    public function getCommentStatus() {
        return $this->commentStatus;
    }

    public function setCommentStatus($commentStatus) {
        $this->commentStatus = $commentStatus;
    }

    public function getAuthor() {
        return $this->author;
    }

    public function setAuthor($author) {
        $this->author = $author;
    }

    public function getMeta() {
        return $this->meta;
    }

    public function setMeta($meta) {
        $this->meta = $meta;
    }

}

?>
