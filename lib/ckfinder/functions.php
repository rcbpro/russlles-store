<?php

function add_to_cart($product, $qty){

	$i = 0;
	$was_found = false;
	if ((!isset($_SESSION['shopping_cart'])) || (count($_SESSION['shopping_cart']) < 1)){
		$_SESSION['shopping_cart'] = array(
											1 => array(
														"product_id" => $product['product_id'], 
														"product_qty" => $qty, 
														"product_name" => $product['product_name'], 
														"product_desc" => $product['product_desc'],
														"product_image" => $product['product_image'],
														"product_price" => $product['product_price']														
													  )
										  );
	}else{
		foreach($_SESSION['shopping_cart'] as $eachSet){
			$i++;
			while(list($key, $value) = each($eachSet)){
				if (($key == "product_id") && ($value == $product['product_id'])){
					array_splice($_SESSION['shopping_cart'], $i - 1, 1, 
								array(
									array(
											"product_id" => $product['product_id'], 
											"product_qty" => $eachSet['product_qty'] + $qty,
											"product_name" => $product['product_name'], 
											"product_desc" => $product['product_desc'],
											"product_image" => $product['product_image'],
											"product_price" => $product['product_price']														
										 )
									 )
								);
					$was_found = true;
				}
			}	
		}
		if (!$was_found){
			array_push($_SESSION['shopping_cart'], 
						array(
								"product_id" => $product['product_id'], 
								"product_qty" => $qty,
								"product_name" => $product['product_name'], 
								"product_desc" => $product['product_desc'],
								"product_image" => $product['product_image'],
								"product_price" => $product['product_price']														
							 )
						);
		}
	}
}

function total_items($cart){

	$num_items = 0;	
	if(is_array($cart)){
		foreach($cart as $id => $qty){
			$num_items += $qty;
		}	
	}
	return $num_items;
}

function total_price($cart){

	$price = 0.0;
	if (is_array($cart)){
		foreach($cart as $eachCart){
			$price += $eachCart['product_price'] * $eachCart['product_qty'];
		}
	}	
	return $price;
}	

/* This function will prepare the value entered by the user to put it in to the database */
function mysql_preperation($value){		

	$magic_quotes_active = get_magic_quotes_gpc();
	$new_enough_php = function_exists("mysql_real_escape_string"); 
	// i.e. PHP >= v4.3.0
	if ($new_enough_php){ 
		// PHP v4.3.0 or higher
		// undo any magic quote effects so mysql_real_escape_string can do the work
		if ($magic_quotes_active){ 
			$value = stripslashes($value); 
		}
		$value = mysql_real_escape_string($value);
	}else{ 
		// before PHP v4.3.0
		// if magic quotes aren't already on then add slashes manually
		if (!$magic_quotes_active){ 
			$value = addslashes( $value ); 
		}
		// if magic quotes are active, then the slashes already exist
	}
	return $value;
}
/* End of the function */

function errorCheckingFields($fieldsArray = array()) {

	$errorFieldsArray = array();
	$errorsFound = true;
	foreach($fieldsArray as $field => $value) {
		if ((isset($value)) && (!empty($value)) && ($value != '') && ($value != NULL)) $errorsFound = 'false';
		else $errorFieldsArray[] = $field;
	}
	return array('errorStatus' => $errorsFound, 'errorFields' => $errorFieldsArray);
}

function checkEmail($email) {
	
   if (preg_match("/[a-zA-Z0-9_-.+]+@[a-zA-Z0-9-]+.[a-zA-Z]+/", $email) > 0) return true;
   else return false;
}