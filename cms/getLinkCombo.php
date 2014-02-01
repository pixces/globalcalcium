<?php
include_once("config.inc.php");

if($_GET['id']){
	$id =  $_GET['id'];
	} else {
	$id = '';
}


$t = getSectionCombo($id);
echo $t;
exit;

?>