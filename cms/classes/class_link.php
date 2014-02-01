<?php
/**
* This class is for the functionality of the content link.
* Using this class you can List, Add, Edit, Delete site links.
*/

class Link{
	public $linkId;
	public $parentId;
	public $error;
	public $message;
	
	
	private $query;
	
	
	function __construct($id = NULL){
		if(!empty($id) && is_numeric($id)){
			$this->linkId = $id;
		}
	}
	
	/**
	* Display All Content Link Items.
	* If var flag is 1 then the result will be return an array of all the links for smarty compatible
	*	html drop down list
	*/
	public function display_link($flag = NULL){
		global $db;
		
		$sQl = "SELECT 
					c.link_id AS link_id,
					c.link_name AS link_name,
					c.link_type AS link_type,
					cn.link_parent AS parent_id,
					cn.link_name AS parent_name,
					cn.link_order AS order_id
				FROM 
					cms_link c
				LEFT OUTER JOIN 
					cms_link cn ON( cn.link_id = c.link_parent )
				ORDER BY c.link_type, cn.link_parent";
		
		
		//$this->query($sQl);
		
		$result = $db->get_results($sQl);
		$linkList = array();
		if($result){
			// If flag is 1 make the result into one array to display in html drop down list
			if($flag == 1){ 
				foreach($result as $links)
					{
					$linkList[$links->link_id] = ucwords(strtolower($links->link_name));
					$result = $linkList;
					}
			}
			// end of if flag
			return $result;
			} else {
			return false;
				}
	}
	
	/**
	* Function to display all the child links
	*/
	public function get_child_link($pId){
		global $db;
		
		$sQl = "SELECT * FROM cms_link WHERE link_parent = '".$pId."' ORDER BY link_id ASC";
		$result = $db->get_results($sQl);
		if($result){
			return $result;
			} else {
				$this->error = "Sub Link list is empty";
				return false;
		}
	
	}
	
	
	/**
	* Function to add a link. 
	* @PARAM POSTED form values
	* Page Order : Select the max value of the order from the table and assign max + 1
	* Link Type : Check for the parent link Id 
	* 			if Parent link is not main link, 
	*			get the parent link type and assign to the link.
	* @RETURN True / False
	*/
	public function add_link($data){
		global $db;
		
		if(!is_array($data)){  $error = "Invalid Data"; return false; }
		
		$mxPageOrderQry = "SELECT MAX(link_order) AS page_order FROM cms_link LIMIT 1";
		$mxPageOrder = $db->get_row($mxPageOrderQry);
		if($mxPageOrder->page_order == NULL){
			$page_order = 1;
			} else {
			$page_order = $mxPageOrder->page_order + 1;
		}
		
		// If the parent link is not a main link
		
		if($data['parentLink'] != 0){
			$sQl = "SELECT link_type FROM cms_link WHERE link_id = '".$data['parentLink']."'";
			$result = $db->get_row($sQl);
			if($result){
				$linkType = $result->link_type;
			} 
			
		} else {		// else part of " if($data['parentLink'] != 0) "
			$linkType = $data['rd_linktype']; 
		}
		
		$sQl = "INSERT INTO cms_link
							(`link_name`,
							`link_parent`,
							`link_order`,
							`link_date_added`,
							`link_type`)
					VALUES(
							'".$data['linkName']."',
							'".$data['parentLink']."',
							'".$page_order."',
							NOW(),
							'".$linkType."')";
		
		$result = $db->query($sQl);
		if($result){
			$this->message = "Link added successfully";
			return true;
			} else {
			$this->error = "Cannot Add Site Link. Try Again.";
			return false;
		}
		
	}
	
