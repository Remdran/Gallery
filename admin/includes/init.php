<?php

// If DS is defined set it to null else set it to a seperator(\ or /) depending on OS
defined('DS') ? null : define('DS', DIRECTORY_SEPARATOR);

// Define the root directory of the site
define('SITE_ROOT', 'Desktop' . DS . 'Work' . DS . 'Gallery');


defined('INCLUDES_PATH') ? null : define('INCLUDES_PATH', SITE_ROOT . DS . 'admin' . DIRECTORY_SEPARATOR . 'includes');



require_once("new_config.php");
require_once("Database.php");
require_once("Db_Object.php");
require_once("User.php");
require_once("Photo.php");
require_once("Comment.php");
require_once("Session.php");
require_once("functions.php");
