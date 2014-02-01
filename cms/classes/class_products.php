<?php
/**
* This class is to manage the products
* Using this class you can List, Add, Edit, Delete content of the links
*/

class Products{
	public $productId;
	public $error;
	public $message;
	private $table = 'cms_products';
	
	public function __construct($id = NULL){
		if(!empty($id) && is_numeric($id)){
			$this->productId = $id;
		}
	}
	
	// Function to get all the products in the system
	function display_products(){
		global $db;
		$sQl = "SELECT a.*, count(b.product_id) as total FROM `cms_products` a LEFT JOIN `cms_product_specification` b ON a.id = b.product_id GROUP BY a.id";
		$results = $db->get_results($sQl);
		if($results){
			return $results;
			} else {
				$this->error = "Could not find any products in the system.";
				return false;
		}
	}
	
	
	/*
	* function to get a single dim product list
	* as an array
	* array[id] = value; format
	*/
	function getProductListFormated($all = FALSE){
	
		$nArray = array();
		$linkList = $this->get_link_array(NULL,$all);
		
		if ($linkList)
			{
			foreach($linkList as $link){
				$nArray[$link['id']] = $link['name'];
				
				if ($link['sub'])
					{
					foreach($link['sub'] as $sub)
						{
						$nArray[$sub['id']] = "--".$sub['name'];
						}
					}
				}
			} else {
				return false;
				}		
		return $nArray;
	}
	
	/*
	* function to get the list of all the links
	* Be they are primary / secondary.
	* only the main links will be retrieved by default
	* if variable is set then the array will have sublinks also
	* PARAM $type = 0/1 => 0 for Primary, 1 for Secondary
	* PARAM $all = FALSE => Gets only Mainlinks. TRUE => to get all main link as well as secondary link array
	* DEFAULT $op = NULL, $all = false
	* The result
	* Array in a structure of
	* [0]=> array(
			[id] = 6,
			[name] = MainLinkName,
			[href] = relation,
			[sub] = array() // sublink array
			
			)
	*/
	function get_link_array($type=NULL,$all=FALSE){
		global $db;
		
		if (!is_null($type))
			{
			$mainList = $this->get_links($type);
			} else {
				$mainList = $this->get_links();
				}
		
		//get the total count of the link
		$c = 0;
		$m_l_c = count($mainList);
		if ($mainList)
			{
			$links = array();

			foreach($mainList as $main)
				{
				$links[$c]= array(
					'id'=>$main->id,
					'name'=>$main->name			
					);
				
				if ($all)
					{
					//get the sublinks of this link
					$subList = $this->get_links(NULL,$main->id);
					
					if($subList)
						{
						$sub = array();
						foreach($subList as $sLink)
							{
							$sub[] = array(
									'id'=>$sLink->id,
									'name'=>$sLink->name		
									);
							}
						$links[$c]['sub'] = $sub;
						}					
					}
				$c++;
				}
			}
		
		return $links;	
	}
	
	
	/*
	* function to get the link set
	* PARAM $type, $id;
	* Default $type= NULL, $id = NULL
	* RETURN False / Array
	*
	* by default it will give a list of all the Primary & Secondary links 
	* if $type is set to 0 - Only Primary Links
	* if $type is set to 1 - Only Secondary Links 
	* if $id is set to !0 - Parent Id.. by default only main links
	*/
	function get_links($type=NULL,$id=0){
		global $db;
		$whrCls = array();
		
		$sQl = "select * from `".$this->table."` ";
		
		//get all the links of this Parent Only
		$whrCls[] = " parent_id = '".$id."'";
				
		if (!is_null($type))
			{
			//get all the links.. both primary & secondary
			$whrCls[] = " link_type = '$type' ";
			}
		if ($whrCls) 
			{
			$sQl .= " where ".implode(" && ",$whrCls)." ";
			}
		
		#adding order
		$sQl .= " order by name ASC";
		
		$result = $db->get_results($sQl);
		if ($result)
			{
			return $result;
			} else {
				$this->error = "Cannot display the Product List";
				return false;
				}
	}
	
	// Function to add the product
	function add_product($var){
		global $db;
		if(!is_array($var) || empty($var)){ 
			$this->error = "Invalid parameter to add the product."; 
			return false;
		}
			
		$product_groups = implode(',', $var['product_group']);
		
		$sQl = "INSERT INTO `cms_products` (`parent_id`,`name`,`sef_name`,`group`,`formula`,`weight`,`cas_number`,`details`,`date_added`) VALUES (".$var['productList'].",'".mysql_real_escape_string($var['product_name'])."','".$var['sef_title']."','".$product_groups."','".$var['product_formula']."','".$var['product_weight']."','".$var['product_cas_no']."','".mysql_real_escape_string($var['product_details'])."',NOW())";

		$result = $db->query($sQl);
		if ($result) {
			$productId = $db->insert_id;
			$this->message = "Product ".$var['product_name']." added successfully.";
			return true;
			} else {
				$this->error = "Could not add the product. Try again.";
				return false;
				}
	}
	
