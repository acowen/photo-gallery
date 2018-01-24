<?php

/**
 * Define paths and loads need files.
 *
 */

define("PRIVATE_PATH", dirname(dirname(__FILE__)).'/private');
define("PROJECT_PATH", PRIVATE_PATH);
define("PUBLIC_PATH", dirname(PROJECT_PATH) . '/public');
define("INCLUDES_PATH", PRIVATE_PATH . '/includes');
define("SHARED_PATH", PRIVATE_PATH . '/shared');
define("IMAGE_PATH", PUBLIC_PATH . '/images');


defined('DS') ? null : define('DS', DIRECTORY_SEPARATOR);


//load config file first
require_once(INCLUDES_PATH.DS."config.php");

//load basic functions
require_once(INCLUDES_PATH.DS."functions.php");

//load core objects
require_once(INCLUDES_PATH.DS."database.php");
require_once(INCLUDES_PATH.DS."session.php");
require_once(INCLUDES_PATH.DS."database_object.php");
require_once(INCLUDES_PATH.DS."pagination.php");

//load database-related classes
require_once(INCLUDES_PATH.DS."user.php");
require_once(INCLUDES_PATH.DS."photograph.php");
require_once(INCLUDES_PATH.DS."comments.php");