<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 *
 * @author max
 */
interface SingleViewInterface{
    public function getTitle();
    public function getContent();
    public function getExcerpt();
    public function getMeta();
    public function getCreateDate();
    public function getPublishDate();
    public function getCommentCount();
    public function getComments();
    public function getStatus();
    public function getCommentsStatus();
    public function getID();
}

?>
