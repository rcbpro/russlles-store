<?php

include_once("../lib/ckeditor/ckeditor.php");
include_once("../lib/ckfinder/ckfinder.php"); 
include_once("inc_header.php"); 
require_once("../config.php");
require_once("../lib/functions.php");

if (isset($_GET['id'])){
	$sql = "SELECT * FROM products WHERE product_id = ".$_GET['id'];
	$product_details = $DBConn->return_mysql_fetched_results_to_single_array($DBConn->execute_query($sql), array('product_id', 'product_name', 'product_description', 'product_image'));	
	// Geth the product prices
	$sql = "SELECT * FROM products_prices WHERE product_id = ".$_GET['id'];
	$product_prices = $DBConn->return_mysql_fetched_results($DBConn->execute_query($sql), array('id', 'loaf_type', 'price'));	

	if (isset($_POST['product'])){
		//$errors = errorCheckingFields($_POST['product']);
		if (empty($_POST['product']['name'])){
			$product_name_error = true;
			$error_message = "Please fix these errors";
		}else{
			if ($_FILES['product_image']['name'] != ""){
				if (file_exists($_SERVER['DOCUMENT_ROOT']."www.russlls-famous-cookies.com/images/products/".$product_details['product_image'])){
					unlink($_SERVER['DOCUMENT_ROOT']."www.russlls-famous-cookies.com/images/products/".$product_details['product_image']);
				}	
				if (move_uploaded_file($_FILES['product_image']['tmp_name'], $_SERVER['DOCUMENT_ROOT']."www.russlls-famous-cookies.com/images/products/".basename($_FILES['product_image']['name']))){
					$product_image = $_FILES['product_image']['name'];
				}	
			}else{
				$product_image = $product_details['product_image'];
			}
			$sql = "UPDATE products SET 
							product_name = '".mysql_preperation($_POST['product']['name'])."', 
							product_description = '".mysql_preperation($_POST['product']['description'])."', 
							product_image = '".mysql_preperation($product_image)."'  
					WHERE product_id = ".$_GET['id'];
			$DBConn->execute_query($sql);
			
			if (!empty($_POST['product_prices'])){
				$errors_in_prices = errorCheckingFields($_POST['product_prices']);						
				if (count($errors_in_prices['errorFields']) > 0){
					$error_message = "Please fix these errors";			
				}else{
					// Add four product prices
					foreach($_POST['product_prices'] as $key => $val){
						$sql = "INSERT INTO products_prices (product_id, loaf_type, price) 
								VALUES(".$product_details['product_id'].", '".mysql_preperation($key)."', '".$val."')";
						$DBConn->execute_query($sql);
					}
					$_SESSION['product_updated_success'] = true;
					header("Location: http://".$_SERVER['HTTP_HOST'].'/www.russlls-famous-cookies.com/admin/list_products.php');
				}
			}	
			if (!isset($_POST['product_prices'])){			
				$_SESSION['product_updated_success'] = true;
				header("Location: http://".$_SERVER['HTTP_HOST'].'/www.russlls-famous-cookies.com/admin/list_products.php');
			}	
		}	
	}
	
}

?>
<?php if (!empty($product_prices)):?>
<script type="text/javascript" charset="utf-8">
$(function() {
	$(".price_change").editable("<?php echo WEB_PATH?>admin/update_prices.php", { 
		indicator : '<img src="<?php echo WEB_PATH?>public/images/indicator.gif">',
	  	type   : 'text',
      	submitdata: { _method: "put", id : $("#priceTable .price_change td").attr('id') },
      	select : true,
      	submit : 'OK',
		tooltip   : "Click to edit...",
      	cancel : 'cancel',
      	cssclass : "editable"
	});
});
</script>
<?php endif;?>
<div id="masthead"> 
    <div class="content_pad"> 
    </div> <!-- .content_pad -->
