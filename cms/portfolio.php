<?php
/**
* This file is for manage Portfolios.
*/

// Check for the configuration file exist or not
if(file_exists("config.inc.php")) {
	include_once("config.inc.php");	
	} else {
		die("Configuration file could not found.");
}

//Check for loggedIn 
isLoggedIn();
$type =(!empty($_GET['type'])) ? $_GET['type'] : "list";
switch($type){
	case 'list':
		$portfolObj = new Portfolio();
		$portfolList = $portfolObj->list_all_portfolio();
		if($portfolList){
			//print_r($portfolList);
			$smarty->assign('portfolList',$portfolList);	
			} else {
				$_SESSION['error'] = $portfolObj->error;
		}		
		$contentFile = "portfolio.html";		
		$sectionTitle = "Manage Portfolios";
	break;
	
	case 'add':
		
		$portfObj = new Portfolio();
		
		if($_POST && $_POST['mm_action'] == 'doAddPortfolio'){
			$data = $_POST;
			
			$addPortfolio = $portfObj->add_portfolio($data);
			
			if($addPortfolio){
				$_SESSION['message'] = $portfObj->message;
				header("location: portfolio.php");
				exit;
				} else {
					$_SESSION['error'] = $portfObj->error;
			}
			
			
		}
		$linkObj = new Link(2); // Hardcoding the Portfolio Link ID
		$subLinkList = $linkObj->get_sub_link();
		if($subLinkList){
			$smarty->assign('subLinkList',$subLinkList);
			} else {
				$_SESSION['error'] = $linkObj->error;
		}
		
		$contentFile = "portfolio_add.html";
		$sectionTitle = "Add Portfolio";
		$smarty->assign('formAction','doAddPortfolio');
		$smarty->assign('formName','Add');
		
	break;
	
	case 'edit':
		if($_POST && $_POST['mm_action'] == "doEditPortfolio"){
			$data = $_POST;
			//print_r($data); exit;
			$portfObj = new Portfolio();
			$portfEdit = $portfObj->edit_portfolio($data);
			if($portfEdit){
				echo "success";
				$_SESSION['message'] = $portfObj->message;
				header("location: portfolio.php");
				exit;
				} else {
					$_SESSION['error'] = $portfObj->error;
					header("location: portfolio.php");
					exit;
			}
		}
		
		// Display the portfolio details which the user want to edit
		$id = $_GET['id'];
		$portfObj = new Portfolio($id);
		$portfolDet = $portfObj->get_details();
		if($portfolDet){
			$smarty->assign('portfDtls',$portfolDet);
			} else {
				$_SESSION['error'] = $portfObj->error;
		}
		
		$linkObj = new Link(2); // Hardcoding the Portfolio Link ID
		$subLinkList = $linkObj->get_sub_link();
		if($subLinkList){			
			$smarty->assign('subLinkList',$subLinkList);
			} else {
				$_SESSION['error'] = $linkObj->error;
		}	
		
		$contentFile = "portfolio_add.html";
		$sectionTitle = "Edit Portfolio";		
		$imagePath = "./images/portfolio/";
		
		$smarty->assign('formAction','doEditPortfolio');
		$smarty->assign('formName','Edit');
		$smarty->assign('imagePath',$imagePath);
		
	break;
	
	case 'delete':
		global $db;
		$id = $_POST['id'];
		$portfObj = new Portfolio($id);
		$portfDel = $portfObj->delete_portfolio();
		if($portfDel){
			$_SESSION['message'] = $portfObj->message;
			echo "success";
			exit;
			} else {
				$_SESSION['error'] = $portfObj->error;
				echo "error";
				exit;
		}					
			
	break;

}

//to start working session message

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