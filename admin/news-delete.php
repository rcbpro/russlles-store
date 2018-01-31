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

$blog_post_id = ((isset($_REQUEST['id'])&& $_REQUEST['id']!='')?$_REQUEST['id']:0);
$sql = "DELETE FROM posts WHERE post_id= ".$blog_post_id." AND post_type = 'N'";
$DBConn->execute_query($sql);
$_SESSION['news_success_deleted'] = true;

header("Location: news-list.php");
exit();
?>