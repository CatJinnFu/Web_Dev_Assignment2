// ===============================
// AUTHOR     : Dieter Schmid   
// CREATE DATE     : 18/09/2017 (added header)
// PURPOSE     : Javascript processing of the search field data entered.
// SPECIAL NOTES:
// ===============================
// Change History:
//
//==================================
$(document).ready(function(){

	 $("#search_content").keydown(function(){

        		$.post("php/search.php",{ 
                            return: "True", 
        								   value:$("#search_content").val()
        								  }, function(data, status){
         				
         			

         				var searches = data.split("\n");
         				
         				var options ="";
         				

         				for (var i = 0; i < searches.length; i++) {
    							
         						options += "<option value='" + searches[i] + "'>\n"
    					}
	    				
	    				
    					$("#searches").html(options);


 

         		});

         		
        });

         $("#search_content").keyup(function(){

                $.post("php/search.php",{ 
                                           return: "True", 
                                           value:$("#search_content").val()
                                          }, function(data, status){
                        
                     

                        var searches = data.split("\n");
                        
                        var options ="";
                        

                        for (var i = 0; i < searches.length; i++) {
                                
                                options += "<option value='" + searches[i] + "'>\n"
                        }
                        
                        
                        $("#searches").html(options);


 

                });

                
        });



     

});

function makeSearch(){

  
                $.post("php/search.php",{ 
                                           submit: "True", 
                                           value:$("#search_content").val()
                                          }, function(data, status){
                          
               
                    
                   window.location.href = "search.html";


                });
              
}

function loadSearchResults(){

xml=loadXSLDoc("search_clothes.xml");
xsl=loadXSLDoc("search_test.xsl");
// code for IE

if (window.ActiveXObject)
  {
  ex=xml.transformNode(xsl);
  document.getElementById("search_results").innerHTML=ex;
  }
// code for Mozilla, Firefox, Opera, etc.
else if (document.implementation && document.implementation.createDocument)
  {
  xsltProcessor=new XSLTProcessor();
  xsltProcessor.importStylesheet(xsl);
  resultDocument = xsltProcessor.transformToFragment(xml,document);
  document.getElementById("search_results").innerHTML="";
  document.getElementById("search_results").appendChild(resultDocument);

  }


}