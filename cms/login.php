<?php
if (file_exists("config.inc.php"))
	{
	require_once("config.inc.php");
	} else {
		die ("cannot initialize configuration");
		}
	if($_POST && $_POST['mm_action'] === 'doLogin'){
		
		$data = $_POST;
		
		$loginObj = new Login();
		$result = $loginObj->doLogin($data);
		if($result){
			// Redirect the user to Index page
			print("logged in");
			header("location:index.php");
			exit;
			} else {
				//display the error here 
				$smarty->assign('errorMsg','Invalid Login Info. Try again');
		}
		
	
	}

//display the left naivgation and 
//ask the admin to click on any of the link 
//to start working
$smarty->assign("login","yes");
$smarty->assign("contentFile","login.html");
$smarty->display('index.tpl');
?>