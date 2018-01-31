<?php 
session_start();
header("Cache-control: private");

$_SESSION['is_logged'] = false;
$_SESSION['user_type'] = "";
$_SESSION['user_id'] = "";
$_SESSION['logged_user'] = "";
session_unset();
session_regenerate_id();

header('Location: index.php');
exit();
?>