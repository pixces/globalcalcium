<?php
#get the latest news
$eventObj = new Events;
$currentEvents = $eventObj->get_event_list('current');

$newsList = '';

foreach($currentEvents as $newsEvent){
$newsList .= '<div>';
$newsList .= '<div><span class="text" align="center"><img src="upload/'.$newsEvent->news_image_logo.'" width="240" /></span></div>';
$newsList .= '<div align="center"><span class="text">'.$newsEvent->news_date.'</span></div>';
$newsList .= '<div align="center"><span class="text">'.$newsEvent->news_location.'</span></div>';
$newsList .= '<div class="div_more" align="center"><span class="text"><a href="news/'.$newsEvent->news_title_sef.'" class="readmorebtnpink">more &gt;&gt;</a></span></div>';
$newsList .= '</div>';
}
?>
