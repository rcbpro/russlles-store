<?php 
function get_message($message_id=0){
	
	$message="";
	
	switch($message_id){
		
		case 0:	{$message='';}break;
		
		case 1:	{$message='Database has been successfully updated';}break;
		case 2:	{$message='<h3>Record has been successfully deleted</h3>';}break;
		
		case 3:{$message='<h3>Invalid document type</h3>';}break;
		case 4:{$message='<h3>Document has been successfully uploaded</h3>';}break;
		case 5:{$message='User Name already exist';}break;
		case 6:{$message='<h3>Image  has been successfully uploaded</h3>';}break;
		case 7:{$message='<h3>Invalid Image type !</h3>';}break;
		case 8:	{$message='<h3>Image has been successfully deleted</h3>';}break;
		
		/*Services*/
		case 10:{$message='Service has been added successfully';}break;
		case 11:{$message='Service has been updated successfully';}break;
		case 12:{$message='Please enter valid service name';}break;
		case 13:{$message='Service has been deleted successfully';}break;
		
		/*Testimonials*/ 
		case 14: {$message='Testimonial has been added successfully';}break;
		case 15: {$message='Testimonial has been updated successfully';}break;
		case 16: {$message='Testimonial has been deleted successfully';}break;
		case 17: {$message='Invalid Image size';}break;
		case 18: {$message='Error while saving testimonial image';}break;
		case 19: {$message='Invalid file type. Only (jpg/jpeg/png/gif) types are allowed';}break;
		
		/*Users*/ 
		case 20: {$message='User has been added successfully';}break;
		case 21: {$message='User has been updated successfully';}break;
		case 22: {$message='User has been deleted successfully';}break;
		case 23: {$message='User Name already exists';}break;
		
		/*News*/ 
		case 24: {$message='News item has been added successfully';}break;
		case 25: {$message='News item has been updated successfully';}break;
		case 26: {$message='News item has been deleted successfully';}break;
		
		/*Blog*/ 
		case 27: {$message='Blog post has been added successfully';}break;
		case 28: {$message='Blog post has been updated successfully';}break;
		case 29: {$message='Blog post has been deleted successfully';}break;
	}
	
	return $message;
}
?>