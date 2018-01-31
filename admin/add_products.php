<?php

include_once("../lib/ckeditor/ckeditor.php");
include_once("../lib/ckfinder/ckfinder.php"); 
include_once("inc_header.php"); 
require_once("../config.php");
require_once("../lib/functions.php");

if ("POST" == $_SERVER['REQUEST_METHOD']){
	if ((isset($_POST['product'])) && (!isset($_GET['product_id'])) && (isset($_POST['product_prices']))){
		$errors = errorCheckingFields($_POST['product']);
		$errors_in_prices = errorCheckingFields($_POST['product_prices']);		
		if ((($errors['errorStatus'] == 'true') || ($errors_in_prices['errorStatus'] == 'true')) && ($_FILES['product_image']['name'] == "")){
			$error_message = "Please fix these errors";
		}else if ((($errors['errorStatus'] == 'false') && ($errors_in_prices['errorStatus'] == 'false')) && ($_FILES['product_image']['name'] != "")){
			if (move_uploaded_file($_FILES['product_image']['tmp_name'], $_SERVER['DOCUMENT_ROOT']."www.russlls-famous-cookies.com/images/products/".basename($_FILES['product_image']['name']))){
				// Add product details
				$product_image = $_FILES['product_image']['name'];
				$sql = "INSERT INTO products (product_name, product_description, product_image) 
						VALUES('".mysql_preperation($_POST['product']['name'])."', '".mysql_preperation($_POST['product']['description'])."', '".mysql_preperation($product_image)."')";
				$DBConn->execute_query($sql);
				$product_id = $DBConn->getLastInsertedId();
				// Add four product prices
				foreach($_POST['product_prices'] as $key => $val){
					$sql = "INSERT INTO products_prices (product_id, loaf_type, price) 
							VALUES(".$product_id.", '".mysql_preperation($key)."', '".$val."')";
					$DBConn->execute_query($sql);
				}
				$_SESSION['product_addedd_success'] = true;
				header("Location: http://".$_SERVER['HTTP_HOST'].'/www.russlls-famous-cookies.com/admin/list_products.php');
				//exit();
			}else{
				$_SESSION['upload_error_message'] = true;			
			}	
		}	
	}
}

?>
<div id="masthead"> 
    <div class="content_pad"> 
        <h1 class="no_breadcrumbs"><?php echo (isset($html_title)) ? $html_title : ""?> Content Edit</h1> 
    </div> <!-- .content_pad -->
</div> <!-- #masthead -->	
<div id="content" class="xgrid"> 
	<?php if ((isset($error_message)) && ($error_message != "")):?>
    <span id="productQtyErrorMessage"><?=$error_message?></span>
    <?php endif;?>
    <div class="x12">
        <form id="products" name="products" method="post" class="form label-inline uniform" action="" enctype="multipart/form-data">
          <div class="field">
                <label for="product_name">Product Name</label> 
                <input id="product_name" name="product[name]" size="53" type="text" value="<?=(isset($_POST['product']['name']) && ($_POST['product']['name'] != "") ? $_POST['product']['name'] : "")?>" class="medium <?php echo ((isset($errors)) && (in_array("name", $errors['errorFields']))) ? 'errorInBack' : ''?>" />
          </div>
          <div class="field">
                <label for="name">Description</label> 
                <textarea id="description" name="product[description]" cols="50" rows="4" class="<?php echo ((isset($errors)) && (in_array("description", $errors['errorFields']))) ? 'errorInBack' : ''?>"><?=(isset($_POST['product']['description']) && ($_POST['product']['description'] != "") ? $_POST['product']['description'] : "")?></textarea>
          </div>
         <div id="pricesDiv" class="field" style="border:1px solid #069; padding:10px; width:310px; margin-left:150px;">
                <label for="product_price1">Price for 3lb</label>
                <input id="product_price1" name="product_prices[3lb]" value="<?=(isset($_POST['product_prices']['3lb']) && ($_POST['product_prices']['3lb'] != "") ? $_POST['product_prices']['3lb'] : "")?>" size="20" type="text" class="medium <?php echo ((isset($errors_in_prices)) && (in_array("3lb", $errors_in_prices['errorFields']))) ? 'errorInBack' : ''?>" /><br /><br />                
                <label for="product_price2">Price for 1.5lb</label>
                <input id="product_price2" name="product_prices[1.5lb]" value="<?=(isset($_POST['product_prices']['1.5lb']) && ($_POST['product_prices']['1.5lb'] != "") ? $_POST['product_prices']['1.5lb'] : "")?>" size="20" type="text" class="medium <?php echo ((isset($errors_in_prices)) && (in_array("1.5lb", $errors_in_prices['errorFields']))) ? 'errorInBack' : ''?>" /><br /><br />                
                <label for="product_price3">Price for 0.5lb Sample</label>
                <input id="product_price3" name="product_prices[0.5lb_Sample]" value="<?=(isset($_POST['product_prices']['0.5lb_Sample']) && ($_POST['product_prices']['0.5lb_Sample'] != "") ? $_POST['product_prices']['0.5lb_Sample'] : "")?>" size="20" type="text" class="medium <?php echo ((isset($errors_in_prices)) && (in_array("0.5lb_Sample", $errors_in_prices['errorFields']))) ? 'errorInBack' : ''?>" /><br /><br />                
                <label for="product_price4">Price for 3lb Refill Bag</label>
                <input id="product_price4" name="product_prices[3lb_Refill_Bag]" value="<?=(isset($_POST['product_prices']['3lb_Refill_Bag']) && ($_POST['product_prices']['3lb_Refill_Bag'] != "") ? $_POST['product_prices']['3lb_Refill_Bag'] : "")?>" size="20" type="text" class="medium <?php echo ((isset($errors_in_prices)) && (in_array("3lb_Refill_Bag", $errors_in_prices['errorFields']))) ? 'errorInBack' : ''?>" />                
         </div>
         <div class="field">
         	<?php echo ((isset($_FILES['product_image']['name'])) && ($_FILES['product_image']['name'] == "")) ? "<span style='color:red; font-weight:bold; font-size:14px;'>*</span>" : ""?>
            <label for="product_image">Product Image</label>            
            <input type="file" id="product_image" name="product_image" size="60" class="medium">
            <!--<p style="margin-left:150px;"><strong><em>Note: Image size must be 200x200px</em></strong></p>-->
         </div>
          <div class="buttonrow">
                <button class="btn" type="button" onClick="javascript: location='desktop.php';" >Go Back</button>
                <button class="btn btn-black" type="submit">Add Product</button> 
          </div>
      </form>
</div> 
 <?php include_once("inc_footer.php"); ?>