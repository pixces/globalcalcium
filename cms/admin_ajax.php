<?php
include_once("config.inc.php");

$opt = $_GET['type'];
if (!$opt)
	{
	echo "Invalid request status";
	exit;
	}

switch($opt){

	//add admin record
	case'1':
		if ( $_POST && $_POST["mm_action"] == "doAddAdmin")
			{
			//print_r($_POST);
			$data = $_POST;

			$admin = new Admin($data);
			$result = $admin->admin_add($data);
			
			if ($result)
				{
				$_SESSION['message'] = "New admin has been successfully created.\n An email with the password has been sent to the email address provided";
				echo "success";
				} else {
					echo $admin->error;
					}
			exit;
			}
	break;
	
	//edit admin record
	case '2':
		if ( $_POST && $_POST["mm_action"] == "editBanner"){

			}
	break;
	
	//delete admin record
	case '3':
		
	break;
	
	

}

?>