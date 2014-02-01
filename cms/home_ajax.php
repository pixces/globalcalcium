<?php
include_once("config.inc.php");

$opt = $_GET['opt'];
if (!$opt)
	{
	echo "Invalid request status";
	exit;
	}

switch($opt){

	//add sections
	case'1':
		if ( $_POST && $_POST["mm_action"] == "doSection")
			{
			$data = $_POST;
			
			$section = new Section();
			if (!$section->section_add($data))
				{
				$_SESSION['error'] = $section->error;	
				} else {
					$_SESSION['message'] = "Section added successfully";
					}
			header("location: index_section_page.php");
			exit;
			}
	break;
	
	//edit sections
	case '2':
		if ( $_POST && $_POST["mm_action"] == "editSection"){
				$data = $_POST;
				$secObj = new Section();
				$editSec = $secObj->section_edit($data);
				//print_r($_POST);
				//exit;
				//do edit
				if ($editSec)
					{
					$_SESSION['message'] = $secObj->message;
					header("location: index_section_page.php");
					exit;
					} else {
						$_SESSION['error'] = $secObj->error;
						header("location: index_section_page.php");
						exit;						
						}	
			}
	break;
	
	//delete section
	case '3':
		$id = $_POST['id'];
		
		//do delete
		$secObj = new Section($id);
		$result = $secObj->section_delete();
		if ($result)
			{
			echo "success";
			exit;
			} else {
				echo "error";
				exit;
				}
	break;
	
	//get the details of the section id provided
	case '4':
		$id = $_GET['id'];
		$secObj = new Section($id);
		$details = $secObj->section_details();
		if ($details)
			{
			//section_parent 	section_name 	section_content 	image_url 	link_url
			echo $details->section_id."##".$details->section_name."##".$details->section_parent."##".$details->section_content."##".$details->image_url."##".$details->link_url;
			exit;				
			} else {
				echo "error";
				exit;
				}

	break;
	



}

?>