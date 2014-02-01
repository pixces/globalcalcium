<?php
if (file_exists("config.inc.php"))
	{
	require_once("config.inc.php");
	} else {
		die ("cannot initialize configuration");
		}


//check for loggedIn 
isLoggedIn();

$type =(!empty($_GET['type'])) ? $_GET['type'] : "list";

switch($type){
	case 'list':
		$productsObj = new Products();
		//get the list of all products
		//$productList = $productsObj->display_products();
		//print_r($productList);	
		$productList = $productsObj->get_link_array( NULL, TRUE );
		
		//create a single dimension list of this whole
		$list = array();
		foreach($productList as $product){
			$latest = $productsObj->check_latest($product['id']);
			$list[] = array(
						'id'=>$product['id'],
						'name'=>$product['name'],
						'latest'=>$latest
						);
			if ($product['sub']){
				foreach($product['sub'] as $sub){
					$latest = $productsObj->check_latest($sub['id']);
					$list[] = array(
								'id'=>$sub['id'],
								'name'=>"&nbsp;&nbsp;--".$sub['name'],
								'latest'=>$latest
							);
				}
			}
		}
		
		if(!empty($list))
			{
			$smarty->assign('productList',$list);
			$smarty->assign('products_count',count($list));
			}
		else
			{
			$_SESSION['error'] = $productsObj->error;			
			}
		
		$contentFile = "product_list.html";
		$sectionTitle = "Product List";
		
	break;
	
	case 'add':	
		$productsObj = new Products();
		if($_POST && $_POST['mm_action'] == 'doAdd'){
			
			$data = $_POST;
			$addProduct = $productsObj->add_product($data);
			
			if($addContent){
				$_SESSION['message'] = $productsObj->message;
				header("location:products.php");
				exit;
				} else {
				echo $productsObj->error;
				$_SESSION['error'] = $productsObj->error;
				header("location:products.php");
				exit;
			}
		}
		
		//$linkList = $linkObj->display_link(1);
		$ProductGroupList = $productsObj->getProductListFormated();
		//print_r($ProductGroupList); exit;
		if($ProductGroupList) {
				$smarty->assign('ProductGroupList',$ProductGroupList);
			} else {
				$_SESSION['error'] = "Product category list are empty";
		}
		global $product_groups;
		$smarty->assign('product_groups',$product_groups);
		
		$contentFile = "product_add.html";
		$sectionTitle = "Add Product";
		
		$smarty->assign('formName','Add');		// Assigning smarty var for Form title and button name
		$smarty->assign('action','doAdd');		// Assigning a var for hidden value in html file to decide whether Add or Edit
		$smarty->assign('disable','');	// Assigning a var to make the drop down disabled while editing
		
	break;
	
	case 'tests':	
			
		if ($_POST){
			//add to database
			$productObj = new Products;
			$addTests = $productObj->add_product_tests($_POST);
			if($addTests){
					$_SESSION['message'] = $productsObj->message;
					header("location:products.php");
					exit;
				} else {
					echo $productsObj->error;
					$_SESSION['error'] = $productsObj->error;
					header("location:products.php");
					exit;
					}
		}
		
		$id = $_GET['id'];
		$productsObj = new Products($id);
		$productTestDet = $productsObj->get_product_tests();	
		
		if ($productTestDet){
			$smarty->assign('product_test_count',count($productTestDet));
		} else {
			$smarty->assign('product_test_count',0);
		}
		
		$smarty->assign('productId',$id);		
		$smarty->assign('productTestDet',$productTestDet);
		$contentFile = "product_test.html";
		$sectionTitle = "Add/Edit Product Specifications";
		$smarty->assign('formName','Edit');
		$smarty->assign('action','doAddTest');		
		$smarty->assign('disable','');
		
	break;
	
	case 'edit':	
		$productsObj = new Products();
		if($_POST && $_POST['mm_action'] == 'doEdit'){
			$data = $_POST;
			$editContent = $productsObj->edit_product($data);
			if($editContent){
					$_SESSION['message'] = $productsObj->message;										
					header("location: products.php");
					exit;
				} else {
					$_SESSION['error'] = $productsObj->error;
			}
		}
		
		$id = $_GET['id'];
		$productDet = $productsObj->get_product_details($id);	
				
		if($productDet){	
			$smarty->assign('productDet',$productDet);			
		}
		
		$ProductGroupList = $productsObj->getProductListFormated($all = TRUE);
		//print_r($ProductGroupList); exit;
		global $product_groups;
		$smarty->assign('product_groups',$product_groups);
		$smarty->assign('groups',explode(",",$productDet->group));
		
		$contentFile = "product_add.html";
		$sectionTitle = "Edit Product Details";
		$smarty->assign('ProductGroupList',$ProductGroupList);
		$smarty->assign('formName','Edit');		// Assigning smarty var for Form title and button name
		$smarty->assign('action','doEdit');		// Assigning a var for hidden value in html file to decide whether Add or Edit
		$smarty->assign('disable','');	// Assigning a var to make the drop down disabled while editing
		
	break;
	
	case 'delete':
	
		$id = $_GET['id'];
		$productsObj = new Products($id);
		$delProduct = $productsObj->delete();	
		
		if( $delProduct ) {
				$_SESSION['message'] = $productsObj->message;
				header("location: products.php");
				exit;
				} else {
					$_SESSION['error'] = $productsObj->error;
		}					
	break;
	
	case 'status':
		$id = $_GET['id'];
		$status = $_GET['change'];
		$productsObj = new Products($id);
		if ( $productsObj->change_status($status) ){
			$_SESSION['message'] = $productsObj->message;
			header("location:products.php");
		} else {
			$_SESSION['error'] = $productsObj->error;
			header("location:products.php");
			}
		exit;
	break;
}


//to start working

if ($_SESSION['error'])
	{
	$error = $_SESSION['error'];
	unset($_SESSION['error']);
	}

if ($_SESSION['message'])
	{
	$message = $_SESSION['message'];
	unset($_SESSION['message']);
	}	
	
if ($error) { $smarty->assign('error',$error); }
if ($message) { $smarty->assign('message',$message); }

//display the left naivgation and 
//ask the admin to click on any of the link 
//to start working

$smarty->assign('contentFile',$contentFile);
$smarty->assign('sectionTitle',$sectionTitle);
$smarty->assign('bodyFile','frame.html');
$smarty->display('index.tpl');
?>