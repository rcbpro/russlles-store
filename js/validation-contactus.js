// Easy Pool Js
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
				required:true
			},
			message:{
				required:true
			}			
		},
		messages:{
			client_name:{
				required:"Please enter Your Name."
			},
			telephone:{
				required:"Please enter Your Telephone."
			},
			email:{
				required:"Please enter Your Email.",
				email:"Please enter valide Email"
			},
			subject:{
				required:"Please enter Subject."
			},
			message:{
				required:"Please enter Message."
			}		
		}
	});
	
}); 