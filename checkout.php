<?php
ini_set('display_errors', 0);
error_reporting(E_ALL);
session_start();
if ((!isset($_SESSION['cart_details'])) || (empty($_SESSION['cart_details']))){
	header('Location: index.php');	
	exit();
}
require 'config.php';
require 'lib/class.config_db.php';
require 'lib/database.php';
require_once 'lib/anet_php_sdk/AuthorizeNet.php'; 

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
	if (isset($_POST['checkoutdetails'])){
		$errors = errorCheckingFields($_POST['checkoutdetails']);
		if ($errors['errorStatus'] == 0){
			$transaction = new AuthorizeNetAIM(API_LOGIN_ID, API_TRANSACTION_KEY);
			if ((isset($_SESSION['cart_details'])) && (isset($_SESSION['totalCartExp']))){
				$total_price = $_SESSION['totalCartExp'];		
			}else{
				$error_message_in_cart = true;				
			}
			/*	
			$transaction->amount = $total_price;
			$transaction->card_num = mysql_preperation($_POST['checkoutdetails']['ccnumber']);
			$transaction->exp_date = $_POST['checkoutdetails']['expiry_date'];
			*/
			$transaction->setFields(
									array(
										'amount' => $total_price, 
										'card_num' => mysql_preperation($_POST['checkoutdetails']['credit_card_number']), 
										'exp_date' => $_POST['checkoutdetails']['expiry_date'],
										'card_code' => mysql_preperation($_POST['checkoutdetails']['cc_number'])
										)
									);
			$response = $transaction->authorizeAndCapture();
			
			if ($response->approved){
				header('Location: thankyou.php');			
			}else{
				$error_message_in_payment = $response->error_message;
			}
		}else{
			$error_message = true;
		}
	}
}
include LAYOUT_PATH.'checkout.html';