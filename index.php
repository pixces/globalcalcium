<?php
/**
* basic bootstraping
*/
if (!file_exists("config.inc.php"))	 { die("Cannot proceed further. Configuration cannot be found" ); }
require_once("config.inc.php");

$sidebar = "home-sidebar.html";
$content = "main.html";

#default metatags
#to be placed on the home page
$meta = get_meta_info();
require_once("loadTemplate.php");
?>