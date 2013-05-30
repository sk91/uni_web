<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 *
 * @author max
 */
interface EditPostViewInterface extends SingleViewInterface{
    public function save();
    public function getSuccessUrl();
    public function validateData();
    public function getAuthor();
}

?>
