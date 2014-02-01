<?php

class Template{


	function get_nav_menu(){
		#get first level of navigation
		$firstLevel = $this->get_menu_items();
		
		$nav = array();	
		foreach($firstLevel as $link){
			
			
			$list = array('id'=>$link->id, 'title'=>$link->link_title, 'url'=>$link->link_name);
			#check if there are submenus for this id
			$subNav = array();
			$submenu = $this->get_menu_items($link->id);
			if ($submenu){
				foreach($submenu as $sub){
					array_push($subNav, array('id'=>$sub->id, 'title'=>$sub->link_title, 'url'=>$sub->link_name));
				}
			} 
			$list['sub'] = $subNav;			
			array_push($nav,$list);
		}
		return $nav;
	}


	function get_nav_menu_html(){
		$menu = $this->get_nav_menu();
		$nav = "";
		
		$nav = '<ul class="topnav">';
		foreach($menu as $item){
			$nav .= '<li>';
			$nav .= '<a href="articles.php?id='.$item['id'].'">'.ucwords($item['title']).'</a>';
		
			if ($item['sub']){
			$nav .= '<ul class="subnav">';
				foreach($item['sub'] as $sub){
					$nav .= '<li><a href="articles.php?id='.$sub['id'].'">'.ucwords($sub['title']).'</a></li>';
				}
			$nav .= '</ul>';	
			}
			$nav .= '</li> ';
		}
		$nav .='</ul>';
	
		return htmlentities($nav);
	}

	function get_menu_items($parent_id = 0){
		global $db;
		$sQl = "select id, link_title, link_name from links where parent_id = '".$parent_id."'";
		$result = $db->get_results($sQl);
		if ($result){
			return $result;
			} else {
				return false;
				}
	}








/* end class */
}
$template = new Template;
?>