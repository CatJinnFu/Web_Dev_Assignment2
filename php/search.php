<?php
// ===============================
// AUTHOR     : Dieter Schmid   
// CREATE DATE     : 18/09/2017 (added header)
// PURPOSE     : Uses DB to generate an xml file to render as a search result in XML/XSL.
// SPECIAL NOTES:
// ===============================
// Change History:
//
//==================================
//build database from xml
/* Set oracle user login and password info */
$dbuser = "schmidd"; /* your deakin login */
$dbpass = "22pelf74"; /* your oracle access password */
$db = "SSID"; 
$connect = oci_connect($dbuser, $dbpass, $db);

if (!$connect) {
echo "An error occurred connecting to the database"; 
exit; 
}



$xml=simplexml_load_file("clothes.xml");
//print_r($xml);

foreach($xml->ladies as $ladies){

	foreach($ladies->item as $item){
	    $Product_ID = intval($max) + 1; 
		$gender = 'ladies';
		$Type = $item->type;
        $Id  = $item->id;
        $product  = $item->product;
        $brand = $item->brand;
        $price = $item->price;
        $details  = $item->details;
        $material = $item->material;
        $csize = $item->size;
        $description = $item->description;

       
	
        foreach($item->photos as $photos){
         
         	$photo_one = $photos->photo_one;
         	$photo_two = $photos->photo_two;

         if(!alreadyInDB($gender,$Type,$Id,$connect)){
         	$query = "INSERT INTO Products (Gender,Type, Id,product,brand,price,details,material,csize,description,photo_one,photo_two) 
            VALUES 
            ('$gender',
             '$Type',
             '$Id', 
            q'[$product]',
             '$brand',
             '$price',
            q'[$details]',
            q'[$material]',
            q'[$csize]',
            q'[$description]',
             '$photo_one',
             '$photo_two')"z;
         	//Type,$id,$product,$brand,$price,$details,$material,$csize,$description,$photo_one,$photo_two)
             // echo $query;
         	$stmt = oci_parse($connect, $query); 
		    
		 	if(!$stmt) {
				echo "An error occurred in parsing the sql string.\n"; 
				exit; 
			 }
          
         	oci_execute($stmt);
         }
         	
    	}
	}




}


foreach($xml->men as $men){

    foreach($men->item as $item){
        $Product_ID = intval($max) + 1; 
        $gender = 'men';
        $Type = $item->type;
        $Id  = $item->id;
        $product  = $item->product;
        $brand = $item->brand;
        $price = $item->price;
        $details  = $item->details;
        $material = $item->material;
        $csize = $item->size;
        $description = $item->description;

       
    
        foreach($item->photos as $photos){
         
            $photo_one = $photos->photo_one;
            $photo_two = $photos->photo_two;

         if(!alreadyInDB($gender,$Type,$Id,$connect)){
            $query = "INSERT INTO Products (Gender,Type, Id,product,brand,price,details,material,csize,description,photo_one,photo_two) 
            VALUES 
            ('$gender',
             '$Type',
             '$Id', 
            q'[$product]',
             '$brand',
             '$price',
            q'[$details]',
            q'[$material]',
            q'[$csize]',
            q'[$description]',
             '$photo_one',
             '$photo_two')";
            //Type,$id,$product,$brand,$price,$details,$material,$csize,$description,$photo_one,$photo_two)
             // echo $query;
            $stmt = oci_parse($connect, $query); 
            
            if(!$stmt) {
                echo "An error occurred in parsing the sql string.\n"; 
                exit; 
             }
            
            oci_execute($stmt);
         }
            
        }
    }




}


////Do search functionality.


$search_words = explode(" ", $value);



$query = "";
for($i = 0; $i < count($search_words); $i++){

    if($search_words[$i] == 'girl' || 
       $search_words[$i] == 'women' ||
       $search_words[$i] == 'lady'){
       $search_words[$i] = 'ladies'; 
    } else if ($search_words[$i] == 'boy' ||
               $search_words[$i] == 'man'){
        $search_words[$i] = 'men'; 
    }

    if($i == 0){
    $query = "SELECT * FROM Products 
          WHERE (LOWER(gender) LIKE LOWER('%".$search_words[0]."%')
          OR LOWER(Type) LIKE LOWER('%".$search_words[0]."%')
          OR LOWER(product) LIKE LOWER('%".$search_words[0]."%')
          OR LOWER(brand) LIKE LOWER('%".$search_words[0]."%'))"; 
    } else if ($search_words[$i] != '') {
    $query = $query . "AND (LOWER(gender) LIKE LOWER('%".$search_words[$i]."%')
          OR LOWER(Type) LIKE LOWER('%".$search_words[$i]."%')
          OR LOWER(brand) LIKE LOWER('%".$search_words[$i]."%')
          OR LOWER(product) LIKE LOWER('%".$search_words[$i]."%'))";
          echo "search word is - ".$search_words[$i];
    }
    //echo $query;

    
}