	// function to edit the product
	function edit_product($var){
		global $db;
		if(!is_array($var) || empty($var)){ 
			$this->error = "Invalid parameter to add the product."; 
			return false;
		}
		
		$product_groups = implode(',', $var['product_group']);
		
		$sQl = "UPDATE `cms_products` SET 
					`parent_id` = '".$var['productList']."',
					`name` = '".mysql_real_escape_string($var['product_name'])."',
					`sef_name` = '".$var['sef_title']."',
					`group` = '".$product_groups."',
					`formula` = '".$var['product_formula']."',
					`weight` = '".$var['product_weight']."',
					`cas_number` = '".$var['product_cas_no']."',
					`details` = '".mysql_real_escape_string($var['product_details'])."',
					`date_modified`	= NOW()
				WHERE `id` = ".$var['productId'];
				
		$result = $db->query($sQl);
		if($result){
			$this->message = "Product ".$var['Product_name']." updated successfully";
			return $result;
			} else {
				return false;
		}	
	}
	
	function add_product_tests($var){
		global $db;
		$productId = $var['productId'];
		
		#check if there are products posted
		if (!sizeof($var['product_test'])){
			#no data added
			$this->error = "No new tests added";
			return false;
		}
		
		#create sql statemenet to add the tests
		$valueArray = array();
		$sQl = "insert into cms_product_tests (`product_id`,`product_test`,`test_specification`,`test_reference`) VALUES ";
		foreach($var['product_test'] as $k=>$v){
			$tmp = "('".$var['productId']."','".mysql_real_escape_string($var['product_test'][$k])."','".mysql_real_escape_string($var['product_specification'][$k])."','".mysql_real_escape_string($var['product_reference'][$k])."')";
			array_push($valueArray,$tmp);
		}
		$nSql = $sQl.implode(",",$valueArray);
		
		//print_r($nSql); exit;
		
		#truncate existing tests from the table
		$delete = $db->query("delete from cms_product_tests where product_id = '".$productId."'");
		
		#add to database
		$result = $db->query($nSql);
		if ($result){
			$this->message = "Tests and Specifications successfully added.";
			return true;
		} else {
			$this->error = "Cannot add Tests and Specifications.";
			return false;
		}
	
	
	}
	
	// Funciton to get the details of a product
	function get_product_details($id){
		global $db;
		$sQl = "SELECT * FROM `cms_products` WHERE `id` = ".$id;
		$result = $db->get_row($sQl);
		if($result){
			return $result;
			}  else {
				$this->error = "Could not find the product details.";
				return false;
		}
	}
	
	// Funciton to get the product test details
	function get_product_specification($id){
		global $db;
		$sQl = "SELECT * FROM `cms_product_specification` WHERE `product_id` = ".$id;
		$result = $db->get_results($sQl,ARRAY_A);
		if($result){
			return $result;
			} else {
				$this->error = "Could not find any product test details.";
				return false;
		}
	}
	
	function get_product_tests(){
		global $db;
		$sQl = "select * from cms_product_tests where product_id = '".$this->productId."' order by id ASC";
		$result = $db->get_results($sQl,ARRAY_A);
		if ($result){
			return $result;
		} else {
			return false;
			}
	}
	
	function check_latest($id){
		global $db;
		$sQl = "select latest from cms_products where id = '".$id."'";	
		$result = $db->get_var($sQl);
		return $result;
	}
	
	function change_status($status = 'mark'){
		global $db;
		if ($status == 'mark') { $change = 1; }
		else if ($status == 'unmark') { $change = 0; }
		
		$sQl = "update cms_products set latest = '".$change."' where id = '".$this->productId."'";

		$result = $db->query($sQl);
		
		if ($result){
			$this->message = "Status Updated successfully";
			return true;
		} else {
			$this->error = "Cannot update status";
			return false;
			}
	}
	
	function delete(){
		global $db;
		#get the product details
		$productDet = $this->get_product_details($this->productId);
			
		#delete from the products main table
		$sQl = "delete from cms_products where id = '".$this->productId."'";
		$result = $db->query($sQl);
		if ($result){
			$sQl = "delete from cms_product_tests where product_id = '".$this->productId."'";
			$results = $db->query($sQl);
			$this->message = "Product details of ".$productDet->name." deleted successfully.";
			return true;
		} else {
			$this->error = "Product details of ".$productDet->name." cannot be deleted.";		
			return false;
		}
	}	
	
}
?>