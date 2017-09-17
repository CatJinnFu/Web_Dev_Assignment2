<?php
session_start();


switch ($action)  {
    case 'loadCart':
    	itemsCart();
      break;
}  

function writeOrder(){
	//setup SQL statement. 
	global $db;
	//insert user into DB
	$firstname = $_SESSION['firstname'];
	$lastname = $_SESSION['lastname'];
	$address = $_SESSION['address'];
	$company = $_SESSION['company'];
	$city = $_SESSION['city'];
	$postcode = $_SESSION['postcode'];
	$country = $_SESSION['country'];
	$state = $_SESSION['state'];
	$phone = $_SESSION['phone'];
	$email = $_SESSION['email'];
	$action = $_GET['action'];
	$total = $_SESSION['total'];


	if(!userExists($firstname,$lastname,$email,$db)){
         	$query = "INSERT INTO Users (password,firstname,lastname,address,state,country,email) 
            VALUES 
            ('password',
             '$firstname',
             '$lastname',
             '$address', 
             '$state',
             '$country',
             '$email')";


             echo "--*--" . $query;


            $stmt = oci_parse($db, $query); 
            
            if(!$stmt) {
                echo "An error occurred in parsing the sql string.\n"; 
                exit; 
             }
            
            oci_execute($stmt);
    } 

   
	//insert order into DB
    $User_ID = (int) userExists($firstname,$lastname,$email,$db);
    $Status = 'ordered';
    $Order_Date = date("Y-m-d h:i:sa");
	  

    
		//,Status,Order_Date,Total
    $query = "INSERT INTO Orders (User_ID, Status,Order_Date, Total) 
            VALUES 
            ( $User_ID,'$Status','$Order_Date','$total')";

				//'$Status',
             //'$Order_Date',
            // '$total'
            $stmt = oci_parse($db, $query); 
    
           

            if(!$stmt) {
                echo "An error occurred in parsing the sql string.\n"; 
                exit; 
             }
            
            oci_execute($stmt);




	//insert products into DB
    $Order_ID = returnOrder_ID($User_ID,$Status,$Order_Date,$total,$db);
    


	$cart = $_SESSION['cart'];
	if ($cart) {
		$items = explode(' ',$cart);
		$contents = array();
		foreach ($items as $item) {
			$contents[$item] = (isset($contents[$item])) ? $contents[$item] + 1 : 1;
		
		}
		
		
		foreach ($contents as $id=>$qty) {

			$lookUp = explode(',',$id);

			
				$sql = "SELECT * FROM Products WHERE Gender='".$lookUp[0]."' AND Type='".$lookUp[1]."' AND Id LIKE '%".$lookUp[2]."%'";
				
			
			
			// modified by Shang			
			$stmt = oci_parse($db, $sql); 
  
			if(!$stmt)  {
				echo "An error occurred in parsing the sql string.\n"; 
				exit; 
			}
			
			oci_execute($stmt); 

			while(oci_fetch_array($stmt)) {
				$product_ID = oci_result($stmt,"PRODUCT_ID");
				$price = oci_result($stmt,"PRICE");
					
			}

			$query = "INSERT INTO Products_Ordered (Order_ID,Product_ID,Qty,Total) 
            VALUES 
            ('$Order_ID',
             '$product_ID',
             '$qty',
             '$price')";

           

            $stmt = oci_parse($db, $query); 

           	
            
            if(!$stmt) {
                echo "An error occurred in parsing the sql string.\n"; 
                exit; 
             }
            
            oci_execute($stmt);

       

		}
		
		return "<h2 align='center'>Order Placed</h2>";
	
	} else{
		return "<h2 align='center'>Order did not get processed.</h2>";

	}




}

function userExists($firstname,$lastname,$email,$db){

    $query = "SELECT User_ID FROM Users WHERE firstname = '$firstname' AND lastname = '$lastname' AND  email ='$email'" ;
      

    
    $stmt = oci_parse($db, $query); 
            
    if(!$stmt) {
                echo "An error occurred in parsing the sql string.\n"; 
                exit; 
    }            
    
    oci_execute($stmt);

   while(oci_fetch_array($stmt)){

    $result =  oci_result($stmt,"USER_ID");
   }
   
   return $result;


}

function returnOrder_ID($User_ID,$Status,$Order_Date,$total,$db ){

	$query = "SELECT Order_ID FROM Orders WHERE User_ID = '$User_ID' AND Status = '$Status' AND  Order_Date ='$Order_Date' AND  total ='$total'" ;
    

    $stmt = oci_parse($db, $query); 
            
    if(!$stmt) {
                echo "An error occurred in parsing the sql string.\n"; 
                exit; 
    }            
    
    oci_execute($stmt);

   while(oci_fetch_array($stmt)){

    $result =  oci_result($stmt,"ORDER_ID");
   }
   
   return $result;



}


