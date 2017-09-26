<?php
// ===============================
// AUTHOR     : Dieter Schmid   
// CREATE DATE     : 18/09/2017 (added header)
// PURPOSE     : Functions that are related to logging in and starting a session.
// SPECIAL NOTES:
// ===============================
// Change History:
//
//==================================



require_once('php/functions.php');
session_start();

/*
* Creates a new user in the database with firstand lastname as well as email.
*/


function registerUser(){
	global $db;
	
	$firstname = $_SESSION['firstname'];
	$lastname = $_SESSION['lastname'];
	$email = $_SESSION['email'];
	$password = $_SESSION['password'] ;

	if(!userExists($firstname,$lastname,$email,$db)){
		$query = "INSERT INTO Users (password,firstname,lastname,email) 
            VALUES 
            ('$password',
             '$firstname',
             '$lastname',
             '$email')";

           
 
            $stmt = oci_parse($db, $query); 
            
            if(!$stmt) {
                echo "An error occurred in parsing the sql string.\n"; 
                exit; 
             }
            
            oci_execute($stmt);

            $query = "SELECT User_id FROM Users WHERE password = '$password' AND  email ='$email' " ;




            $stmt = oci_parse($db, $query); 
            
            if(!$stmt) {
                echo "An error occurred in parsing the sql string.\n"; 
                exit; 
            }            
    
            oci_execute($stmt);

            while(oci_fetch_array($stmt)){
                    $_SESSION['USER_ID'] =  oci_result($stmt,"USER_ID");
            }       


            return 'registered';

		//Already registered message.
		//please login enter password.
	} else {

		return "User already exists, please Login";
	}
}

/*
* Logs user into the database as long as they have the correct email.
*/


function loginUser(){
    global $db;
	$email = $_SESSION['email'];
	$password = $_SESSION['password'];

    if($email && $password){

	   $query = "SELECT User_ID,firstname,lastname FROM Users WHERE password = '$password' AND  email ='$email' " ;
      

        
       $stmt = oci_parse($db, $query); 
            
       if(!$stmt) {
                echo "An error occurred in parsing the sql string.\n"; 
                exit; 
       }            
    
       oci_execute($stmt);

   	    while(oci_fetch_array($stmt)){

    	   $user_id =  oci_result($stmt,"USER_ID");
           $firstname =  oci_result($stmt,"FIRSTNAME");
           $lastname =  oci_result($stmt,"LASTNAME");

   	    }
    
        $_SESSION['USER_ID'] = $user_id;
        $_SESSION['firstname'] = $firstname;
        $_SESSION['lastname'] = $lastname;
   	    return $user_id;

    }


}

/*
* Show orders made by a customer.
*/


function showOrders() {

    global $db;
    $User_ID = $_SESSION['USER_ID'];
    //based on User_ID, get all orders.
    $sql = "SELECT * FROM Orders WHERE User_ID ='$User_ID'";


    $stmt = oci_parse($db, $sql); 
  
            if(!$stmt)  {
                echo "An error occurred in parsing the sql string.\n"; 
                exit; 
            }
            
    oci_execute($stmt); 


        $output[] =      '<tbody>';
        $output[] =      '<thead>';
        $output[] =      '<tr>';
        $output[] =      '<th>Order</th>';
        $output[] =      '<th>Date</th>';
        $output[] =      '<th>Total</th>';
        $output[] =      '<th>Status</th>';
        $output[] =      '<th>Action</th>';
        $output[] =      '</tr>';
        $output[] =      '</thead>';
        $output[] =      '<tbody>';

         while(oci_fetch_array($stmt)) {
                $order_id = oci_result($stmt,"ORDER_ID");
                $date = oci_result($stmt,"ORDER_DATE");
                $status = oci_result($stmt,"STATUS");
                $total = oci_result($stmt,"TOTAL");  
                $output[] = '<tr>';
                $output[] = "<th>#". $order_id."</th>";
                $output[] = "<td>".$date." </td>";
                $output[] = "<td>".$total."</td>";
                $output[] = "<td><span class='label label-info'>".$status."</span></td>";
                $output[] = "<td><a href='customer-order.php?action=post&orderid=".$order_id."' class='btn btn-primary btn-sm'>View</a></td>";
                $output[] = "</tr>";
               
        }

          $output[] =      '</tbody>';



        return join('',$output);
}

