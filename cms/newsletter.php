<?php
if (file_exists("config.inc.php"))
	{
	require_once("config.inc.php");
	} else {
		die ("cannot initialize configuration");
		}


//check for loggedIn 
isLoggedIn();

$type =(!empty($_GET['type'])) ? $_GET['type'] : "list";

switch($type){
	case 'list':
		$nlObj = new Newsletter();
		$nlList = $nlObj->display_newsletters();
		if($nlList){
			$smarty->assign('nlList',$nlList);
			} else {
				$_SESSION['error'] = $nlObj->error;	
		}
		
		$contentFile = "newsletter_list.html";
		$sectionTitle = "Newsletters";			
	break;
	
	case 'add':
		
		if($_POST && $_POST['mm_action'] == 'doAddNewsLetter'){
			$data = $_POST;
			$nlObj = new Newsletter();
			$nlAdd = $nlObj->add_newsletters($data);
			if($nlAdd){
				$_SESSION['message'] = $nlObj->message;	
				header("location: newsletter.php");
				exit;
				} else {
					$_SESSION['error'] = $nlObj->error;	
			}		
		}
		
		$smarty->assign('mm_action','doAddNewsLetter');
		$smarty->assign('formName','Add');
		$contentFile = "newsletter_add.html";
		$sectionTitle = "Newsletters";			
	break;
	
	case 'edit':
		$id = $_GET['id'];
		if($_POST && $_POST['mm_action'] == 'doEditNewsLetter'){
			$data = $_POST;
			$nlObj = new Newsletter();
			$nlEdit = $nlObj->edit_newsletters($data);
			if($nlEdit){
				$_SESSION['message'] = $nlObj->message;	
				header("location: newsletter.php");
				exit;
				} else {
					$_SESSION['error'] = $nlObj->error;	
			}		
		}
		
		// Get the details of the newsletter and assign to smarty
		
		$nlObj = new Newsletter($id);
		$nlEdit = $nlObj->get_newsletters();
		if($nlEdit){
			$smarty->assign('nlEdit',$nlEdit);
			} else {
				$_SESSION['error'] = $nlObj->error;	
		}
		
		$smarty->assign('mm_action','doEditNewsLetter');		
		$smarty->assign('formName','Edit');
		$contentFile = "newsletter_add.html";
		$sectionTitle = "Newsletters";			
	break;
	
	case 'delete':
		$id = $_GET['id'];
		$nlObj = new Newsletter($id);
		$nlDel = $nlObj->del_newsletters();
		if($nlDel){
			$_SESSION['message'] = $nlObj->message;	
			header("location: newsletter.php");	exit;
			} else {
				$_SESSION['error'] = $nlObj->error;	
		}
	break;
	
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

//get all the other other stuff

//display the left naivgation and 
//ask the admin to click on any of the link 
//to start working

$smarty->assign('contentFile',$contentFile);
$smarty->assign('sectionTitle',$sectionTitle);
$smarty->assign('bodyFile','frame.html');
$smarty->display('index.tpl');
?>