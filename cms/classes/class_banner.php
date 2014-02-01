<?php

/*
* Banner class
*/

class Banner{

	public $bannerId;
	public $message;
	public $error;

	/*
	* constructor
	*/	
	function __construct($id = NULL){
		
		if (!is_null($id))
			{
			$this->bannerId = $id;
			}
	}
	
	/**
	* function Add Banner
	* Get the $_FILES var Check for image uploaded
	* check if already image by the same name does not exists.
	* If already any image rename it
	* Uplaod the image & update the database
	*/
	function add_banner(){
		global $db;

		if (!$_FILES['ban_img']['tmp_name']) { $this->error = "Banner image not located"; return false; }
		
		$image_file_name = $_FILES['ban_img']['name'];
		
		//check if the image is already in the upload dir
		if ( file_exists( UPLOAD_DIR.$image_file_name))
			{
			//rename it
			$image_name = "img-".rand(0,999)."-".$image_file_name;
			} else {
				$image_name = $image_file_name;
				}
		
		//upload the image to the dir
		//if successfully uploaded update the database
		if ( move_uploaded_file($_FILES['ban_img']['tmp_name'], UPLOAD_DIR.$image_name) ) 
			{
			//update the database
			$sQl = "insert into cms_tbl_banner(`banner_image`,`banner_comment`) values ('".$image_name."','".mysql_real_escape_string($_POST['comments'])."')";
			$result = $db->query($sQl);
				
			if ($result)
				{
				$this->message = "Banner ".$image_name." added successfully";
				return true;
				} else {
					$this->error = "Cannot add banner to system";
					return false;
					}
			} else {
				$this->error = "Cannot upload banner image";
				return false;
				}
	}


	/**
	* function Edit Banner
	* Get the data from $_POST & $_FILES
	* Check if any file has been updated
	* if so ... do file upload
	* remove the old file whoes name exists in the $_POST data;
	* do the query to update database
	* if no file uploaded, update the comments only
	*/
	function edit_banner(){
		global $db;
		
		//check if no file has been uploaded	
		$comments = mysql_real_escape_string($_POST['comments']);
		$banner_id = $_POST['ban_id'];
		$old_image_name = $_POST['old_img'];
		
		if (!$_FILES['ban_img']['tmp_name']) 
			{ 
			//update the database with the comments only
			
			echo $sQl = "update cms_tbl_banner set
					banner_comment = '".$comments."'
					where banner_id = '".$banner_id."'";
		
			if ($db->query($sQl))
				{
				$this->message = "Successfully updated banner record";
				return true;
				} else {
					$this->error = "Cannot update banner record";	
					return false;
					}		
			}
		
		//else it means that a new file has been uploaded
		$image_file_name = $_FILES['ban_img']['name'];
		
		//check if the image is already in the upload dir
		if ( file_exists( UPLOAD_DIR.$image_file_name))
			{
			//rename it
			$image_name = "img-".rand(0,999)."-".$image_file_name;
			} else {
				$image_name = $image_file_name;
				}
		
		//upload the image to the dir
		//if successfully uploaded update the database
		if ( move_uploaded_file($_FILES['ban_img']['tmp_name'], UPLOAD_DIR.$image_name) ) 
			{
			//update the database
			$sQl = "update cms_tbl_banner set 
					`banner_image` = '".$image_name."',
					`banner_comment` = '".$commnets."'
					where banner_id = '".$banner_id."'";
			
			$result = $db->query($sQl);
				
			if ($result)
				{
				$this->message = "Banner ".$image_name." added successfully & record updated";
				return true;
				} else {
					$this->error = "Cannot add banner to system";
					return false;
					}
			} else {
				$this->error = "Cannot upload banner image";
				return false;
				}
	}

	
	/**
	* function delete banner
	* Delete the entry from the table
	* delete the image from the folder as well
	*/
	function delete_banner(){
		global $db;
		
		//get details of this banner
		$details = $this->get_banner_details();
	
		//remove from database
		$sQl = "delete from cms_tbl_banner where banner_id = '".$this->bannerId."'";
		$result = $db->query($sQl);
		if ($result)
			{
			//unlink the file
				unlink(UPLOAD_DIR.$details->banner_image);
				return true;		
			} else {
				return false;
				}
	
	
	}
	
	/**
	* function banner details
	* Functiont to get the details of the banners
	*/
	function get_banner_details(){
		global $db;
		
		$sQl = "select * from cms_tbl_banner where banner_id = '".$this->bannerId."'"; 
		$result = $db->get_row($sQl);
		if ($result)
			{
			return $result;
			} else {
				return false;
				}
	}
	
		
		
	/**
	* get the list of all banner in the system
	*/
	function get_banner_list(){
		global $db;
		$sQl = "select * from cms_tbl_banner order by banner_id ASC";
		$result = $db->get_results($sQl);
		if ($result)
			{
			return $result;
			} else {
				$this->error = "Cannot get banner List";
				return false;
				}	
	}

	
	/**
	* get one random banner from the database
	**/
	function get_random_banner(){
		global $db;
		$sQl  = "select * from cms_tbl_banner order by rand() limit 0,1";
		$result = $db->get_row($sQl);
		if ($result)
			{
			return $result;
			} else {
				return false;
				}
	}

/* end class */
}