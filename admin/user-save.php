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
$result = NULL;

$user_id     = ((isset($_POST['user_id'])&&$_POST['user_id']!='')?$_POST['user_id']:'');
$first_name  = ((isset($_POST['first_name'])&&$_POST['first_name']!='')?$_POST['first_name']:'');
$last_name   = ((isset($_POST['last_name'])&&$_POST['last_name']!='')?$_POST['last_name']:'');
$user_name   = ((isset($_POST['user_name'])&&$_POST['user_name']!='')?$_POST['user_name']:'');
$password    = ((isset($_POST['password'])&&$_POST['password']!='')?$_POST['password']:'');
$is_activate = ((isset($_POST['is_activate'])&&$_POST['is_activate']=='1')?1:0); 
$type 		 = ((isset($_POST['type'])&&$_POST['type']!='')?$_POST['type']:''); 
$message_id	 = '';

$new_user 	 = false;
if($user_id == 0){
	$sql_check = "SELECT id FROM user WHERE user_name='".mysql_escape_string($user_name)."'";
	$db->execute($sql_check,$result_check);

	if(mysql_num_rows($result_check) > 0){//user name already exists
		$message_id = 23; 
		//header("Location: user-edit.php?id=".$user_id."&message_id=5"); 
		//exit(); 
	}else{ 
		$sql = "INSERT INTO user(first_name,last_name,user_name,password,is_activate,user_type) 
				VALUES('".mysql_escape_string($first_name)."',
					   '".mysql_escape_string($last_name)."',
					   '".mysql_escape_string($user_name)."',
					   '".md5(mysql_escape_string($password))."',
					   '".$is_activate."',
					   '".$type."')"; 
		$db->execute_with_id($sql,$result,$user_id);
		$message_id = 20;//added successfully
	}
}else{
	$sql_check = "SELECT id FROM user 
			 	  WHERE id NOT IN('".$user_id."') AND 
			  		(user_name='".mysql_escape_string($user_name)."')";
	$db->execute($sql_check,$result_check);

	if(mysql_num_rows($result_check) > 0){ //user name already exists
		$message_id = 23;
		//header("Location: user-edit.php?id=".$user_id."&message_id=5"); 
		//exit(); 
	}else{  
		$sql = "UPDATE `user` SET 
					first_name='".mysql_escape_string($first_name)."', 
					last_name='".mysql_escape_string($last_name)."',
					user_name='".mysql_escape_string($user_name)."',
					is_activate='".$is_activate."',
					user_type = '".$type."'
				WHERE id='".$user_id."'"; 
		$db->execute($sql,$result);

		if($password != ""){ 
			$sql_pass = "UPDATE user SET password='".md5(mysql_escape_string($password))."' 
						  WHERE id='".$user_id."'"; 
			$db->execute($sql_pass,$result_pass); 
		}
		$message_id = 21;//updated successfully
	}
}


unset($db,$result_pass,$result);
header("Location: user-edit.php?id=".$user_id."&message_id=".$message_id);
exit();

?>