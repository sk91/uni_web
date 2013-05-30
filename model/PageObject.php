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
class PageObject extends PostObject {

    const PAGE_OBJECT_TYPE = 1;

    protected static $type = self::PAGE_OBJECT_TYPE;

    function __construct($id, $status, $staffOnly, $title, $excerpt, $content, $createDate, $publish_date) {
        parent::__construct($id, $status, $staffOnly, $title, $excerpt, $content, $createDate, 0, CommentObject::COMMENTS_NOT_ALLOWED, $publish_date);
    }

    public static function getFromStd($std) {
        return new PageObject(
                        $std->id,
                        $std->status,
                        $std->staff_only,
                        $std->title,
                        $std->excerpt,
                        $std->content,
                        $std->create_date,
                        $std->publish_date
        );
    }

    public function getCommentCount() {
        return 0;
    }

    public function getCommentStatus() {
        return CommentObject::COMMENTS_NOT_ALLOWED;
    }

    public function setCommentCount($commentCount) {
        parent::setCommentCount(0);
    }

    public function setCommentStatus($commentStatus) {
        parent::setCommentStatus(CommentObject::COMMENTS_NOT_ALLOWED);
    }

}

?>