	/**
	* Function to edit a link.
	* @PARAM POSTED form data
	* @RETURN Bool True / False
	*/
	public function edit_link($data){
	
	global $db;
		if(is_array($data))
		{
			if($data['parentLink'] != 0){
				$sQl = "SELECT link_type FROM cms_link WHERE link_id = '".$data['parentLink']."'";
				$result = $db->get_row($sQl);
				if($result){
					$linkType = $result->link_type;
				} 
				
			} else {		// else part of " if($data['parentLink'] != 0) "
				$linkType = $data['rd_linktype']; 
			}
		    
			$orderLink = $data['orderLink'];
			$linkName = $data['linkName'];
			$parentId = $data['parentLink'];
			$linkType = $linkType;
			$sQl = "UPDATE cms_link 
								SET link_name='".$linkName."',
								link_parent='".$parentId."',
								link_date_updated = NOW(),
								link_type = '".$linkType."',
								link_order = '".$orderLink."'
								WHERE link_id='".$this->linkId."'";
				
			$result = $db->query($sQl);
			if($result){
				$this->message = "Link Modified Successfully";
				return true;
				} else {
					$this->error = "Cannot Modify Link. Try Again	";
					return false;
			}	
		}
		else
		{
			$this->error = "Invalid data";
			return false;
		}
	}
	
	/**
	* Function to delete a link.
	*/
	public function delete_link(){
		
		global $db;
		$sQl = "DELETE FROM cms_link where link_id='".$this->linkId."'";
		$result = $db->query($sQl);
		if($result)
		{
			return $result;
		}
		else
		{
			return false;
		}
	}
	
	/**
	* Function to get a link details.
	* @RETURN Array / False
	*/
	public function get_details(){
		global $db;
		//$sQl = "SELECT LK.*,CM.content_sef_title FROM cms_link LK, cms_content CM WHERE LK.link_id = CM.content_link_id AND LK.link_id='".$this->linkId."'";
		
		$sQl = "select LK.* from cms_link LK where LK.link_id = '".$this->linkId."'";
		
		$result = $db->get_row($sQl);
		if($result)
		{
			return $result;
		} else {
			$this->error = "Cannot find link details. Try again";
			return false;
			}
	
	}
	
	/***
	* Function to get all parent links
	* @PARAM id default NULL. 
	* @RETURN Array / False
	*/
	public function get_parent_link(){
		global $db;
		
		$sQl = "SELECT * FROM cms_link WHERE link_parent = 0 ORDER BY link_type ASC";
		
		$result = $db->get_results($sQl);
		if($result && $flag != 3){
			foreach($result as $links)
				{
				$parentList[$links->link_id] = ucwords(strtolower($links->link_name));
				}
			return $parentList;
			} else {
			return $result;
		}
	}
	
	/*
	* recussive function to get all the parent
	* and child in one array
	*/
	function get_link_list(){
	
		global $db;	
		$table = "cms_link";
		$sQl = "select * from $table where link_parent = '0' order by link_type ASC";
		$mainList = $db->get_results($sQl);
		$linkList = array();
		if ($mainList)	
			{
			foreach($mainList as $mainLink)
				{
				$linkList[$mainLink->link_id] = array(
					"linkId" =>$mainLink->link_id,
					"type_flag" =>$mainLink->link_type,
					"parent_flag" =>$mainLink->link_parent,
					"link_name"=>$mainLink->link_name
					);				
				
				//do the query for the set of sub links
				$subSql = "select * from $table where link_parent = '".$mainLink->link_id."' order by link_order ASC";
				$subRes = $db->get_results($subSql);
				if ($subRes)
					{
					foreach($subRes as $subLink)
						{
						$linkList[$subLink->link_id] = array(
								"linkId" =>$subLink->link_id,
								"type_flag" =>$subLink->link_type,
								"parent_flag" =>$subLink->link_parent,
								"link_name"=>$subLink->link_name
								);						
						}
					}
				}
			return $linkList;
			} else {
				return false;
				}
			  	
	}	
	
