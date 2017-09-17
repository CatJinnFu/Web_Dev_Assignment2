/* ********When the User clicks a clothing category the loadXMLDoc() function is executed.
*
* The loadXMLDoc() function creates an XMLHttpRequest object, adds the function to be executed when the server response is ready, and sends the request off to the server.
* When the server response is ready, the XMLHttpRequest object is parsed to a function in the onload()  event this is to build the side menu.
* 
* This all works in the lastest Chrome and IE browsers, there are issues in firefox.
*
* Never ended up using Jquery, just Ajax, JAvascript, XML, XSL, and DOM. 
*
* Written by Dieter Schmid on 20/07/2017 base on the https://www.w3schools.com/xml/xml_http.asp tutorial. 
***************/
numItems = 6;
start = 0;
pageItems = 6;
totalNumItems = 0;
nextPage = false;
totalItemsMen = 0;
totalItemsLady = 0;
count = 0;
once = false;
oldType = 'none';

/***Basic XML load function take from W3C
*
*   Written by Dieter Schmid on 20/07/2017
**/



function loadXMLDoc(url, cFunction, gender,type)
{
  cGender = gender;
  cType = type;

  
    var xmlhttp=new XMLHttpRequest();
    xmlhttp.onreadystatechange=function()
    {
     if (this.readyState==4 && this.status==200) {

       cFunction(this);



    }//end of if
  } //end of callback function

  xmlhttp.open("GET",url,true);
  xmlhttp.send();

} //end of loadXMLDoc(url)


/***When the category html page is load the sideMenu is built.
*
* Written by Dieter Schmid on 20/07/2017
**/

function sideMenuBuild(xmlhttp){
  
  var x=xmlhttp.responseXML.documentElement.getElementsByTagName("men");
  totalItemsMen = x[0].getElementsByTagName("item").length;
  //listItemsNumber(6);
  var txt="<a href='category-man.html?#6'>Men" + "<span class='badge pull-right'>" 
  + x[0].getElementsByTagName("item").length + "</span></a>\n" +"<ul>\n";
  //var i = 0;
  //for (i=0;i<x.length;i++)
      txt += "<li> <a href='category-man.html?cType=T-shirt' onclick='loadXMLDoc('clothes.xml',loadItems,'men','none')'>T-shirts</a>\n" +
                                        "</li>\n" +
                                        "<li><a href='category-man.html?cType=Shirt' onclick='loadXMLDoc('clothes.xml',loadItems,'men','none')'>Shirts</a>\n" +
                                        "</li>\n" +
                                        "<li><a href='category-man.html?cType=Pants' onclick='loadXMLDoc('clothes.xml',loadItems,'men','none')'>Pants</a>\n" +
                                        "</li>\n" +
                                        "<li><a href='category-man.html?cType=Accessories' onclick='loadXMLDoc('clothes.xml',loadItems,'men','none')''>Accessories</a>\n" +
                                        "</li>\n" +
                                    "</ul>\n" +
                                "</li>";

  document.getElementById('men_list').innerHTML=txt;

  x=xmlhttp.responseXML.documentElement.getElementsByTagName("ladies");
  totalItemsLady = x[0].getElementsByTagName("item").length;


  
  txt="<a href='category-lady.html?#6'>Ladies" + "<span class='badge pull-right'>" 
  + x[0].getElementsByTagName("item").length  + "</span></a>\n" +"<ul>\n";
  //var i = 0;
  //for (i=0;i<x.length;i++)
      txt += "<li><a href='category-lady.html?cType=T-shirt' onclick='loadXMLDoc('clothes.xml',loadItems,'ladies','none')'>T-shirts</a>\n" +
                                        "</li>\n" +
                                        "<li><a href='category-lady.html?cType=Shirt' onclick='loadXMLDoc('clothes.xml',loadItems,'ladies','none')'>Shirts</a>\n" +
                                        "</li>\n" +
                                        "<li><a href='category-lady.html?cType=Pants' onclick='loadXMLDoc('clothes.xml',loadItems,'ladies','none')'>Pants</a>\n" +
                                        "</li>\n" +
                                        "<li><a href='category-lady.html?cType=Accessories' onclick='loadXMLDoc('clothes.xml',loadItems,'ladies','none')'>Accessories</a>\n" +
                                        "</li>\n" +
                                    "</ul>\n" +
                                "</li>";

  document.getElementById('lady_list').innerHTML=txt;

      if(cGender==='men'){
                  totalNumItems = totalItemsMen;
                  
      } else if (cGender==='ladies'){

                  totalNumItems = totalItemsLady;
                  
      }
     
      if(start == 0 && cType != 'detail'){

        renderPages(1);

      }



}

