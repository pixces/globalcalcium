<?php
/**
* This class is to manage the content of the links
* Using this class you can List, Add, Edit, Delete content of the links
*/

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
	
	public function display_content(){
		global $db;
		
		$sQl = "SELECT * FROM cms_content CN,cms_link LK WHERE CN.content_link_id = LK.link_id ORDER BY LK.link_order";	
		$result = $db->get_results($sQl);
		
		$c = 0;
		if($result){
			foreach($result as $contentList){
				$contentArray[]= array(
					'content_id'=>$contentList->content_id,
					'content_link_id'=>$contentList->content_link_id,
					'content_title'=>$contentList->content_title,
					'content_sef_title'=>$contentList->content_sef_title,
					'content_file'=>$contentList->content_filename,
					'content'=>$contentList->content);
			}
			return $contentArray;
			} else {
			$this->error = "Content List is empty. Please add content to links";
			return false;
		}
	}
	
	
	/*	
	* Function to insert content into table
	*/
	public function add_content($data){
		global $db;
		
		//print_r($_FILES);
		if(!is_array($data)){  $error = "Invalid Data"; return false; }
		$errorFlag = 0;
		$sQlCheck = "SELECT content_id,content_link_id,content_title,content_sef_title,link_name FROM cms_content CN,cms_link LK WHERE CN.content_link_id = LK.link_id AND LK.link_id = '".$data['linkList']."'";
		
		$resultCheck = $db->get_row($sQlCheck);
		if($resultCheck){
			$errorFlag = 1;
			$this->error = $resultCheck->content_title." Page Already Exist.";
			return false;
			
			/* 
			// Image or html uploading starts here
			} else {	
					// Text / html file upload starts here
					// Configuration 
					$allowed_filetypes = array('.txt','.html','.htm'); // These will be the types of file that will pass the validation.
					$upload_path = '../upload/content/'; // The place the files will be uploaded to (currently a 'files' directory).
					$filename = $_FILES['page_content']['name']; // Get the name of the file (including file extension).
					$fName = substr($filename, 0, strpos($filename,'.'));
					$ext = substr($filename, strpos($filename,'.'), strlen($filename)-1); // Get the extension from the filename.
					if(file_exists($upload_path . $filename)){
						$newFilename =$fName.rand(0,999).$ext;
						} else {
							$newFilename =$fName.rand(0,999).$ext;
					}
					
					// Check if the filetype is allowed, if not DIE and inform the user.
					if(!in_array($ext,$allowed_filetypes)){
						$errorFlag = 1;
						$this->error = "Only Image or HTML file is allowed to upload.";
						return false;
						} else {
							
							/**
							* Check the image exist or not, 
							* if exists quit the entire process
							* without adding any images.
							*/
						
							/*
							$arrC = count($_FILES['content_image']['name']);
							// Location of the images.
							$upload_img_path = '../images/'; 	
							for($t = 0; $t < $arrC; $t++){
								if(!empty($_FILES['content_image']['name'][$t])){
									$imageNameCheck = $_FILES['content_image']['name'][$t];									
									if(file_exists($upload_img_path . $imageNameCheck)){
										$this->error = "Selected image / image name exists. Please rename image file and upload.";
										$errorFlag = 1;
										return false;
									}
								}
							}
							
							// Image name check ends here
							if($errorFlag == 0){
								// Image Upload starts here
									
								$uploadErrors = '';	// To store upload errors.
								$imgNames = array();
								
								//print_r($_FILES);																	
								for($i = 0; $i < $arrC; $i++){	
									if(!empty($_FILES['content_image']['name'][$i])){
										// These will be the types of file that will pass the validation.
										$allowed_filetypes = array('.png','.jpg','.jpeg','.gif'); 										
										
										// Get the name of the file (including file extension).
										 $imageName = $_FILES['content_image']['name'][$i];
										
										// Get the extension from the filename.
										$imageExt = substr($imageName, strpos($imageName,'.'), strlen($imageName)-1); 
										if(file_exists($upload_img_path . $imageName)){
											$this->error = "Selected image / image name exists. Please rename image file and upload.";
											$errorFlag = 1;
											return false;
										}
										
										// Check if the filetype is allowed, if not DIE and inform the user.
										if(!in_array($imageExt,$allowed_filetypes)){
											$uploadErrors .= "\t".$imageName." is not a image file.\n";
											$errorFlag = 1;
											return false;
											} else {			
											
												// Upload the file to your specified path.
												if(move_uploaded_file($_FILES['content_image']['tmp_name'][$i],$upload_img_path . $imageName)){
													//" images Uploaded successfully";
													$imgNames[$i] = $imageName;
													}
													else {
														$errorFlag = 1;
														$uploadErrors .= "\t There was an error while uploading ".$imageName." file.\n";
														return false;
														//echo 'There was an error during the file upload.  Please try again.'; 
												}			
										}
									} 							
								}
								$serImgArray = serialize($imgNames);						
							}
							// Image Upload ends here

							// Upload the file to your specified path.
							if(move_uploaded_file($_FILES['page_content']['tmp_name'],$upload_path . $newFilename)){
								//return true;
								} else {
									$errorFlag = 1;
									$this->error = 'There was an error during the file upload.  Please try again.'; 
									return false;
							}
					}
					*/
		}
		// Text / HTML file upload ends here
	
		
		if($errorFlag == 0){
			$sefTitle = convert_sef_name($data['sef_title']);
			$sQl = "INSERT INTO cms_content
								(`content_link_id`,
								`content_title`,
								`content_sef_title`,
								`content`,
								`content_added`)
						VALUES(
								'".$data['linkList']."',
								'".mysql_real_escape_string($data['page_title'])."',
								'".$sefTitle."',
								'".mysql_real_escape_string($data['page_content'])."',
								NOW())";
			$result = $db->query($sQl);
			if($result){
				$lastInsertId = $db->insert_id;
				$sQl = "UPDATE `cms_content` SET `page_url` = '?page_id=".$lastInsertId."' WHERE `content_id` = ".$lastInsertId;
				$result = $db->query($sQl);
				/* 
				if($uploadErrors != ''){
					$this->message = "Some files could not be uploaded.Check the following errors :\n".$uploadErrors;
					} else {
						$this->message = "Site Content Added Successfully";
				}
				 */
				$this->message = "Site Content Added Successfully";
				return true;
				} else {
					$this->error = "Cannot Add Site Content. Try Again.";
					return false;
			}
		}
	}	
	
	
	/*
	* Function to get the details of a site content
	* @PARAM content_id
	* @RETURN Bool TRUE/ FALSE
	*/
	public function get_content($id){
	global $db;
	
		$sQl = "SELECT * FROM cms_content WHERE content_id = '".$id."' "; 
		$result = $db->get_row($sQl);
		if($result){
			return $result;		
			} else {
			$this->error = "Connot find the Content details";
			return false;		
		}	
	}
 	
	
	/**
	* Function to modify the content.
	* @PARAMS - POSTED form data
	* @RETURN - BOOL TRUE/FALSE
	*/
	public function edit_content($data){
		global $db;
		
		if(!is_array($data)) { $this->error = "Invalid Data Provided."; return false; }
		
		$sefTitle = convert_sef_name($data['sef_title']); 
					
		$sQl = "UPDATE cms_content 
						SET 
							`content_title` 		= '".addslashes($data['page_title'])."',
							`content_sef_title` 	= '".$sefTitle."',
							`content` 				= '".mysql_real_escape_string($data['page_content'])."'
						WHERE `content_id` 			= '".$data['contentId']."'";		
		
		$result = $db->query($sQl);
		if($result){			
				$this->message = $data['content_title']." Page Updated Successfully";
				return true;
			} else {
				$this->error = $data['content_title']."' Page Connot be Updated. Try again";
				return false;
		}
	}
	
	
	/**
	* Function to delete the content
	*/
	public function delete_content(){
		global $db;
		$sQl_img = "SELECT content,content_image FROM cms_content WHERE content_id = '".$this->contentId."'";
		$contentDtls = $db->get_row($sQl_img);
		$content = $contentDtls->content;
		$imgName = unserialize($contentDtls->content_image);
		$imgCount = count($imgName);
		$imgSrc ="../images/";
		foreach($imgName as $images){
			unlink($imgSrc.$images);		
		}
		
		$content ="../upload/content/".$content;
		unlink($content);
		
		$sQl = "DELETE FROM cms_content WHERE content_id = '".$this->contentId."'";
		$result = $db->query($sQl);
		if($result){
			$this->message = "Content Deleted Successfully";
			return true;		
			} else {
			$this->error = "Connot Delete Content";
			return false;		
		}		
	}
	
	
}
/*
* End of class
*/

?>