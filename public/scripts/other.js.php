<?php 
defined("PS") ? NULL : define("PS", "/");
defined("WEB_PATH") ? NULL : define("WEB_PATH", "http://".$_SERVER['HTTP_HOST'].PS."www.russlls-famous-cookies.com".PS);
?>
$(document).ready(function(){
	$("#backToShoppingButton").click(function(){
		location.href = "<?php echo WEB_PATH?>index.php";
	});						   	
	$("#toCheckOutButton").click(function(){
		location.href = "<?php echo WEB_PATH?>billing.php";
	});						   	
	$("#shippingAddressCheckBox").change(function(){
		if ($('#shippingAddressCheckBox').is(':checked')){
        	$("#payment-address-shipping").removeClass("hide");
	    }else{
        	$("#payment-address-shipping").addClass("hide");
        }
    });
});