<?php
/**
* basic bootstraping
*/
require_once("config.inc.php");

if ($_GET){
	$sef = $_GET['sef'];
}

$sQl = "select * from cms_verticals where sef_name = '".$sef."'";
$verticals = $db->get_row($sQl);

$color_class = "bg_".$verticals->bg_link_color;
$title = ucwords(strtolower($verticals->name));
$page_content = $verticals->content;

#get list of products in this vertical
$productObj = new Product();
$productList = $productObj->products_in_vertical($sef);
//print_r($productList);

#get the list of verticals excluding the current one
$sQl_list = "select name,sef_name,bg_link_color from cms_verticals order by id ASC";
$verticalList = $db->get_results($sQl_list);

$sidebar = "home-sidebar.html";
$content = "verticals.html";
require_once("loadTemplate.php");
?>