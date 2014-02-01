<?php
/**
	This class for login check

		1. Login Process
			a) User Submits a Login Form & Details
			b) Validate it, check with database
			c) If all correct do the Login Process
				a) Register a session for the user
				b) Redirect him to the member page
		2. Logout Process
			Check for the Session
			Unset the session
			redirect to the login / index page
*/ 
class Login{
	
		private $username;
		private $password;
		private $loggedin;
		
		public function __construct(){	
		}

		public function doLogin($data){
			global $db;

			$valid = $this->doValidate($data);
			var_dump($valid);			
			if ($valid)
				{
                $password = md5($data['passWord']);

				$sQl = "SELECT id , username , password from cms_admin where username='".mysql_real_escape_string($data['userName'])."' && password = '".$password."' and `admin_status` = '1'";
				
				$result = $db->get_row($sQl);
				if ($result)
					{
					$_SESSION['adminId'] = $result->id;
					$_SESSION['loggedIn'] = 'yes';
					return true;
					} else {
						return false;
						}
				
				} else {
					echo "false";
					}

		}
		
		
		private function doValidate($var){			
			global $db;
			
			if(is_array($var))
				{
				if (empty($var['userName']))
					{
					return false;
					} 
				else if (empty($var['passWord']))
					{
					return false;
					} 
				else {
					return true;
					}
				
				} else {
					return false;
					}
		}
		
	
		public function doLogout(){
			if($_SESSION['logggedin']=='yes'){
				$_SESSION['loggedin']='no';
				return true;
			}
		}
		
		
		/**
		* Function to check the password
		* @PARAMS : admin user ID,password
		* @RETURN : BOOL TRUE/FALSE
		*/
		public function check_passW(){
			global $db;
			$sQl = "SELECT password FROM cms_admin WHERE id = '".$_SESSION['adminId']."'";
			$result = $db->get_row($sQl);
			if($result){
				return $result;
				} else {
					return false;
			}
		}
		
/* end class */
}



?>