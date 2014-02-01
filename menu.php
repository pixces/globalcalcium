<?php
	$menu = $template->get_nav_menu();

	$nav = '<ul class="topnav">';
		foreach($menu as $item){
		$nav .= '<li><a href="articles.php?id='.$item['id'].'">'.ucwords($item['link_title']).'</a></li> ';
		}
	$nav .='</ul>';
	
	echo $nav;
?>
<!--    
   <ul class="topnav"> 
   <li><a href="HTML/index.php">Home</a></li>
    <li>  
        <a href="HTML/static.php?id=we-are">We are</a>  
        <ul class="subnav">  
            <li><a href="HTML/static.php?id=we-are">About Global Calcium</a></li>  
            <li><a href="HTML/static.php?id=we-are">Mission</a></li>  
            <li><a href="HTML/static.php?id=we-are">Management Team</a></li>  
            <li><a href="HTML/static.php?id=we-are">Manufacturing Units</a></li>  
            <li><a href="HTML/static.php?id=we-are">Logisticsd</a></li>                                      
        </ul>  
    </li>  
    <li>  
        <a href="HTML/static.php?id=we-are">Our Strength</a>  
        <ul class="subnav">  
            <li><a href="HTML/static.php?id=we-are">Research & Development</a></li>  
            <li><a href="HTML/static.php?id=we-are">Expertise</a></li>  
            <li><a href="HTML/static.php?id=we-are">Parameters</a></li>  
            <li><a href="HTML/static.php?id=we-are">Certificates</a></li>  
            <li><a href="HTML/static.php?id=we-are">Cstomized Solution</a></li>  
        </ul>  
    </li>  
    <li><a href="HTML/static.php?id=we-are">Products</a></li>  
    <li><a href="HTML/static.php?id=we-are">Data Sheet</a></li>  
    <li><a href="HTML/static.php?id=we-are">FAQ's</a></li>  
    <li>
    	<a href="HTML/static.php?id=we-are">Reach Us</a>
        <ul class="subnav">  
            <li><a href="HTML/static.php?id=we-are">Sample</a></li>  
            <li><a href="HTML/static.php?id=we-are">Location</a></li>  
            <li><a href="HTML/static.php?id=we-are">Contact Us</a></li>  
        </ul>        
    </li>  
</ul>  
//-->