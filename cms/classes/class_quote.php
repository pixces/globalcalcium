<?php

class Quote{
	public $quoteId;
	public $error;
	public $query;
	
	public function __construct($id = NULL){
		if(!empty($id)){
			$this->quoteId = $id;
		}
	}
	
	public function get_quote_list(){
	global $db;
		
	$sQl = "SELECT * FROM cms_tbl_quote order by cms_quote_id";
		
	$result = $db->get_results($sQl);
	if($result){
		return $result;
		} 
	else {
		$this->error = "Quote List is empty.";
		return false;
		}
	}
	
	/**
	* Function to get the quote details  
	*/
	
	function quote_details(){
		global $db;
		
		$sQl = "select * from cms_tbl_quote where cms_quote_id = '".$this->quoteId."' ";
		
		$result = $db->get_row($sQl);
		if ($result)
			{
			return $result;
			} 
		else {
			$this->error = "Cannot get details";
			return false;
			} 
	}	
	
	/**
	* Function to add the quote in the database 
	*/
	
	function add_quote($data){
		global $db;		
		
		$serviceId = $data['service'];
		$sQlService = "SELECT CMS_COL_CAT_NAME FROM cms_tbl_category  WHERE CMS_COL_CAT_ID = '".$serviceId."'";
		
		$resultService = $db->get_row($sQlService);
		if($resultService){
			$serviceName = $resultService->CMS_COL_CAT_NAME;
		}
				
		$sQl = "insert into cms_tbl_quote 
		(`cms_quote_name`,`cms_quote_address`,`cms_quote_phone`,`cms_quote_email`,
		 `cms_quote_service`,`cms_quote_query`,`cms_quote_date`)
		Values
		('".$_POST['name']."','".addslashes($_POST['address'])."','".$_POST['phone']."',
		 '".addslashes($_POST['email'])."',	'".addslashes($serviceName)."',
		 '".addslashes($_POST['query'])."',NOW())";
		$result = $db->query($sQl);
		if($result)
			{
			//send the email to the admin
			$to = "preetha@tvcsp.com";
			$subject = "Customer Quote";
			$message = "Please reply on the following query \n";
			$message.= $_POST['query'];
			$message.= "\nOn this service:";
			$message.= $serviceName;
			$message.="\nAs soon as possible";
			$header = "From:support@tvcsp.com";
			mail($to,$subject,$message,$header);
			return true;
			} else {
			return false;
		}
		
	}
	
	/**
	* Function to update the database once the quote reply mail sent / fail
	* @PARAMS : 0 - Unsent (Default), 1 - Sent / Replied, 2 - Failed (If message sending failed)
	* @RETURN : TRUE / FALSE
	*/
	
	function quote_reply($data){
		global $db;
						
		echo $sQl = "UPDATE cms_tbl_quote SET cms_quote_status = '".$data."' WHERE cms_quote_id = '".$this->quoteId."'",
		$result = $db->query($sQl);
		if($result){
			return true;
			} else {
				return false;
		}
	}

		
	
}
	
?>