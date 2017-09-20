// ===============================
// AUTHOR     : Dieter Schmid   
// CREATE DATE     : 18/09/2017 (added header)
// PURPOSE     : validation functions for user order form.
// SPECIAL NOTES:
// ===============================
// Change History:
//
//==================================



$(document).ready(function(){

    
           

        $("#firstname").blur(function(){
        		$.post("php/check.php",{
        								   fieldname:"firstname",
        								   value:$("#firstname").val()
        								  }, function(data, status){
         						
         						
         		});
        });

        $("#lastname").blur(function(){
        		$.post("php/check.php",{
        								   fieldname:"lastname",
        								   value:$("#lastname").val()
        								  }, function(data, status){
         						
         						
         		});
        });

        $("#address").blur(function(){
        		$.post("php/check.php",{
        								   fieldname:"address",
        								    value:$("#address").val()
        								  }, function(data, status){
         						
         						
         		});
        });

        $("#company").blur(function(){
        			$.post("php/check.php",{
        								    fieldname:"company",
        								    value:$("#company").val()
        								  }, function(data, status){
         						
         						
         		});
        });

        $("#city").blur(function(){
        			$.post("php/check.php",{
        								    fieldname:"city",
        								    value:$("#city").val()
        								  }, function(data, status){
         						
         						
         		});
        });

        $("#postcode").blur(function(){
        		$.post("php/check.php",{
        								    fieldname:"postcode",
        								    value:$("#postcode").val()
        								  }, function(data, status){
         						
         				  if(data.trim() == 'error'){		
         					//alert("Invalid Postcode");
         					$("#postcode").val("invalid").css("color","red");
         					
       					  } else if (parseInt($("#postcode").val()) != NaN) {
       					  	$("#postcode").val(parseInt($("#postcode").val())).css("color","black");
       					  
       					  }	   	
       					  
         		});
        });

         $("#country").blur(function(){
        		$.post("php/check.php",{country:$("#country").val()}, function(data, status){
           						if($("#state").val() == ""){
         							$("#state").val("Required field");
         						} else if ($("#country").val() == "AU") {
  									if(!$("#state").val()){	
         							$("#state").html(
         											 "<option value='VIC'>VIC</option>" +
         											 "<option value='NSW'>NSW</option>" +
         											 "<option value='WA'>WA</option>" +
         											 "<option value='TAS'>TAS</option>" +
         											 "<option value='NT'>NT</option>" +
         											 "<option value='SA'>SA</option>")	
         							}
         						} else {
         									$("#state").html("");	
         						}
         		});
        });

            $("#country").click(function(){
        		$.post("php/check.php",{country:$("#country").val()}, function(data, status){
           						if($("#state").val() == ""){
         							$("#state").val("Required field");
         						} else if ($("#country").val() == "AU") {
  									if(!$("#state").val()){	
         							$("#state").html(
         											 "<option value='VIC'>VIC</option>" +
         											 "<option value='NSW'>NSW</option>" +
         											 "<option value='WA'>WA</option>" +
         											 "<option value='TAS'>TAS</option>" +
         											 "<option value='NT'>NT</option>" +
         											 "<option value='SA'>SA</option>")	
         							}
         						} else {
         									$("#state").html("");	
         						}
         		});
        });
	


        $("#state").blur(function(){
        		$.post("php/check.php",{state:$("#state").val()}, function(data, status){
           						if($("#state").val() == ""){
         							$("#state").val("Required field");
         						} else if ($("#country").val() == "AU") {
  									if(!$("#state").val()){	
         							$("#state").html(
         											 "<option value='VIC'>VIC</option>" +
         											 "<option value='NSW'>NSW</option>" +
         											 "<option value='WA'>WA</option>" +
         											 "<option value='TAS'>TAS</option>" +
         											 "<option value='NT'>NT</option>" +
         											 "<option value='SA'>SA</option>")	
         							}
         						} else {
         									$("#state").html("");	
         						}
         		});
        });

         $("#state").click(function(){
        		$.post("php/check.php",{state:$("#state").val()}, function(data, status){
           						if($("#state").val() == ""){
         							$("#state").val("Required field");
         						} else if ($("#country").val() == "AU") {
         						    if(!$("#state").val()){	
         							$("#state").html(
         											 "<option value='VIC'>VIC</option>" +
         											 "<option value='NSW'>NSW</option>" +
         											 "<option value='WA'>WA</option>" +
         											 "<option value='TAS'>TAS</option>" +
         											 "<option value='NT'>NT</option>" +
         											 "<option value='SA'>SA</option>")	
         							}
         						}else {
         									$("#state").html("");	
         						}
         		});
        });

        $("#country").blur(function(){
        			$.post("php/check.php",{
        								    fieldname:"country",
        								    value:$("#country").val()
        								  }, function(data, status){
         						
         					
         		});
        });

        $("#phone").blur(function(){
        			$.post("php/check.php",{
        								    fieldname:"phone",
        								    value:$("#phone").val()
        								  }, function(data, status){
         				if(data.trim() == 'error'){		
         					$("#phone").val(" ");
         					$("#phone").val($("#phone").val() + " this is invalid - format (XX)XXXX XXXX").css("color","red");
         	
         					
       					  } else {
       					  	$("#phone").val($("#phone").val()).css("color","black");;
       					  	
       					  }	
         						
         		    });
        });

        $("#email").blur(function(){
        		$.post("php/check.php",{
        								    fieldname:"email",
        								    value:$("#email").val()
        								  }, function(data, status){
         				  if(data.trim() == 'error'){		
         					$("#email").val(" ");
         					$("#email").val($("#email").val() + " this is invalid.").css("color","red");
         					
         					
         					
       					  } else {
       					  	$("#email").val($("#email").val()).css("color","black");;
       					  	
       					  }	
         		});
        });

        

      /* $("#email_test_pw").blur(function(){
                $.post("php/check.php",{
                                            fieldname:"email_test_pw",
                                            value:$("#email_test_pw").val()
                                          }, function(data, status){
                          if(data.trim() == 'error'){       
                            $("#email_test_pw").val(" ");
                            $("#email_test_pw").val($("#email_test_pw").val() + " this is invalid.").css("color","red");
                            
                            
                            
                          } else {
                            $("#email_test_pw").val($("#email_test_pw").val()).css("color","black");;
                            
                          } 
                });
        });

        $("#email_test").blur(function(){
                $.post("php/check.php",{
                                            fieldname:"email_test",
                                            value:$("#email_test").val()
                                          }, function(data, status){
                          if(data.trim() == 'error'){       
                            $("#email_test").val(" ");
                            $("#email_test").val($("#email_test").val() + " this is invalid.").css("color","red");
                            
                            
                            
                          } else {
                            $("#email_test").val($("#email_test").val()).css("color","black");;
                            
                          } 
                });
        });*/


      	
       $("form :input").focus(function(){

        	var text = "";
        	error = false;

        		$.post("php/check.php",{
        								    fieldname:"email",
        								    value:$("#email").val()
        								  }, function(data, status){
         				  if(data.trim() == 'error'){	
                            console.log("print-- " + data + " -  " + $("#email").val());	
         					$("#email").val(" ");
         					$("#email").val($("#email").val() + " this is invalid.").css("color","red");
         					error = true;	
        					text += "<p>Invalid email<\p>";
        				
         					
         					
       					  } else {
       					  	$("#email").val($("#email").val()).css("color","black");;
       					  	
       					  }	
         		});
        	
      			$.post("php/check.php",{
        								    fieldname:"phone",
        								    value:$("#phone").val()
        								  }, function(data, status){
         				if(data.trim() == 'error'){		
         					$("#phone").val(" ");
         					$("#phone").val($("#phone").val() + " this is invalid.").css("color","red");
         						error = true;	
        					    text += "<p>Invalid Phone Number - format (XX)XXXX XXXX<\p>";
        					
         					
       					  } else {
       					  	$("#phone").val($("#phone").val()).css("color","black");;
       					  	
       					  }	
         						
         		    });
      
				$.post("php/check.php",{
        								    fieldname:"postcode",
        								    value:$("#postcode").val()
        								  }, function(data, status){
         						
         				  if(data.trim() == 'error'){		
         					//alert("Invalid Postcode");
         					$("#postcode").val("invalid").css("color","red");
         						error = true;	
        					    text += "<p>Invalid Post Code<\p>";
        				
         					
       					  } else if (parseInt($("#postcode").val()) != NaN) {
       					  	$("#postcode").val(parseInt($("#postcode").val())).css("color","black");
       					  }	  else {
       					  	error = true;	
        					text += "<p>Invalid Post Code<\p>";
       					  }

       					
       					  
         		});

                
                    $.post("php/check.php",{
                                            fieldname:"country",
                                            value:$("#country").val()
                                          }, function(data, status){
                                
                            
                    });

    

        
                
				
				$.post("php/check.php",{
        								    fieldname:"default",
        								    value:$("#aButton").val()
        								  }, function(data, status){
         						
         			
       					  	if($("#firstname").val() == "" ){error = true;	 text += "<p>Requires a First name<\p> ";}
        					if($("#lastname").val() == "" ){error = true;	 text += "<p>Requires a Last name<\p> ";}
        					if($("#address").val() == "" ){error = true;	 text += "<p>Requires an Address<\p> ";}
        					if($("#city").val() == "" ){ error = true;	text += "<p>Requires a City<\p> ";}
        					if($("#state").val() == "" ){ error = true;	text += "<p>Requires a State<\p>";}	
        					if($("#country").val() == "" ){ error = true;	text += "<p>Requires a Country<\p> ";}

        					if(error) {
         			
        							$("#errors").html(text);
                                    $("#aButton").prop('disabled', true);
        					} else {
         			               $("#aButton").prop('disabled', false);
         							//window.location.href = "checkout2.php";	
         					} 	
       					  
         		});		

         });


        $("#button_2").click(function(){
        		
                $.post("php/check.php",{
                                            fieldname:"shipping",
                                            value:$("input[name=delivery]:checked").val()
                                          }, function(data, status){

                            if ($("input[name=delivery]:checked").val()){


                    //write function to add shipping cost.
                    window.location.href = "checkout3.php"; 
                    } else {

                    $("#error").html("<p>Please selected Shipping Option.</p>");
                    }                
                    
                                
            });

        	
        		
        });	

        $("#card_name").blur(function(){
        			$.post("php/check.php",{
        								    fieldname:"card_name",
        								    value:$("#card_name").val()
        								  }, function(data, status){
         			
         						
         		     });
        });

        $("#card_number").blur(function(){
        			$.post("php/check.php",{
        								    fieldname:"card_number",
        								    value:$("#card_number").val()
        								  }, function(data, status){
         			 	  if(data.trim() == 'error'){		
         				
         					$("#card_number").val("invalid").css("color","red");
         					$("#error_msg").html("Enter 16 digits XXXXXXXXXXXXXXXX");
         					
       					  }else if (parseInt($("#card_number").val()) != NaN) {
       					  	$("#card_number").val(parseInt($("#card_number").val())).css("color","black");
       					  	$("#error_msg").html("");
       					  }	  
         						
         		     });
        });

      $("#expiry_month").blur(function(){
        			$.post("php/check.php",{
        								    fieldname:"expiry_month",
        								    value:$("#expiry_month").val(),
        								    year:$("#expiry_year").val()
        								  }, function(data, status){
        				
         				  if(data.trim() == 'error'){		
         					
         					$("#expiry_month").val("invalid").css("color","red");
         					$("#error_msg").html("Number of Month - i.e. 03");
         					
         					
       					  } else if (data.trim() == 'out'){
       					  
       					   		$("#expiry_month").val("invalid").css("color","red");
         					    $("#error_msg").html("Invalid Month Entered");
       					  } else if (parseInt($("#expiry_month").val()) != NaN) {
       					  	$("#expiry_month").val(parseInt($("#expiry_month").val())).css("color","black");
       					  	$("#error_msg").html("");
       					  }	
         		     });
       					 
       					  
        });

        $("#expiry_year").blur(function(){
        			$.post("php/check.php",{
        								    fieldname:"expiry_year",
        								    value:$("#expiry_year").val(),
        								    month:$("#expiry_month").val()
        								  }, function(data, status){
        								  	
         				  if(data.trim() == 'error'){		
         					
         					$("#expiry_year").val("invalid").css("color","red");
         					$("#error_msg").html("Number of year - i.e. 2017");
         				         					
       					  } else if (data.trim() == 'out'){
       					
       					   		$("#card_number").val("invalid").css("color","red");
         					    $("#error_msg").html("Invalid Year Entered");
       					  }else if (parseInt($("#expiry_year").val()) != NaN) {
       					  	$("#expiry_year").val(parseInt($("#expiry_year").val())).css("color","black");
       					  
       					  	$("#error_msg").html("");
       					  }	
         						
         		     });
       					  
        });  

        $("#cvv").blur(function(){
        			$.post("php/check.php",{
        								    fieldname:"cvv",
        								    value:$("#cvv").val()
        								  }, function(data, status){
         			
         				    if(data.trim() == 'error'){		
         					//alert("Invalid Postcode");
         					$("#cvv").val("invalid").css("color","red");
         					$("#error_msg").html("Insert XXX - 3 Numbers");
         					//alert("Insert XXX - 3 Numbers");
         					
       					  } else if (parseInt($("#cvv").val()) != NaN) {
       					  	$("#cvv").val(parseInt($("#cvv").val())).css("color","black");
       					  	//console.log("print-- " + data);
       					  	$("#error_msg").html("");
       					  }		
         		     });
        });  
          
         				
        $("#button_3").click(function(){
        			var error_text = "";
        			error = false;
        	
        			$.post("php/check.php",{
        								    fieldname:"card_number",
        								    value:$("#card_number").val()
        								  }, function(data, status){
         			 	  if(data.trim() == 'error'){		
         				
         					$("#card_number").val("invalid").css("color","red");
         					error_text += "<p>Invalid Card Number</p>";
         					error = true;
         					
       					  }else if (parseInt($("#card_number").val()) != NaN) {
       					  	$("#card_number").val(parseInt($("#card_number").val())).css("color","black");
       					  	//$("#error_msg").html("");
       					  }	  
         						
         		     });
        	

        	
        			$.post("php/check.php",{
        								    fieldname:"expiry_month",
        								    value:$("#expiry_month").val(),
        								    year:$("#expiry_year").val()
        								  }, function(data, status){
        				
         				  if(data.trim() == 'error'){		
         					
         					$("#expiry_month").val("invalid").css("color","red");
         					//$("#error_msg").html("Number of Month - i.e. 03");
         					error_text += "<p>Invalid Month</p>";
         					error = true;
         					
       					  } else if (data.trim() == 'out'){
       					  	console.log("print-- *" + data);
       					   		$("#card_number").val("invalid").css("color","red");
         					    error_text += "<p>Invalid Month</p>";
         					    error = true;
       					  } else if (parseInt($("#expiry_month").val()) != NaN) {
       					  	$("#expiry_month").val(parseInt($("#expiry_month").val())).css("color","black");
       					  	//$("#error_msg").html("");
       					  }	
         		    });
       					 


        	
        			$.post("php/check.php",{
        								    fieldname:"expiry_year",
        								    value:$("#expiry_year").val(),
        								    month:$("#expiry_month").val()
        								  }, function(data, status){
        								  	
         				  if(data.trim() == 'error'){		
         					
         					$("#expiry_year").val("invalid").css("color","red");
         					$("#error_msg").html("Number of year - i.e. 2017");
         				    error_text += "<p>Invalid year</p>";     
         				    error = true;					
       					  } else if (data.trim() == 'out'){
       					  	console.log("print-- *" + data);
       					   		$("#card_number").val("invalid").css("color","red");
         					    $("#error_msg").html("Invalid Year Entered");
         					    error_text += "<p>Invalid year</p>"; 
         					    error = true;
       					  }else if (parseInt($("#expiry_year").val()) != NaN) {
       					  	$("#expiry_year").val(parseInt($("#expiry_year").val())).css("color","black");
       					  
       					  	$("#error_msg").html("");
       					  }	
         						
         		     });
       					  
        

        	
        			$.post("php/check.php",{
        								    fieldname:"cvv",
        								    value:$("#cvv").val()
        								  }, function(data, status){
         			
         				  if(data.trim() == 'error'){		
         					//alert("Invalid Postcode");
         					$("#cvv").val("invalid").css("color","red");
         					$("#error_msg").html("Insert XXX - 3 Numbers");
         					error_text += "<p>Invalid cvv</p>"; 
         					error = true;
         					
       					  } else if (parseInt($("#cvv").val()) != NaN) {
       					  	$("#cvv").val(parseInt($("#cvv").val())).css("color","black");
       					  	//console.log("print-- " + data);
       					  	//$("#error_msg").html("");
       					  }		


       					  if($("#card_name").val() == "" ){error = true;	error_text += "<p>Requires a name<\p> ";}

       					  if(error){
       					  		$("#msg").html(error_text);
        				  } else if ($("input[name=payment]:checked").val()){
                                        //pass values here.
                                        //
        								window.location.href = "order.php";	
        				  } else {

        						$("#msg").html("<p>Please selected Shipping Option.</p>");
        				  }
         		     });
        

        		

        	

        		
        });						
        

   
});

