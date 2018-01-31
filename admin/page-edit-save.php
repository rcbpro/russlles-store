<?php

session_start();
header("Cache-control: private");
if(!$_SESSION['is_logged']){
	header("location: index.php");
	exit();
}

require_once("../lib/class.config_db.php");
require_once("../lib/database.php");
require_once("../lib/functions.php");

$page_id = (isset($_POST['page_id']) && $_POST['page_id'] != '') ? $_POST['page_id'] : 0; 

if($page_id==0){
	header("Location: desktop.php");
	exit();	
}

$html_title = (isset($_POST['html_title']) && $_POST['html_title']!=''? $_POST['html_title'] : ''); 
$main_content = (isset($_POST['main_content']) && $_POST['main_content'] !='' ? $_POST['main_content']:''); 
$heading = (isset($_POST['heading']) && $_POST['heading'] != '' ? $_POST['heading'] : ''); 
$meta_keywords = (isset($_POST['meta_keywords']) && $_POST['meta_keywords'] != '' ? $_POST['meta_keywords'] : ''); 
$meta_description = (isset($_POST['meta_description']) && $_POST['meta_description'] != '' ? $_POST['meta_description'] : '');

if (($_FILES['heading_image']['name'] != "") || ($_FILES['banner_image']['name'] != "")){
	$allowed_file_types = array('image/jpeg', 'image/png', 'image/gif', 'image/jpg');
	$upload_directory = '../images/page-images/';

	if ($_FILES['heading_image']['name'] != ""){
		$file_sizes = getimagesize($_FILES['heading_image']['tmp_name']);
		if (($file_sizes[0] < 920) || ($file_sizes[0] > 925)){
			$_SESSION['heading_error_in_width'] = true;
		}
		if (($file_sizes[1] < 120) || ($file_sizes[1] > 138)){
			$_SESSION['heading_error_in_height'] = true;
		}
		if (!in_array($_FILES['heading_image']['type'], $allowed_file_types)){
			$_SESSION['heading_image_not_correct_type'] = true;
		}
	}
	if ($_FILES['banner_image']['name'] != ""){
		$file_sizes = getimagesize($_FILES['banner_image']['tmp_name']);
		if ($file_sizes[0] != 900){
			$_SESSION['banner_error_in_width'] = true;
		}
		if (($file_sizes[1] < 330) || ($file_sizes[1] > 335)){
			$_SESSION['banner_error_in_height'] = true;
		}
		if (!in_array($_FILES['banner_image']['type'], $allowed_file_types)){
			$_SESSION['banner_image_not_correct_type'] = true;
		}
	}
	// This is for the heading image update
	if (($_FILES['heading_image']['name'] != "") && ($_FILES['banner_image']['name'] == "")){
		if ((!$_SESSION['heading_error_in_width']) && (!$_SESSION['heading_error_in_height']) && (!$_SESSION['heading_image_not_correct_type'])){
			if (move_uploaded_file($_FILES['heading_image']['tmp_name'], $upload_directory.basename($_FILES['heading_image']['name']))){
				$sql='UPDATE pages SET 
						page_title="'.mysql_preperation($html_title).'",
						heading="'.mysql_preperation($heading).'",
						heading_image="'.mysql_preperation(basename($_FILES['heading_image']['name'])).'",										
						page_content="'.mysql_preperation($main_content).'",
						meta_keywords="'.mysql_preperation($meta_keywords).'",
						meta_description="'.mysql_preperation($meta_description).'"
					WHERE page_id = '.$page_id;
				$results = $DBConn->execute_query($sql);	
				if ($results) $_SESSION['success_update'] = true;
			}else{
				$_SESSION['heading_image_uploading_error'] = true;
			}
		}
	}	
	// This is for the banner image update
	if (($_FILES['heading_image']['name'] == "") && ($_FILES['banner_image']['name'] != "")){
		if ((!$_SESSION['banner_error_in_width']) && (!$_SESSION['banner_error_in_height']) && (!$_SESSION['banner_image_not_correct_type'])){
			if (move_uploaded_file($_FILES['banner_image']['tmp_name'], $upload_directory.basename($_FILES['banner_image']['name']))){
				$sql='UPDATE pages SET 
						page_title="'.mysql_preperation($html_title).'",
						heading="'.mysql_preperation($heading).'",
						banner_image="'.mysql_preperation(basename($_FILES['banner_image']['name'])).'",										
						page_content="'.mysql_preperation($main_content).'",
						meta_keywords="'.mysql_preperation($meta_keywords).'",
						meta_description="'.mysql_preperation($meta_description).'"
					WHERE page_id = '.$page_id;
				$results = $DBConn->execute_query($sql);	
				if ($results) $_SESSION['success_update'] = true;
			}else{
				$_SESSION['banner_image_uploading_error'] = true;
			}
		}
	}	
	// This is for the header and banner images update
	if (($_FILES['heading_image']['name'] != "") && ($_FILES['banner_image']['name'] != "")){
		if (
			((!$_SESSION['heading_error_in_width']) && (!$_SESSION['heading_error_in_height']) && (!$_SESSION['heading_image_not_correct_type'])) && 
			((!$_SESSION['banner_error_in_width']) && (!$_SESSION['banner_error_in_height']) && (!$_SESSION['banner_image_not_correct_type']))
		   )
			{
			if (
				(move_uploaded_file($_FILES['heading_image']['tmp_name'], $upload_directory.basename($_FILES['heading_image']['name']))) && 
				(move_uploaded_file($_FILES['banner_image']['tmp_name'], $upload_directory.basename($_FILES['banner_image']['name'])))
			   )
				{
				$sql='UPDATE pages SET 
						page_title="'.mysql_preperation($html_title).'",
						heading="'.mysql_preperation($heading).'",
						heading_image="'.mysql_preperation(basename($_FILES['heading_image']['name'])).'",										
						banner_image="'.mysql_preperation(basename($_FILES['banner_image']['name'])).'",																
						page_content="'.mysql_preperation($main_content).'",
						meta_keywords="'.mysql_preperation($meta_keywords).'",
						meta_description="'.mysql_preperation($meta_description).'"
					WHERE page_id = '.$page_id;
				$results = $DBConn->execute_query($sql);	
				if ($results) $_SESSION['success_update'] = true;
			}else{
				$_SESSION['heading_image_uploading_error'] = true;			
				$_SESSION['banner_image_uploading_error'] = true;
			}
		}
	}	
	header("Location: page-edit.php?page_id=".$page_id);	
	exit();
}else{
	$sql='UPDATE pages SET 
			page_title="'.mysql_preperation($html_title).'",
			heading="'.mysql_preperation($heading).'",
			page_content="'.mysql_preperation($main_content).'",
			meta_keywords="'.mysql_preperation($meta_keywords).'",
			meta_description="'.mysql_preperation($meta_description).'"
		WHERE page_id = '.$page_id;
	
	$results = $DBConn->execute_query($sql);	
	if ($results) $_SESSION['success_update'] = true;
}
header("Location: page-edit.php?page_id=".$page_id);
exit();

?>