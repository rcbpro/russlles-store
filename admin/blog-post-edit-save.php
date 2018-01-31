<?php 
session_start();
header("Cache-control: private");
if (!$_SESSION['is_logged']){
	header("location: index.php");
	exit();
}

require_once("../lib/class.config_db.php");
require_once("../lib/database.php");
require_once("../lib/functions.php");

$blog_post_id = ((isset($_POST['blog_post_id']) && $_POST['blog_post_id'] != '') ? $_POST['blog_post_id'] : 0);
$post_title = ((isset($_POST['post_title'])&& $_POST['post_title'] != '') ? $_POST['post_title'] : ''); 
$post_content = ((isset($_POST['post_content']) && $_POST['post_content'] != '') ? $_POST['post_content'] : '');
$active = ((isset($_POST['active']) && $_POST['active'] == '1') ? 1 : 0); 
$new_blog_post = false;

if ($blog_post_id == 0){
	$sql = "INSERT INTO posts(post_title, post_content, active, date_created, post_type) VALUES('".$post_title."', '".$post_content."', ".$active.", '".date("Y-m-d")."', 'B')";
	$DBConn->execute_query($sql);
	$new_blog_post = true;
	$blog_post_id = $DBConn->getLastInsertedId();
}else{
	$sql = "SELECT * FROM posts WHERE post_id = ".$blog_post_id. " AND post_type = 'B'";
	$postDetails = $DBConn->return_mysql_fetched_results_to_single_array($DBConn->execute_query($sql), array('post_id', 'post_title', 'post_content', 'cover_image', 'active'));
	
	if ($DBConn->checkSomeRecordsAreAvaliable($DBConn->execute_query($sql))){
		$blog_post_id = $postDetails['post_id'];
		$post_title = $postDetails['post_title'];
		$post_content = $postDetails['post_content'];
		$cover_image = $postDetails['cover_image'];
		$active = $postDetails['active'];
	}
} 

$allowed_file_types = array('image/jpeg', 'image/png', 'image/gif', 'image/jpg');
$upload_directory = '../images/blog-post/';

if ($_FILES['cover_image']['error'] == UPLOAD_ERR_OK){
	 $tmp_name  = $_FILES["cover_image"]["tmp_name"];
	 $name 	    = $_FILES["cover_image"]["name"];
	 $file_type = $_FILES['cover_image']['type'];
	 $size	    = $_FILES['cover_image']['size']; 
	 $extension = pathinfo ($name,PATHINFO_EXTENSION);

	 if(in_array($file_type, $allowed_file_types)){ 
		 $image_save_name = strtolower($blog_post_id.'-'.$name);
		 if (move_uploaded_file($tmp_name, $upload_directory.'temp-'.$image_save_name)){
			 //if(($image_size[0]==$width && $image_size[1]==$height)||$image_type==3){ 
			 	rename($upload_directory.'temp-'.$image_save_name,$upload_directory.$image_save_name);
			  	$sql = "UPDATE posts SET
			   						post_title = '".mysql_preperation($post_title)."',
								    post_content = '".mysql_preperation($post_content)."',
								    active = ".$active.",
				    				cover_image = '".$image_save_name."'
	       						WHERE post_id = ".$blog_post_id." AND post_type = 'B'";
				$DBConn->execute_query($sql);
				$_SESSION['blog_success_update'] = true;
			 //}else{
//				 unlink($upload_directory.'temp-'.$image_save_name);
//				 $message_id=17;//Image size incorrect
//			 }
		 }else{
			$_SESSION['blog_fail_update'] = true;		 
		 }
	 }else{
		$_SESSION['image_restricted'] = true;		 
	 }
}else{
	$sql = "UPDATE posts SET
						post_title = '".mysql_preperation($post_title)."',
						post_content = '".mysql_preperation($post_content)."',
						active = ".$active.",
						cover_image = '".$cover_image."'
					WHERE post_id = ".$blog_post_id." AND post_type = 'B'";
	$DBConn->execute_query($sql);
	$_SESSION['blog_success_update'] = true;
}

header("Location: blog-post-edit.php?id=".$blog_post_id);
exit();

?>