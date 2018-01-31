<?php

class Prodcuts {

	private $prodcuts_array = NULL;
	
	public function __construct() {
	
		global $DBConn;
		$sql = "SELECT * FROM products ORDER BY product_id DESC";		
		$this->prodcuts_array = $DBConn->return_mysql_fetched_results($DBConn->execute_query($sql), array('product_id', 'product_name', 'product_description', 'product_image'));		
	}
	
	public function getAllProducts() {
	
		global $DBConn;
		$sql = "SELECT * FROM products ORDER BY product_id DESC";		
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
		return $DBConn->return_mysql_fetched_results($DBConn->execute_query($sql), array('product_id', 'product_name', 'product_description', 'product_image'));		
	}
	
	public function getAllProductsCount() { return count($this->prodcuts_array); }
	
	public function getProductDetailsById($prodcutId) {
	
		foreach($this->prodcuts_array as $eachProdcut){
			if ($prodcutId == $eachProdcut['product_id']){
				$selectedProduct = $eachProdcut;
			}	
		}	
		return $selectedProduct;
	}
	
	public function getProductPrices($product_id) {
	
		global $DBConn;
		$sql = "SELECT * FROM products_prices WHERE product_id = ".$product_id;		
		return $DBConn->return_mysql_fetched_results($DBConn->execute_query($sql), array('product_id', 'loaf_type', 'price', 'id'));		
	}
}
