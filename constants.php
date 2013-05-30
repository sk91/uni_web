<?php

define("DS", DIRECTORY_SEPARATOR);
//Define the site root dir
define("SITE_ROOT", dirname(__FILE__));

define('SITE_GENERAL', SITE_ROOT . DS . 'general');
define('SITE_MODEL', SITE_ROOT . DS . 'model');
define("SITE_VIEW", SITE_ROOT . DS . 'view');
define("SITE_VIEWS",SITE_VIEW . DS . 'views');
define("SITE_CONTROLLER", SITE_ROOT . DS . 'controller');
define('SITE_TEMPLATES', SITE_VIEW . DS . 'templates');
define('SITE_VIEW_HELPERS', SITE_VIEW . DS . 'helpers');

define('SITE_STATIC',SITE_ROOT.DS. 'static');

define('SITE_AUTOLOADER', SITE_GENERAL . DS . 'Autoloader.php');

define('AJAX_INDICATOR','ajax');
?>
