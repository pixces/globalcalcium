<?php
/**
* Page for Index page section items
* to display link content digest 
* also to display all the section
* you can have different block of section and sub section too
*/
if (file_exists("config.inc.php"))
	{
	require_once("config.inc.php");
	} else {
		die ("cannot initialize configuration");
		}

//check for loggedIn 
isLoggedIn();

//get the section list and display
$section = new Section();
$section_list = $section->section_list();
//print_r($section_list);
$smarty->assign("section_list",$section_list);

//get the list of all main sections to be displayed as a drop down box;
$section_combo = getSectionCombo();


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


$smarty->assign('section_combo',$section_combo);
$smarty->assign('contentFile',"index_section_page.html");
$smarty->assign('sectionTitle',"Index Page Sections");
$smarty->display('index.tpl');
?>