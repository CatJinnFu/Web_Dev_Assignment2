<?php

// ===============================
// AUTHOR     : Dieter Schmid   
// CREATE DATE     : 18/09/2017 (added header)
// PURPOSE     : Functions relating to changing account details.
// SPECIAL NOTES:
// ===============================
// Change History:
//
//==================================
session_start();

require_once('php/functions.php');
require_once('php/functions-login.php');


/*
* Change the password on the account.
*/

function changePassword($new){
  global $db;
  $email = $_SESSION['email'];
  $password = $_SESSION['password'] ;
  //search on email and password return user_id
  //insert into user_id new password
  $query = "SELECT User_id FROM Users WHERE password = '$password' AND  email ='$email' " ;




  $stmt = oci_parse($db, $query); 
            
       if(!$stmt) {
                echo "An error occurred in parsing the sql string.\n"; 
                exit; 
       }            
    
       oci_execute($stmt);

  while(oci_fetch_array($stmt)){
       $User_id =  oci_result($stmt,"USER_ID");
  }

  $query = "UPDATE Users SET password ='$new' WHERE USER_ID='$User_id'";   

  echo "--update--" . $query;

  $stmt = oci_parse($db, $query); 
            
       if(!$stmt) {
                echo "An error occurred in parsing the sql string.\n"; 
                exit; 
       }            
    
  oci_execute($stmt);


  $_SESSION['password'] = $new; 
  return "Your new password details have been updated";

}


/*
* Load the account details from the database into the SESSION variable.
*/


function setUpAccount(){
	global $db;

	$email = $_SESSION['email'];
	$password = $_SESSION['password'] ;

	//login to database and get details
	$query = "SELECT * FROM Users WHERE password = '$password' AND  email ='$email' " ;
      
       
        
       $stmt = oci_parse($db, $query); 
            
       if(!$stmt) {
                echo "An error occurred in parsing the sql string.\n"; 
                exit; 
       }            
    
       oci_execute($stmt);

   	   while(oci_fetch_array($stmt)){

    	   $_SESSION['firstname'] =  oci_result($stmt,"FIRSTNAME");
    	   $_SESSION['lastname']=  oci_result($stmt,"LASTNAME");
    	   $_SESSION['address'] =  oci_result($stmt,"ADDRESS");
    	   $_SESSION['state']=  oci_result($stmt,"STATE");
    	   $_SESSION['country']=  oci_result($stmt,"COUNTRY");
    	   $_SESSION['emaildb'] =  oci_result($stmt,"EMAIL");
    	   //forgot to add this to database. So just using some dummy data, if i get time ill fix it up.
    	   $_SESSION['postcode'] = '3000';
    	   
   	   }
    

   	    

	   return "setup" . $email;



}

/*
* Write new details for teh users Account to the database.
*/

function updateAccount(){
        global $db;

        $firstname = $_SESSION["firstname"];
        $lastname = $_SESSION['lastname'];
        $address = $_SESSION['address'] ;
        $state = $_SESSION['state'];
        $country = $_SESSION['country'];
        $email = $_SESSION['email'];
        $emaildb = $_SESSION['emaildb'];
        $password = $_SESSION['password'] ;

        //login to database and get details
        $query = "SELECT * FROM Users WHERE password = '$password' AND  email ='$email' " ;

        echo "--select--" . $query;

        $stmt = oci_parse($db, $query); 
            
       if(!$stmt) {
                echo "An error occurred in parsing the sql string.\n"; 
                exit; 
       }            
    
       oci_execute($stmt);

      while(oci_fetch_array($stmt)){
        $User_id =  oci_result($stmt,"USER_ID");
      }

      $query = "UPDATE Users SET firstname ='$firstname', lastname = '$lastname', address = '$address', state = '$state', country = '$country', email = '$emaildb' WHERE USER_ID='$User_id'";   

      echo "/n-update--" . $query;

      $stmt = oci_parse($db, $query); 
            
       if(!$stmt) {
                echo "An error occurred in parsing the sql string.\n"; 
                exit; 
       }            
    
      oci_execute($stmt);


    
      return "Your Account Details have been updated.";

} 



?>