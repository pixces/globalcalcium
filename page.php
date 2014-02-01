<?php
/**
* basic bootstraping
*/
require_once("config.inc.php");

if ($_GET['sef']){
	$page_id = Content::get_link_id($_GET['sef']);
} else if ($_GET['id']){
	$page_id = $_GET['id'];
} else {
	//invalid page requested
	//display a proper 303 error 
	//page not found.
	//temporary solution .. redirect to homne page
	header("location:".SITE_ROOT);
	exit;
}

//initalize classes
$contentObj = new Content();

#get meta data
$meta = get_meta_info($page_id);

#get page info	
$page = $contentObj->get_display_content($page_id);
if(!$page){
		$page['content'] = "Page is Under Construction.";
	}

$linkList = get_addl_link($page_id);
if ($linkList){
	$link_title = "Additional Links";
} else {
	//$linkList = get_latest_products();
	$link_title = "Latest Products";
}



$sidebar = "home-sidebar.html";
$content = "articles.html";
require_once("loadTemplate.php");
?>