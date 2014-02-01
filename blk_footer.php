<?php
	#get the footer links
	$links = new Link();
	if ($config['sef_url'] != 0){
			$links->sef = true;
	}

	$LinkSet1 = $Link::get_links(1);
	$LinkSet2 = $links->get_links(8);

?>
