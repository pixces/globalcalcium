<?php
/**
* page to manage all tag activity
* to display the banner form
* as well as to display the list of 
* all available banners in the system
*/
if (file_exists("config.inc.php"))
	{
	require_once("config.inc.php");
	} else {
		die ("cannot initialize configuration");
		}

//check for loggedIn 
isLoggedIn();

//check if the content id is present
if (!isset($_GET['linkid'])) { 
	die("cannot get the link information");
	exit;
	}
#get values from the request	
$link_id = $_GET['linkid'];	
$section = $_GET['section'];

#save infor if form submitted
if($_POST && $_POST['mm_action'] == "doAddMeta"){	
	
	$metaObj = new Metatag();
	$data = $_POST;
	$addMeta = $metaObj->add_meta($data);	
	if($addMeta){
			$_SESSION['message'] = $metaObj->message;
		} else {
			$_SESSION['error'] = $metaObj->error;
		}
	if($section =='page'){
		header("location: content.php");
		exit;
	} else {
		header("location: products.php");
		exit;
		}
}


# to display information in the metatag form

#get display information
if($section == 'products'){
	#get the product name and basic info
	$prodObj = new Products;
	$dtls = $prodObj->get_product_details($link_id);
	if($dtls){
		$smarty->assign('page_name',$dtls->name);
	}
} else if ($section == 'page'){
	#get basic link info to be displayed
	$linkObj = new Link($link_id);
	$linkDtls = $linkObj->get_details();
	if($linkDtls) {
			//print_r($linkDtls);
			$smarty->assign('page_name',$linkDtls->link_name);
		} else {
			$_SESSION['error'] = "Content Links Are Empty";
	}	
}

#assign linkid to the form
$smarty->assign('linkId',$link_id);

#assign section name to the form
$smarty->assign('section',$section);

#get meta tag data from table if exists
$metaObj = new Metatag();
$metaDtls = $metaObj->get_meta_info($link_id,$section);

if($metaDtls){
	$smarty->assign('metaDtls',$metaDtls);		
	$smarty->assign('custom1',$metaDtls['meta_custom']);	
	$smarty->assign('custom2',$metaDtls['meta_custom2']);	
} 

#create robots array for robots selection box 
$robotArray = array(
				'All' => 'All',
				'None' => 'None',
				'Index' =>'Index',
				'No Index' => 'No Index',
				'Follow' => 'Follow',
				'No Follow' =>'No Follow');	
$smarty->assign('robotArray',$robotArray);

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
$smarty->assign('contentFile',"meta_tag.html");
$smarty->assign('sectionTitle',"Manage Meta Information");
$smarty->display('index.tpl');
?>