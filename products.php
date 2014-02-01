<?php
/**
* basic bootstraping
*/
require_once("config.inc.php");

if ($_GET){
	if ($_GET['sef']){
		if ( ($_GET['sef'] == 'all') || ($_GET['sef'] == 'latest') ) {
			$type = $_GET['sef'];
		} else {
			$type = 'product';
			$sef = $_GET['sef'];
		}
	} else if ($_GET['id']){
		$type = 'product';
		$id = $_GET['id'];
	} else {
		$type = 'all';
	}
}	

/* list sizes */
$prod_specification = true;
$prod_tests = true;
$prod_details = true;
$prod_list = false;

switch($type){
	case 'all':
		//get the list of all products
		$productObj = new Product();
		$productList = $productObj->get_product_list();
		
		#get product meta info
		$meta = get_meta_info();

		#page to display data on
		$section = "all";
		$title = "Product List";	
		$pageName = "products.html";
		break;
	case 'product':
		$section = "details";
		if (isset($sef)){
			$id = Product::map_sef2id($sef);
		} 
		
		#get the product details of this product id
		#along with all the test associated to the product
		$productObj =  new Product($id);
		$productDet = $productObj->get_product_detail();
		
		$prod_specification = $productDet['formula'] ? true : false;
		$prod_tests  = $productDet['tests'] ? true : false;
		$prod_details = $productDet['details'] ? true : false;
		
		//get the list of addl. products
		$productList = $productObj->get_list($id);
		$prod_list =  ($productList !== false) ? true : false;
		
		#get product meta info
		$meta = get_meta_info($id,'products');
				
		$title = $productDet['name'];
		$pageName = "products.html";
		break;
	case 'latest':
		$productObj = new Product;
		$latestProducts = $productObj->get_latest_products();
		$latestPage = $productObj->get_page_content('latest');
		
		#get product meta info
		$meta = get_meta_info();

		$title = "Our Latest Products";
		$section = "latest_products";
		$pageName = "products.html";
		break;
}


$sidebar = "home-sidebar.html";
$content = $pageName;
require_once("loadTemplate.php");
?>