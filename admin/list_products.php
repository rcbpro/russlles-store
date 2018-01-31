<?php 
include_once("inc_header.php");
include_once("../lib/pagination.php"); 

$invalidPage = false;
// This is for the total number of records
$sql = "SELECT * FROM products";
$total_records_count = $DBConn->getTheNumOfRecords($DBConn->execute_query($sql));

// This is for display all products
$sql = "SELECT * FROM products ORDER BY product_id";
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
$allProducts = $DBConn->return_mysql_fetched_results($DBConn->execute_query($sql), array('product_id', 'product_name', 'product_description', 'product_image'));
$pagination_obj = new Pagination();
$pagination = $pagination_obj->generate_pagination($total_records_count, $_SERVER['REQUEST_URI'], NO_OF_RECORDS_PER_PAGE);				
$tot_page_count = ceil($total_records_count/NO_OF_RECORDS_PER_PAGE);				
// If no records found or no pages found
$page = (isset($_GET['page'])) ? $_GET['page'] : 1;
if (($page > $tot_page_count) || ($page == 0)){
	$invalidPage = true;	
}

?>
<div id="masthead"><br /><br /><br />
    <div class="content_pad"><h1 class="no_breadcrumbs">All Products</h1></div> <!-- .content_pad -->
</div> <!-- #masthead -->	
<div id="content" class="xgrid">
	<?php if ((isset($_SESSION['product_addedd_success'])) && ($_SESSION['product_addedd_success'])):?>
    <div class="success">New product added successfully !</div>
    <?php unset($_SESSION['product_addedd_success'])?>
    <?php endif;?><br />
	<?php if ((isset($_SESSION['product_updated_success'])) && ($_SESSION['product_updated_success'])):?>
    <div class="success">Selected product updated successfully !</div>
    <?php unset($_SESSION['product_updated_success'])?>
    <?php endif;?><br />
	<?php if ((isset($_SESSION['product_success_deleted'])) && ($_SESSION['product_success_deleted'])):?>
    <div class="success">Selected product deleted successfully !</div>
    <?php unset($_SESSION['product_success_deleted'])?>
    <?php endif;?><br />    
    <div class="x12">
        <div class="font-setting"><h2>&nbsp;</h2></div>
        <div class="cs-setting"><button class="btn btn-small" onClick="javascript: location='add_products.php';">New Product</button></div>
        <table width="100%" id="custom_table_1" border="0" align="center"  cellpadding="1" cellspacing="1">
                <tr  bgcolor="#000000">
                    <th align="center">ID</th>
                    <th align="center">Product Name</th>	
                    <th align="center">Description</th>							
                    <th align="<strong>left</strong>">Edit</th>
                </tr> 
            <tbody>
            <?php 
				if ((!$invalidPage) && ($allProducts)):
					foreach($allProducts as $eachProduct):?>
                <tr> 
                    <td align="center" class="smallFont" width="5%"><?=$eachProduct['product_id']?></td>  
                    <td align="center" class="smallFont" width="20%"><?=$eachProduct['product_name']?></td> 
                    <td align="center" class="smallFont" width="45%"><?=substr($eachProduct['product_description'], 0, 100).'...'?></td>
                    <td align="left" class="smallFont" width="10%"> 
                     <a href="edit_product.php?id=<?=$eachProduct['product_id']?>">
                        <img src="../images/edit.png" border="0" title="Edit Product" alt="Edit Product">
                     </a> 
                     <a href="#" onClick="javascript: get_confirmation('Are you sure you wish to delete this post? ','product_delete.php?id=<?=$eachProduct['product_id']?>')">
                        <img src="../images/cross.png" border="0" title="Delete News Post" alt="Delete News Post">
                     </a> 
                   </td>
             </tr> 
             	<?php endforeach;
	        		else:?> 
            <tr> 
                <td align="center" colspan="6"><strong>No Record Found !</strong></td>
            </tr> 
        <?php endif; ?> 
            </tbody>
        </table>
    </div> <!-- .x12 -->    
</div> <!-- #content --><br />
<?php if ((!$invalidPage) && ($allProducts)):?>
<div class="paginationContainer"><?php echo $pagination;?></div>
<?php endif;?>
<?php include_once("inc_footer.php"); ?><!-- #footer -->		
</div> <!-- #wrapper -->