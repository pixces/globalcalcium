<?php
/**
* Bootstrap to load the Template &
* basic site configurations
*/
//get all the css files
$cssLinks = '<link type="text/css" href="'.SITE_ROOT.'assets/css/main.css" rel="stylesheet">'."\n";
$cssLinks .= '<link type="text/css" href="'.SITE_ROOT.'assets/css/menu.css" rel="stylesheet">'."\n";

# for png fix for IE
$pngLinks = '<!--[if lt IE 7]>'."\n";
$pngLinks .= '<script defer type="text/javascript" src="'.SITE_ROOT.'assets/js/pngfix.js"></script>'."\n";
$pngLinks .= '<![endif]-->'."\n";

# All javascript includes
$jsLinks = "";
$jsLinks .= '<script type="text/javascript" src="'.SITE_ROOT.'assets/js/jquery.js" ></script>'."\n";
$jsLinks .= '<script type="text/javascript" src="'.SITE_ROOT.'assets/js/menu.js" ></script>'."\n";
$jsLinks .= '<script type="text/javascript" src="'.SITE_ROOT.'assets/js/jFunctions.js" ></script>'."\n";
$jsLinks .= '<script type="text/javascript" src="'.SITE_ROOT.'assets/js/jquery.fancybox-1.3.4.pack.js"></script>'."\n";
$jsLinks .= '<script type="text/javascript" src="'.SITE_ROOT.'assets/js/jquery.easing-1.3.pack.js"></script>'."\n";
$jsLinks .= '<script type="text/javascript" src="'.SITE_ROOT.'assets/js/jquery.mousewheel-3.0.4.pack.js"></script>'."\n";
$jsLinks .= '<script type="text/javascript" src="'.SITE_ROOT.'assets/js/slideshow.js"></script>'."\n";
$jsLinks .= '<script type="text/javascript" src="'.SITE_ROOT.'assets/js/jquery.innerfade.js"></script>'."\n";

$cssLinks .= '<link rel="stylesheet" href="'.SITE_ROOT.'assets/css/jquery.fancybox-1.3.4.css" type="text/css" media="screen" />'."\n";
$cssLinks .= '<link type="text/css" href="'.SITE_ROOT.'assets/css/slideshow.css" rel="stylesheet">'."\n";


//add the navigation 
require_once("blk_navigation.php");

//newsticker on all pages
require_once("blk_news_ticker.php");

require_once(HTML."template.html");
?>