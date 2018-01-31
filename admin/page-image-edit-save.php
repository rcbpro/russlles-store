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

$page_id	= (isset($_POST['page_id']) && $_POST['page_id']!=''?$_POST['page_id']:0);
$image_id	= (isset($_POST['image_id'])&& $_POST['image_id']!=''?$_POST['image_id']:0);
$rid 	 	=((isset($_POST['rid'])&& $_POST['rid']!='')?$_POST['rid']:0);

if($page_id==0 || $image_id==0 || $rid==0){
	header("Location: desktop.php");
	exit();		
}
$db = new mySQL();
$result=NULL;
$image_already_uploaded = false;
$sql="SELECT image_src,width,height,image_type FROM page_images  
		WHERE (page_id=".$page_id.")AND 
			  (id=".$image_id.")";
	$db->execute($sql,$result);
	if(mysql_num_rows($result)>0){
		$width  	= mysql_result($result,0,'width');
		$height		= mysql_result($result,0,'height');
		$image_type = mysql_result($result,0,'image_type');
		
		if(trim(mysql_result($result,0,'image_src'))!=''){
			$image_already_uploaded = true;
		}else{
			$image_already_uploaded = false;
		}
	}else{
		$image_already_uploaded = false;
	}


$alt_tag	= (isset($_POST['alt_tag'])&& $_POST['alt_tag']!=''?$_POST['alt_tag']:'');
$title		= (isset($_POST['title'])&& $_POST['title']!=''?$_POST['title']:'');
$article_description = (isset($_POST['article_description'])&& $_POST['article_description']!=''?$_POST['article_description']:'');
$article_title = (isset($_POST['article_title'])&& $_POST['article_title']!=''?$_POST['article_title']:'');

$message_id = 0;

$allowed_file_types = array('image/jpeg','image/png','image/gif','image/jpg');
$upload_directory = '../images/page-images/';
if($_FILES['my_image']['error']==UPLOAD_ERR_OK){
	 $tmp_name  = $_FILES["my_image"]["tmp_name"];
	 $name 	    = $_FILES["my_image"]["name"];
	 $file_type = $_FILES['my_image']['type'];
	 $size	    = $_FILES['my_image']['size']; 
	 $extension = pathinfo ($name,PATHINFO_EXTENSION);
	  
	 if(in_array($file_type,$allowed_file_types)){
		 
		 $image_save_name = strtolower($page_id.'-'.$image_id.'-'.$name);
		  
		 if(move_uploaded_file($tmp_name,$upload_directory.'temp-'.$image_save_name)){
			 $image_size = getimagesize($upload_directory.'temp-'.$image_save_name);
			  //print_r($image_size);
			  //die($image_size[0].'=='.$width.'   '.$image_size[1].'=='.$height);
			 if(($image_size[0]==$width && $image_size[1]==$height)||$image_type==3){ 
			 	rename($upload_directory.'temp-'.$image_save_name,$upload_directory.$image_save_name);
			    $sql="UPDATE page_images SET
						alt_tag='".mysql_escape_string($alt_tag)."',
						title='".mysql_escape_string($title)."',
						article_description='".mysql_escape_string($article_description)."',
						article_title='".mysql_escape_string($article_title)."',
						image_src='".mysql_escape_string($image_save_name)."'
				   WHERE (page_id=".$page_id.")AND 
						 (id=".$image_id.")";
				$db->execute($sql,$result);
			 	$message_id=4;//success
			 }else{
				 unlink($upload_directory.'temp-'.$image_save_name);
				 $message_id=6;//Image size incorrect
			 }
		 }else{
			$message_id=3;//Error while saving the file 
		 }
	 }else{
		$message_id=2;//Restricted file type 
	 }
}elseif($image_already_uploaded==true){
	 $sql="UPDATE page_images SET
					alt_tag='".mysql_escape_string($alt_tag)."',
					title='".mysql_escape_string($title)."',
					article_description='".mysql_escape_string($article_description)."',
					article_title='".mysql_escape_string($article_title)."' 
			   WHERE (page_id=".$page_id.")AND 
					 (id=".$image_id.")";
			$db->execute($sql,$result);
    $message_id=5;//updated successfully
}else{
	$message_id = 1;//please select a file to upload
}

unset($db,$result);
//die("Location: page-image-edit.php?page_id=".$page_id."&image_id=".$image_id."&message_id=".$message_id);
header("Location: page-image-edit.php?page_id=".$page_id."&rid=".$rid."&image_id=".$image_id."&message_id=".$message_id);
exit();	  
?>