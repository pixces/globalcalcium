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
		$subxObj = new Subscribers();
		$subxList = $subxObj->display_subscribers();
		if($subxList){
			$smarty->assign('subxList',$subxList);
			} else {
				$_SESSION['error'] = $subxObj->error;
		}
		
		$contentFile = "subscribers_list.html";
		$sectionTitle = "Subscribers";			
	break;
	
	case 'unSubx':
		$id = $_GET['id'];
		$subxObj = new Subscribers($id);
		$unSubx = $subxObj->unSubx_subscribers();
		
		if($unSubx){
			
			$_SESSION['message'] = $subxObj->message;
			header("location: subscribers.php");
			exit;
			} else {
					$_SESSION['error'] = $subxObj->error;
					return false;
		}		
	break;
	
	
	case 'unsubxAll':		// This case is used to Unsubscribe all selected emails
		if($_POST){
			$data = $_POST;
			$subxObj = new Subscribers();
			$subxUn = $subxObj->unsubxAll_subscribers($data);
			if($subxUn){
				$_SESSION['message'] = "Unsubscribed selected emails";
				} else {
						$_SESSION['error'] = "Cannot unsubscribe emails. Try again";
				}
		}
	break;
	
	case 'subxAll':		// This case is used to Subscribe all selected emails
		if($_POST){
			$data = $_POST;
			$subxObj = new Subscribers();
			$subxAdd = $subxObj->subxAll_subscribers($data);
			if($subxAdd){
				$_SESSION['message'] = $subxObj->message;
				} else {
						$_SESSION['error'] = $subxObj->error;
				}
		}
	break;
	
	
	
	case 'delAll':		// This case is used to Unsubscribe all selected emails
		if($_POST){
			$data = $_POST;
			$subxObj = new Subscribers();
			$subxDel = $subxObj->deleteAll_subscribers($data);
			if($subxDel){
				$_SESSION['message'] = "Deleted selected emails";
				} else {
						$_SESSION['error'] = "Cannot delete emails. Try again";
				}
		}
	break;
	
	case 'subx':
		$id = $_GET['id'];
		$subxObj = new Subscribers($id);
		$subx = $subxObj->subx_subscribers();
		if($subx){
			$_SESSION['message'] = $subxObj->message;
			header("location: subscribers.php");
			exit;
			} else {
					$_SESSION['error'] = $subxObj->error;
			}		
	break;
	
	case 'delSubx':
		$id = $_GET['id'];
		$subxObj = new Subscribers($id);
		$unSubx = $subxObj->delSubx_subscribers();
		if($unSubx){
			$_SESSION['message'] = $subxObj->message;
			header("location: subscribers.php");
			exit;
			} else {
					$_SESSION['error'] = $subxObj->error;
			}		
	break;
}


//to start working
//error & messages
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

$smarty->assign('contentFile',$contentFile);
$smarty->assign('sectionTitle',$sectionTitle);
$smarty->assign('bodyFile','frame.html');
$smarty->display('index.tpl');
?>