function orderExists($firstname,$lastname,$email,$db){

    $query = "SELECT User_ID FROM Users WHERE firstname = '$firstname' AND lastname = '$lastname' AND  email ='$email'" ;
      
    
    $stmt = oci_parse($connection, $query); 
            
    if(!$stmt) {
                echo "An error occurred in parsing the sql string.\n"; 
                exit; 
    }            
    
    oci_execute($stmt);

   while(oci_fetch_array($stmt)){

    $result =  oci_result($stmt,"User_ID");
   }
   
   return $result;


}

function writeShoppingCart() {
	

	$cart = $_SESSION['cart'];
	if (!$cart) {
		return  '<p>You have no items in your shopping cart</p>';
	} else {
		// Parse the cart session variable
		$items = explode(' ',$cart);
		$s = (count($items) > 1) ? 's':'';
		return  '<p>You have <a href="basket.php">'.count($items).' item'.$s.' in your shopping cart</a></p>';
	}
}

function itemsCart() {
	

	$cart = $_SESSION['cart'];
	if (!$cart) {
		return  '0 items in cart';
	} else {
		// Parse the cart session variable
		$items = explode(' ',$cart);
		$s = (count($items) > 1) ? 's':'';
		return  count($items).' item'.$s.' in cart';
	}
}

function showCart() {

	global $db;
	$_SESSION['total']= 0;

	$cart = $_SESSION['cart'];
	if ($cart) {
		$items = explode(' ',$cart);
		$contents = array();
		foreach ($items as $item) {
			$contents[$item] = (isset($contents[$item])) ? $contents[$item] + 1 : 1;
		
		}
		
		$output[] = '<tbody>';
		$output[] =      '<thead>';
        $output[] =      '<tr>';
        $output[] =      '<th>Image</th>';
        $output[] =      '<th>Product</th>';
        $output[] =      '<th>Quantity</th>';
        $output[] =       '<th>Unit price</th>';
        $output[] =       '<th>Discount</th>';
        $output[] =       '<th>Total</th>';
        $output[] =       '</tr>';
        $output[] =       '</thead>';
		
		foreach ($contents as $id=>$qty) {

			$lookUp = explode(',',$id);

			
				$sql = "SELECT * FROM Products WHERE Gender='".$lookUp[0]."' AND Type='".$lookUp[1]."' AND Id LIKE '%".$lookUp[2]."%'";
				
			
			
			// modified by Shang			
			$stmt = oci_parse($db, $sql); 
  
			if(!$stmt)  {
				echo "An error occurred in parsing the sql string.\n"; 
				exit; 
			}
			
			oci_execute($stmt); 

			while(oci_fetch_array($stmt)) {
				$product = oci_result($stmt,"PRODUCT");
				$price = oci_result($stmt,"PRICE");
				$photo = oci_result($stmt,"PHOTO_ONE");			
			}
		
			
			$output[] = '<tr>';
			$output[] = "<td><img src='img/product_img/".$photo.".jpg' ></a></td>";
			$output[] = "<td><a href='detail.html#".$lookUp[2]."?".$lookUp[1]."=".$lookUp[0]."'>".$product."</a></td>";
			$output[] = '<td><input type="number" name="'.$lookUp[0].','.$lookUp[1].','.$lookUp[2].'" value='.$qty.' class="form-control"></td>';
			$output[] = '<td>'.$price.'</td>';
			$output[] = '<td></td>';
			$subTotal =  (float) preg_replace("/[^0-9\.]/", '', $price) * $qty;
			$total += $subTotal;
			$_SESSION['total'] = $total;
			$output[] = '<td>AU$ '.$subTotal.'</td>';
			$output[] = "<td><a href='basket.php?action=delete&g=".$lookUp[0]."&t=".$lookUp[1]."&id=".$lookUp[2]."'><i class='fa fa-trash-o'></i></a></td>";
			$output[] = '</tr>';

		}
		$output[] = '</tbody>';
		$output[] = '<tfoot>';
		$output[] = '<th colspan="5">Total</th>';
		$output[] = '<th colspan="2">$'.$total.'</th>';
		$output[] = '</tfoot>';

		    					
	
	} else{
		$output[] = '';

	}
	return join('',$output);
}


function getTotal() {
	

	return (float) $_SESSION['total'];

}

function getShipping() {
	//global $shipping;
	return (float) $_SESSION['shipping'];
}

function getGST(){
	global $total;
	
	return (float) $_SESSION['total'] * 0.1;

}

function getTotalGST(){
	global $total;
	
	return ( (float) $_SESSION['total'] * 1.1) + (float) $_SESSION['shipping'];

}




?>
