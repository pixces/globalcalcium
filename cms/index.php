<?php
if (file_exists("config.inc.php"))
	{
	require_once("config.inc.php");
	} else {
		die ("cannot initialize configuration");
		}

/**
* check for user login 
* if user is not logged in 
* create a function to do so
*/
isLoggedIn();

//get all the other other stuff
$contentFile = "home_main.html";
$sectionTitle = "Home";
//display the left naivgation and 
//ask the admin to click on any of the link 
//to start working

$smarty->assign('contentFile',$contentFile);
$smarty->assign('sectionTitle',$sectionTitle);
$smarty->display('index.tpl');
?>