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
		
		$linkObj = new Link();
		
		// Add link details if post		
		
		if($_POST && $_POST['mm_action'] == 'doAddLink'){
			$data = $_POST;
					
			$result = $linkObj->add_link($data);
			if($result){
				$_SESSION['message'] = "Link Added Successfully";
				} else {
					$_SESSION['error'] = "Cannot add Link. Try Again";
					}
					header("location:link.php");
				exit;
		}
		
		//get the links from the database
		//and display them all.
		
		$linkList = $linkObj->get_link_list();
		if($linkList){
			$smarty->assign('linkList',$linkList);
			} else {
				$_SESSION['error'] = "No links found. Please Add links";
		}
		$parentList = $linkObj->get_link_formated($all = FALSE);
		//print_r($linkList);
		
		$smarty->assign('disabled','disabled="disabled"');		
		$smarty->assign('pLinks',$parentList);
		
		$smarty->assign('linkTypeP','checked="checked"');
		$smarty->assign('action','doAddLink');
		$smarty->assign('formName','Add');
		$contentFile = "link_list.html";
		$sectionTitle = "Site Links";
		// end of listing
		
		
		// end of add link
	break;
	
	case 'edit':
		
		$id = $_GET['link_id']; 
		
		$linkObj = new Link($id);
		
		// Update the link details
		if ( ($_POST) && ($_POST['mm_action'] == 'doEdit') )
			{
			$editVars = $_POST;	
			$linkEdit = $linkObj->edit_link($editVars);
			if ($linkEdit){
				$_SESSION['message'] = "Link Edited Successfully";
				header("location: link.php");
				exit;
				} else {
					$_SESSION['error'] = "Cannot edit Link. Try Again";
					}					
			}
		// end of updation of link details
		
		// To Display all the link list on the left side
		$linkList = $linkObj->get_link_list();
				$parentList = $linkObj->get_link_formated($all = FALSE);
		if(!empty($linkList)){
			$smarty->assign('linkList',$linkList);
			} else {
				$_SESSION['error'] ="Link List is Empty. Please Add Links";			
		}
		//print_r($pLinkList);
		if(!empty($parentList)){
			$smarty->assign('pLinks',$parentList);
		}
		// end of display link list
		
		// Display the link details on the edit form
		$linkDet = $linkObj->get_details();		
		
		if(!empty($linkDet)){
			if($linkDet->link_type == 0){
				$linkTypeP = 'checked';
				$linkTypeS = '';
				} else {
				$linkTypeP = '';
				$linkTypeS = 'checked';
			}
			
			$smarty->assign('linkDet',$linkDet);
		}
		
		// end of the display edit link
		$smarty->assign('orderLink',$orderLink);
		$smarty->assign('linkTypeP',$linkTypeP);
		$smarty->assign('linkTypeS',$linkTypeS);
		$smarty->assign('action','doEdit');
		$smarty->assign('formName','Edit');
		$contentFile = "link_list.html";
		$sectionTitle = "Site Links";
	
	break;
	
	case 'delete':
	
		$id = $_GET['link_id'];
		$linkObj = new Link($id);
		$linkDel = $linkObj->delete_link();	
		
		if($linkDel) {
				$_SESSION['message'] = "Link Deleted Successfully";
				header("location: link.php");
				exit;
				} else {
					$_SESSION['error'] = "Cannot delete link. Try Again";
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