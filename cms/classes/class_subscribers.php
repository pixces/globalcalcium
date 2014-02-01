<?php
/**
* Class file for subscribers
* This class is used to add, edit, delete and list
*/

class Subscribers{
	public $sb_id;
	public $error;
	public $message;
	
	/**
	* construction
	*/
	
	function __construct($id = NULL){
		if(!is_null($id)){
			$this->sb_id = $id;
		}	
	}
	
	/**
	* This function is to list all the subscribers
	* @PARAM : 
	* @RETURN : ARRAY / FALSE
	* Generate error message
	*/
	
	public function display_subscribers(){
		global $db;
		$sQl = "SELECT * FROM cms_tbl_subscriber ";
		$result = $db->get_results($sQl);
		if($result){
			return $result;
			} else {
				$this->error = "Subscribers list is empty. Please add subscribers";
			}
	}
	
	/**
	* This function is to subscribe all selected emails (mass subscribe)
	* @PARAMS : Posted form data / ARRAY -- Array of subscribers id.
	* @RETURN : TRUE / FALSE
	* Generate message
	*/
	
	public function subxAll_subscribers($data){
		global $db;
		foreach($data as $data){
			foreach($data as $key => $value){
				$sQl = "UPDATE cms_tbl_subscriber 
								SET status = 1
								WHERE subscriber_id = '".$value."'
							";
				$result = $db->query($sQl);				
			}
		}
		exit;
	}
	
	
	/**
	* This function is to unsubscribe all selected emails (mass unsubscribe)
	* @PARAMS : Posted form data / ARRAY -- Array of unsubscribers id.
	* @RETURN : TRUE / FALSE
	* Generate message
	*/
	
	public function unsubxAll_subscribers($data){
		global $db;
		foreach($data as $data){
			foreach($data as $key => $value){
				$sQl = "UPDATE cms_tbl_subscriber 
								SET status = 0
								WHERE subscriber_id = '".$value."'
							";
				$result = $db->query($sQl);				
			}
		}
		exit;
	}
	
	
	/**
	* This function is to delete all selected emails (mass delete)
	* @PARAMS : Posted form data / ARRAY -- Array of subscriber ids to delete.
	* @RETURN : TRUE / FALSE
	* Generate message
	*/
	
	public function deleteAll_subscribers($data){
		global $db;
		foreach($data as $data){
			foreach($data as $key => $value){
				$sQl = "DELETE FROM cms_tbl_subscriber WHERE subscriber_id = '".$value."'";
				$result = $db->query($sQl);				
			}
		}
		exit;
	}
	
	/**
	* This function is to subscribe one mail id
	* @PARAMS : subscriber id
	* @RETURN : TRUE / FALSE
	* Generate message
	*/
	
	public function subx_subscribers(){
		global $db;
		$sQl = "UPDATE cms_tbl_subscriber 
								SET status = 1
								WHERE subscriber_id = '".$this->sb_id."'
							";
		$result = $db->query($sQl);			
		if($result){
			$this->message = "Email Subscribed successfully";
			return true;
			} else {
			$this->error = "Email cannot subscribed. Try again";
			return false;
		}
	}
	
	/**
	* This function is to unsubscribe one mail id
	* @PARAMS : subscriber id
	* @RETURN : TRUE / FALSE
	* Generate message
	*/
	
	public function unSubx_subscribers(){
		global $db;
		$sQl = "UPDATE cms_tbl_subscriber SET status = 0 WHERE subscriber_id = '".$this->sb_id."' ";
		$result = $db->query($sQl);			
		if($result){
			
			
			$this->message = "Email unsubscribed successfully";
			return true;
			
			} else {
			$this->error = "Email cannot unsubscribed. Try again";
			return false;
		}
	}
	
	/**
	* This function is to delete one mail id
	* @PARAMS : subscriber id
	* @RETURN : TRUE / FALSE
	* Generate message
	*/
	
	public function delSubx_subscribers(){
		global $db;
		$sQl = "DELETE FROM cms_tbl_subscriber WHERE subscriber_id = '".$this->sb_id."'
							";
		$result = $db->query($sQl);			
		if($result){
			$this->message = "Email deleted successfully";
			return true;
			} else {
			$this->error = "Email cannot deleted. Try again";
			return false;
		}
	}
	
	

}
?>