function get_confirmation(message,url){
	if(confirm(message)==1)	{
		top.location= url;	
	}
}

function change_values(element_id){
	document.getElementById(element_id).value = "";
}

$(document).ready(function() { 
//$("#testimonial").validate({			 	
//		rules:{
//			user:{
//				required:true
//			},
//			summary_description:{
//				required:true
//			},
//			description:{
//				required:true
//			}			
//		},
//		messages:{
//			user:{
//				required:"Please enter Testimonial User"
//			},
//			summary_description:{
//				required:"Please enter Summary Description"
//			} 		
//		}
//	});
	
$("#user").validate({			 	
		rules:{
			first_name:{
				required:true
			},
			last_name:{
				required:true
			},
			user_name:{
				required:true
			},
			password:{
			},
			re_password:{
				equalTo: "#password"
			}			
		},
		messages:{
			first_name:{
				required:" Please enter First Name"
			},
			last_name:{
				required:" Please enter Last Name"
			},
			user_name:{
				required:" Please enter User Name"
			},
			password:{
			},
			re_password:{
				equalTo: "Password doesn't match"
			}			
		}
	});

$("#video").validate({			 	
		rules:{
			script:{
				required:true
			}			
		},
		messages:{
			script:{
				required:" Please enter First Name"
			}			
		}
	});

$("#current_special").validate({			 	
		rules:{
			summary_description:{
				required:true
			},
			description:{
				required:true
			}			
		},
		messages:{
			summary_description:{
				required:"Please enter Summary Description"
			},
			description:{
				required:" Please enter Description"
			}			
		}
	});

$("#newsletter").validate({			 	
		rules:{
			name:{
				required:true
			},
			email:{
				required:true,
				email:true
			}
		},
		messages:{
			name:{
				required:" Please enter name"
			},	
			email:{
				required:" Please enter email",
				email:"Please enter valid email"
			}
		},		
		submitHandler:function(form){
			$.ajax({
			type   :    "POST",
			url    :    "newsletter-signup.php",
			cache  :	false,
			data   :    $("#newsletter").serialize(),
			success: function(html){
				switch(html){ 
					case '1':
						$("#status").html("Thank you for signup");
						break;
					case '2':
						$("#status").html("Email already exists");
						break;
				}
			
			}
		});
			return false;
		}
	});
	
$("#contact_us").validate({			 	
		rules:{
			client_name:{
				required:true
			},
			email:{
				email:true
			},
			message:{
				required:true
			}
		},
		messages:{
			client_name:{
				required:" Please enter your name"
			},	
			email:{
				email:"Please enter valid email"
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

$("#request").validate({			 	
		rules:{
			client_name:{
				required:true
			},
			email:{
				required:true,
				email:true
			},
			service_request:{
				required:true
			}
		},
		messages:{
			client_name:{
				required:" Please enter your name"
			},	
			email:{
				required:" Please enter your email",
				email:"Please enter valid email"
			},
			service_request:{
				required:"Please select service request"
			}
		},		
		submitHandler:function(form){
			$.ajax({
			type   :    "POST",
			url    :    "service-request-form-save.php",
			cache  :	false,
			data   :    $("#request").serialize(),
			success: function(html){
				switch(html){ 
					case '7':
						$("#back-message").html("Your Service Request has been send to site administrator");
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
