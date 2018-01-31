<?php

include_once("../lib/ckeditor/ckeditor.php");
include_once("../lib/ckfinder/ckfinder.php");
 
$page_id = ((isset($_REQUEST['page_id']) && $_REQUEST['page_id'] != '') ? $_REQUEST['page_id'] : 0);

if ($page_id==0){//Invalid request 
	header("Location: desktop.php");
	exit();	
}
include_once("inc_header.php"); 

$sql = "SELECT * FROM pages WHERE page_id=".$page_id;
$pageContent = $DBConn->return_mysql_fetched_results_to_single_array($DBConn->execute_query($sql), array('page_id', 'page_title', 'heading', 'heading_image', 'banner_image', 'page_content', 'meta_keywords', 'meta_description'));
$html_title	= stripcslashes($pageContent['page_title']);
$heading = stripcslashes($pageContent['heading']);
$heading_image = stripcslashes($pageContent['heading_image']);
$main_content = stripcslashes($pageContent['page_content']);
$banner_image = stripcslashes($pageContent['banner_image']);
$meta_keywords = stripcslashes($pageContent['meta_keywords']);
$meta_description = stripcslashes($pageContent['meta_description']);

?>
<div id="masthead"><br /><br /><br /> 
    <div class="content_pad"> 
        <h1 class="no_breadcrumbs"><?php echo (isset($html_title)) ? $html_title : ""?> Content Edit</h1> 
    </div> <!-- .content_pad -->
</div> <!-- #masthead -->	
<div id="content" class="xgrid"> 
	<?php if ((isset($_SESSION['success_update'])) && ($_SESSION['success_update'])):?>
    <div class="success">Page updated succesfully !</div><br />
    <?php unset($_SESSION['success_update'])?>
    <?php endif;?>
	<?php if ((isset($_SESSION['heading_error_in_width'])) && ($_SESSION['heading_error_in_width'])):?>
    <div class="error">Select the correct image width !</div><br />
    <?php unset($_SESSION['heading_error_in_width'])?>
    <?php endif;?>    
	<?php if ((isset($_SESSION['heading_error_in_height'])) && ($_SESSION['heading_error_in_height'])):?>
    <div class="error">Select the correct image height !</div><br />
    <?php unset($_SESSION['heading_error_in_height'])?>
    <?php endif;?>    
	<?php if ((isset($_SESSION['heading_not_correct_type'])) && ($_SESSION['heading_not_correct_type'])):?>
    <div class="error">Select the correct file type !</div><br />
    <?php unset($_SESSION['heading_image_not_correct_type'])?>
    <?php endif;?>    
	<?php if ((isset($_SESSION['heading_image_uploading_error'])) && ($_SESSION['heading_image_uploading_error'])):?>
    <div class="error">Header image uploading error !</div><br />
    <?php unset($_SESSION['heading_image_uploading_error'])?>
    <?php endif;?>    
	<?php if ((isset($_SESSION['banner_image_uploading_error'])) && ($_SESSION['banner_image_uploading_error'])):?>
    <div class="error">Banner image uploading error !</div><br />
    <?php unset($_SESSION['banner_image_uploading_error'])?>
    <?php endif;?>    
    <div class="x12">
        <form id="page_save" name="page_save" method="post" class="form label-inline uniform" action="page-edit-save.php" enctype="multipart/form-data">
          <input type="hidden" name="page_id" value="<?=$page_id?>" />	
          <div class="field">
                <label for="name">Page Title</label> 
                <input id="html_title" name="html_title" size="80" type="text" class="medium" value="<?php echo isset($html_title) ? $html_title : "";?>" />
          </div>
          <div class="field">
                <label for="name">Heading</label> 
                <input id="heading" name="heading" size="80" type="text" class="medium" value="<?php echo isset($heading) ? $heading : "";?>" />
          </div>
            <div class="field">
                <label for="name">Heading Image</label>
                <input type="file" id="heading_image" name="heading_image" size="60" class="medium">
                <p style="margin-left:150px;"><strong><em>Note: Image size must be (920 - 925) x (120 - 138) px / (jpg, jpeg, png, gif)</em></strong></p>
            	<img src="../images/page-images/<?=((isset($heading_image)) ? $heading_image : "")?>" />
            </div>
            <div class="field">
                <label for="name">Banner Image</label>
                <input type="file" id="banner_image" name="banner_image" size="60" class="medium">
                <p style="margin-left:150px;"><strong><em>Note: Image size must be 900 x (330 - 335) px / (jpg, jpeg, png, gif)</em></strong></p>
                <img src="../images/page-images/<?=((isset($banner_image)) ? $banner_image : "")?>" />
            </div>
          <div class="field">
            <table align="center" border="0">
                <tr>
                    <td align="left"><b>Main content</b><?php echo str_repeat('&nbsp;',20)?></td>
                    <td><?php
                    $ckeditor = new CKEditor(); 
                    $ckeditor->basePath = '../lib/ckeditor/'; 
                    CKFinder::SetupCKEditor($ckeditor,CK_EDITOR_BASE_DIRECTORY); 
                    $ckeditor->returnOutput = true; 
                    $ckeditor->config['width'] = 800; 
                    $ckeditor->textareaAttributes = array("cols" => 80, "rows" => 10); 
                    $initialValue = (isset($main_content)) ? $main_content : "";  
                    $code = $ckeditor->editor("main_content", $initialValue); 
                    echo $code;?></td>
                </tr>
            </table>
         </div>
         <div class="field">
                <label for="name">Meta Keywords</label>
                <textarea name="meta_keywords" cols="80" rows="4" class="medium" id="meta_keywords"><?php echo (isset($meta_keywords)) ? $meta_keywords : "";?></textarea>
         </div>
         <div class="field">
                <label for="name">Meta Description</label>
                <textarea name="meta_description" cols="80" rows="4" class="medium" id="meta_description"><?php echo (isset($meta_description)) ? $meta_description : "";?></textarea>
         </div> 
          <div class="buttonrow">
                <button class="btn" type="button" onClick="javascript: location='desktop.php';" >Go Back</button>
                <button class="btn btn-black" type="submit">Save Settings</button> 
          </div>
      </form>
</div> 
 <?php include_once("inc_footer.php"); ?>