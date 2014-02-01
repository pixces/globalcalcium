<?php
if (file_exists("config.inc.php")){
	require_once("config.inc.php");
	} 
else {
	die ("cannot initialize configuration");
	}

//check for loggedIn 
isLoggedIn();


		$qtoObj = new Quote();
		//get the list of all quote list
		$quoteList = $qtoObj->get_quote_list();
		
		if(!empty($quoteList))
			{
			$smarty->assign('quoteList',$quoteList);
			}
		else
			{
			$_SESSION['error'] = "List is empty";			
			}
			
/*		//get the Get link
		$getLink = get_quote_list($_GET,"sort");
		//echo $getLink;*/
		
		$contentFile = "list_quote.html";
		$sectionTitle = "Quote Content";
		

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

$smarty->assign('contentFile',$contentFile);
$smarty->assign('sectionTitle',$sectionTitle);
$smarty->display('index.tpl');
?>