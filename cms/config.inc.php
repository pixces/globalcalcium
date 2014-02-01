<?php
error_reporting(E_ALL ^ E_NOTICE);

//config file that inclues all the files
ob_start();
session_start();

#debug switch
$debug = false;

include_once("../assets/includes/connection.inc.php");
include_once("includes/functions.php");
include_once("classes/ez_sql.php");
include_once("includes/libs/Smarty.class.php");

// all custom classes

include_once("classes/class_login.php");
include_once("classes/class_link.php");
include_once("classes/class_content.php");
include_once("classes/class_products.php");
include_once("classes/class_events.php");
include_once("classes/class_section.php");
include_once("classes/class_quote.php");
include_once("classes/class_subscribers.php");
include_once("classes/class_newsletter.php");
include_once("classes/class_tag.php");
include_once("classes/class_metatag.php");
include_once("classes/class_admin.php");
include_once("classes/class_upload.php");
include_once("classes/class.phpmailer.php");
include_once("classes/class.smtp.php");

//get the dynamic path
define("ABSPATH", dirname(__FILE__));
define("UPLOAD_DIR", "../images/");

/**
* get the basic site configuration
*/
$conf = getConfiguration();

/**
* do a common logout
*/
if (isset($_GET['logout']))
	{
	do_Admin_Logout();
	}

//configure the smarty directories
$smarty = new Smarty;
$smarty->template_dir = ABSPATH . "/HTML/";
$smarty->config_dir = ABSPATH . "/HTML/";
$smarty->compile_dir =  "includes/libs/compile";
$smarty->cache_dir =  ABSPATH . "/HTML/";

// get the welcome note for the admin
// get the permissions of the admin
$admin = new Admin($_SESSION['adminId']);
$welcomeNote = $admin->admin_welcome_note();
$navigation = $admin->get_navigation_array();

$smarty->assign('welcomeNote',$welcomeNote);
$smarty->assign('navigation',$navigation);




?>