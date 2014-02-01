<?php
/**
* Class file for News Letters
* This class is used to add, edit, delete and list
*/

class Newsletter{
	public $nl_id;
	public $error;
	public $message;
	public $emailList = array();
	
	/**
	* construction
	*/
	
	function __construct($id = NULL){
		if(!is_null($id)){
			$this->nl_id = $id;
		}	
	}
	
	/**
	* This function is to list all the newsletters
	* @PARAM 
	* @RETURN ARRAY / FALSE
	* Generate error message
	*/
	
	public function display_newsletters(){
		global $db;
		$sQl = "SELECT * FROM cms_tbl_newslettter ";
		$result = $db->get_results($sQl);
		
		if($result){
			return $result;
			} else {
			$this->error = "Newsletter list empty. Please add newsletter";
		}
		
	
	}
	
	/**
	* This function is to add newsletters
	* @PARAM POSTed form data
	* @RETURN TRUE / FALSE
	* Generate error message
	*/
	
	public function add_newsletters($vars){
		global $db;		
		$conf = getConfiguration();
		
		if($vars['nlName']=='' || $vars['nlAddr']){
				$vars['nlName'] = $conf['sender_name'];
				$vars['nlAddr'] = $conf['sender_addr'];
				
		$sQl = "INSERT INTO cms_tbl_newslettter (`from_name`,`from_addr`,`subject`,`message`,`date_created`)
					VALUES ('".addslashes($vars['nlName'])."','".addslashes($vars['nlAddr'])."','".addslashes($vars['nlSub'])."','".urlencode($vars['nlMessage'])."',NOW())";
		
		$result = $db->query($sQl);
		if($result){
			$this->message = "Newsletter added successfully";
			return true;
			} else {
			$this->error = "Cannot Add newsletter. Please try again";
		}
		}
	}
	
	/**
	* This function is to edit newsletters
	* @PARAM POSTed form data
	* @RETURN TRUE / FALSE
	* Generate error message
	*/
	
	public function edit_newsletters($vars){
		global $db;	
				
		$sQl = "UPDATE cms_tbl_newslettter SET
					`from_name` = '".$vars['nlName']."',
					`from_addr` = '".$vars['nlAddr']."',
					`subject` = '".$vars['nlSub']."',
					`message` = '".$vars['nlMessage']."'
				WHERE nl_id ='".$vars['nl_id']."' ";
		
		$result = $db->query($sQl);
		if($result){
			$this->message = "Newsletter edited successfully";
			return true;
			} else {
			$this->error = "Cannot edit newsletter. Please try again";
		}
		
	
	}
	
		/**
	* This function is to delete a newsletter
	* @PARAM newsletter id
	* @RETURN TRUE / FALSE
	* Generate error message
	*/
	
	public function del_newsletters(){
		global $db;	
				
		$sQl = "DELETE FROM cms_tbl_newslettter WHERE nl_id = '".$this->nl_id."'";
		
		$result = $db->query($sQl);
		if($result){
			$this->message = "Newsletter deleted successfully";
			return true;
			} else {
			$this->error = "Cannot delete newsletter. Please try again";
		}
		
	
	}
	
	/**
	* This function is to get all the details of a newsletter
	* @PARAM newsletter id
	* @RETURN ARRAY / FALSE
	* Generate error message
	*/
	
	public function get_newsletters(){
		global $db;
		$sQl = "SELECT * FROM cms_tbl_newslettter WHERE nl_id ='".$this->nl_id."' ";
		$result = $db->get_row($sQl);
		if($result){
			return $result;
			} else {
			$this->error = "Cannot find details.";
		}
	}


	/**
	* mark newsletter as sent
	* also add date into the sent field
	**/
	function nl_mark_sent(){
		global $db;
		$sQl = "update cms_tbl_newslettter set 
					`nl_status` = '1',
					`nl_sent` = NOW()
					where `nl_id` = '".$this->nl_id."'";
		
		$result = $db->query($sQl);
		if ($result)
			{
			return true;
			} else {
				return false;
				}
	}

	/**
	* funtion to get the count of all
	* subscribed email ids
	*/	
	function nl_subscriber_count(){
		global $db;
		$sQl = "select count(*) as count from cms_tbl_subscriber where status = '1' ";
		$result = $db->get_var($sQl);

		if ($reuslt)
			{
			return $result;
			} else {
				return false;
				}
	}
	
	/**
	* funtion to get the newseletter details for this newsletter
	*/	
	function newsletter_details(){
		global $db;
		
		$sQl = "Select * from cms_tbl_newslettter where nl_id = '".$this->nl_id."'";
		$result = $db->get_row($sQl);
		if ($result)	
			{
				return $result;
			} else {
				return false;
				}	
		
	
	}

	/**
	* get the list of all subscribes
	* this will be an array of email address
	*/
	function get_address($start=0, $end = NULL){
		global $db;
		
		$sQl = "select * from cms_tbl_subscriber where status = '1' order by email";
		if (!is_null($end))
			{
			$sQl .= " Limit ".$start.", ".$end." ";
			}
		//echo $sQl;
		$result = $db->get_results($sQl);
		if ($result)
			{	
			foreach ($result as $email)
				{
				array_push($this->emailList, $email->email);
				}
			return true;
			} else {
				return false;
				}	
	
	}
	
	
/* end of class */
}
?>