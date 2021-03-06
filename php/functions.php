<?php
// ===============================
// AUTHOR     : Dieter Schmid   
// CREATE DATE     : 18/09/2017 (added header)
// PURPOSE     : Functions relating to the shopping and ordering of items from the website.
// SPECIAL NOTES:
// ===============================
// Change History:
//
//==================================

session_start();
// turn all error reporting ON
//error_reporting(E_ALL);
// register error handler for all errors
//set_error_handler('err_handler');

switch ($action)  {
    case 'loadCart':
    	itemsCart();
      break;
}  

/*
* Write an order to the database based on a User_ID
*/

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
	$total = $_SESSION['total'];
	

	


	if(!userExists($firstname,$lastname,$email,$db)){

			$password = random_password(4);

         	$query = "INSERT INTO Users (password,firstname,lastname,address,company,city,postcode,state,phone,country,email) 
            VALUES 
            ('$password',
             '$firstname',
             '$lastname',
             '$address', 
             '$company', 
             '$city',
          	 '$postcode',
          	 '$state', 	
             '$phone',
             '$country',
             '$email')";


    


            $stmt = oci_parse($db, $query); 
            
            if(!$stmt) {
                echo "An error occurred in parsing the sql string.\n"; 
                exit; 
             }
            
            oci_execute($stmt);

            $_SESSION['password'] = $password;

    } else {

    		$User_ID = userExists($firstname,$lastname,$email,$db);

    		$query = "UPDATE Users SET firstname ='$firstname', lastname = '$lastname', address = '$address', state = '$state', country = '$country', city ='$city', postcode='$postcode', phone = '$phone' WHERE USER_ID='$User_ID'";   


      		$stmt = oci_parse($db, $query); 
            
       		if(!$stmt) {
                echo "An error occurred in parsing the sql string.\n"; 
                exit; 
       		}            
    
      		oci_execute($stmt);


    }

   
	//insert order into DB
    $User_id = userExists($firstname,$lastname,$email,$db);
    $Status = 'ordered';
    $Order_Date = date("Y-m-d h:i:sa");
	  

    
		//,Status,Order_Date,Total
    $query = "INSERT INTO Orders (User_ID, Status,Order_Date, Total) 
            VALUES 
            ('$User_id','$Status','$Order_Date','$total')";

          

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
    $Order_ID = returnOrder_ID($User_id,$Status,$Order_Date,$total,$db);
    


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
		$_SESSION['ORDER_ID'] = $Order_ID;
		$_SESSION['USER_ID'] = $User_id;
		return "<h2 align='center'>Order Placed</h2>";
	
	} else{
		return "<h2 align='center'>Order did not get processed.</h2>";

	}




}


/*
* Check if a user exists already in the database
*/

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


/*
* get the ID of the order and return it when this function is called.
*/

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

/*
* check if an order has been made.
* Looks like is check the Users table for some reason ?
* Function is not used and wont work properly it shoudl return an order_ID
*/


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
   

    //should include :
	//$query = "SELECT Order_ID FROM Orders WHERE firstname = '$firstname' AND lastname = '$lastname' AND  email ='$email'" ;
    //return the Order_ID 

   return $result;


}



/*
* Function is a double up not sure why its here ?
*
*/

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

/*
* Print the number of items in a shopping cart.
*
*/

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

/*
* Display the cart items
*
*/

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
			$output[] = "<td><a href='detail.php#".$lookUp[2]."?".$lookUp[1]."=".$lookUp[0]."'>".$product."</a></td>";
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

function random_password( $length = 8 ) {
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_-=+;:,.?";
    $password = substr( str_shuffle( $chars ), 0, $length );
    return $password;
}


// define custom error handler:
function err_handler($errcode,$errmsg,$file,$lineno) {
	echo 'An error has occurred!<br />';
  	echo "file: $file<br />";
  	echo "line: $lineno<br />";
  	echo "Problem: $errmsg<br />";
	return true;
}

?>
