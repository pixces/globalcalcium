<?php
require_once("config.inc.php");

$term = $_GET['query'];

#get search result from the product table
$productObj = new Product;
$productObj->search_term = $term;

$productList = $productObj->search_by_title();

$matchCount = count($productList);

$sidebar = "home-sidebar.html";
$content = "search_result.html";
require_once("loadTemplate.php");

?>