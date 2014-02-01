<?php
if (file_exists("config.inc.php"))
	{
	require_once("config.inc.php");
	} else {
		die ("cannot initialize configuration");
		}
		
$contentFile = "login.html";
$sectionTitle = "Page Name";
//display the left naivgation and 
//ask the admin to click on any of the link 
//to start working

$smarty->assign('contentFile',$contentFile);
$smarty->assign('sectionTitle',$sectionTitle);
$smarty->assign('bodyFile','frame.html');
$smarty->display('index.tpl');
?>