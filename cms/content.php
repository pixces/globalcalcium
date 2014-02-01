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
		$contObj = new Content();
		//get the list of all contentS
		$contentList = $contObj->display_content();
				
		if(!empty($contentList))
			{
			$smarty->assign('contentList',$contentList);
			$smarty->assign('content_count',count($contentList));
			}
		else
			{
			$_SESSION['error'] = $contObj->error;			
			}
		
		$contentFile = "content_list.html";
		$sectionTitle = "Site Content";
		
	break;
	
	case 'add':	
		$contObj = new Content();
		if($_POST && $_POST['mm_action'] == 'doAdd'){
			
			$data = $_POST;
			// echo "<pre>";
			// print_r($data); exit;
			$pageContent = isset($data) ? trim($data['page_content']) : '';
			if(!$pageContent || $pageContent == ''){
				$_SESSION['error'] = "Please enter the page content.";
				header("location:content.php");
			}
			$addContent = $contObj->add_content($data);
			
			if($addContent){
				$_SESSION['message'] = $contObj->message;
				header("location:content.php");
				exit;
				} else {
				echo $contObj->error;
				$_SESSION['error'] = $contObj->error;
				header("location:content.php");
				exit;
			}
		}
		
		$linkObj = new Link();
		//$linkList = $linkObj->display_link(1);
		$linkList = $linkObj->get_link_formated($all = TRUE);
		if($linkList) {
				$smarty->assign('linkList',$linkList);
			} else {
				$_SESSION['error'] = "Content Links Are Empty";
		}
		
		$contentFile = "content_add.html";
		$sectionTitle = "Add Site Content";
		
		$smarty->assign('formName','Add');		// Assigning smarty var for Form title and button name
		$smarty->assign('action','doAdd');		// Assigning a var for hidden value in html file to decide whether Add or Edit
		$smarty->assign('disable','');	// Assigning a var to make the drop down disabled while editing
		
	break;
	
	case 'edit':	
		$contObj = new Content();
		if($_POST && $_POST['mm_action'] == 'doEdit'){
			$data = $_POST;
			$editContent = $contObj->edit_content($data);
			if($editContent){
					$_SESSION['message'] = $contObj->message;										
					header("location: content.php");
					exit;
				} else {
					$_SESSION['error'] = $contObj->error;
			}
		}
		
		$id = $_GET['id'];
		$contentDet = $contObj->get_content($id);	
		//print_r($contentDet); exit;	
		if($contentDet){	
			$smarty->assign('contentDet',$contentDet);	
			$smarty->assign('pageContent',stripslashes(urldecode($contentDet->content)));			
		}
		
		$linkObj = new Link();
		$linkList = $linkObj->get_link_formated($all = TRUE);
		//print_r($linkList); exit;
		
		$contentFile = "content_add.html";
		$sectionTitle = "Edit Site Content";
		$smarty->assign('linkList',$linkList);
		$smarty->assign('formName','Edit');		// Assigning smarty var for Form title and button name
		$smarty->assign('action','doEdit');		// Assigning a var for hidden value in html file to decide whether Add or Edit
		$smarty->assign('disable','disabled="true"');	// Assigning a var to make the drop down disabled while editing
		
	break;
	
	case 'delete':
	
		$id = $_GET['id'];
		$contentObj = new Content($id);
		$delContent = $contentObj->delete_content();	
		
		if($delContent) {
				$_SESSION['message'] = $contentObj->message;
				header("location:content.php");
				exit;
				} else {
					$_SESSION['error'] = $contentObj->error;
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

//display the left naivgation and 
//ask the admin to click on any of the link 
//to start working

$smarty->assign('contentFile',$contentFile);
$smarty->assign('sectionTitle',$sectionTitle);
$smarty->assign('bodyFile','frame.html');
$smarty->display('index.tpl');
?>