<?php 
include_once("inc_header.php"); 
require_once("../lib/ckeditor/ckeditor.php");
require_once("../lib/ckfinder/ckfinder.php");
?>
	<div id="masthead"><br /><br /><br />
		<div class="content_pad">
		  <h1 class="no_breadcrumbs">Edit Site Content</h1></div> <!-- .content_pad -->
	</div> <!-- #masthead -->	
    <form id="site_content" name="site_content" method="post" enctype="multipart/form-data" action="site-settings-save.php">
	<div id="content" class="xgrid">
		<span style="margin-left:10px;text-align:left;color:#FF9900;font-weight:bold;">
        <?php
			if ((isset($message_id)) && ($message_id == 1)){
				echo 'Changes have been saved successfully';	
			}
        ?>
        </span>
	  <div class="x12">	
      <h5>Site Pages</h5>  
          <table align="center" width="100%" id="custom_table_1" cellpadding="1" cellspacing="1">
              <thead> 
                  <tr bgcolor="#000000"> 
                      <th align="center">Page Name</th> 
                      <th align="center" >Edit</th> 
                  </tr> 
              </thead> 
              <tbody>
              <?php
                $site_pages=array(
                    'home'=>array('page_name'=>'Home','url'=> 'page-edit.php?page_id=1'),
                    'privacy_policy'=>array('page_name'=>'Privacy Policy', 'url'=> 'page-edit.php?page_id=2'),
                    'products'=>array('page_name'=>'Products','url'=> 'list_products.php'),
                    'news'=>array('page_name'=>'News','url'=> 'news-list.php'),
                    'blog'=>array('page_name'=>'Blog','url'=> 'blog-post-list.php')
                );
                
            foreach($site_pages as $my_page):?>
                <tr>  
                    <td align="left"><?php echo $my_page['page_name']?></td> 
                    <td align="center"> 
                    <a href="<?php echo $my_page['url']?>"> 
                        <img src="../images/edit.png" border="0" title="Edit Page Content" alt="Edit Page Content">
                    </a>
                    </td> 
                </tr> 
        <?php endforeach; ?>	  
              </tbody> 
          </table> 
	  </div> 
       <div class="x12">	
       	<p><hr/></p>
       </div>
	</div> <!-- #content -->
    </form>
	<?php include_once("inc_footer.php"); ?><!-- #footer -->		
</div> <!-- #wrapper -->
</body> 
</html>
<?php unset($db,$result);?>