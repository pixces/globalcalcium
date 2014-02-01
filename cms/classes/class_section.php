<?php
/**
* Class for managing the index page contents  
*/
class Section{
	public $sectionId;
	public $message;
	public $error;
	private $query;
	
	/** 
	* Constructor to intialize the sectoin Id
	*/
	
	function __construct($id = NULL){
		if(!is_null($id)){
			$this->sectionId = $id;			
		}		
	}
	
	
	/**
	* Function to add a section details
	* @PARAM POSTED form data
	* @RETURN BOOL TRUE / FALSE
	*/
	public function section_add($data){
		global $db;
		
		// If the data sent from the form is not an array then generate the error message and return false
		if(!is_array($data)){
			$this->error = "Invalid Data Provided";
			return false;
		}
		
		//do add section
		print_r($data);
		
		$sQl = "insert into cms_tbl_section 
			(`section_parent`,`section_name`,`section_content`,`image_url`,`link_url`,`date_created`) 
				values 
			('".$data['sec_parent']."','".addslashes($data['sec_name'])."','".addslashes($data['sec_data'])."','".$data['sec_image']."','".$data['sec_URL']."',NOW())";
		
		$result = $db->query($sQl);
		if ($result)
			{
			return true;
			} else {
				$this->error = "Cannot add section information";
				return false;
				}
				
		exit;
	}
	
	/**
	* Function to edit the section details
	* @PARAMS - SectionId, POSTED form data
	* @RETURN BOOL TRUE / FALSE	
	*/
	public function section_edit($data){
		global $db;
		
		// If the posted data is not an array ? then generate error message and return false
		if(!is_array($data)){
			$this->error = "Invalid Data Provide";
			return false;			
		}
		
		$sQl = "UPDATE cms_tbl_section SET
						`section_parent` = '".$_POST['sec_parent']."',
						`section_name` = '".$_POST['sec_name']."',
						`section_content` = '".$_POST['sec_data']."',
						`image_url` = '".$_POST['sec_image']."',
						`link_url` = '".$_POST['sec_URL']."'
				WHERE section_id = '".$_POST['sec_id']."' ";
		$result = $db->query($sQl);
		if($result){
			$this->message = "Section edited successfully";
			return true;
			} else {
				$this->error = "Cannot edit section. Try again";
				return false;
		}
	}
	
	/**
	* Function to delete a section details
	* @PARAMS - Section Id
	* @RETURN - TRUE / FALSE
	*/
	public function section_delete(){
		global $db;
		if($this->sectionId == 0){
			$sQlChild = "DELETE FROM cms_tbl_section WHERE section_parent = '".$this->sectionId."'";
			$resultChild = $db->query($sQlChild);
			if($resultChild){
				$this->message = "Section details deleted successfully";
				return true;
				} else {
					$this->error = "Cannot delete section details. Try again";
					return false;
			}
			
		}
		$sQl = "DELETE FROM cms_tbl_section WHERE section_id = '".$this->sectionId."'";
		$result = $db->query($sQl);
		if($result){
			$this->message = "Section details deleted successfully";
			return true;
			} else {
				$this->error = "Cannot delete section details. Try again";
				return false;
		}
		
	}
	
	/**
	* Function to get details of a section 
	* @PARAMS - Section Id
	* @RETURN Array / FALSE
	*/
	public function section_details(){
		global $db;
		$sQl = "SELECT * FROM cms_tbl_section WHERE section_id = '".$this->sectionId."'";
		$result = $db->get_row($sQl);
		if($result){
			return $result;
			} else {
				$this->error = "Cannot find section details. Try again";
				return false;
		}
		
	}
	
	/**
	* Function to get the list of all sections
	* as well as their sub list in one single array 
	* @RETURN Array / false
	*/
	public function section_list(){
		global $db;
		$sQl = " SELECT * FROM `cms_tbl_section` where section_parent = '0' order by section_id ASC ";
		$result = $db->get_results($sQl);

		$list = array();
		
		$c = 0;

		if ($result)
			{
				foreach($result as $main)
					{
					$list[$c]['id'] = $main->section_id;
					$list[$c]['name'] = $main->section_name;
					$list[$c]['content'] = $main->section_content;
					$list[$c]['image'] = $main->image_url;
					$list[$c]['href'] = $main->link_url;					
					
					
					//get the sublinks if any
					$sQl_sub = " SELECT * FROM `cms_tbl_section` where section_parent = '".$main->section_id."' order by section_id ASC ";
					$subList = $db->get_results($sQl_sub);
					if ($subList)
						{
						$sub = array();
						foreach($subList as $subSec)
							{
							$sub[]= array( 'id'=>$subSec->section_id,
											'name'=>$subSec->section_name,
											'content'=>$subSec->section_content,
											'image'=>$subSec->image_url,
											'href'=>$subSec->link_url
										);	
							}
						$list[$c]['sub'] = $sub;
						}
					$c++;
					}	
			return $list;
			} else {
				return false;
				}	
	}


/**
* End of the class file
*/

}



?>