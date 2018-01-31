<?
/*
	hhdchamara@gmail.com
	2012-01-07
*/
session_start();
header("Cache-control: private");
if(!$_SESSION['is_logged']){
	header("location: index.php");
	exit();
}

require_once("../lib/class.config_db.php");
require_once("../lib/class.mysql.php");

$db	= new mySQL();
$result=NULL;


$footer_text = (isset($_POST['footer_text']) && $_POST['footer_text']!=''?$_POST['footer_text']:''); 

$sql="UPDATE site_setting 
		SET footer_text='".mysql_escape_string($footer_text)."'
	  WHERE id=1";
$db->execute($sql,$result);

unset($db,$result);

header("Location: desktop.php?message_id=1");
exit();
?>