</div> <!-- #masthead -->	
<div id="content" class="xgrid"> 
	<?php if ((isset($error_message)) && ($error_message != "")):?>
    <span id="productQtyErrorMessage"><?=$error_message?></span>
    <?php endif;?>
    <div class="x12">
        <form id="products" name="products" method="post" class="form label-inline uniform" action="" enctype="multipart/form-data">
          <div class="field">
                <label for="name">Product Name</label> 
                <input id="product_name" name="product[name]" size="53" type="text" class="medium <?php echo ((isset($product_name_error)) && ($product_name_error)) ? 'errorInBack' : ''?>" value="<?=$product_details['product_name']?>" />
          </div>
          <div class="field">
                <label for="name">Description</label> 
                <textarea id="description" name="product[description]" cols="50" rows="4" class="<?php echo ((isset($errors)) && (in_array("description", $errors['errorFields']))) ? 'errorInBack' : ''?>"><?=$product_details['product_description']?></textarea>
          </div>
         		<?php if (empty($product_prices)):?>
         <div id="pricesDiv" class="field" style="border:1px solid #069; padding:10px; width:310px; margin-left:150px;">                
                <label for="product_price1">Price for 3lb</label>
                <input id="product_price1" name="product_prices[3lb]" value="<?=(isset($_POST['product_prices']['3lb']) && ($_POST['product_prices']['3lb'] != "") ? $_POST['product_prices']['3lb'] : "")?>" size="20" type="text" class="medium <?php echo ((isset($errors_in_prices)) && (in_array("3lb", $errors_in_prices['errorFields']))) ? 'errorInBack' : ''?>" /><br /><br />                
                <label for="product_price2">Price for 1.5lb</label>
                <input id="product_price2" name="product_prices[1.5lb]" value="<?=(isset($_POST['product_prices']['1.5lb']) && ($_POST['product_prices']['1.5lb'] != "") ? $_POST['product_prices']['1.5lb'] : "")?>" size="20" type="text" class="medium <?php echo ((isset($errors_in_prices)) && (in_array("1.5lb", $errors_in_prices['errorFields']))) ? 'errorInBack' : ''?>" /><br /><br />                
                <label for="product_price3">Price for 0.5lb Sample</label>
                <input id="product_price3" name="product_prices[0.5lb_Sample]" value="<?=(isset($_POST['product_prices']['0.5lb_Sample']) && ($_POST['product_prices']['0.5lb_Sample'] != "") ? $_POST['product_prices']['0.5lb_Sample'] : "")?>" size="20" type="text" class="medium <?php echo ((isset($errors_in_prices)) && (in_array("0.5lb_Sample", $errors_in_prices['errorFields']))) ? 'errorInBack' : ''?>" /><br /><br />                
                <label for="product_price4">Price for 3lb Refill Bag</label>
                <input id="product_price4" name="product_prices[3lb_Refill_Bag]" value="<?=(isset($_POST['product_prices']['3lb_Refill_Bag']) && ($_POST['product_prices']['3lb_Refill_Bag'] != "") ? $_POST['product_prices']['3lb_Refill_Bag'] : "")?>" size="20" type="text" class="medium <?php echo ((isset($errors_in_prices)) && (in_array("3lb_Refill_Bag", $errors_in_prices['errorFields']))) ? 'errorInBack' : ''?>" />                
				<?php else:?>         
         <div id="pricesDiv" class="field" style="border:1px solid #069; padding-left:40px; padding-top:10px; width:290px; margin-left:150px;">    			                
				<span class="field" style="color:#069; font-weight:bold;">Click the price text to change !</span>
         		<table id="priceTable" border="1" cellspacing="0" cellpadding="0" width="250">
                <thead>
                	<th align="left" style="font-weight:bold; color:#444444;">Weight</th>
                    <th align="right" style="font-weight:bold; color:#444444;">Price</th>
                	<tr>
                    	<td colspan="2">&nbsp;</td>    
                    </tr>    
                </thead>
                <tbody>
				<?php foreach($product_prices as $eachPrice):?>
                	<tr>
                    	<td align="left" style="font-weight:bold; color:#444444;"><?=str_replace("_", " ", $eachPrice['loaf_type'])?></td>    
                    	<td align="right" class="price_change" id="<?=$eachPrice['id']?>" style="font-weight:bold; color:#444444;"><?=$eachPrice['price']?></td>    
                    </tr>    
                	<tr>
                    	<td colspan="2">&nbsp;</td>    
                    </tr>    
         		<?php endforeach;?>
                </tbody>
                </table>
                <?php endif;?>
         </div>
		   <?php
                if ((!empty($product_details['product_image'])) && ($product_details['product_image'] != '')):
                    $upload_directory = '../images/products/';
                    $image_size = getimagesize($upload_directory.$product_details['product_image']);
           ?>
              <div class="field">
              <label for="main_image">Prodcut Image</label>
              <img id="main_image" name="main_image" src="../images/products/<?=(($product_details['product_image'] != "") ? $product_details['product_image'] : "")?>" border="0">
              </div>
           <?php endif; ?>
         <div class="field">
            <label for="name">Product Image</label>            
            <input type="file" id="product_image" name="product_image" size="60" class="medium">
            <!--<p style="margin-left:150px;"><strong><em>Note: Image size must be 200x200px</em></strong></p>-->
         </div>
          <div class="buttonrow">
                <button class="btn" type="button" onClick="javascript: location='desktop.php';" >Go Back</button>
                <button class="btn btn-black" type="submit">Edit Product</button> 
          </div>
      </form>
</div> 
 <?php include_once("inc_footer.php"); ?>