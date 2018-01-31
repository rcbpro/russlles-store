<?php 

session_start();
header("Cache-control: private");
require_once("../lib/class.config_db.php");
require_once("../lib/class.mysql.php");

$db = new mySQL();
$user_name = $_REQUEST['user_name'];
$password = $_REQUEST['password'];
$sql = "SELECT * FROM user WHERE user_name='".mysql_escape_string($user_name)."' AND password='".md5(mysql_escape_string($password))."' AND is_activate=1";
$db->execute($sql,$result);

if(mysql_num_rows($result)==0){
	header('Location: index.php?err=1');
	exit();
}else{
	$_SESSION['is_logged'] 	= true;
	$_SESSION['user_type'] 	= mysql_result($result,0,'user_type');
	$_SESSION['user_id']   	= mysql_result($result,0,'id');
	$_SESSION['logged_user']= mysql_result($result,0,'first_name')." ".mysql_result($result,0,'last_name');
	$last_logon_ip = $_SERVER['REMOTE_ADDR'];
	header('Location: desktop.php');
	exit();
}

?>