/*
* Show products in an order made by a customer.
*/
function showProductsOrdered() {

    global $db;
    $subTotal = 0;
    $Order_ID = $_SESSION['Order_ID'];
    //based on User_ID, get all orders.
    $sql = "SELECT * FROM Products_Ordered WHERE Order_ID ='$Order_ID'";

  

    $stmt = oci_parse($db, $sql); 
  
            if(!$stmt)  {
                echo "An error occurred in parsing the sql string.\n"; 
                exit; 
            }
            
    oci_execute($stmt); 


        $output[] =      '<thead>';
        $output[] =      '<tr>';
        $output[] =      '<th colspan="2">Product</th>';
        $output[] =      '<th>Quantity</th>';
        $output[] =      '<th>Unit price</th>';
        $output[] =      '<th>Discount</th>';
        $output[] =      '<th>Total</th>';
        $output[] =      '</tr>';
        $output[] =      '</thead>';
        $output[] =      '<tbody>';

        while(oci_fetch_array($stmt)) {
                //get product id
                $product_id = oci_result($stmt,"PRODUCT_ID");
                $qty = oci_result($stmt,"PRODUCT_ID");
                //look product info
                $sql = "SELECT * FROM Products WHERE Product_ID ='$product_id'";


                //produce table.
                $stmt_next = oci_parse($db, $sql); 
  
                    if(!$stmt)  {
                            echo "An error occurred in parsing the sql string.\n"; 
                            exit; 
                    }
            
                oci_execute($stmt_next);

                while(oci_fetch_array($stmt_next)) {

                    $product = oci_result($stmt_next,"PRODUCT");
                    $price = oci_result($stmt_next,"PRICE");
                    $photo = oci_result($stmt_next,"PHOTO_ONE"); 
                    $gender = oci_result($stmt_next,"GENDER");
                    $type = oci_result($stmt_next,"TYPE");   
                    $id = oci_result($stmt_next,"ID");
                        

                    $output[] = '<tr>';
                    $output[] = "<td><img src='img/product_img/".$photo.".jpg' ></a></td>";
                    $output[] = "<td><a href='detail.php#".(int)$id."?".$type."=".$gender."'>".$product."</a></td>";


                    $sql = "SELECT qty FROM Products_Ordered WHERE Product_ID ='$product_id' AND Order_ID = '$Order_ID'";

                    $stmt_new = oci_parse($db, $sql); 
  
                    if(!$stmt_new)  {
                            echo "An error occurred in parsing the sql string.\n"; 
                            exit; 
                    }
            
                    oci_execute($stmt_new);

                    while(oci_fetch_array($stmt_new)) {
                        $qty = oci_result($stmt_new,"QTY");
                        $output[] = "<td>".$qty."</td>";
                    }   

                    $output[] = "<td>".$price."</td>"; 
                    $output[] = "<td></td>"; 
                    $output[] = "<td>$". ((float) preg_replace("/[^0-9\.]/", '', $price) * (float) $qty) ."</td>"; 
                    $subTotal += ((float) preg_replace("/[^0-9\.]/", '', $price) * (float) $qty);
                    $output[] = "</tr>";

                }
               
        }

        $output[] = '</tbody>';
        $output[] = "<tfoot>";
        $output[] = "<tr>";
        $output[] = "<th colspan='5' class='text-right'>Order subtotal</th>";
        $output[] = "<th>$" . $subTotal . "</th>";
        $output[] = "</tr>";
        $output[] = "<tr>";
        $output[] = "<th colspan='5' class='text-right'>Shipping and handling</th>";
        $output[] = "<th>".(float) $_SESSION['shipping']."</th>";
        $output[] = "</tr>";
        $output[] = "<tr>";
        $output[] = "<th colspan='5' class='text-right'>GST</th>";
        $output[] = "<th>$". $subTotal * 0.1 . "</th>";
        $output[] = "</tr>";
        $output[] = "<tr>";
        $output[] = "<th colspan='5' class='text-right'>Total</th>";
        //this is because i left shipping out o fthe database, it would next to be fixed.
        $output[] = "<th>$". (($subTotal * 1.1)  + (float) $_SESSION['shipping']). "</th>";
        $output[] = "</tr>";
        $output[] = "</tfoot>";
        
        return join('',$output);
}


/*
* Display address for HTML page.
*/

function showAddress(){

    global $db;

    $User_ID = $_SESSION['USER_ID'];

    $sql = "SELECT * FROM Users WHERE User_ID ='$User_ID'";



    $stmt = oci_parse($db, $sql); 
  
    if(!$stmt)  {
                echo "An error occurred in parsing the sql string.\n"; 
                exit; 
    }
            
    oci_execute($stmt); 


    $output[] =        "<h2>Shipping address</h2>";


     while(oci_fetch_array($stmt)) {

        $fname = oci_result($stmt,"FIRSTNAME");
        $lname = oci_result($stmt,"LASTNAME");
        $address = oci_result($stmt,"ADDRESS");
        $state = oci_result($stmt,"STATE");
        $country = oci_result($stmt,"COUNTRY");
                 
        $output[] =  "<p>".$fname ." " . $lname . "</p>";
        $output[] =  "<br>" . $address . "</br>";
        $output[] =  "<br>" . $state .  "</br>";
        $output[] =  "<br>" . $country . "</p>";
    }    


      return join('',$output);
}


/*
* Display order date for HTML page.
*/

function orderDate(){


    global $db;


    $Order_ID = $_SESSION['Order_ID'];

    $sql = "SELECT * FROM Orders WHERE Order_ID ='$Order_ID'";

    $stmt = oci_parse($db, $sql); 
  
    if(!$stmt)  {
                echo "An error occurred in parsing the sql string.\n"; 
                exit; 
    }
            
    oci_execute($stmt); 


    $output[] = "<h2>Shipping address</h2>";


    while(oci_fetch_array($stmt)) {

        $date = oci_result($stmt,"ORDER_DATE");
        $status = oci_result($stmt,"STATUS");                
   
    }    

    return "#" . $_SESSION['Order_ID'] . " was placed on <strong> " . $date . " </strong> and is currently <strong> ".$status.".</strong>";
}

function getName(){

    return  $_SESSION['firstname'] . " " . $_SESSION['lastname'];
}
?>