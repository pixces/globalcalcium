<?php
/**
* This class is for the functionality of the content link.
* Using this class you can List, Add, Edit, Delete site links.
*/

class Tag{
	public $tagId;
	public $contentId;
	public $add_tag_array = array();
	public $delete_tag_array = array();
	
	private $query;
	
	
	function __construct($id = NULL){
		if(!empty($id) && is_numeric($id)){
			$this->tagId = $id;
		}
	}
	
	/**
	* function to add tags to the database
	* also will check and sssign 
	*/
	function add_tag(){
		global $db;
		
		$tag_list = $this->add_tag_array;
		$tagCount = count($tag_list);
		
		//check if the tag already exists
		//if yes.. get the id and add to tag relation table
		//if no.. insert tag .. get the id .. add to tag relation table
		for($x=0; $x < $tagCount; $x++)	
			{
			$sQl = "select * from cms_tbl_tags where tag_name = '".trim($tag_list[$x])."'";
			$res = $db->get_row($sQl);
			if ($res)
				{
				$tag_Id = $res->tagId;
				} else {
					//it does not exists add it to database
					$sQl = "insert into cms_tbl_tags (`tag_name`) values ('".trim(ucwords($tag_list[$x]))."')";
					$result = $db->query($sQl);
					if ($result)
						{
						$tag_Id = $db->insert_id;
						} else {
							return false;
							}
					}
			
			//if the data is inserted the add relation to the database
			if ($tag_Id)
				{
				$sQl = "insert into cms_tbl_tag_relation (`tagId`,`contentId`) values ('".$tag_Id."','".$this->contentId."')";
				$result = $db->query($sQl);
				if (!$result)
					{
					return false;
					}				
				}
			}
		return true;
	}
	
	
	/*
	* function add tags
	* assuming that the data received is a comma seperated list of tags
	* also the content id has been passed as the self:contentId;
	*/
	function do_add_tag($data){
		global $db;
		
		/*
		* logic
		* first get the list of all existing tags for this content in the system
		* now match the new tag list with the old
		* get a set of tags which already exists..
		* we need not modify them
		* for the rest we need to either add or delete their assignment for this content
		* check in the system for the tag name and check if its already asigned ... if so then remove its assignment
		* if it does not exists add it to the system
		*/
		
		//get the list of all tags
		$oldTags = $this->get_tagList_for_content();
		$newTags = $data;
		
		if (!$oldTags)
			{
			//it means only new tags are there so
			//add these tags
			$newTags = explode(',',$newTags);
			
			$this->add_tag_array = $newTags;
			//add these to the database
			$result = $this->add_tag();
			if ($result)
				{
				return true;
				} else {
					return false;
					}		
			} else {
				//we need to delete the tags
				//reassign relations
				//add new tags
				$addResult = true;
				$remResult = true;

				
				$newTags = explode(',',$newTags);
				$oldTags = explode(',',$oldTags);
				
				$tag_intersect= array_intersect($newTags,$oldTags);
			
				//get the array of tags to be added
				$addTag = array_diff($newTags,$tag_intersect);
				//get the array of tags to be removed
				$remTag = array_diff($oldTags,$tag_intersect);
				
				
				$this->add_tag_array = explode(',',implode(',',$addTag));				
				$addResult = $this->add_tag();
				if ($remTag)
					{
					$this->delete_tag_array = $remTag;
					$remResult = $this->remove_tag_relation();
					}
				if ($addResult && $remResult)
					{
					return true;
					} else {
						return false;
						}
				exit;
			
				}
	}
	
	
	/*
	* function to remove tag relation
	*/
	function remove_tag_relation(){
		global $db;
		$tagList = $this->delete_tag_array;
		$remCount = count($tagList);
		
		//do the loop and remove data
		for($x = 0; $x < $remCount; $x++)
			{
			//get the id of this tag name
			$tag_id = $this->get_tagId_by_name($tagList[$x]);
			$sQl = "delete from `cms_tbl_tag_relation` where tagId = '".$tag_id."' && contentId = '".$this->contentId."'";
			$result = $db->query($sQl);
			if (!$result)
				{
				return false;
				}
			}
		return true;
	}
	
	
	/*
	* function to get the tag id if name is providede
	*
	*/
	function get_tagId_by_name($tag){
		global $db;
		
		$sQl = "select tagId from cms_tbl_tags where tag_name = '".$tag."'";
		$result = $db->get_var($sQl);
		if ($result)
			{
			return $result;
			} else {
				return false;
				}
	}
			
