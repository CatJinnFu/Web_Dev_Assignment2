$(document).ready(function(){


	      		 $.post("php/functions.php",{ 
                                           action:"loadCart"
                                          },function(data,status)){

	      		 				$("#items").val(data)
         		});


});