/***This is a really big function that does most of the generation of product listing
*    Im sure it can be massively refactored.
*
*   Written by Dieter Schmid on 20/07/2017
**/

function loadItems(xmlhttp){
  

         //find the elements that belong to 'gender'
         var x=xmlhttp.responseXML.documentElement.getElementsByTagName(cGender); 
          //check filters
          //use javascript dom objects
          //is a brand or multiple brands selected ?
          //if brand is selected add to new array 
        var e = document.getElementById("price");
        var strUser = e.options[e.selectedIndex].text;
        //var option = options[0].text;
        

        if(strUser === "Price: low-high" ){
          lowHigh = true;
        } else {
          lowHigh = false;

        }

        itemTxt =''; 
        items = x[0];
        numItem = 6;
        

        //use function quick sort from http://www.geeksforgeeks.org/quick-sort/
        quickSort(items,0,items.getElementsByTagName("price").length-1);
        
          
        if(parent.document.URL.indexOf("?") != -1 && parent.document.URL.indexOf("#") == -1){
         cType = parent.document.URL.substring(parent.document.URL.indexOf('=')+1, parent.document.URL.length);
    
         numItems = items.getElementsByTagName("item").length;
         listDisplayGreyOut();
         pagesGreyOut();

          if(cType != oldType && cType != 'detail'){
            if(cGender === 'men'){
                  passParameterTypeToBrands('brands_men_type.xsl',cType);
            }  else {
                  passParameterTypeToBrands('brands_ladies_type.xsl',cType);
            }
           
            oldType = cType;  
          }
        } else {
         cType = 'none';

        }  

        //get all xml attributes

        xmlDoc = document.implementation.createDocument("", "", null);
        root = xmlDoc.createElement("clothes");
        xmlDoc.appendChild(root); 

        for(i = 0; i < items.getElementsByTagName("item").length;i++) {
           

         var brand = items.getElementsByTagName("brand")[i].childNodes[0].nodeValue;  
         var details = items.getElementsByTagName("product")[i].childNodes[0].nodeValue;    

         testType = 'none';
         //Test for the clothing category
         if(cType != 'none'){
           testType = items.getElementsByTagName("type")[i].childNodes[0].nodeValue;
         }
         
         //just to make sure
         if(brand !== null){
          var testBrand = document.getElementById(brand.split(" ")[0]).checked;

         }   

            if((testBrand && cType == 'none') || (testBrand && (cType === testType)) || (testBrand && (loadCheckBeltBag(details)===cType))) {

              var newNode =  items.getElementsByTagName('item')[i].cloneNode(true);
            
              xmlDoc.documentElement.appendChild(newNode);

              
            }
            
        }      

        totalNumItems =   xmlDoc.getElementsByTagName("item").length;    

        if(parent.document.URL.indexOf("#") != -1){  

           if( nextPage ){
                   
                  
                 if(!( (numItems + parseInt(parent.document.URL.substring(parent.document.URL.indexOf('#')+1, parent.document.URL.length))) > xmlDoc.getElementsByTagName("item").length) && start <= numItems ) {
                   numItems += parseInt(parent.document.URL.substring(parent.document.URL.indexOf('#')+1, parent.document.URL.length));
                    
                 } else if (start < numItems)  {
                   numItems = start + parseInt(parent.document.URL.substring(parent.document.URL.indexOf('#')+1, parent.document.URL.length)); 
                   
                 }  else {
                    numItems = xmlDoc.getElementsByTagName("item").length;
                 }
              
           } else {  
             
              if(parseInt(parent.document.URL.substring(parent.document.URL.indexOf('#')+1, parent.document.URL.length)) < xmlDoc.getElementsByTagName("item").length){
                numItems = parseInt(parent.document.URL.substring(parent.document.URL.indexOf('#')+1, parent.document.URL.length));
              } else {
                 numItems = xmlDoc.getElementsByTagName("item").length;
              }
              
           }      
        } 

        if( !parseInt(numItems)) {
          numItems = xmlDoc.getElementsByTagName("item").length;

        }

        if(xmlDoc.getElementsByTagName("item").length <= 6){
                  numItems = xmlDoc.getElementsByTagName("item").length;
                  listDisplayGreyOut();
                  pagesGreyOut();
                  once = true;
        } else if(once && xmlDoc.getElementsByTagName("item").length > 6){
          listItemsNumber(6);
          renderPages(1);
          numItems = xmlDoc.getElementsByTagName("item").length;
    
          once = false;
        }
        
      


        count = 0;
        
        for(i = start; i < numItems;i++) {
         //I dont see how these images can all be resized with looking strange anyway.
         var imgOne = xmlDoc.getElementsByTagName("photo_one")[i].childNodes[0].nodeValue; 
         var imgTwo = xmlDoc.getElementsByTagName("photo_two")[i].childNodes[0].nodeValue; 
         var details = xmlDoc.getElementsByTagName("product")[i].childNodes[0].nodeValue; 
         var price = xmlDoc.getElementsByTagName("price")[i].childNodes[0].nodeValue;
         var brand = xmlDoc.getElementsByTagName("brand")[i].childNodes[0].nodeValue;
         var type_ = xmlDoc.getElementsByTagName("type")[i].childNodes[0].nodeValue;
         var r = /\d+/;
         var id = xmlDoc.getElementsByTagName("id")[i].childNodes[0].nodeValue.trim();
         id = id.match(r);
     
         
         testType = 'none';
         //Test for the clothing category
         if(cType != 'none'){
           testType = xmlDoc.getElementsByTagName("type")[i].childNodes[0].nodeValue;
         }
         
         //just to make sure
         if(brand !== null){
          var testBrand = document.getElementById(brand.split(" ")[0]).checked;

         } 


         if((testBrand && cType == 'none') || (testBrand && (cType === testType)) || (testBrand && (loadCheckBeltBag(details)===cType))) {
            count++;
            itemTxt +="<div class='col-md-4 col-sm-6'><div class='product'><div class='flip-container'><div class='flipper'>" +
                      "<div class='front'><a href='detail.html#" + id +"?"+ type_ + "=" + cGender +"'><img src='img/product_img/" + imgOne +".jpg' alt='"+ imgOne +"' class='img-responsive'>" +
                      "</a></div><div class='back'><a href='detail.html#" + id +"?"+ type_ + "=" + cGender +"'><img src='img/product_img/" + imgTwo + ".jpg' alt='"+ imgTwo +"' class='img-responsive'>" +
                      "</a></div></div></div><a href='detail.html#" + id +"?"+ type_ + "=" + cGender +"' class='invisible'><img src='img/product_img/" + imgOne +".jpg' alt='"+ imgOne +"' class='img-responsive'></a>" +
                      "<div class='text'><h3><a href='detail.html#" + id +"?"+ type_ + "=" + cGender +"'>" + details + "</a></h3><p class='price'>" + price + "</p><p class='buttons'>" +
                      "<a href='detail.html#" + id +"?"+ type_ + "=" + cGender +"' class='btn btn-default'>View detail</a><a href='basket.php?action=add&g="+cGender +"&t="+type_+"&id="+id+"' class='btn btn-primary'>" + 
                      "<i class='fa fa-shopping-cart'></i>Add to cart</a></p></div>" +
                      "</div></div></div></div>";

                      document.getElementById('frontproduct').innerHTML=itemTxt;
          }    
         //add element 


      

             
         
         
         //document.getElementById('showOf').innerHTML =  showOfTxt;        
        // is low to high set ?
          //sort the array by the value of price
        } 

        if (count === 0) {
            itemTxt += "";
            document.getElementById('frontproduct').innerHTML=itemTxt;
        }
        
       
    

        document.getElementById('showOf').innerHTML = "Showing <strong>" + count +  "</strong> of <strong> " + xmlDoc.getElementsByTagName("item").length + " </strong> products";  
  //loop through array and pull out all t-shirts for that gender
  //render each item to the middle of the screen

}


