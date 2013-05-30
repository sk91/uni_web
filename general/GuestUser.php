<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of GuestUser
 *
 * @author max
 */
class GuestUser extends UserObject{
    function __construct() {
        parent::__construct(0, 'Guest', '', AccessManager::VIEW_ONLY);
    }

}

?>
