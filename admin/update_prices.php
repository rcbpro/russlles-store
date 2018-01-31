<?php
ini_set('display_errors', 1);
error_reporting(E_ALL ^ E_WARNING ^ E_NOTICE);
require_once("../config.php");
require_once("../lib/class.config_db.php");
require_once("../lib/database.php");
require_once("../lib/functions.php");
if ("POST" == $_SERVER['REQUEST_METHOD']){
	$sql = "UPDATE products_prices SET price = '".$_POST['value']."' WHERE id = ".$_POST['id'];
	if ($DBConn->execute_query($sql)){
		$sql = "SELECT price FROM products_prices WHERE id = ".$_POST['id'];	
		echo $DBConn->return_single_result($DBConn->execute_query($sql));
	}
}