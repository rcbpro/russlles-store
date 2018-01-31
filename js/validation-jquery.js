// Easy Pool Js
$(document).ready(function() { 
$("#login_form").validate({ 	
		rules:{
			user_name:{
				required:true
			},
			password:{
				required:true
			}			
		},
		messages:{
			user_name:{
				required:"Please enter User Name."
			},
			password:{
				required:"Please enter Password."
			}		
		}
	
	});
	
}); 