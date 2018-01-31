<?php
session_start();
if ((!isset($_SESSION['billing_details'])) || (empty($_SESSION['billing_details']))){
	header('Location: index.php');	
	exit();
}
require 'config.php';
require 'lib/class.config_db.php';
require 'lib/database.php';
require 'products.php';
global $products;

$productsClass = new Prodcuts();

if ((isset($_SESSION['cart_details'])) && (!empty($_SESSION['cart_details']))):
	$cartOrderDetails = "";
	$cartOrderDetails .= "<table width='510' border='0' cellspacing='0' cellpadding='0' class='cart-table'>";
	$cartOrderDetails .= "<tr class='table-header'>";
	foreach($_SESSION['cart_details'] as $productKey => $productCartDetails):
		$cartOrderDetails .= "<tr class='table-row'>
								<td width='360'>";
		$productDetails = $productsClass->getProductDetailsById($productKey);
		$cartOrderDetails .= "<br /><h3><strong>".$productDetails['product_name']."</strong></h3>";	
		$cartOrderDetails .= "
		<table width='360px' border='0' cellpadding='0' cellspacing='0'>
			<thead>
				<th align='center' colspan='2'>&nbsp;&nbsp;Weight</th>
				<th colspan='3' align='center'>Shipping Charges</th>                                            
			</thead>";
			foreach($productCartDetails as $eachWeightKey => $eachWeightDetails):
				$qty = 0;
				foreach($eachWeightDetails as $eachDetail):
					$qty += $eachDetail['product_qty'];											                                                                     	
				endforeach;
		$cartOrderDetails .= "			
				<tr>
					<td>
						&nbsp;&nbsp;<span class='cart-table'>(".$eachDetail['product_weight']." ) : 
					</td>
					<td>
						 ($".$eachDetail['product_price']." X ".$qty." = $".sprintf('%01.2f', ($eachDetail['product_price'] * $qty)).")</span>
					</td>	
					<td>&nbsp;&nbsp;<strong>+</strong>&nbsp;&nbsp;</td>
					<td align='center'>";
				if (($eachDetail['product_weight'] == "3lb") || ($eachDetail['product_weight'] == "3lb_Refill_Bag")):
		$cartOrderDetails .= "($".SHIPPING_CHARGES_OPT2 . " X " . $qty . "</td><td align='left'> =&nbsp;&nbsp;$" .sprintf('%01.2f', (SHIPPING_CHARGES_OPT2 * $qty)).")";
				else:
		$cartOrderDetails .= "($".SHIPPING_CHARGES_OPT1 . " X " . $qty . "</td><td align='left'> =&nbsp;&nbsp;$" .sprintf('%01.2f', (SHIPPING_CHARGES_OPT1 * $qty)).")";                                        
				endif;
		$cartOrderDetails .= "				
					</td>
				</tr>";
			endforeach;
$cartOrderDetails .= "
			</table>";
	endforeach;			
endif;	

$cartOrderDetails .= "<br />Total = $" . sprintf('%01.2f', ($_SESSION['totalCartExp']));

$sql = "SELECT * FROM pages WHERE page_id=1";
$pageContent = $DBConn->return_mysql_fetched_results_to_single_array($DBConn->execute_query($sql), array('page_id', 'heading', 'heading_image', 'banner_image', 'page_title', 'page_content', 'meta_keywords', 'meta_description'));
$html_title	= stripcslashes($pageContent['page_title']);
$heading = stripcslashes($pageContent['heading']);
$heading_image = stripcslashes($pageContent['heading_image']);
$main_content = stripcslashes($pageContent['page_content']);
$banner_image = stripcslashes($pageContent['banner_image']);
$meta_keywords = stripcslashes($pageContent['meta_keywords']);
$meta_description = stripcslashes($pageContent['meta_description']);

