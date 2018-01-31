<?php 
include_once("inc_header.php"); 
 
$page_id    = ((isset($_REQUEST['page_id'])&&$_REQUEST['page_id']!='')?$_REQUEST['page_id']:'0');
$image_id   = ((isset($_REQUEST['image_id'])&&$_REQUEST['image_id']!='')?$_REQUEST['image_id']:'0');
$message_id = ((isset($_REQUEST['message_id'])&&$_REQUEST['message_id']!='')?$_REQUEST['message_id']:'0');
$rid 	 	=((isset($_REQUEST['rid'])&& $_REQUEST['rid']!='')?$_REQUEST['rid']:0);


$sql="SELECT * FROM page_images 
	  WHERE (page_id=".$page_id.")AND
	  	    (id=".$image_id.")AND
			(is_enabled=1)";
$result = NULL;
$db->execute($sql,$result);
?>

	<div id="masthead"> 
		<div class="content_pad"> 
			<h1 class="no_breadcrumbs">Page Image Edit</h1>
			<!-- #search -->
		</div> <!-- .content_pad -->
	</div> <!-- #masthead -->	 
	<div id="content" class="xgrid"> 
		<div class="x12"> 
	<?
	if(mysql_num_rows($result)>0){
		$width 		= mysql_result($result,0,'width');
		$height 	= mysql_result($result,0,'height');
		$image_src	= mysql_result($result,0,'image_src');
		$alt_tag	= mysql_result($result,0,'alt_tag');
		$title		= mysql_result($result,0,'title');
		$article_description= mysql_result($result,0,'article_description');
		$article_title = mysql_result($result,0,'article_title'); 
		$alias		= mysql_result($result,0,'alias');
		$image_type	= mysql_result($result,0,'image_type');
	 
	 	if($image_type==3){
			$width=100;
			$height=100;	
		}
	?> 	
<script type="text/javascript">
	//$("#go_back").click(function(){
//		window.location.href='page-edit.php?page_id=<?=$page_id ?>';
//	});
</script>    
		<form id="page_images" name="page_images" method="post" class="form label-inline uniform"  enctype="multipart/form-data" action="page-image-edit-save.php">
            <input type="hidden" name="page_id" id="page_id" value="<?=$page_id?>" />
            <input type="hidden" name="image_id" id="image_id" value="<?=$image_id?>" />
            <input type="hidden" name="rid" id="rid" value="<?=$rid?>" />
            <?
				if($message_id!=''){?>
					<div class="field">
                        <label for="alias">&nbsp;</label> 
                        <span style="text-align:left;color:#FF9900;font-weight:bold;">
                        <?
							switch($message_id){
								case 1:{
									echo 'Please select an image to upload';
								}break;
								case 2:{
									echo 'You can upload images only (jpg/jpeg/png/gif)';
								}break;
								case 3:{
									echo 'Error while saving the image';
								}break;
								case 4:{
									echo 'Image has been successfully uploaded';
								}break;
								case 5:{
								    echo 'Changes have been updated successfully';
								}break;
								case 6:{
									echo 'Incorrect image size';
								}break;
							}
						?>
                        </span>
                    </div>
			<?	}
			?>
            <div class="field">
                <label for="alias">Alice</label> 
                <input disabled readonly id="alias" name="alias" size="80" type="text" class="medium" value="<?=$alias?>" />
            </div>
            <div class="field">
              <label for="main_image"> Image</label>
              <img id="main_image" name="main_image" src="../images/page-images/<?=$image_src?>" width="<?=$width?>" height="<?=$height?>" border="0">
            </div>
        	
            <div class="field">
                <label for="file">&nbsp;</label>
                <input type="file" id="my_image" name="my_image" size="60" class="medium">
             	<p style="margin-left:150px;"><strong><em>Note: Image size must be <?=$width?>x<?=$height?>px</em></strong></p>
            </div> 
            <?
			 if($image_type==1){//Normal image
			?> 
            <div class="field">
                <label for="title">Title</label> 
                <input id="title" name="title" size="80" type="text" class="medium" value="<?=$title?>" />
            </div>
          <div class="field">
            <label for="alt_tag">Alt Tag</label>
             <input name="alt_tag" type="text" class="medium" id="alt_tag" value="<?=$alt_tag?>" size="80">
            </div>
            <? } ?>
            <?
			if($image_type==2){//Article Background Image
			?>
             <div class="field">
                <label for="article_title">Article Title</label>
                <textarea name="article_title" cols="80" rows="4" class="medium" id="article_title"><?=$article_title?></textarea>
             </div> 
             <div class="field">
                <label for="article_description">Article Description</label>
                <textarea name="article_description" cols="80" rows="4" class="medium" id="article_description"><?=$article_description?></textarea>
            </div>    
            <? } ?> 
            <? if($image_type==3){//page background image
				
			}?>
          <div class="buttonrow">
                <button id="go_back" class="btn" type="button" onClick="javascript: location='page-edit.php?page_id=<?=$page_id?>&rid=<?=$rid?>';">Go Back</button>
                <button id="save_settings" class="btn btn-black" type="submit">Save Settings</button>
            </div>
        </form>     
		<? }else{
			?>Error<?	
		}?> 
		</div><!-- .x12 -->
	</div> <!-- #content -->

	 <?php include_once("inc_footer.php"); ?><!-- #footer -->		
</div> <!-- #wrapper -->
</body> 
 
</html>