<?php
/**
* This class is to manage the admin
*/

class Admin{
	public $adminId;
	public $error;
	public $message;
	
		
	public function __construct($id = NULL){
		if(!empty($id) && is_numeric($id)){
			$this->adminId = $id;
		}
	}
	

	/**
	* function admin list
	* Get all the admin in the site except the admin 
	* who is himself logged in 
	*/
	
	function admin_list(){
		global $db;
		
		$myId = $_SESSION['adminId'];
		$sQl = "select * from cms_admin where id != '".$myId."'";
		$result = $db->get_results($sQl);
		
		
		if ($result)
			{
			return $result;
			} else {
				$this->error = "Cannot get admin list/or no admin present";	
				return false;
				}		 
	}

	/*
	* function get details of the admin in question
	*/
	function admin_detail(){
		global $db;
		$sQl = "select * from cms_admin where id = '".$this->adminId."'";
		$result = $db->get_row($sQl);
		if ($result)
			{
			return $result;
			} else {
				$this->error = "Cannot get details of the admin";	
				return false;
				}
	}
	
	
	/**
	* function to add admin record in the database
	*/
	function admin_add($data){
		global $db;
		if (!is_array($data))
			{
			return false;
			}
		
		//add the nornal record
		//get the admin insert Id
		//do the permission array
		//update to add the permissions
	
		//generate a temporary password
		$password = $this->admin_random_password();
	
		//secure password
		$securePassword = $password;  //md5($password);
		
		//get the permission array
		$perms_values = array('man_home','man_link','man_content','man_event','man_admin');
		
		$perms = $data['permission'];
		
		
		if (isset($perms)) 
			{
			foreach($perms_values as $perm) {
				if ( in_array($perm, $perms)) {
						$admin_perms[$perm] = 1;
					} else {
						$admin_perms[$perm] = 0;
						}
				}
		} else {
			foreach($perms_values as $perm) {
				$admin_perms[$perm] = 0;
				}
		}
			
		$sQl = "Insert into cms_admin (`first_name`,`last_name`,`admin_email`,`role`,`username`,`password`,`admin_status`) 
				values 
				('".$data['fname']."','".$data['lname']."','".$data['email']."','2','".$data['username']."','".$securePassword."','".$data['admin_status']."')";
		
		
		$resAdd = $db->query($sQl);
		if ($resAdd)
			{
			$newAdminId = $db->insert_id;
			
			//do the update to add permission
			$sQlUpdate = "update cms_admin set 
							`man_home` = '".$admin_perms['man_home']."',
							`man_link` = '".$admin_perms['man_link']."',
							`man_content` = '".$admin_perms['man_content']."',
							`man_event` = '".$admin_perms['man_event']."',
							`man_admin` = '".$admin_perms['man_admin']."'
							where id = '".$newAdminId."'";
	
			$result = $db->query($sQlUpdate);
			
			if ($result)
				{
				//now send an email to this admin
				//confirming the registration and advising to view the details
				$mailMessage = "
					Dear ".$data['fname'].",\n
					Your admin account has been created for WENXT, with the following details.\n\n
					Login Url: http://www.wenext.transvisionarysolutions.com\cms\n
					Login Username:".$data['username']."\n
					Login Password: ".$password."\n
					Please remember the password is case sensitive.\n\n
					You are adviced to login to the admin section and change you password.\n\n
					Regards\n
					Team TVS";
					
				$mail_headers = "From: support@wenxt.com \n";
				$mail_headers .= "Reply-to: support@wenxt.com \n";	
				
				$subject = "[Admin] Welcome to WENXT\n";
				
				@mail($data['email'],$subject,$mailMessage,$mail_headers);	
				
				$this->message = "New admin has been successfully created.\n An email with the password has been sent to the email address provided";
				return true;
				} else {
					$this->error = "Cannot update admin permissions";
					return false;
					}
		
			} else {
				$this->error = "Cannot add new admin";			
				return false;
				}
	}