//The loadXMLDoc() function is used to load the XML and XSL files. 
//It checks what kind of browser the user has and loads the file.
function loadXSLDoc(dname)
{ 
  xslhttp=new XMLHttpRequest();
  xslhttp.open("GET",dname,false);
  xslhttp.send("");
  return xslhttp.responseXML;
}

/*This function is used to display the XML file styled by the XSL file.

Load XML and XSL file
Test what kind of browser the user has
If the user has a browser supporting the ActiveX object:
Use the transformNode() method to apply the XSL style sheet to the xml document
Set the body of the current document (id="example") to contain the styled xml document
If the user has a browser that does not support the ActiveX object:
Create a new XSLTProcessor object and import the XSL file to it
Use the transformToFragment() method to apply the XSL style sheet to the xml document
Set the body of the current document (id="example") to contain the styled xml document
*/
function displayResult(xsl)
{
xml=loadXSLDoc("clothes.xml");
xsl=loadXSLDoc(xsl);
// code for IE
if (window.ActiveXObject)
  {
  ex=xml.transformNode(xsl);
  document.getElementById("brands").innerHTML=ex;
  }
// code for Mozilla, Firefox, Opera, etc.
else if (document.implementation && document.implementation.createDocument)
  {
  xsltProcessor=new XSLTProcessor();
  xsltProcessor.importStylesheet(xsl);
  resultDocument = xsltProcessor.transformToFragment(xml,document);
  document.getElementById("brands").innerHTML="";
  document.getElementById("brands").appendChild(resultDocument);
  


  }

  document.getElementById("Armani").checked=true;
  document.getElementById("Versace").checked=true;
  document.getElementById("Carlo").checked=true;
  document.getElementById("Jack").checked=true;
   
}


