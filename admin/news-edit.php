<?php 

require_once("../lib/ckeditor/ckeditor.php");
require_once("../lib/ckfinder/ckfinder.php");
include_once("inc_header.php"); 

$blog_post_id = ((isset($_REQUEST['id']) && $_REQUEST['id'] != '') ? $_REQUEST['id'] : 0);

$sql = "SELECT * FROM posts WHERE post_id = ".$blog_post_id. " AND post_type = 'N'";
$postDetails = $DBConn->return_mysql_fetched_results_to_single_array($DBConn->execute_query($sql), array('post_id', 'post_title', 'post_content', 'cover_image', 'active'));

if ($DBConn->checkSomeRecordsAreAvaliable($DBConn->execute_query($sql))){
	$blog_post_id = $postDetails['post_id'];
	$post_title = $postDetails['post_title'];
	$post_content = $postDetails['post_content'];
	$cover_image = $postDetails['cover_image'];
	$active = $postDetails['active'];
}
 
?>
	<div id="masthead"><br /><br /><br />
		<div class="content_pad">
			<h1 class="no_breadcrumbs">News Edit</h1>
			<!-- #search -->
		</div> <!-- .content_pad -->
	</div> <!-- #masthead -->	
	
	<div id="content" class="xgrid">
		<?php if ((isset($_SESSION['news_success_update'])) && ($_SESSION['news_success_update'])):?>
        <div class="success">News updated successfully !</div>
        <?php unset($_SESSION['news_success_update'])?>
        <?php endif;?><br />
        <?php if ((isset($_SESSION['news_fail_update'])) && ($_SESSION['news_fail_update'])):?>
        <div error="success">News updated failed !</div>
        <?php unset($_SESSION['news_fail_update'])?>
        <?php endif;?><br />
        <?php if ((isset($_SESSION['news_image_restricted'])) && ($_SESSION['news_image_restricted'])):?>
        <div class="error">Not a valid type to upload !</div>
        <?php unset($_SESSION['news_image_restricted'])?>
        <?php endif;?><br />
		<div class="x12"> 
		<form id="blog_post" name="blog_post" method="post" class="form label-inline uniform" action="news-edit-save.php" enctype="multipart/form-data">
            <input type="hidden" name="blog_post_id" id="blog_post_id" value="<?php echo (!empty($blog_post_id)) ? $blog_post_id : ""?>" />
            <div class="field">
                <label for="name">Title</label> 
                <input id="title" name="post_title" size="100" type="text" class="medium" value="<?php echo (!empty($post_title)) ? $post_title : ""?>" />
            </div> 
            <div class="field">
                <table align="center" border="0">
            		<tr>
                	<td align="right">Description<?=str_repeat('&nbsp;',26)?></td>
                    <td><?php
					$ckeditor = new CKEditor(); 
					//$ckeditor->basePath = '../lib/ckeditor/'; 
					CKFinder::SetupCKEditor($ckeditor,CK_EDITOR_BASE_DIRECTORY); 
					$ckeditor->returnOutput = true; 
					$ckeditor->config['width'] = 800; 
					$ckeditor->textareaAttributes = array("cols" => 80, "rows" => 10); 
					$initialValue = ((!empty($post_content)) ? $post_content : "");  
					$code = $ckeditor->editor("post_content", $initialValue); 
					echo $code;
				?></td>
                </tr>
            </table>
            </div>   
            <div class="field">
            <span class="label">Is Active?</span>
                <div class="controlset-pad">
                    <input name="active" id="is_enabled" value="1" type="checkbox" <?=(((!empty($active)) && ($active == 1)) ? "checked" : "")?> />
                </div>
            </div>	
              
               <?php
			    	if ((!empty($cover_image)) && ($cover_image != '')):
						$upload_directory = '../images/news/';
						$image_size = getimagesize($upload_directory.$cover_image );
			   ?>
                  <div class="field">
                  <label for="main_image">News Image</label>
                  <img id="main_image" name="main_image" src="../images/news/<?=(($cover_image != "") ? $cover_image : "")?>" border="0">
                  </div>
               <?php endif; ?>
            <div class="field">
                <label for="name">&nbsp;</label>
                <input type="file" id="my_image" name="cover_image" size="60" class="medium">
             	<!--<p style="margin-left:150px;"><strong><em>Note: Image size must be 200x200px</em></strong></p>-->
            </div>
            <div class="buttonrow">
                <button class="btn" type="button" onClick="javascript: location='blog-post-list.php';">Go Back</button>
                <button class="btn btn-black" type="submit">Save Post &raquo;</button>
                <?php if($blog_post_id != 0):?>
                <button class="btn btn-grey" type="button" onClick="javascript: get_confirmation('Are you sure you wish to delete this news ? ','blog-post-delete.php?id=<?=$blog_post_id?>')">Delete </button>
                <? endif; ?>
            </div>
        </form>
		</div> <!-- .x12 -->
	</div> <!-- #content -->
	 <?php include_once("inc_footer.php"); ?><!-- #footer -->		
</div> <!-- #wrapper -->
</body> 
</html>