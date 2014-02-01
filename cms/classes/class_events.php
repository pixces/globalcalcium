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
	
	
	public function add($data){
		
		global $db;
		$message = array();
		$error = array();
		
		if(!is_array($data)){ $error = "Invalid data provided"; return false; }
		
		//add the image of the product and do the thumbnail creation too
		//print_r($_FILES);
		//print_r($data);
		
		#first check and add logo
		//print_r($_FILES);

		if (!empty($_FILES['event_logo']['tmp_name'])) {
			$logoDetls = getimagesize($_FILES['event_logo']['tmp_name']);
			$logoName = $_FILES['event_logo']['name'];				
			
			if(file_exists($this->imgPath.$logoName)){
				$imgNameSplt = explode('.',$logoName);
				$imgNewName = $imgNameSplt[0]."_".rand(0,99).".".$imgNameSplt[1];
			} else{
				$imgNewName = str_replace(' ','_',$logoName);
			}
			#move upload the logo
			if ( move_uploaded_file($_FILES['event_logo']['tmp_name'],$this->imgPath.$imgNewName) ){
				$message[] = "Logo image added";
			} else {
				$error[] = "Cannot add Logo image";
			}
		}

        //clean out the data using mysql_real_escape_strings


		#now add all the details to table
		$sQl = "INSERT INTO cms_news (
					`news_title`,`news_title_sef`,`news_image_logo`,`news_summary`,
					`news_details`,`news_location`,`news_date`,
					`news_photo1`,`news_photo2`,`news_photo3`,`news_valid_upto`,`added_on`) VALUES ( 
						
					'".$data['event_title']."','".$data['sef_title']."','".$imgNewName."','".mysql_real_escape_string($data['event_summary'])."',
					'".mysql_real_escape_string($data['event_details'])."','".mysql_real_escape_string($data['event_location'])."',
					'".mysql_real_escape_string($data['event_date'])."',
					'".$photoName1."','".$photoName2."','".$photoName3."',
					'".date('Y-m-d', strtotime($data['event_end_date']))."',NOW() )";
					
		$result = $db->query($sQl);
		if($result){
			$message[] = "Event Details added Successfully.";
		} else{
			$error[] = "Cannot add Event details.";
		}
		
		if (sizeof($message)){ $this->message = implode("<br />",$message); }
		if (sizeof($error)){ $this->error = implode("<br />",$error); }
		
		if ($result){
			return true;
			} else {
				return false;
				}
	}
	
	function edit($data){
		global $db;
		$message = array();
		$error = array();
		
		if(!is_array($data)){ $error = "Invalid data provided"; return false; }
		
		//add the image of the product and do the thumbnail creation too
		//print_r($_FILES);
		//print_r($data);
		
		#first check and add logo
		print_r($_FILES);
		
		#first check and add logo
		if (!empty($_FILES['event_logo']['tmp_name'])) {
			$logoDetls = getimagesize($_FILES['event_logo']['tmp_name']);
			$logoName = $_FILES['event_logo']['name'];				
			
			if(file_exists($this->imgPath.$logoName)){
				$imgNameSplt = explode('.',$logoName);
				$imgNewName = $imgNameSplt[0]."_".rand(0,99).".".$imgNameSplt[1];
			} else{
				$imgNewName = str_replace(' ','_',$logoName);
			}
			#move upload the logo
			if ( move_uploaded_file($_FILES['event_logo']['tmp_name'],$this->imgPath.$imgNewName) ){
				$message[] = "Logo image added";
				$newlogoName = $imgNewName;
			} else {
				$error[] = "Cannot add Logo image";
			}
		}
		
		
		#check for the images and add new images
		$imageNames = array();
		//$imgArSize = count($FILES['event_image']['tmp_name']);
		
		for($x=0;$x<3;$x++){
			if (!empty($_FILES['event_image']['tmp_name'][$x])) {
				echo $imgName = $_FILES['event_image']['name'][$x];
				
				if(file_exists($this->imgPath.$imgName)){
					$imgNameSplt = explode('.',$imgName);
					$imgNewName = $imgNameSplt[0]."_".rand(0,99).".".$imgNameSplt[1];
				} else{
					$imgNewName = str_replace(' ','_',$imgName);
				}
				
				#move upload the logo
				if ( move_uploaded_file($_FILES['event_image']['tmp_name'][$x],$this->imgPath.$imgNewName) ){
					$message[] = "Event image added";
					$imageNames[$x] = $imgNewName;
				} else {
					$error[] = "Cannot add Event image";
				}
			}
		}
		
		#now update all the details to table
		$sQl = "UPDATE cms_news set
					`news_title` = '".$data['event_title']."',
					`news_title_sef` = '".$data['sef_title']."',
					`news_summary` = '".mysql_real_escape_string($data['event_summary'])."',
					`news_details` = '".mysql_real_escape_string($data['event_details'])."',
					`news_location` = '".mysql_real_escape_string($data['event_location'])."',
					`news_date` = '".mysql_real_escape_string($data['event_date'])."',
					`news_valid_upto` = '".date('Y-m-d', strtotime($data['event_end_date']))."'";
					
		#add for logo
		if ($newlogoName) { 
			$sQl .= " , `news_image_logo` = '".$newlogoName."'";
		}	
		
		#add for images
		if (sizeof($imageNames)){
			foreach($imageNames as $k=>$image){
				if ($image){
					$n = "news_photo".($k+1);
					$sQl .= " , `".$n."` = '".$image."'";
				}
			}
		}
					
		$sQl .= " where id = '".$data['eventId']."'";
		//echo $sQl;
				
		$result = $db->query($sQl);
		if($result){
			$message[] = "Event Details updated Successfully.";
		} else{
			$error[] = "Cannot edit Event details.";
		}
		
		if (sizeof($message)){ $this->message = implode("<br />",$message); }
		if (sizeof($error)){ $this->error = implode("<br />",$error); }
		
		if ($result){
			return true;
			} else {
				return false;
				}
	}
	
	function delete(){
		
		#get the event details
		$eventDet = $this->get_full_details();
		//print_r($eventDet);
		#unlink all images for the event
		if ($eventDet->news_image_logo) { 
			//unlink($this->imgPath.$eventDet->news_image_logo);
		}
		if ($eventDet->news_photo1) { 
			unlink($this->imgPath.$eventDet->news_photo1);
		}
		if ($eventDet->news_photo2) { 
			unlink($this->imgPath.$eventDet->news_photo2);
		}
		if ($eventDet->news_photo3) { 
			unlink($this->imgPath.$eventDet->news_photo3);
		}						
		
		#remove event entry from the db
		global $db;
		$sQl = "delete from cms_news where  id = '".$this->event_id."'";
		if ($db->query($sQl)){
			$this->message = "Event ".$eventDet->news_title." deleted successfully";
			return true;
		} else {
			$this->error = "Cannot delete Event ".$eventDet->news_title."";
			return false;
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
	
	function get_event_list(){
		global $db;
		$sQl = "select id,news_title,news_title_sef,news_location,news_date from cms_news order by added_on DESC";
		$result = $db->get_results($sQl);
		if ($result){
			return $result;
		} else {
			return false;
		}
	}
	
	function get_current_events(){
	}
	
	function get_past_events(){
	}
	
	function get_event_count(){
	}
	
	function map_id2sef(){
	}
	
	function map_sef2id(){
	}
	
/* end class */
}
?>