$stmt = oci_parse($connect,$query);

if(!$stmt) {
                echo "An error occurred in parsing the sql string.\n"; 
                exit; 
}  

oci_execute($stmt);  

$return_text = " ";

while(oci_fetch_array($stmt)){

    $gender =  oci_result($stmt,"GENDER");
    $Type =  oci_result($stmt,"TYPE");
    $product =  oci_result($stmt,"PRODUCT");
    $brand =  oci_result($stmt,"BRAND");
    $return_text = $return_text . $gender . " " . $brand . " " . $Type . " " . $product . "\n";
}     

if ($return == 'True'){
oci_close($connect);
echo $return_text;


}



if ($submit == 'True'){

loadResultsPages($stmt);

}
	
function alreadyInDB($g,$t,$i,$connection)
{



    $query = "SELECT Product_ID,Gender, Type, ID FROM Products WHERE gender = '$g' AND Type = '$t' AND  Id ='$i'" ;
      
    
    $stmt = oci_parse($connection, $query); 
            
    if(!$stmt) {
                echo "An error occurred in parsing the sql string.\n"; 
                exit; 
    }            
    
    oci_execute($stmt);

   while(oci_fetch_array($stmt)){

    $result =  oci_result($stmt,"PRODUCT_ID");
   }
    return $result;


}

function loadResultsPages($statement){
    
    //Do a complete product search
    //create an xml document and display results 
    
    oci_execute($statement);
    $newXML = new SimpleXMLElement('<clothes></clothes>');

    
    $newXML->addChild('men');
    $newXML->addChild('ladies');
    $clothing = $newXML;
   
    $i = 0;
    $j = 0;
    while($row = oci_fetch_assoc($statement)){
        
        echo " -- test -- " . $row['GENDER'];

        if($row['GENDER'] == 'men'){
            $clothing->men->addChild('item');
            $clothing->men->item[$i]->addChild('Gender',$row['GENDER']);
            $clothing->men->item[$i]->addChild('Type',$row['TYPE']);
            //got to clean the id for passing to product details.
            $s = $row['ID'];
            preg_match("/([0-9]+)/", $s, $matches);
            $clothing->men->item[$i]->addChild('Id',$matches[1]);
            $clothing->men->item[$i]->addChild('product',$row['PRODUCT']);
            $clothing->men->item[$i]->addChild('brand',$row['BRAND']);
            $clothing->men->item[$i]->addChild('price',$row['PRICE']);
            $clothing->men->item[$i]->addChild('details',$row['DETAILS']);
            $clothing->men->item[$i]->addChild('material',$row['MATERIAL']);
            $clothing->men->item[$i]->addChild('csize',$row['CSIZE']);
            $clothing->men->item[$i]->addChild('description',$row['DESCRIPTION']);
            $clothing->men->item[$i]->addChild('photos');
            $clothing->men->item[$i]->photos->addChild('photo_one',$row['PHOTO_ONE']);
            $clothing->men->item[$i]->photos->addChild('photo_two',$row['PHOTO_TWO']);
            $i++;
        }else if($row['GENDER'] == 'ladies'){
            $clothing->ladies->addChild('item');  
            $clothing->ladies->item[$j]->addChild('Gender',$row['GENDER']);
            $clothing->ladies->item[$j]->addChild('Type',$row['TYPE']);
            $s = $row['ID'];
            preg_match("/([0-9]+)/", $s, $matches);
            $clothing->ladies->item[$j]->addChild('Id',$matches[1]);
            $clothing->ladies->item[$j]->addChild('product',$row['PRODUCT']);
            $clothing->ladies->item[$j]->addChild('brand',$row['BRAND']);
            $clothing->ladies->item[$j]->addChild('price',$row['PRICE']);
            $clothing->ladies->item[$j]->addChild('details',$row['DETAILS']);
            $clothing->ladies->item[$j]->addChild('material',$row['MATERIAL']);
            $clothing->ladies->item[$j]->addChild('csize',$row['CSIZE']);
            $clothing->ladies->item[$j]->addChild('description',$row['DESCRIPTION']);
            $clothing->ladies->item[$j]->addChild('photos');
            $clothing->ladies->item[$j]->photos->addChild('photo_one',$row['PHOTO_ONE']);
            $clothing->ladies->item[$j]->photos->addChild('photo_two',$row['PHOTO_TWO']);
            $j++;
        }

     
        
    }   

    

    ob_start();
    $dom = new DomDocument();
    $dom->preserveWhiteSpace = false;
    $dom->formatOutput = true;
    $dom->loadXML($newXML->asXML());
    $dom->save('../search_clothes.xml');
    ob_end_clean();
}
//search database for match on brand and product name

//display list of searches
oci_close($connect);
?>