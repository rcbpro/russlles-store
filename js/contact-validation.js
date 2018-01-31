$(document).ready(function() { 
$("#contact_us").validate({			 	
		rules:{
			client_name:{
				required:true
			},
			telephone:{
				required:true
			},
			email:{
				required:true,
				email:true
			},
			subject:{
				required:true,
			},
			message:{
				required:true
			}
		},
		messages:{
			telephone:{
				required:" Please enter your name"
			},	
			client_name:{
				required:" Please enter your name"
			},
			email:{
				required:" Please enter your email",
				email:"Please enter valid email"
			},
			subject:{
				required:"Please enter your subject"
			},
			message:{
				required:"Please enter your message"
			}
		},		
		submitHandler:function(form){
			$.ajax({
			type   :    "POST",
			url    :    "contact-us-save.php",
			cache  :	false,
			data   :    $("#contact_us").serialize(),
			success: function(html){
				switch(html){ 
					case '7':
						$("#back-message").html("Thank you for Contact us");
						break;
					case '6':
						$("#back-message").html("");
						break;
				}
			
			}
		});
			return false;
		}
	});
	
});