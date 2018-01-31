<?php
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
	if (isset($_POST['contactus'])){
		$errors = errorCheckingFields($_POST['contactus']);
	}else if (checkEmail($_POST['contactus']['email'])){
		$errors['email'] = "email";
		$error_message = true;
	}
	if (empty($errors['errorFields'])){
		  $to      = 'Info@mrsrussells.com';
		  $subject = mysql_preperation($_POST['contactus']['subject']);
		  $message = mysql_preperation($_POST['contactus']['message']);
		  $headers = "From: {$_POST['contactus']['email']}" . "\r\n" .
					 "Reply-To: Info@mrsrussells.com" . "\r\n" .
					 "X-Mailer: PHP/" . phpversion();
		  mail($to, $subject, $message, $headers);
		  $_SESSION['mail_sent'] = 'ok';
		  header('Location: contact_us.php');						
	}else{
		$error_message = true;
	}
	
}
include LAYOUT_PATH.'contact_us.html';