	/**
	* function to edit admin record
	*/
	function admin_edit($data){
		global $db;
		if (!is_array($data))
			{
			return false;
			}

		//we need not update the password.
		//this will be done by other link
		
		//get the permission array
		
		$perms_values = array('man_home','man_link','man_content','man_event','man_admin');
		$perms = $data['permission'];
		
		
		if (isset($perms)) 
			{
			foreach($perms_values as $perm) 
				{
				if ( in_array($perm, $perms)) {
						$admin_perms[$perm] = 1;
					} else {
						$admin_perms[$perm] = 0;
						}
				}
			} else {
				foreach($perms_values as $perm) {
					$admin_perms[$perm] = 0;
					}
				}
			
		 
		$sQl = "update cms_admin set
				`first_name`='".$data['fname']."',
				`last_name`='".$data['lname']."',
				`admin_email`='".$data['email']."',
				`username`='".$data['username']."',
				`admin_status`='".$data['admin_status']."',
				`man_home`='".$admin_perms['man_home']."',
				`man_link`='".$admin_perms['man_link']."',
				`man_content`='".$admin_perms['man_content']."',
				`man_event`='".$admin_perms['man_event']."',
				`man_admin`='".$admin_perms['man_admin']."'
				where id='".$data['id']."'";				
			
			$resAdd = $db->query($sQl);
		
		if ($resAdd)
			{
			$this->message = "Admin details have been changed successfully";
			return true;		
			} else {
				$this->error = "Cannot update admin record or no change in record";			
				return false;
				}
	}
	

	/*
	* function to do a random password
	*/
	function admin_random_password(){
		
		$char = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','!','@','#','~','&','$','1','2','3','4','5','6','7','8','9','0');
		
		$randNumber = "";
		//$countChr = count($char);
		
		for($x=0; $x < 8; $x++){
			$randNumber .= $char[rand(0,count($char))];
			}
	
		return $randNumber;
	}
	
	/**
	* function to get the wlecome not for the admin
	*/
	function admin_welcome_note(){

		$note = "";
		$result = $this->admin_detail();
		
		if ($result)
			{	
			$note .= "Welcome back <b>".ucwords($result->first_name)." ".ucwords($result->last_name)."</b>&nbsp;&nbsp;"; 
			$note .= '<a href="#">Edit</a>&nbsp;|&nbsp;<a href="javascript:void(0);" id="popUp">Change Password</a>&nbsp;|&nbsp;<a href="?logout">Logout</a>';	
			return $note;
			} else {
				return false;
				}
	}
	
	/**
	* function to get the admin permission 
	*/

	function get_admin_permission(){
		global $db;
		
		$sQl = "Select `man_home`,`man_link`,`man_content`,`man_event`,`man_admin`,`man_products` from cms_admin where `id` = '".$this->adminId."'";
		$result = $db->get_row($sQl);
		if ($result)
			{
			return $result;
			} else {
				return false;
				}	
	}
	
	/**
	* function to get the navigation array of this admin
	*/
	function get_navigation_array(){
		$nav_array = array();
		$result = $this->get_admin_permission();
		
		if ($result)
			{
				//if ($result->man_home == '1') { $nav_array[] = '<a href="index_section_page.php">Manage Home</a>';	}
				if ($result->man_link == '1') { $nav_array[] = '<a href="link.php">Site Links</a>';	}
				if ($result->man_content == '1') { $nav_array[] = '<a href="content.php">Site Content</a>';	}
				if ($result->man_products == '1') { $nav_array[] = '<a href="products.php">Products</a>';	}
				if ($result->man_event == '1') { $nav_array[] = '<a href="events.php">News &amp; Events</a>';	}
				if ($result->man_admin == '1') { $nav_array[] = '<a href="manage-admin.php">Manage Admin</a>';	}
					
				$nav_array[] = '<a href="?logout">Logout</a>';		
				
				$navigation = implode("",$nav_array);
				return $navigation;
				
			} else {
				return false;
				}
	
	
	}		



	public function delete_admin(){
		global $db;
		
		$sQl = "DELETE FROM cms_admin WHERE ID = '".$this->adminId."'";
		
		$result = $db->query($sQl);
		if($result){
			$this->message = "Admin Deleted Successfully";
			return true;		
			} else {
			$this->error = "Connot Delete Admin";
			return false;		
		}		
	}
	
	/**
	* Function to change the admin user password
	* This function will change only the password with new password provided
	* @PARAMS : admin user ID
	* @RETURN : BOOL TRUE/FALSE
	*/
	public function change_password($data){
		global $db;
		$sQl = "UPDATE cms_admin SET password = '".$data['new_password']."' WHERE id = '".$this->adminId."'";		
		$result = $db->query($sQl);
		if($result){
			$this->message = "Password changed successfully";
			return true;
			} else {
				$this->error = "Cannot change password. Try again";
				return false;
		}
	}
	
/*
* End of class
*/

}
?>