	/*
	* function to get the list of tags
	* comma seperated for a given contentId
	*/	
	
	function get_tagList_for_content(){
		
		$tag_array = $this->get_tagArray_for_content();
		
		if ($tag_array)
			{
			//create a comma seperated list
			$tgList = array();
			foreach($tag_array as $tag)
				{
				$tgList[] = $tag->tag_name;
				}
			if ($tgList || count($tgList) > 0)
				{
				return implode(',',$tgList);			
				} else {
					return false;
					}
			} else {
				return false;
				}
	}
	
	/*
	*function get an array of the page tags
	*/
	function get_tagArray_for_content(){
	
		global $db;
		
		$sql = "select * from `cms_tbl_tag_relation` tr
				left outer join cms_tbl_tags t on  (t.tagId = tr.tagId)
				where tr.contentId = '$this->contentId'
				";
		
		$result = $db->get_results($sql);
		//print_r($result);
		
		if ($result)
			{
			return $result;
			} else {
				return false;
				}			
	}
	
	
	
	/*
	* function get list of all tags
	* get the list of all tags in the system to display
	*/
	function get_all_tag_list(){
		global $db;
		
		$sQl = "select * from cms_tbl_tags order by tag_name ";
		$result = $db->get_results($sQl);
		if ($result)
			{
				return $result;
			} else {
				return false;
				}
	}
	
	/**
	* Function  to get all the links
	* and its details curresponding to a tag
	* @PARAMS : tag ID
	* @RETURN : ARRAY / FALSE
	*/
	function get_all_tag_links(){
		global $db;
		$sQl = "SELECT a.tagId,b.* FROM cms_tbl_tag_relation a,cms_tbl_content_management b WHERE a.tagId = '".$this->tagId."' AND a.contentId = b.CMS_COL_CONTENT_ID AND b.CMS_COL_STATUS = 1";
		$result = $db->get_results($sQl);
		if($result){
			return $result;
			} else {
				return false;
		}
	}
	
	/**
	* Function to get the details about the tag
	* @PARAMS : tag ID
	* @RETURN : ARRAY / FALSE
	*/
	function get_tag_details(){
		global $db;
		$sQl = "SELECT * FROM cms_tbl_tags WHERE tagId = '".$this->tagId."'";
		$result = $db->get_row($sQl);
		if($result){
			return $result;
			} else {
				return false;
		}
	}
	
	/**
	* Function to get the tag ID 
	* @PARAMS tag Name
	* @RETURN tag ID / FALSE
	*/
	function get_tag_id($tagName){
		global $db;
		$sQl = "SELECT tagId FROM cms_tbl_tags WHERE tag_name = '".$tagName."'";
		$result = $db->get_row($sQl);
		if($result){
			$this->tagId = $result->tagId;			
			return $result;			
			} else {
				return false;
		}
	}
	
	/**
	* Function to get all the tag name along with its weight(the count of contents)
	* @RETURN ARRAY / FALSE
	*/
	function get_tag_cloud_array(){
		global  $db;
		$tag_cloud_array = array();
		
		$sQl = "SELECT tagId, tag_name FROM cms_tbl_tags LIMIT 30";
		$result = $db->get_results($sQl);
		if($result){
			foreach($result as $tags){
				$tagId = $tags->tagId;
				$sQlTagWeight = "SELECT COUNT(*) AS WEIGHT FROM cms_tbl_tag_relation WHERE tagId = '".$tagId."'";
				$contentWeight = $db->get_var($sQlTagWeight);
				if($contentWeight != 0 ){
					$tag_cloud_array[$tags->tag_name] = $contentWeight;
				}
			}
			return $tag_cloud_array;
		}
	}
/**
* End of the Class.
*/
}

?>