<?php
if (file_exists("config.inc.php")){
	require_once("config.inc.php");
	} 
else {
	die ("cannot initialize configuration");
	}

//check for loggedIn 
isLoggedIn();


$type =(!empty($_GET['type'])) ? $_GET['type'] : "list";

switch($type){

	case 'list':
	
	//get the list of all admin in the system except the super admin
//Super Admin have the role Id as 1
//all the other will have the role Id as 2
//only super admin will have all the right to manage the admin
	
	$admin = new Admin();
	$adminList = $admin->admin_list();
	$smarty->assign('adminList',$adminList);
	$smarty->assign('action','doAddAdmin');		// Assigning a var for hidden value in html file to decide whether Add or Edit 
	$smarty->assign('formName','Add');			// Assigning smarty var for Form title and button name
	
	$contentFile = "manage-admin.html";
	$sectionTitle = "Manage Administrators";
	break;
	
	// Add the new admin user	
	case 'add':
				
		if($_POST && $_POST['mm_action'] == 'doAddAdmin')
			{
			$data = $_POST;
			
			$adminObj = new Admin();
			$adminAdd = $adminObj->admin_add($data);
			
		
			if($adminAdd){
				$_SESSION['message'] = $adminObj->message;
				header("location:manage-admin.php");
				exit;
					} else{
						$_SESSION['error'] = $adminObj->error;
						}
			}
			
			$smarty->assign('adminAdd',$adminAdd);
			
			$contentFile = "manage-admin.html";
			$sectionTitle = "Manage Administrators";
	break;
		
	// Modify the detals of the existing admin user
	case 'edit':
	
		$id = $_GET['id'];
		$adminObj = new Admin($id);
		
		if($_POST && $_POST['mm_action'] == 'doEdit')
			{
				$data = $_POST;
				$editAdmin = $adminObj->admin_edit($data);
			
				if($editAdmin){
					$_SESSION['message'] = $adminObj->message;
					//header("location:manage-admin.php");
					//exit;
					} else {
						$_SESSION['error'] = $adminObj->error;
						}
			}
		
		$adminDet = $adminObj->admin_detail();	
		
		if($adminDet){		
			$smarty->assign('adminDet',$adminDet);
			
				
			if($adminDet->admin_status == 1){
				$smarty->assign('checked','checked');
				}
			} else {
			$_SESSION['error'] = $adminObj->error;
			
		}
		
		// Display the details on the edit form
		$adminDet = $adminObj->admin_detail();		
		if(!empty($adminDet)){
						
			$smarty->assign('adminDet',$adminDet);
			// check only those boxes 
			// permission given to a specific admin
			if($adminDet->man_home == 1){
				$smarty->assign('man_home','checked');
				} else {$smarty->assign('man_home','');
						}
			if($adminDet->man_link == 1){
				$smarty->assign('man_link','checked');
				} else {$smarty->assign('man_link','');
						}
			if($adminDet->man_content ==1){
				$smarty->assign('man_content','checked');
				} else {$smarty->assign('man_content','');
						}
			if($adminDet->man_event == 1){
				$smarty->assign('man_event','checked');
				} else {$smarty->assign('man_event','');
						}
			if($adminDet->man_admin == 1){	
				$smarty->assign('man_admin','checked');			
				} else {$smarty->assign('man_admin','');
						}
		}
		
		// listing all admins
		$adminList = $admin->admin_list();
		$smarty->assign('adminList',$adminList);
		
		$smarty->assign('action','doEdit');		// Assigning a var for hidden value in html file to decide whether Add or Edit 
		$smarty->assign('formName','Edit');		// Assigning smarty var for Form title and button name
		$contentFile = "manage-admin.html";
		$sectionTitle = "Manage Administrators";
		
	break;
	
	// To delete the existing admin user
	case 'delete':
	
		$id = $_GET['id'];
		$adminObj = new Admin($id);
		$delAdmin = $adminObj->delete_admin();	
		
		if($delAdmin) {
				$_SESSION['message'] = $adminObj->message;
				header("location:manage-admin.php");
				exit;
				} else {
					$_SESSION['error'] = $adminObj->error;
		}					
			
	break;
	
	case 'check':
		$id = $_SESSION['adminId'];		
		$data = $_POST;
		$logObj = new Login($id);
		$chkPW = $logObj->check_passW($data);
		//print_r($chkPW);
		$providedP = trim($data['old_password']);
		$currP = trim($chkPW->password);
		
		if($currP == $providedP){
			echo "success";
			exit;
			} else {
				echo "error";
				exit;		
		}
	break;
	
	// To change Password
	case 'change':
		$id = $_SESSION['adminId'];		
		$data = $_POST;
		$admObj = new Admin($id);
		$chngPW = $admObj->change_password($data);
		if($chngPW){
			$_SESSION['message'] = $admObj->message;
			} else {
				$_SESSION['error'] = $admObj->error;
		}
	break;
	
}



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


$smarty->assign('contentFile',$contentFile);
$smarty->assign('sectionTitle',$sectionTitle);
$smarty->display('index.tpl');
?>