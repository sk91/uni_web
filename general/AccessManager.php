<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AccessManager
 *
 * @author max
 */
class AccessManager {
    //comments privilages

    const VIEW_ONLY = 0;
    const WRITE_COMMENTS = 1;          //0b0000000000000000000000000000001
    const EDIT_OWN_COMMENTS = 2;       //0b0000000000000000000000000000010
    const EDIT_COMMENTS = 4;           //0b0000000000000000000000000000100
    const REMOVE_OWN_COMMENTS = 8;     //0b0000000000000000000000000001000
    const REMOVE_COMMENTS = 16;        //0b0000000000000000000000000010000
    //post privilages
    const CREATE_POST = 32;            //0b0000000000000000000000000100000
    const EDIT_OWN_POST = 64;          //0b0000000000000000000000001000000
    const EDIT_POST = 128;             //0b0000000000000000000000010000000
    const REMOVE_POST = 256;           //0b0000000000000000000000100000000
    const REMOVE_OWN_POST = 512;       //0b0000000000000000000001000000000
    const PUBLISH_POST = 1024;         //0b0000000000000000000010000000000
    //page
    const CREATE_PAGE = 2048;          //0b0000000000000000000100000000000
    const EDIT_OWN_PAGE = 4096;        //0b0000000000000000001000000000000
    const EDIT_PAGE = 8192;            //0b0000000000000000010000000000000
    const REMOVE_PAGE = 16384;         //0b0000000000000000100000000000000
    const REMOVE_OWN_PAGE = 32768;     //0b0000000000000001000000000000000
    const PUBLISH_PAGE = 65536;        //0b0000000000000010000000000000000
    //tags
    const REMOVE_TAG = 131072;         //0b0000000000000100000000000000000 
    //users
    const MANAGE_USER = 262144;        //0b0000000000001000000000000000000  
    const STAFF = 524288;              //0b0000000000010000000000000000000 

    private static $instance;

    private function __construct() {}

    public static function getInstance() {
        if (!isset(self::$instance)) {
            self::$instance = new AccessManager();
        }
        return self::$instance;
    }

    private function userOrDefautl($user = null) {
        if ($user == null) {
            $rg = Registry::getInstance();
            return $rg->user;
        }
        return $user;
    }

    private function canDoSomething($privilage, $user = null) {
        $user = $this->userOrDefautl($user);
        return $user->hasPrivilage($privilage);
    }

    public function canViewPost(PostObject $post, $user = null) {
        if ($post->isStaffOnly()) {
            return $this->canDoSomething(self::STAFF, $user);
        }
        return true;
    }

    public function canCreatePost($user = null) {
        return $this->canDoSomething(self::CREATE_POST, $user);
    }
    
    public function canCreatPage($user =null){
        $this->canDoSomething(self::CREATE_PAGE, $user);
    }

    public function getGuestPrivilages() {
        return self::VIEW_ONLY;
    }

    public function getDefaultPrivilages() {
        return self::WRITE_COMMENTS & self::EDIT_OWN_COMMENTS & self::REMOVE_OWN_COMMENTS;
    }

}

?>