// Mail sending to the customer
$to      = "Info@mrsrussells.com";
$subject = "Transaction Success";
$message = "Hi, \r\n Your transaction has been done. Thank you!.";
$headers = "From: Info@mrsrussells.com" . "\r\n" .
		   "Reply-To: Info@mrsrussells.com" . "\r\n" .
		   "X-Mailer: PHP/" . phpversion();
mail($to, $subject, $message, $headers);
// Mail sending to the merchant regarding the customer billing and shipping details
if (isset($_SESSION['billing_details'])){
	$to      = $_SESSION['billing_details']['billing_email'];
	$subject = "Transaction Success - Billing Information";
	$message = "Hi, \r\n Last transaction has been done. Following are billing information. Thank you!.";
	$message .= "\r\n Name : ".$_SESSION['billing_details']['billing_name'];	
	$message .= "\r\n Address : ".$_SESSION['billing_details']['billing_address'];	
	$message .= "\r\n City : ".$_SESSION['billing_details']['billing_city'];	
	$message .= "\r\n State : ".$_SESSION['billing_details']['billing_state'];	
	$message .= "\r\n Zip Code : ".$_SESSION['billing_details']['billing_zip_code'];	
	$message .= "\r\n Telephone number : ".$_SESSION['billing_details']['billing_telno'];	
	$message .= "\r\n Here is the last transaction order details : <br /><br />".$cartOrderDetails;							
	$headers = "From: Info@mrsrussells.com" . "\r\n" .
			   "Reply-To: Info@mrsrussells.com" . "\r\n" .
			   "X-Mailer: PHP/" . phpversion();
	mail($to, $subject, $message, $headers);
	unset($_SESSION['billing_details']);
}
if (isset($_SESSION['billing_and_shipping_details'])){
	$to      = $_SESSION['billing_and_shipping_details']['billing_email'];
	$subject = "Transaction Success - Billing Information";
	$message = "Hi, \r\n Last transaction has been done. Following are billing information.";
	$message .= "\r\n Name : ".$_SESSION['billing_and_shipping_details']['billing_name'];	
	$message .= "\r\n Address : ".$_SESSION['billing_and_shipping_details']['billing_address'];	
	$message .= "\r\n City : ".$_SESSION['billing_and_shipping_details']['billing_city'];	
	$message .= "\r\n State : ".$_SESSION['billing_and_shipping_details']['billing_state'];	
	$message .= "\r\n Zip Code : ".$_SESSION['billing_and_shipping_details']['billing_zip_code'];	
	$message .= "\r\n Telephone number : ".$_SESSION['billing_and_shipping_details']['billing_telno'];						
	$message .= "\r\n";		
	$message = "Hi, \r\n Following are shipping information. Thank you!.";	
	$message .= "\r\n Name : ".$_SESSION['billing_and_shipping_details']['shipping_name'];	
	$message .= "\r\n Address : ".$_SESSION['billing_and_shipping_details']['shipping_address'];	
	$message .= "\r\n City : ".$_SESSION['billing_and_shipping_details']['shipping_city'];	
	$message .= "\r\n State : ".$_SESSION['billing_and_shipping_details']['shipping_state'];	
	$message .= "\r\n Zip Code : ".$_SESSION['billing_and_shipping_details']['shipping_zip_code'];	
	$message .= "\r\n Telephone number : ".$_SESSION['billing_and_shipping_details']['shipping_telno'];							
	$message .= "\r\n Here is the last transaction order details : <br /><br />".$cartOrderDetails;									
	$headers = "From: Info@mrsrussells.com" . "\r\n" .
			   "Reply-To: Info@mrsrussells.com" . "\r\n" .
			   "X-Mailer: PHP/" . phpversion();
	mail($to, $subject, $message, $headers);
	unset($_SESSION['billing_and_shipping_details']);
}

$_SESSION['mail_sent'] = 'ok';
//header('Location: contact_us.php');						
include LAYOUT_PATH.'thankyou.html';
?>