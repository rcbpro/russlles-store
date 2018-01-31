<?php
ini_set('display_errors', 0);
error_reporting(E_ALL);

session_start();
require 'config.php';
require 'lib/class.config_db.php';
require 'lib/database.php';
require 'products.php';
global $products;

$productsClass = new Prodcuts();

$sql = "SELECT * FROM pages WHERE page_id=1";
$pageContent = $DBConn->return_mysql_fetched_results_to_single_array($DBConn->execute_query($sql), array('page_id', 'heading', 'heading_image', 'banner_image', 'page_title', 'page_content', 'meta_keywords', 'meta_description'));
$html_title	= stripcslashes($pageContent['page_title']);
$heading = stripcslashes($pageContent['heading']);
$heading_image = stripcslashes($pageContent['heading_image']);
$main_content = stripcslashes($pageContent['page_content']);
$banner_image = stripcslashes($pageContent['banner_image']);
$meta_keywords = stripcslashes($pageContent['meta_keywords']);
$meta_description = stripcslashes($pageContent['meta_description']);

if ("POST" == $_SERVER['REQUEST_METHOD']){
	// This is for the updation of some orders
	if (isset($_POST['updateOrderButton'])){
		$_SESSION['cart_details'] = $_POST['cart_details'];		
	}	
	// This is for the deletion of some orders
	if (isset($_POST['checkboxRemoveItem'])){	

		// Remove the current items 
		foreach($_POST['checkboxRemoveItem'] as $eachRemoveProductKey => $eachRemoveProductDetails){			
			foreach($eachRemoveProductDetails as $eachWeightKey => $eachWeightDetails){
				unset($_SESSION['cart_details'][$eachRemoveProductKey][$eachWeightKey][key($eachWeightDetails)]);
				if (empty($_SESSION['cart_details'][$eachRemoveProductKey][$eachWeightKey])){
					unset($_SESSION['cart_details'][$eachRemoveProductKey][$eachWeightKey]);
					if (empty($_SESSION['cart_details'][$eachRemoveProductKey])){
						unset($_SESSION['cart_details'][$eachRemoveProductKey]);						
					}
				}
			}
		}
		if ((!isset($_SESSION['cart_details'])) || (empty($_SESSION['cart_details']))){
			unset($_SESSION['totalCartExp']);
		}
	}
}
include LAYOUT_PATH.'cart.html';