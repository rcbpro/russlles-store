<?php 
session_start();
header("Cache-control: private");

if(!$_SESSION['is_logged']){
	header("location: index.php");
	exit();
}

require_once("../lib/class.config_db.php");
require_once("../lib/class.mysql.php");

$db = new mySQL();
$user_id  = ((isset($_REQUEST['id'])&&$_REQUEST['id']!='')?$_REQUEST['id']:'0'); 

$sql = "SELECT id FROM user WHERE id='".$user_id."'";
$db->execute($sql,$result);

if(mysql_num_rows($result) > 0){
	$sql_delete = "DELETE FROM user WHERE id='".$user_id."'";
	$db->execute($sql_delete,$result_delete);
}

header("Location: user-list.php?message_id=22");
exit();
?>