/**************
* This is a function that makes use of XSLT to pass parameter to do .xls to render the brand check boxs.
* Just wanted to play around with using Xpath.
* This doesnt really work in firefox however !
* Written by Dieter Schmid on 20/07/2017
******************/


function passParameterTypeToBrands(xsl, theType)
{

xml=loadXSLDoc("clothes.xml");
xsl=loadXSLDoc(xsl);

// code for IE
if (window.ActiveXObject)
  {
  ex=xml.transformNode(xsl);

       var template = new ActiveXObject('Msxml2.XslTemplate');
        template.stylesheet = xsl;
        var proc = template.createProcessor();
        proc.input = xml;
        proc.addParameter('type', theType);
        proc.transform();
        document.getElementById("brands").innerHTML = proc.output;


  document.getElementById("brands").innerHTML=ex;
  }
// code for Mozilla, Firefox, Opera, etc.
else if (document.implementation && document.implementation.createDocument)
  {
  xsltProcessor=new XSLTProcessor();
  xsltProcessor.importStylesheet(xsl);
  xsltProcessor.setParameter(null, 'type', ""+theType);
  resultDocument = xsltProcessor.transformToFragment(xml,document);
  
  document.getElementById("brands").innerHTML="";
  document.getElementById("brands").appendChild(resultDocument);

  

  }

  document.getElementById("Armani").checked=true;
  document.getElementById("Versace").checked=true;
  document.getElementById("Carlo").checked=true;
  document.getElementById("Jack").checked=true;


}




