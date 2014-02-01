<?php

class Content{
	public $contentId;
	public $error;
	public $message;
	
	public function __construct($id = NULL){
		if(!empty($id) && is_numeric($id)){
			$this->contentId = $id;
		}
	}
	
	/*
	* Function to get the list of content 
	* List all the content details
	* @RETURN Array / False
	*/
		
	public function get_display_content($id){
		global $db;
		
		$sQl = "SELECT content_id, content_title, content ,content_sef_title, content_filename FROM cms_content WHERE content_link_id = '".$id."' ";
		$contentDtls = $db->get_row($sQl);
		
		if($contentDtls){
			
			if ($contentDtls->content){
				$data = $contentDtls->content;

			} else {
				$contentFile = $contentDtls->content_filename;
				$contentdata ="./upload/content/".$contentFile;
				
				//read the file content
				$fileRead = fopen($contentdata, 'r') or die('Cannot open file:'.$contentdata); 
				$data = fread($fileRead,filesize($contentdata));
			}
			
			
			
			if($data){
				return array( 'title'=>$contentDtls->content_title,'content'=>$data);
				} else {
					$this->error = "Connot find data on the file.";
					return false;
				}
			} else {
				$this->error = "Cannot find the content details for this link.";
				return false;
		}
	}
	
	/**
	* Funcition to find out the content id for
	* the sef name provided.
	* @PARAMS sef_name
	* @RETURN link_id / FALSE
	*/
	public function get_link_id($sef_name){
		global $db;
		$sQl = "SELECT content_link_id FROM cms_content WHERE content_sef_title = '".$sef_name."'";
		$result = $db->get_var($sQl);
		if($result){
			return $result;
			} else {
				return false;
		}
	}

}
?>