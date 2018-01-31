<?php

ini_set('display_errors', 0);
error_reporting(E_ALL);
session_start();

require 'config.php';
//require 'config/config.php';
require 'lib/class.config_db.php';
require 'lib/database.php';
require 'products.php';

switch($_GET['action']){

	case "getSelectedPrice":
		if (!empty($_GET['priceId'])){
			$sql = "SELECT product_id, loaf_type, price FROM products_prices WHERE id = ".$_GET['priceId'];
			echo json_encode($DBConn->return_mysql_fetched_results_to_single_array($DBConn->execute_query($sql), array('product_id', 'loaf_type', 'price')));
		}
	break;
}