/***
* Implementation of algorithm from http://www.geeksforgeeks.org/quick-sort/ accessed 20/07/2017
*  Written by Dieter Schmid on 20/07/2017
*/


function quickSort(array,lo,hi){

    if (lo < hi)
    {
        /* pi is partitioning index, arr[p] is now
           at right place */
        var pi = partition(array, lo, hi);

        quickSort(array, lo, pi - 1);  // Before pi
        //quickSort(array, pi, hi);
        quickSort(array, pi + 1 , hi); // After pi
    }
}


function partition (array, lo, hi)
{
    // pivot (Element to be placed at right position)
    var pivot = array.getElementsByTagName("price")[hi].childNodes[0].nodeValue; 
    
    //price is in string format use regex to find price number get rid of AU$.
    r =  /\d+/;
  

    
    var i = lo -1; // Index of smaller element

    for (j = lo; j <= hi-1; j++)
    {
        // If current element is smaller than or
        // equal to pivot
       if(lowHigh){
         if (parseInt(array.getElementsByTagName("price")[j].childNodes[0].nodeValue.match(r)[0]) < parseInt(pivot.match(r)[0])){
           
            i++;    // increment index of smaller element
            var swapi = array.getElementsByTagName('item')[i].cloneNode(true);
            var swapj = array.getElementsByTagName('item')[j].cloneNode(true);
            array.replaceChild(swapj,array.getElementsByTagName('item')[i]);
            array.replaceChild(swapi,array.getElementsByTagName('item')[j]);
           
         }
       } else {
           if (parseInt(array.getElementsByTagName("price")[j].childNodes[0].nodeValue.match(r)[0]) > parseInt(pivot.match(r)[0])){
            
            i++;    // increment index of smaller element
            var swapi = array.getElementsByTagName('item')[i].cloneNode(true);
            var swapj = array.getElementsByTagName('item')[j].cloneNode(true);
            array.replaceChild(swapj,array.getElementsByTagName('item')[i]);
            array.replaceChild(swapi,array.getElementsByTagName('item')[j]); 
          }
      }
    }
    var swap =  array.getElementsByTagName('item')[i+1].cloneNode(true);
    var swaphi =  array.getElementsByTagName('item')[hi].cloneNode(true);    
    array.replaceChild(swaphi,array.getElementsByTagName('item')[i+1]);
    array.replaceChild(swap,array.getElementsByTagName('item')[hi]);

    return (i + 1)
}

/***
*  Trying to just spilt up a few more functions, this just does  search for bag or belt using regex.  
*   Because i didnt put bag or belt in the clothes.xml  
*
*  Written by Dieter Schmid on 20/07/2017
*/


function loadCheckBeltBag(detail){

         
         var patternBag = new RegExp("bag");
         var patternBelt = new RegExp("belt");

      

       if(patternBag.test(detail.toLowerCase())){
         return "bag";


         }

        if(patternBelt.test(detail.toLowerCase())){
         //item is bag
         return "belt";

        }

        return false;



}

/***
*  This is the logic for selecting 6,12 or all items on a page.
*
*  Written by Dieter Schmid on 20/07/2017
*/

