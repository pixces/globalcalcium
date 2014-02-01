<?php
class Link{

	public $linkId;
	public $link_array = array();
	private $query;
	public $error = "";
	public $message = "";
	public $sef = true;
	
	private $tbl_name = "cms_link";	
	
	/**
	* constructor
	*/
	function __construct($id = NULL){
		if (!is_null($id))
			{
			$this->linkId = clean($id);	
			}
	}
	
	/**
	* function to get the list of links
	* Case 1: Get only the main links by default
	* Case 2: Get sublinks for an link Id provided
	*/	
	function get_link_list($link_id = 0){
		global $db;		
		$sQl = "select * from $this->tbl_name where link_parent = '".$link_id."' order by link_order ASC";
		
		$result = $db->get_results($sQl);
		if ($result)
			{
			return $result;
			} else {
				return false;
				}
	}
	
	/**
	* function to format the array list
	* to get a hierachial array structure
	*/	
	function get_links($link_id = 0, $all = FALSE){
		
		$mainList = $this->get_link_list($link_id);
	
		//get the total count of the link
		$c = 0;
		$m_l_c = count($mainList);

		if ($mainList){
			$links = array();
			
			foreach($mainList as $main){
					if ( strtolower($main->link_name) == "products"){
						$href = "#";
					} else {
						 $href = $this->get_link_href($main->link_id); //content_sef_title
						}
				
				$links[$c]= array(
					'id'=>$main->link_id,
					'name'=>$main->link_name,
					'href'=>$href
					);
				
				#get all sublinks				
				if ($all){
					if ( strtolower( $main->link_name ) == "products"){
						$sub = $this->get_product_sub_list();
						$links[$c]['sub'] = $sub;
						} else {	
							//get the sublinks of this link
							$subList = $this->get_link_list($main->link_id);
							
							if($subList){
								$sub = array();
								foreach($subList as $sLink){
									$sub[] = array(
										'id'=>$sLink->link_id,
										'name'=>$sLink->link_name,
										'href'=>$this->get_link_href($sLink->link_id)	//content_sef_title
										);
								}
							$links[$c]['sub'] = $sub;		
							}
						}
				}
			$c++;
			}
		}
		return $links;		
	}
	
	function get_product_sub_list(){
		global $db;
		
		$sQl = "select id,parent_id,name,sef_name from cms_products where parent_id = 0 order by name ASC";
		$result = $db->get_results($sQl);
		$subArray = array(array('id'=>'0','name'=>"All Products",'sef'=>'all'),array('id'=>'1','name'=>"Latest Products",'sef'=>'latest'));
		$sub = array();
		if ($result){
			foreach($result as $product){
				array_push($subArray, array('id'=>$product->id,'name'=>$product->name,'sef'=>$product->sef_name));	
			}
			if ($subArray){
				foreach($subArray as $item){
					if ($this->sef){
						$url = SITE_ROOT."products/".$item['sef'];
					} else {
						if ( ($item['sef'] == 'latest') || ($item['sef'] == 'all') ){
							$url  = SITE_ROOT."products.php?type=".$item['sef'];
						} else {
							$url  = SITE_ROOT."products.php?id=".$item['id'];
						}
					}
					
					$sub[] = array(
								'id'=>$item['id'],
								'name'=>$item['name'],
								'href'=>$url
							);
				}
			}
			return $sub;
		}	
	}
	
/*
	* function to get a single dim link list
	* as an array
	* array[id] = value; format
	*/
	function get_link_formated(){
	
		$nArray = array();
		$linkList = $this->get_links(1, FALSE);
		//print_r($linkList);
		
		foreach($linkList as $link){
			$nArray[$link['id']] = $link['name'];
			if($link['sub']){
					foreach($link['sub'] as $sub){
						$nArray[$sub['id']] = $sub['name'];
					}
				}
			}
			
		return $nArray;
		
	}
	
	/**
	* Function to get a link details
	* @PARAMS Link ID
	* @RETURN ARRAY /  FALSE	
	*/
	public function get_link_details(){
		global $db;
		$sQl = "SELECT * FROM cms_link WHERE link_id = ".$this->linkId;
		$result = $db->get_row($sQl);
		
		if($result){
			return $result;
			} else {
				$this->error = "Cannot find the link details.";
				return false;
		}
	}
	
	/**
	* function to get the 
	* href for a link if the link Id is provided
	* return null / when no href found
	*/
	function get_link_href($id){
		global $db;
		
		$linkId = $id;
		//$hrefId = "";
		
			#get the details of this link from the contents page
			$sQl = "select c.content_id, c.content_link_id, c.content_title, c.content_sef_title from cms_content c
					left join cms_link l on (l.link_id = c.content_link_id)
					where c.content_link_id = '".$linkId."'";
			
			#get the parent details of this link
			$sQl_parent = "SELECT l1.link_id,l1.link_name,l1.link_parent, l2.link_name as parent 
							FROM `cms_link` l1 left join cms_link l2 on l1.link_parent = l2.link_id 
							WHERE l1.link_id = '".$linkId."'";
			
			$content = $db->get_row($sQl);
			$parent = $db->get_row($sQl_parent);
			

			if (!$content){ return "#";	}	
			if ($this->sef){
				#get by sef
				$hrefId = SITE_ROOT.'page/'.$content->content_sef_title;
			} else {
				#get by content id
				if ($content->content_link_id){
					$hrefId = SITE_ROOT.'page.php?id='.$content->content_link_id;
				} else {
					$hrefId = "#";
				}	
			}
			return $hrefId;
	
	}
	
	
	function get_siblings(){
		global $db;
		#first get the parent id of this link
		$parent_id = $db->get_var("select link_parent as parent from cms_link where link_id = '".$this->linkId."'");

		if ($parent_id != 0){
			$list = $this->get_links($parent_id);
			return $list;
		} else {
			return false;
			}

	}

/* end of class */
}
?>