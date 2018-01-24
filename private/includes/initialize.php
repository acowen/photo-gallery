<?php

//Define the core paths
//Define them as absolute paths to make sure that require_once works as expected

define("PRIVATE_PATH", dirname(__FILE__));
define("PROJECT_PATH", dirname(PRIVATE_PATH));
define("PUBLIC_PATH", PROJECT_PATH . '/public');
define("INCLUDES_PATH", PROJECT_PATH . '/includes');
define("SHARED_PATH", PRIVATE_PATH . '/shared');
define("IMAGE_PATH", PROJECT_PATH . '/public/images');


defined('DS') ? null : define('DS', DIRECTORY_SEPARATOR);

defined('SITE_ROOT') ? null:
    define('SITE_ROOT', DS.'sandbox'.DS.'photo_gallery');

defined('LIB_PATH')?null:define('LIB_PATH',SITE_ROOT.DS.'includes');

//load config file first
require_once(INCLUDES_PATH . DS . "config.php");


//load basic functions next so that everything after can use them
require_once(INCLUDES_PATH . DS . "functions.php");

//load core objects
require_once(INCLUDES_PATH . DS . "database.php");
require_once(INCLUDES_PATH . DS . "session.php");
require_once(INCLUDES_PATH . DS . "database_object.php");
require_once(INCLUDES_PATH . DS . "pagination.php");

//load database-related classes
require_once(INCLUDES_PATH . DS . "user.php");
require_once(INCLUDES_PATH . DS . "photograph.php");
require_once(INCLUDES_PATH . DS . "comments.php");