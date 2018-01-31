<?php
session_start();
if ((!isset($_SESSION['cart_details'])) || (empty($_SESSION['cart_details']))){
	header('Location: index.php');	
	exit();
}
require 'config.php';
require 'lib/class.config_db.php';
require 'lib/database.php';

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
	if ((isset($_POST['billingDetails'])) && (!$_POST['shippingAddressCheckBox'])){
		$errors = errorCheckingFields($_POST['billingDetails']);
		if (empty($errors['errorFields'])){			
			$_SESSION['billing_details'] = $_POST['billingDetails'];
			header('Location: checkout.php');						
		}else{
			$error_message = true;
		}
	}elseif ((isset($_POST['billingDetails'])) && ($_POST['shippingAddressCheckBox'])){
		$errors1 = errorCheckingFields($_POST['billingDetails']);	
		$errors2 = errorCheckingFields($_POST['shippingDetails']);
		$errors3 = array_merge($errors1['errorFields'], $errors2['errorFields']);
		if (empty($errors['errorFields'])){
			$_SESSION['billing_and_shipping_details'] = array_merge($_POST['billingDetails'], $_POST['shippingDetails']);		
			header('Location: checkout.php');						
		}else{
			$error_message = true;
		}
	}
}
include LAYOUT_PATH.'billing.html';