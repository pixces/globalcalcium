<?php
//get all the navigation
$navList = array();
$navList[] = '<li><a href="./">Home</a></li>'; 

$links = new Link();
if ($config['sef_url'] != 0){
	$links->sef = true;
}

$siteLink = $links->get_links(0,TRUE);

//substitute all products
//redirecting to products.php page
if ($siteLink)
	{
	foreach($siteLink as $link)
		{
		if (strtolower($link['name']) != "news & events"){
			$l = '<a href="'.$link['href'].'">'.$link['name'].'</a>';
			} else {
			$l = '<a href="news/all">'.$link['name'].'</a>';
		}
			
		$s=array();
		$subLinks = "";
		if (strtolower($link['name']) != "portfolio")
			{
			if ($link['sub'])
				{	
				foreach($link['sub'] as $sub)
					{
					$s[] = '<li><a href="'.$sub['href'].'">'.$sub['name'].'</a></li>';
					}
				$subLinks = '<ul>'.implode("",$s).'</ul>';
				}
			}
		$navList[] = '<li>'.$l.$subLinks.'</li>';
		}
	}

//print_r($navList);


//$navList[] = '<li><a href="contact.php">Contact Us</a></li>'; 

$navLinks =  '<ul id="dropmenu">'.implode('',$navList).'</ul>';

//$smarty->assign('topNavigation',$navLinks);

/*
            <ul class="topnav">
                <li><a href="#">Home</a></li>
                <li>
                    <a href="#">Tutorials</a>
                    <ul class="subnav">
                        <li><a href="#">Sub Nav Link</a></li>
                        <li><a href="#">Sub Nav Link</a></li>
                        <li><a href="#">Sub Nav Link</a></li>
                        <li><a href="#">Sub Nav Link</a></li>
                        <li><a href="#">Sub Nav Link</a></li>
                        <li><a href="#">Sub Nav Link</a></li>                        
                    </ul>
                </li>
                <li>
                    <a href="#">Resources</a>
                </li>
                <li><a href="#">About Us</a></li>
                <li><a href="#">Advertise</a></li>
                <li><a href="#">Submit</a></li>
                <li><a href="#">Contact Us</a></li>
            </ul>
*/

?>
