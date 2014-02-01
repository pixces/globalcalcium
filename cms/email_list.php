<?php
if (file_exists("config.inc.php"))
	{
	require_once("config.inc.php");
	} else {
		die ("cannot initialize configuration");
		}


//check for loggedIn 
isLoggedIn();

		$subxObj = new Subscribers();
		$subxList = $subxObj->display_subscribers();
		if($subxList){
			$smarty->assign('subxList',$subxList);
			} else {
				$_SESSION['error'] = $subxObj->error;
		}
		$smarty->display('subscribers_list.html');

?>