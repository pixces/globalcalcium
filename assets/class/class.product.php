<?php
class Product{
	public $product_id;
	public $error;
	public $message;
	public $sef = false;
	public $search_term;
	
	public function __construct($id = NULL){
		if(!empty($id) && is_numeric($id)){
			$this->product_id = $id;
		}
		
		#set the sef from config
		global $config;
		if ($config['sef_url']){
			$this->sef = true;
		}
	}
	
	
	public function get_product_list($all = false){
		
		$productList = array();
		
		$mainList = $this->get_list();
		foreach($mainList as $product){
			$id = $product['id'];
			
			if ($this->get_list($id)){
				$product['sub'] = $this->get_list($id);
			}	
			array_push($productList,$product);
		}
		return $productList;
	}
	
	
	public function get_list($parent_id=0){
		global $db;
		$sQl = "Select * from cms_products where parent_id = '".$parent_id."' order by name ASC";
		$list = $db->get_results($sQl);
		
		if ($list){
			#format this list to get
			#a keyvalue pair with id,name,sef
			$listArray = array();
			
			foreach($list as $product){
			
				if ($this->sef){
					$href = SITE_ROOT."products/".$product->sef_name;
				} else {
					$href = SITE_ROOT."products.php?id=".$product->id;
				}
			
				array_push($listArray, array(
								'id'=>$product->id,
								'name'=>$product->name,
								'sef'=>$product->sef_name,
								'url'=>$href
								));
			}
			return $listArray;
		} else {
			return false;
		}
	}
	
	
	function get_product_detail(){
		global $db;
		
		#first get the basic details
		#then get all the tests
		
		$sQl = "select * from cms_products p where p.id = '".$this->product_id."'";
		$result = $db->get_row($sQl,ARRAY_A);
		
		if (!$result) { return false; }
		$product = $result;
		$tests = $this->get_product_tests();
		if ($tests){
			$product['tests'] = $tests;
		}
		return $product;
	}
	
	function get_product_tests(){
		global $db;
		$sQl = "select * from cms_product_tests where product_id = '".$this->product_id."' order by id ASC";
		$result = $db->get_results($sQl,ARRAY_A);
		if ($result){
			return $result;
		} else {
			return false;
			}
	}
	
	
	function get_latest_products($limit = NULL){
		global $db;
		
		$sQl = "select * from cms_products where latest != 0 order by name ASC";
		
		if (!is_null($limit)){
			$sQl .= " limit ".$limit; 
		}
		
		$result = $db->get_results($sQl);
		
		if ($result){
			return $result;
			} else {
				return false;
				}	
	}
	
	function get_page_content($sef = null){
		global $db;
		
		$sQl = "select * from cms_content where content_sef_title = '".$sef."'";
		
		$result = $db->get_row($sQl);
		if ($result){
			return $result;
		} else {
			return false;
			}
	}
	
	/*
	Function to search among product titles
	with the term provided
	if term is provided it will override
	the search term class variable
	*/
	function search_by_title($term = null){
		
		if (!is_null($term)){
			$this->search_term = $term;
		}
	
		if (!$this->search_term){ return false; }
		
		global $db;
		
		$sQl = "select id,name,sef_name from cms_products where name like '%".$this->search_term."%' order by parent_id ASC";
		$result =$db->get_results($sQl);
		if ($result){
			$productList = array();
			foreach($result as $product){
				if ($this->sef){
					$href = SITE_ROOT."products/".$product->sef_name;
				} else {
					$href = SITE_ROOT."products.php?id=".$product->id;
				}
				
				array_push($productList, array(
								'id'=>$product->id,
								'name'=>$product->name,
								'sef'=>$product->sef_name,
								'url'=>$href
								));
			
			}
			

			return $productList;
		} else {
			return false;
			}
	}
	
	
	function map_sef2id($sef){
		global $db;
		$sef = strtolower($sef);
		
		$sQl = "select id from cms_products where sef_name = '".$sef."'";
		$result = $db->get_var($sQl);
		if ($result){
			return $result;
		} else {
			return false;
			}		
	}
	
	function products_in_vertical($sef = null){
		global $db;
		if (is_null($sef)) { return false; }
		
		$sQl = "SELECT *
					FROM `cms_products`
					WHERE `group` LIKE '%".strtolower($sef)."%' order by name ASC";
		$list = $db->get_results($sQl);
		if ($list){
			
				#format this list to get
				#a keyvalue pair with id,name,sef
				$listArray = array();
				
				foreach($list as $product){
				
					if ($this->sef){
						$href = SITE_ROOT."products/".$product->sef_name;
					} else {
						$href = SITE_ROOT."products.php?id=".$product->id;
					}
				
					array_push($listArray, array(
									'id'=>$product->id,
									'name'=>$product->name,
									'sef'=>$product->sef_name,
									'url'=>$href
									));
				}
				return $listArray;			
			
			
			
			} else {
				return false;
				}
	}
	
/* end */
}
?>