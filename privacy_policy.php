<?php
require 'config.php';
require 'lib/class.config_db.php';
require 'lib/database.php';

$sql="SELECT * FROM pages WHERE page_id=2";
$pageContent = $DBConn->return_mysql_fetched_results_to_single_array($DBConn->execute_query($sql), array('page_id', 'heading', 'heading_image', 'banner_image', 'page_title', 'page_content', 'meta_keywords', 'meta_description'));
$html_title	= stripcslashes($pageContent['page_title']);
$heading = stripcslashes($pageContent['heading']);
$heading_image = stripcslashes($pageContent['heading_image']);
$main_content = stripcslashes($pageContent['page_content']);
$banner_image = stripcslashes($pageContent['banner_image']);
$main_content = stripcslashes($pageContent['page_content']);
$meta_keywords = stripcslashes($pageContent['meta_keywords']);
$meta_description = stripcslashes($pageContent['meta_description']);

include LAYOUT_PATH.'privacy_policy.html';