	/*
	* function to get the link set
	* PARAM $type, $id;
	* Default $type= NULL, $id = NULL
	* RETURN False / Array
	*
	* by default it will give a list of all the Primary & Secondary links 
	* if $type is set to 0 - Only Primary Links
	* if $type is set to 1 - Only Secondary Links 
	* if $id is set to !0 - Parent Id.. by default only main links
	*/
	function get_links($type=NULL,$id=0){
		global $db;
		$whrCls = array();
		
		$sQl = "select * from cms_link ";
		
		//get all the links of this Parent Only
		$whrCls[] = " link_parent = '".$id."'";
				
		if (!is_null($type))
			{
			//get all the links.. both primary & secondary
			$whrCls[] = " link_type = '$type' ";
			}
		if ($whrCls) 
			{
			$sQl .= " where ".implode(" && ",$whrCls)." order by link_order ASC ";
			}
		
		$result = $db->get_results($sQl);
	
		if ($result)
			{
			return $result;
			} else {
				$this->error = "Cannot display the Link List";
				return false;
				}
	}
	
	
	/*
	* function to get the list of all the links
	* Be they are primary / secondary.
	* only the main links will be retrieved by default
	* if variable is set then the array will have sublinks also
	* PARAM $type = 0/1 => 0 for Primary, 1 for Secondary
	* PARAM $all = FALSE => Gets only Mainlinks. TRUE => to get all main link as well as secondary link array
	* DEFAULT $op = NULL, $all = false
	* The result
	* Array in a structure of
	* [0]=> array(
			[id] = 6,
			[name] = MainLinkName,
			[href] = relation,
			[sub] = array() // sublink array
			
			)
	*/
	function get_link_array($type=NULL,$all=FALSE){
		global $db;
		
		if (!is_null($type))
			{
			$mainList = $this->get_links($type);
			} else {
				$mainList = $this->get_links();
				}
		
		//get the total count of the link
		$c = 0;
		$m_l_c = count($mainList);
		if ($mainList)
			{
			$links = array();

			foreach($mainList as $main)
				{
				$links[$c]= array(
					'id'=>$main->link_id,
					'name'=>$main->link_name,
					'href'=>""				
					);
				
				if ($all)
					{
					//get the sublinks of this link
					$subList = $this->get_links(NULL,$main->link_id);
					
					if($subList)
						{
						$sub = array();
						foreach($subList as $sLink)
							{
							$sub[] = array(
									'id'=>$sLink->link_id,
									'name'=>$sLink->link_name,
									'href'=>""				
									);
							}
						$links[$c]['sub'] = $sub;
						}					
					}
				$c++;
				}
			}
		
		return $links;	
	}
	
	/*
	* function to get a single dim link list
	* as an array
	* array[id] = value; format
	*/
	function get_link_formated($all = FALSE){
	
		$nArray = array();
		$linkList = $this->get_link_array(NULL,$all);
		
		if ($linkList)
			{
			foreach($linkList as $link){
				$nArray[$link['id']] = $link['name'];
				
				if ($link['sub'])
					{
					foreach($link['sub'] as $sub)
						{
						$nArray[$sub['id']] = "--".$sub['name'];
						}
					}
				}
			} else {
				return false;
				}		
		return $nArray;
	}
	
	/**
	* function to get all the sublinks of link Portfolio.
	* push all the result into one array.
	* @PARAMS portfolio_link_id
	* @RETURN ARRAY / FALSE
	*/
	public function get_sub_link(){
		global $db;
		$sQl = "SELECT link_id,link_name FROM cms_link WHERE link_parent = '".$this->linkId."' AND link_status = 1 ORDER BY link_name ASC";
		$result = $db->get_results($sQl);
		if($result){
			$subLinkArray = array();
			foreach($result as $subLList){
				$subLinkArray[$subLList->link_id] = $subLList->link_name;
			}
			return $subLinkArray;
			} else {
				$error = "Could not find sublinks.";
				return false;
		}
	}
	
/**
* End of the Class.
*/
}

?>