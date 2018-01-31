<?php 

session_start();
header("Cache-control: private");

if(!$_SESSION['is_logged']){
	header("location: index.php");
	exit();
}

require_once("../lib/class.config_db.php");
//require_once("../lib/class.mysql.php");
require_once("../lib/database.php");

$product_id = ((isset($_GET['id']) && $_GET['id'] !='') ? $_GET['id'] : 0);
$sql = "DELETE FROM products WHERE product_id= ".$product_id;
$DBConn->execute_query($sql);
$_SESSION['product_success_deleted'] = true;

header("Location: list_products.php");
exit();
?>