<?php
include_once("config.inc.php");

$opt = $_GET['opt'];
if (!$opt)
	{
	echo "Invalid request status";
	exit;
	}

switch($opt){

			
	//edit 
	case '1':
		if ( $_POST && $_POST["mm_action"] == "editAdmin"){
			
				$admin = new Admin();
				
				//do edit
				if ($admin->admin_edit())
					{
					$_SESSION['message'] = $admin->message;
					header("location: manage-admin.php");
					exit;
					} else {
						$_SESSION['error'] = $admin->error;
						header("location: manage-admin.php");
						exit;						
						}	
			}
	break;
	
	//delete admin
	case '2':
		$id = $_POST['id'];
		
		//do delete
		$admin = new Admin($id);
		$result = $banner->delete_admin();
		if ($result)
			{
			echo "success";
			exit;
			} else {
				echo "error";
				exit;
				}
	break;
	
	// get the details of the admin id provided
	case '3':
		$id = $_GET['id'];
		$adminObj = new Admin($id);
		$adminDet = $adminObj->admin_detail();
		if($adminDet){
			echo $adminDet->id."##".$adminDet->first_name."##".$adminDet->second_name."##".$adminDet->admin_email."##".$adminDet->username."##".$adminDet->admin_status;
			}  else {
				echo "error";
				exit;
		}

		
	break;
	
	
	
	
}

?>