<?php
/**
* page for the banners
* to display the banner form
* as well as to display the list of 
* all available banners in the system
*/
if (file_exists("config.inc.php"))
	{
	require_once("config.inc.php");
	} else {
		die ("cannot initialize configuration");
		}

//check for loggedIn 
isLoggedIn();


/* get the banner list */
$banner = new Banner();
$banner_list = $banner->get_banner_list();
$smarty->assign("banner_list",$banner_list);


if ($conf['banner_rotation'] == '0')
	{
	$smarty->assign("ban_off",'checked="checked"');
	}
if ($conf['banner_rotation'] == '1')
	{
	$smarty->assign("ban_on",'checked="checked"');
	}	

//to start working
if ($_SESSION['error'])
	{
	$error = $_SESSION['error'];
	unset($_SESSION['error']);
	}

if ($_SESSION['message'])
	{
	$message = $_SESSION['message'];
	unset($_SESSION['message']);
	}	
	
if ($error) { $smarty->assign('error',$error); }
if ($message) { $smarty->assign('message',$message); }

//display the left naivgation and 
//ask the admin to click on any of the link 
//to start working
$smarty->assign('contentFile',"admn_banner.html");
$smarty->assign('sectionTitle',"Manage Banners");
$smarty->display('index.tpl');
?>