function listItemsNumber(num, gender=cGender){

        pageItems = num;
        //numItems = 0;

        //start = 0;
        //nextPage = false;
        renderPages(1);

      

        if(cGender === 'men'){
          //loadXMLDoc('clothes.xml',loadItems,'men','none');
          gender = 'man';
          
        }else if (cGender === 'ladies'){
          //loadXMLDoc('clothes.xml',loadItems,'ladies','none');
        
          gender = 'lady';
        }else {
        
          //loadXMLDoc('clothes.xml',loadItems,'none','none');
           gender = 'none';
        }  
      
        
        
        if(num === 6){
          var showTxt = "<strong>Show</strong>  <a href='category-"+gender +".html?#6' class=' btn-default btn-sm btn-primary' onclick='listItemsNumber(6)'>6</a>" +  
                                                "<a href='category-"+gender +".html?#12' class='btn btn-default btn-sm' onclick='listItemsNumber(12)'>12</a>" +  
                                                "<a href='category-"+gender +".html?#All' class='btn btn-default btn-sm' onclick='listItemsNumber(0)'>All products</a>";

                                             
        } else if (num === 12){
           var showTxt = "<strong>Show</strong>  <a href='category-"+gender +".html?#6' class='btn btn-default btn-sm ' onclick='listItemsNumber(6)'>6</a>" +  
                                                "<a href='category-"+gender +".html?#12' class='btn btn-default btn-sm btn-primary' onclick='listItemsNumber(12)'>12</a>" +  
                                                "<a href='category-"+gender +".html?#All' class='btn btn-default btn-sm' onclick='listItemsNumber(0)'>All products</a>";
                                                  
        } else {
            var showTxt = "<strong>Show</strong>  <a href='category-"+gender +".html?#6' class='btn btn-default btn-sm' onclick='listItemsNumber(6)'>6</a>" +  
                                                "<a href='category-"+gender +".html?#12' class='btn btn-default btn-sm' onclick='listItemsNumber(12)'>12</a>" +  
                                                "<a href='category-"+gender +".html?#All' class='btn btn-default btn-sm btn-primary' onclick='listItemsNumber(0)'>All products</a>";
                                                

        } 
        
        
        

        document.getElementById('showSix').innerHTML = showTxt; 
        document.getElementById('showOf').innerHTML =  "Showing <strong> " + count +  " </strong> of <strong> " + totalNumItems + " </strong> products";  

        //return num;
}

/***
*  This is the logic for generating the pagination.
*
*  Written by Dieter Schmid on 20/07/2017
*/


function renderPages(page){


      //if num is 6 per page, create number of pages tabs needed
      //total num items / 6 = pages if % true then pages + 1
      if(pageItems == 6){
          pages = Math.ceil(totalNumItems / 6);
          
          start = (page - 1) * 6 ;
        
     
  //else if 12 per page
      } else if   (pageItems == 12)   {
            pages = Math.ceil(totalNumItems / 12);
            start = (page - 1) * 12;  
       
            //else if 12 per page
        
      } else if (pageItems == 0)  {
          pages = 1;
          start  =0;
         

      }

      if(start!=0){
          nextPage = true;

      } else {
        nextPage = false;

      }



      if(cGender === 'men'){
          loadXMLDoc('clothes.xml',loadItems,'men','none');
          iGender = 'man';
          
        }else if (cGender === 'ladies'){
          loadXMLDoc('clothes.xml',loadItems,'ladies','none');
         
          iGender = 'lady';
        }else {
          
          loadXMLDoc('clothes.xml',loadItems,'none','none');
          
        }  

   

        if(page-1 != 0){
           txtPages = "<li><a href='category-"+iGender +".html?#"+pageItems+"' onclick='renderPages("+ (page-1) + ")'>&laquo;</a></li>";
        } else {
           txtPages = "<li><a href='category-"+iGender +".html?#"+pageItems+"' onclick='renderPages("+ page + ")'>&laquo;</a></li>";
       }

        

      
       
      for(j=0;j<pages;j++){
           


             if(j+1 == page) {
                txtPages += " <li class='active'><a href='category-"+iGender +".html?#"+pageItems+"' onclick='renderPages("+ page + ")'>"+page+"</a></li>";
                
                

             } else {
               
                txtPages += "<li><a href='category-"+iGender +".html?#"+pageItems+"' onclick='renderPages("+ (j+1) + ")'>"+(j+1)+"</a></li>" ;

             }

      }

         
       if(page < pages){
         txtPages += "<li><a href='category-"+iGender+".html?#"+pageItems+"' onclick='renderPages("+ (page+1) + ")'>&raquo;</a></li>";
         } else {
           txtPages += "<li><a href='category-"+iGender +".html?#"+pageItems+"' onclick='renderPages("+ page + ")'>&raquo;</a></li>";
       }
     
                                 


      document.getElementById('pages').innerHTML =  txtPages;
      //if pages is 12 per, create number of page tabs needed.


}



