<?php
class Events{

	public $event_id;
	public $message;
	public $error;
	public $sef;
	public $query;
	public $imgPath = "../upload/";
	
	function __construct($id = null){
		if (!is_null($id)){
			$this->event_id = (int) $id;
		}
	}
	
	
	function get_summary(){
	}
	
	function get_full_details(){
		global $db;
		$sQl = "select * from cms_news where id = '".$this->event_id."'";
		$result = $db->get_row($sQl);
		if ($result){
			return $result;
			} else {
				return false;
				}
	}
	
	function get_event_photo(){
		$det = $this->get_full_details();
		$photo = array();
		if ($det){
			if ($det->news_photo1){
				array_push($photo,$det->news_photo1);
			} 
			if ($det->news_photo2){
				array_push($photo,$det->news_photo2);
			} 
			if ($det->news_photo3){
				array_push($photo,$det->news_photo3);
			} 
			return $photo;
		} else {
			return false;
			}
		
		
	}
	
	function get_event_list( $period = null ){
		global $db;
		$order = "DESC";
				
		$sQl = "select id,news_title,news_title_sef,news_image_logo,news_location,news_date from cms_news ";
		
		if ( strtolower($period) == 'current'){
			$sQl .= " where date(news_valid_upto) >= '".date('Y-m-d')."'";
			$order = 'ASC';
		} else if ( strtolower($period) == 'past'){
			$sQl .= " where date(news_valid_upto) < '".date('Y-m-d')."'";
		}			
		
		$sQl .= "order by news_valid_upto ".$order;
		$result = $db->get_results($sQl);
		
		//echo $sQl;
		
		if ($result){
			return $result;
		} else {
			return false;
		}
	}
	

	function map_id2sef(){
	}
	
	function map_sef2id($sef_title){
		global $db;
		$sef = strtolower($sef_title);
		$sQl = "select id from cms_news where news_title_sef = '".$sef."'";
		$result = $db->get_var($sQl);
		if ($result){
			$this->event_id = $result;
		} else {
			$this->error = "invalid sef";
			return false;
		}
	}	
	
/* end class */
}
?>