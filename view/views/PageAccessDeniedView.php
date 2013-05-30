<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PageAccessDenied
 *
 * @author max
 */
class PageAccessDeniedView extends StaticPage{
    public function __construct() {
        parent::__construct('access_denied.html');
    }
}

?>
