<?php
/**
* This class file for managing all the 
* Meta Information for a link/content.
* Using this class, you can add, edit, delete, and display the 
* meta information. 
*/

class Metatag{
	public $metaId;
	public $message;
	public $error;
	
	/**
	* Constructor
	*/
	public function __construct($id = NULL){	
		if(!empty($id) && !is_numeric($id)){
			$this->metaId = $id;
		}
	}
	
	/**
	* Function to add meta tag information
	* @PARAMS POSTed form data
	* @RETURN BOOL TRUE / FALSE
	*/
	public function add_meta($data){
		global $db;
		if(is_null($data)) { $error = "Invalid data to be inserted"; return false; }
		$sQlCheck = "SELECT COUNT(*) AS metas FROM cms_meta_tags WHERE link_id = '".$data['linkId']."'";
		$resultCheck = $db->get_row($sQlCheck);
		if($resultCheck->metas == 0){
			$msg = "added";	// to display on the session message.
			$sQl = "INSERT INTO cms_meta_tags
							(`meta_id`,
							`link_id`,
							`page_title`,
							`meta_key`,
							`meta_description`,
							`meta_robots`,
							`meta_author`,
							`meta_custom`,
							`meta_custom2`,
							`date_added`) VALUES (
							'',
							'".$data['linkId']."',
							'".$data['page_title']."',
							'".$data['metaKey']."',
							'".$data['metaDesc']."',
							'".$data['metaRobots']."',
							'".$data['metaAuthor']."',
							'".htmlentities($data['metaCustom'])."',
							'".htmlentities($data['metaCustom2'])."',
							NOW())";
			} else {
				$msg = "modified";	// to display on the session message.
				$sQl = "UPDATE cms_meta_tags SET
								`page_title` = '".$data['page_title']."',
								`meta_key` = '".$data['metaKey']."',
								`meta_description` = '".$data['metaDesc']."',
								`meta_robots` = '".$data['metaRobots']."',
								`meta_author` = '".$data['metaAuthor']."',
								`meta_custom` = '".htmlentities($data['metaCustom'])."',
								`meta_custom2` = '".htmlentities($data['metaCustom2'])."',
								`date_updated` = NOW()
							WHERE `link_id` = '".$data['linkId']."'";
		}		
		$result = $db->query($sQl);
		if($result){
			$message = "Meta tag information ".$msg." successfully";
			return true;
			} else {
				$error = "Cannot update meta information. Try again.";
				return false;
		}		
		
	}
	
	/**
	* Function to get meta information of a link
	* @PARAMS link_id
	* @RETURN ARRAY / FALSE
	*/	
	public function get_meta_info($id,$section='page'){
		global $db;
		$linkId = $id;
		$sQl = "SELECT * FROM cms_meta_tags WHERE link_id = '".$linkId."' and type='".$section."'";
		$result = $db->get_row($sQl);
		$metaDtls = array();
		if($result){
			$metaDtls = array(
				"page_title" => $result->page_title,
				"meta_key" => $result->meta_key,
				"meta_description" => $result->meta_description,
				"meta_robots" => $result->meta_robots,
				"meta_author" => $result->meta_author,
				"meta_custom" => $result->meta_custom,
				"meta_custom2" => $result->meta_custom2);
			return $metaDtls;
			} else {
				return false;
		}
	}


}

?>