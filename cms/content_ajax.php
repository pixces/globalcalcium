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
		if ( $_POST && $_POST["mm_action"] == "doContent")
			{
			
	break;
	
	//edit banner
	case '2':
		
	break;
	
	//delete banner
	case '3':
		
	break;
	
	//get the details of the banner id provided
	case '4':
	
		
	break;

}

?>