<?php
/**
* basic bootstraping
*/
require_once("config.inc.php");

if ($_GET['sef']) { $sef = $_GET['sef']; }

if ($sef != 'all'){
	$eventObj = new Events();
	$eventObj->map_sef2id($sef);
	$eventDet = $eventObj->get_full_details();
	
	//print_r($eventObj);
	//print_r($eventDet);
	if ($eventDet) { 
		$event = $eventDet;
		$event_details = $event->news_details;
		$event_photo = $eventObj->get_event_photo();
		} else {
			$event = "Details of this event does not exists in the system";
			}
	$section = "detail";
} else if ($sef == 'all') {
	$eventObj = new Events;
	$currentEvents = $eventObj->get_event_list('current');
	$pastEvents = $eventObj->get_event_list( 'past' );
	$section = "list";
}


/*
#get the news from the database
if ($id){
	$sQl = "select * from cms_news where id = '".$id."'";
} else {
	$sQl  = "select * from cms_news order by id DESC limit 1";
	}

echo $sQl;
	
$newsDet = $db->get_row($sQl);

$news_title = ucwords(strtolower($newsDet->news_title));
$news_details = stripslashes($newsDet->news_details);	
*/

$sidebar = "home-sidebar.html";
$content = "news.html";
require_once("loadTemplate.php");
?>