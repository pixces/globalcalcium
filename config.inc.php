<?php
/***
* the basic configuration directives 
* Created by Zainul (pixces@yahoo.com)
*/
error_reporting(E_ALL ^ E_NOTICE ^ E_USER_NOTICE);
define('MEMORY_LIMIT', '32M');
@ini_set('memory_limit', MEMORY_LIMIT);


//set the session
session_start();
ob_start();

# db switch
$debug = false;

# basic path definitions
define('BASEPATH', dirname(__FILE__)); 
define('INCL', BASEPATH . "/assets/includes/");
define('CLS', BASEPATH . "/assets/class/");
define('IMG', BASEPATH . "/assets/images/");
define('HTML', BASEPATH . "/HTML/");

//include required classes
require_once(INCL . "connection.inc.php");
require_once(INCL . "functions.php");
require_once(CLS . "ez_sql.php");
require_once(CLS . "class.link.php");
require_once(CLS . "class.content.php");
require_once(CLS . "class.metatag.php");
require_once(CLS . "class.product.php");
require_once(CLS . "class.events.php");
require_once(CLS . "class.phpmailer.php");
require_once(CLS . "class.smtp.php");
require_once(CLS . "class.pop3.php");

#get basic site configuration
$config = getConfiguration();
define('SITE_ROOT',$config['base_url']);

?>