<?php

require 'config.php';
require 'config/config.php';
require 'lib/class.config_db.php';
require 'lib/database.php';
require 'lib/pagination.php'; 

$sql = "SELECT * FROM pages WHERE page_id=1";
$pageContent = $DBConn->return_mysql_fetched_results_to_single_array($DBConn->execute_query($sql), array('page_id', 'heading', 'heading_image', 'banner_image', 'page_title', 'page_content', 'meta_keywords', 'meta_description'));
$html_title	= stripcslashes($pageContent['page_title']);
$heading = stripcslashes($pageContent['heading']);
$heading_image = stripcslashes($pageContent['heading_image']);
$main_content = stripcslashes($pageContent['page_content']);
$banner_image = stripcslashes($pageContent['banner_image']);
$meta_keywords = stripcslashes($pageContent['meta_keywords']);
$meta_description = stripcslashes($pageContent['meta_description']);

$invalidPage = false;
// This is for the total number of records
$sql = "SELECT * FROM posts WHERE post_type = 'N' ORDER BY date_created DESC";
$total_records_count = $DBConn->getTheNumOfRecords($DBConn->execute_query($sql));

// This is for display all products
$sql = "SELECT * FROM posts WHERE post_type = 'N' ORDER BY date_created DESC";
$limit = "";
$display_items = NO_OF_RECORDS_PER_PAGE;	
$curr_page_no = ((isset($_GET['page'])) && ($_GET['page'] != "") && ($_GET['page'] != 0)) ? $_GET['page'] : 1; 								
if ($curr_page_no != NULL){
	if ($curr_page_no == 1){
		$start_no_sql = 0;
		$end_no_sql = $display_items;
	}else{							
		$start_no_sql = ($curr_page_no - 1) * $display_items;
		$end_no_sql = $display_items;				
	}
}else{
	 $start_no_sql = 0;
	 $end_no_sql = $display_items;		
}
$limit = " Limit {$start_no_sql}, {$end_no_sql}";				
$sql .= $limit;
$allPosts = $DBConn->return_mysql_fetched_results($DBConn->execute_query($sql), array('post_id', 'post_title', 'post_content', 'cover_image', 'active', 'date_created', 'post_type', 'no_of_hits'));
$pagination_obj = new Pagination();
$pagination = $pagination_obj->generate_pagination($total_records_count, $_SERVER['REQUEST_URI'], NO_OF_RECORDS_PER_PAGE);				
$tot_page_count = ceil($total_records_count/NO_OF_RECORDS_PER_PAGE);				
// If no records found or no pages found
$page = (isset($_GET['page'])) ? $_GET['page'] : 1;
if (($page > $tot_page_count) || ($page == 0)){
	$invalidPage = true;	
}


include LAYOUT_PATH.'news.html';