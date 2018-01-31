<?php 
include_once("inc_header.php"); 
include_once("../lib/pagination.php"); 

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

?>
<div id="masthead"><br /><br /><br />
    <div class="content_pad"><h1 class="no_breadcrumbs">News List</h1></div> <!-- .content_pad -->
</div> <!-- #masthead -->	
<div id="content" class="xgrid">
	<?php if ((isset($_SESSION['news_success_deleted'])) && ($_SESSION['news_success_deleted'])):?>
    <div class="success">Selected news deleted successfully !</div>
    <?php unset($_SESSION['news_success_deleted'])?>
    <?php endif;?><br />
    <div class="x12">
        <div class="font-setting"><h2>&nbsp;</h2></div>
        <div class="cs-setting"><button class="btn btn-small" onClick="javascript: location='news-edit.php?id=0';">New Blog Post</button></div>
        <table width="100%" id="custom_table_1" border="0" align="center"  cellpadding="1" cellspacing="1">
                <tr  bgcolor="#000000">
                    <th align="center">ID</th>
                    <th align="left">Title</th>	
                    <th align="left">News Content</th>							
                    <th align="left">Date Created</th>
                    <th align="left">Is Enabled</th>
                    <th align="left">Edit</th>
                </tr> 
            <tbody>
            <?php 
				if ((!$invalidPage) && ($allPosts)):
					foreach($allPosts as $eachPost):?>
                <tr> 
                    <td align="center" class="smallFont" width="5%"><?=$eachPost['post_id']?></td>  
                    <td align="center" class="smallFont" width="20%"><?=$eachPost['post_title']?></td> 
                    <td align="left" class="smallFont" width="45%"><?=substr($eachPost['post_content'], 0, 100).'...'?></td>
                    <td align="center" class="smallFont" width="10%"><?=date("d M Y",strtotime($eachPost['date_created']))?></td>
                    <td align="center" class="smallFont" width="10%"><?=($eachPost['active'] == 1 ? "Yes" : "No")?></td> 
                    <td align="left" class="smallFont" width="10%"> 
                     <a href="news-edit.php?id=<?=$eachPost['post_id']?>">
                        <img src="../images/edit.png" border="0" title="Edit News Post" alt="Edit News Post">
                     </a> 
                     <a href="#" onClick="javascript: get_confirmation('Are you sure you wish to delete this post? ','blog-post-delete.php?id=<?=$eachPost['post_id']?>')">
                        <img src="../images/cross.png" border="0" title="Delete News Post" alt="Delete News Post">
                     </a> 
                   </td>
             </tr> 
             <?php endforeach;?>
        <?php else:?> 
            <tr> 
                <td align="center" colspan="6"><strong>No Record Found !</strong></td>
            </tr> 
        <?php endif; ?> 
            </tbody>
        </table>
    </div> <!-- .x12 -->
</div> <!-- #content -->
<?php if ((!$invalidPage) && ($allPosts)):?>
<div class="paginationContainer"><?php echo $pagination;?></div>
<?php endif;?>
<?php include_once("inc_footer.php"); ?><!-- #footer -->		
</div> <!-- #wrapper -->