function listDisplayGreyOut(){

          
          var showTxt = ""  ;
          document.getElementById('showSix').innerHTML = showTxt;                                       

};

function pagesGreyOut(){

      

          document.getElementById('pages').innerHTML =  ""; 

};

/*** This Page loads all the details of the product.
*    Nothing fancy here.   
*/

function buildDetailPage(xmlhttp){



    var idDetail = parent.document.URL.substring(parent.document.URL.indexOf('#')+1, parent.document.URL.indexOf('?'));
    var typeDetail = parent.document.URL.substring(parent.document.URL.indexOf('?')+1, parent.document.URL.indexOf('='));
    var genderDetail = parent.document.URL.substring(parent.document.URL.indexOf('=')+1, parent.document.URL.length);



    if(genderDetail == 'men'){
       document.getElementById("brands").innerHTML="";
       loadXMLDoc('clothes.xml',sideMenuBuild,'men','detail');
    } else if (genderDetail == 'ladies'){
       document.getElementById("brands").innerHTML="";
       loadXMLDoc('clothes.xml',sideMenuBuild,'ladies','detail');
    }

    var x=xmlhttp.responseXML.documentElement.getElementsByTagName(genderDetail);
    var itemsDetail = x[0]; 
   
    
    //go through the items, find item in question and publish to page.

    for(var i = 0; i < itemsDetail.getElementsByTagName("item").length;i++) {
     
      
       var r = /\d+/;
       var testId = itemsDetail.getElementsByTagName("id")[i].childNodes[0].nodeValue.trim();
       testId = testId.match(r);


       if(testId == idDetail && itemsDetail.getElementsByTagName("type")[i].childNodes[0].nodeValue == typeDetail ){
           var theImage = itemsDetail.getElementsByTagName("photo_one")[i].childNodes[0].nodeValue; 
           
 

           document.getElementById('mainImage').innerHTML = "<img src='img/product_img/" + theImage +".jpg' alt='"+ theImage +"' class='img-responsive'>" ;
           document.getElementById('product').innerHTML= itemsDetail.getElementsByTagName("product")[i].childNodes[0].nodeValue;
           document.getElementById('aPrice').innerHTML= itemsDetail.getElementsByTagName("price")[i].childNodes[0].nodeValue;
           document.getElementById('details').innerHTML= itemsDetail.getElementsByTagName("details")[i].childNodes[0].nodeValue;
           document.getElementById('materials').innerHTML= "<li> "+itemsDetail.getElementsByTagName("material")[i].childNodes[0].nodeValue +"</li>";
           document.getElementById('description').innerHTML= itemsDetail.getElementsByTagName("description")[i].childNodes[0].nodeValue;
           document.getElementById('size').innerHTML= itemsDetail.getElementsByTagName("size")[i].childNodes[0].nodeValue;
           document.getElementById('cartbutton').innerHTML= "<a href='basket.php?action=add&g="+genderDetail +"&t="+typeDetail+"&id="+idDetail+"' class='btn btn-primary' id='addButton'><i class='fa fa-shopping-cart'></i> Add to cart</a>";
           
       }
    } 
}

function clearBrands(){
  document.getElementById("Armani").checked=false;
  document.getElementById("Versace").checked=false;
  document.getElementById("Carlo").checked=false;
  document.getElementById("Jack").checked=false;
  if(cGender == 'ladies') {
    loadXMLDoc('clothes.xml',loadItems,'ladies','none');
  } else if(cGender == 'men'){
    loadXMLDoc('clothes.xml',loadItems,'men','none');
  }
}