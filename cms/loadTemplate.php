<?php
/**
* page to load the basic template theme
* of the website
*/

//get all the javascripts
$jsLink = '<script src="js/jquery.js" type="text/javascript"></script>'."\n";
$jsLink .= '<script src="js/jsfunctions.js" type="text/javascript"></script>'."\n";
//get all the css files
$cssLink = '<link href="includes/main.css" rel="stylesheet" type="text/css">'."\n";

$smarty->assign("jsLink",$jsLink);
$smarty->assign("cssLink",$cssLink);

$smarty->display('index.tpl');
?>