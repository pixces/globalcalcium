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
if (!isset($_GET['id']))
	{
	die("cannot get the content location");
	exit;
	}
$contentId = $_GET['id'];	


//do the post of the form to add tags to the system
if ( $_POST )
	{
	//first method post
	if ( $_POST['mm_action'] == "method_1" )
		{
		//create a comma seperated list of all 
		//the post vars 
		//then send the variable to form submission
		
		$ntgList = implode(',', $_POST['newSelect']);
		$newTagList = $ntgList;
		}

	//second method post
	if ( $_POST['mm_action'] == "method_2" )
		{
		$newTagList = $_POST['taglist'];
		}
		
	$tag = new Tag();
	$tag->contentId = $contentId;
	$add_tag = $tag->do_add_tag($newTagList);
	if ($add_tag)
		{
		$_SESSION['message']="Successfully assigned tags to the content";
		header("location: content.php");
		exit;
		} else {
			$_SESSION['error'] = "Cannot assign tags to the content";
			}
	}

//get the page name
$content = new Content($contentId);
$contDet = $content->get_content($contentId);
if ($contDet)
	{
	$content_title = trim($contDet->CMS_COL_CONTENT_TITLE);
	$smarty->assign('chap_title',$content_title);
	}

//get the tag list for this content a comma seperated list
$tag = new Tag();
$tag->contentId = $contentId;
$page_tagList = $tag->get_tagList_for_content();

if ($page_tagList)
	{
	$smarty->assign('oldTag',$page_tagList);
	}

//get the list of all available tags in the system
$allTagList = $tag->get_all_tag_list();


//get a select option list for the above values
if ($allTagList){
	$aTg = "";
	foreach($allTagList as $allTag)
		{
		$aTg .= "<option value='".$allTag->tag_name."'>".ucwords($allTag->tag_name)."</option>";
		}
	$smarty->assign('oldList', $aTg);
}

//get the tag list for this content
//an array
$content_tag_array = $tag->get_tagArray_for_content();
if ($content_tag_array){
	$nTg = "";
	foreach($content_tag_array as $cTa)
		{
		$nTg .= "<option value='".$cTa->tag_name."'>".ucwords($cTa->tag_name)."</option>";
		}
	$smarty->assign('newList',$nTg);
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
$smarty->assign('contentFile',"tag.html");
$smarty->assign('sectionTitle',"Manage Tags");
$smarty->display('index.tpl');
?>