<?php
if (file_exists("config.inc.php"))
	{
	require_once("config.inc.php");
	} else {
		die ("cannot initialize configuration");
		}


//check for loggedIn 
isLoggedIn();
$type =(!empty($_GET['type'])) ? $_GET['type'] : "list";

switch($type){
	case 'list':
		/* get the list of all events */
		$eventObj = new Events;
		$event_list = $eventObj->get_event_list();
		$event_count = count($event_list);
		//print_r($event_list);	
		if(!empty($event_list)){
			$smarty->assign('list',$event_list);
			$smarty->assign('count',$event_count);
		} else {
			$_SESSION['error'] = $productsObj->error;			
			}
		
		$contentFile = "event_list.html";
		$sectionTitle = "New &amp Events";		
		
	break;
	case 'add':
		if($_POST['mm_action'] && $_POST['mm_action'] == 'doAdd'){
			$data = $_POST;
			$eventObj = new Events;
			$add = $eventObj->add($data);
			if($add){
				$_SESSION['message'] = $eventObj->message;
				header("location: events.php");
				exit;
				} else {
					$_SESSION['error'] = $eventObj->error;
			}
		}
		
		$contentFile = "event_add.html";
		$sectionTitle = "Add New &amp Events";		
				
		$smarty->assign('formName','Add');
		$smarty->assign('action','doAdd');
		$smarty->assign('disable','');
	break;
	case 'edit':
		if($_POST && $_POST['mm_action'] == 'doEdit'){
			$eventObj = new Events($id);
			$data = $_POST;
			$editContent = $eventObj->edit($data);
			if($editContent){
					$_SESSION['message'] = $eventObj->message;										
					header("location: events.php");
					exit;
				} else {
					$_SESSION['error'] = $eventObj->error;
			}
		}
		
		$id = $_GET['id'];
		$eventObj = new Events($id);
		$eventDet = $eventObj->get_full_details();	
		
		//print_r($eventDet);
		
		if($eventDet){	
			$smarty->assign('eventDet',$eventDet);			
		}
		
		$contentFile = "event_add.html";
		$sectionTitle = "Edit Event Details";
		$smarty->assign('formName','Edit');
		$smarty->assign('action','doEdit');	
	break;
	case 'delete':
	
		$id = $_GET['id'];
		$eventObj = new Events($id);
		$delEvent = $eventObj->delete();	
		
		if( $delEvent ) {
				$_SESSION['message'] = $eventObj->message;
				header("location: events.php");
				exit;
				} else {
					$_SESSION['error'] = $eventObj->error;
					}				
	break;
}


//to start working

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

//display the left naivgation and 
//ask the admin to click on any of the link 
//to start working

$smarty->assign('contentFile',$contentFile);
$smarty->assign('sectionTitle',$sectionTitle);
$smarty->assign('bodyFile','frame.html');
$smarty->display('index.tpl');
?>