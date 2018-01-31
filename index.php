<?php
ini_set('display_errors', 0);
error_reporting(E_ALL);
session_start();

require 'config.php';
//require 'config/config.php';
require 'lib/class.config_db.php';
require 'lib/database.php';
require 'lib/pagination.php'; 
require 'products.php';

define('NO_OF_RECORDS_PER_PAGE', '6');  

global $products;
$invalidPage = false;
$productsClass = new Prodcuts();
$pagination_obj = new Pagination();

// Get all products count
$total_products_count = $productsClass->getAllProductsCount();
// Get all products
$products = $productsClass->getAllProducts();
// Start the pagination
$pagination = $pagination_obj->generate_pagination($total_products_count, $_SERVER['REQUEST_URI'], NO_OF_RECORDS_PER_PAGE);				
$tot_page_count = ceil($total_products_count/NO_OF_RECORDS_PER_PAGE);				
// If no records found or no pages found
$page = (isset($_GET['page'])) ? $_GET['page'] : 1;
if (($page > $tot_page_count) || ($page == 0)){
	$invalidPage = true;	
}
// Geth the page content
$sql = "SELECT * FROM pages WHERE page_id = 1";
$pageContent = $DBConn->return_mysql_fetched_results_to_single_array($DBConn->execute_query($sql), array('page_id', 'heading', 'heading_image', 'banner_image', 'page_title', 'page_content', 'meta_keywords', 'meta_description'));
$html_title	= stripcslashes($pageContent['page_title']);
$heading = stripcslashes($pageContent['heading']);
$heading_image = stripcslashes($pageContent['heading_image']);
$main_content = stripcslashes($pageContent['page_content']);
$banner_image = stripcslashes($pageContent['banner_image']);
$meta_keywords = stripcslashes($pageContent['meta_keywords']);
$meta_description = stripcslashes($pageContent['meta_description']);

if ("POST" == $_SERVER['REQUEST_METHOD']){
	if (
		(empty($_POST['cart_details']['quantityPerDozenPrice'])) ||
		(!isset($_POST['cart_details']['quantityPerDozenPrice'])) ||
		($_POST['cart_details']['quantityPerDozenPrice'] == "")
	   ){
	   		$errorMessage = true;
	}else if (
			(empty($_POST['cart_details']['quantityPerDozen'])) ||
			(!isset($_POST['cart_details']['quantityPerDozen'])) ||
			(trim($_POST['cart_details']['quantityPerDozen']) == "")		
   			){
			$errorMessageInQunatityPerDozen = true;	   		
	}else if (!is_numeric(trim($_POST['cart_details']['quantityPerDozen']))){
			$InvalidValInQunatityPerDozen = true;	   		
	}else{
			$_SESSION['cart_details'][$_POST['cart_details']['quantityPerDozenProductId']][$_POST['cart_details']['quantityPerDozenWeight']][] = array(
												'product_qty' => mysql_preperation(trim($_POST['cart_details']['quantityPerDozen'])),
												'product_weight' => $_POST['cart_details']['quantityPerDozenWeight'],
												'product_price' => $_POST['cart_details']['quantityPerDozenPrice']
											   );
			header('Location: cart.php');
	}
}
include LAYOUT_PATH.'index.html';