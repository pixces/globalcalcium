<?php
include_once("config.inc.php");

$opt = $_GET['opt'];
if (!$opt)
	{
	echo "Invalid request status";
	exit;
	}

switch($opt){

	//add banner
	case'1':
		if ( $_POST && $_POST["mm_action"] == "doBanner")
			{
			//upload the image
			//update the database
			$banner = new Banner();
			if ( $banner->add_banner())
				{
				$_SESSION['message'] = $banner->message;
				header("location: banner.php");
				exit;
				} else {
					$_SESSION['error'] = $banner->error;
					header("location: banner.php");
					exit;
					}
			exit;
			}
	break;
	
	//edit banner
	case '2':
		if ( $_POST && $_POST["mm_action"] == "editBanner"){
			
				$banner = new Banner();
				
				//do edit
				if ($banner->edit_banner())
					{
					$_SESSION['message'] = $banner->message;
					header("location: banner.php");
					exit;
					} else {
						$_SESSION['error'] = $banner->error;
						header("location: banner.php");
						exit;						
						}	
			}
	break;
	
	//delete banner
	case '3':
		$id = $_POST['id'];
		
		//do delete
		$banner = new Banner($id);
		$result = $banner->delete_banner();
		if ($result)
			{
			echo "success";
			exit;
			} else {
				echo "error";
				exit;
				}
	break;
	
	//get the details of the banner id provided
	case '4':
		$id = $_GET['id'];
		$banner = new Banner($id);
		$details = $banner->get_banner_details();
		if ($details)
			{
			echo $details->banner_id."##".$details->banner_image."##".$details->banner_comment;
			exit;				
			} else {
				echo "error";
				exit;
				}

	break;
	
	//change banner rotation status
	case '5':
		
		$pref = $_GET['val'];
		
		$p = ($pref == 0) ? 'Off' : 'On';
		
		$sQl = "update cms_config set banner_rotation = '".$pref."'";
		$result = $db->query($sQl);
		if ($result)
			{
			echo "success#Rotation set to ".$p."";		
			exit;
			} else {
				echo "error#Rotation cannot be set to ".$p."";
				exit;
				}
		
	break;

}

?>