<?php
/**
* This class file is for Managing the Portfolio.
* Using the this class you can Add, Edit, Delete, and List Portfolios.
* The Portfolios image upload will be handling using the Image Upload Class. 
*/

class Portfolio{
	public $portfolioId;
	public $error;
	public $message;
	
	/**
	* Constructor to initialize this class.
	*/
	public function __construct($id = NULL){
		if(!empty($id) && is_numeric($id)){
			$this->portfolioId = $id;
		}
	}
	
	/**
	* Function to add portfolio
	* @PARAMS POSTed form data
	* @RETURN BOOL TRUE / FALSE
	*/
	public function add_portfolio($data){
		global $db;
		if(!is_array($data)){ $error = "Invalid data provided"; return false; }
				
		//add the image of the product and do the thumbnail creation too
		if (!empty($_FILES['portf_img']['tmp_name'])) {
			
			$imgDetls = getimagesize($_FILES['portf_img']['tmp_name']);
			
			if($imgDetls[0] == '235' && $imgDetls[1] == '255'){
				$imgPath = "../upload/portfolio/";
				$imgName = $_FILES['portf_img']['name'];
				
								
				if(file_exists($imgPath.$imgName)){
					$imgNameSplt = explode('.',$imgName);
					$imgNewName = $imgNameSplt[0]."_".rand(0,99).".".$imgNameSplt[1];
				} else{
					$imgNewName = $imgName;
				}
				
				if(move_uploaded_file($_FILES['portf_img']['tmp_name'],$imgPath.$imgNewName)){
				
					echo $sQl = "INSERT INTO cms_portfolio VALUES(
													'',
													'".$data['portf_categ']."',
													'".$data['portf_title']."',
													'".$data['portf_desc']."',
													'".$imgNewName."',
													'".$data['portf_alt']."',
													'".$data['ext_link']."'
													)";
					
					$result = $db->query($sQl);
					if($result){
						$this->message = "Portfolio added Successfully.";
						return true;
					} else{
						$this->error = "Cannot add Portfolio. Try again.";
						return true;
					}					
					
				} else{
					$this->error = "Image cannot be uploaded. Try again.";
					return false;
				}							
					
			} else {
					$this->error = "Image size is more than allowed. You can Upload only";
					return false;
			}
		} else {	
					$this->error = "Image cannot be uploaded.";
					return false;
		}	// if(empty($_FILES['portf_..else.... ends here.
		
			
	} // Function add_portfolio ends here
	
	/**
	* Funciton to edit a portfolio details
	* @PARAMS POSTed form data
	* @RETURN BOOL TRUE/FALSE
	*/
	public function edit_portfolio($data){	
		global $db;
		//print_r($data);		
		if(!is_array($data)){ $error = "Invalid data provided"; return false; }
		
		// Get old image details
		$this->portfolioId = $data['portf_id'];
		$imgDtls = $this->get_details();
		//print_r($imgDtls);
		$oldImgName = $imgDtls->img_path;
		
		if (!empty($_FILES['portf_img']['tmp_name'])) {		// If new image location exists, do upload new image
			$imgDetls = getimagesize($_FILES['portf_img']['tmp_name']);
			//echo $imgDetls[0];
			if($imgDetls[0] == '235' && $imgDetls[1] == '255'){
				$imgPath = "../upload/portfolio/";
				unlink($imgPath.$oldImgName);
				$imgName = $_FILES['portf_img']['name']; 				
								
				if(file_exists($imgPath.$imgName)){
					$imgNameSplt = explode('.',$imgName);
					$imgNewName = $imgNameSplt[0]."_".rand(0,99).".".$imgNameSplt[1];
				} else{
					$imgNewName = $imgName;
				}
				if(move_uploaded_file($_FILES['portf_img']['tmp_name'],$imgPath.$imgNewName)){
					return true;					
				} else{
					$this->error = "Image cannot be uploaded. Try again.";
				}							
					
			} else {
					$this->error = "Image size is more than allowed.";
					return false;
			}
		} else {				
				// Keep the old image as it is.
				$image_new_name = $oldImgName; 
		}	// if(empty($_FILES['portf_..else.... ends here.
		
		// update the database 	
		$sQl = "UPDATE cms_portfolio SET 
					`img_cat_id` = '".$data['portf_categ']."',
					`img_title` = '".$data['portf_title']."',
					`img_detail` = '".$data['portf_desc']."',
					`img_path` = '".$image_new_name."',
					`img_alt` = '".$data['portf_alt']."',
					`img_ext_link` = '".$data['ext_link']."'
				WHERE img_id = '".$data['portf_id']."'
				";
		
		$result = $db->query($sQl);
		if($result){
			$this->message = "Portfolio modified successfully";
			return true;
			} else {
				$this->error = "Cannot modify portfolio. Try again";
				return false;
		}
		
	}
	
	/**
	* Function to delete a portfolio
	* @PARAMS portfolio id
	* @RETURN BOOL TRUE / FALSE
	*/
	public function delete_portfolio(){
		global $db;
		$sQl_img = "SELECT img_path FROM cms_portfolio WHERE img_id = '".$this->portfolioId."'";
		$imgDtls = $db->get_row($sQl_img);
		$imgName = $imgDtls->img_path;
		$imgSrc ="../upload/portfolio/".$imgName;		
		unlink($imgSrc);				
		$sQl = "DELETE FROM cms_portfolio WHERE img_id = '".$this->portfolioId."'";
		$result = $db->query($sQl);
		
		if($result){
			$this->message = "Portfolio deleted successfully.";
			return true;
			} else {
				$this->error = "Cannot delete portfolio. Try again.";
				return false;
		}
	}
	
	/**
	* Function to list all the portfolios
	* available in the system
	* @PARAMS 
	* @RETURN 
	*/
	public function list_all_portfolio(){
		global $db;
		$sQl = "SELECT pf.*,lk.link_name FROM cms_portfolio pf, cms_link lk WHERE pf.img_cat_id = lk.link_id ORDER BY lk.link_name ASC";
		$result = $db->get_results($sQl);
		if($result){
			return $result;
			} else {
				$this->error = "Portfolio list is empty. Please Add Portfolios.";
				return false;
		}
	}
	
	/**
	* Function to get details of a portfolio.
	* @PARAMS porfolio id.
	* @RETURN ARRAY / FALSE
	*/
	public function get_details(){
		global $db;
		$sQl = "SELECT * FROM cms_portfolio WHERE img_id = '".$this->portfolioId."'";
		$result = $db->get_row($sQl);
		if($result){
			return $result;
			} else {
			$this->error = "Cannot find details.";
			return false;
		}
	}
	
	
}	// Class Portfolio Ends here.

?>