<?php
// ===============================
// AUTHOR     : Dieter Schmid   
// CREATE DATE     : 18/09/2017 (added header)
// PURPOSE     : backend business logic for processing the users form details.
// SPECIAL NOTES:
// ===============================
// Change History:
//
//==================================



session_start();
//$firstname = $_SESSION['firstname'];
//$address = $_SESSION['address'];
//$company = $_SESSION['company'];
//$city = $_SESSION['city'];
//$postcode = $_SESSION['postcode'];
//$state = $_SESSION['state'];
//$phone = $_SESSION['phone'];
$card_name = "";
$card_number = "";
$expiry_month = "";
$expiry_year = "";
$card_cvv = "";

switch ($fieldname)
{
		case 'firstname':
		 $_SESSION['firstname'] = $value;
		break;
		case 'lastname':
		 $_SESSION['lastname'] = $value;
		break;
		case 'address':
		 $_SESSION['address'] = $value;
		break;
		case 'company':
		 $_SESSION['company'] = $value;
		break;
        case 'city':
         $_SESSION['city'] = $value;
	    break;
	    case 'country':
         $_SESSION['country'] = $value;
	    break;
		case 'postcode' :
		 $_SESSION['postcode'] = validatePostCode($value);
		break;
		case 'state' :
		 $_SESSION['state'] = $value;
		break;
		case 'phone':
		  $_SESSION['phone']= validatePhone($value);
		break;
		case 'email':
		  $_SESSION['email'] = validateEmail($value);
		break;
		case 'card_name':
		  $card_name = $value;
		break;
		case 'card_number':
		  validateCardNumber($value);
		break;
		case 'expiry_month':
		  validateExpiryMonth($value, $year);
		break;
		case 'expiry_year':
		  validateCardYear($value, $month);
		break;
		case 'cvv':
		  validateCvv($value);
		break;
		case 'shipping':
		  setShipping($value);
		break;
		default:
		break;
}


/*
* Checks for all email. 
*/

function validateEmail($email){

	/*if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
  		return "error"; 
    } else {
    	return $email;
    }*/
	
   //see if its a valid number
   //test normal numbar
   $pattern1 = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/';
  
  
   if (preg_match($pattern1,$email)) {  return $email;}
   else { echo "error"; }
 
}



/*
* Checks for phone numbers. In the following formats :
*  (03) 9999 4501
*  0399994501
*  (0428) 081 171
*  0428081171
*/

function validatePhone($phone){

   //see if its a valid number
   //test normal numbar
   $pattern1 = "/^\([0-9]{2}\)\s*[0-9]{4}\s*[0-9]{4}$/";
   $pattern2 = "/^[0-9]{2}[0-9]{4}[0-9]{4}$/";
   $pattern3 = "/^[0-9]{4}[0-9]{3}[0-9]{3}$/";
   $pattern4 = "/^\([0-9]{4}\)\s*[0-9]{3}\s*[0-9]{3}$/";
   
  
   if (preg_match($pattern1,$phone)) {  return $phone;}
   else if (preg_match($pattern2,$phone)) { return $phone;}
   else if (preg_match($pattern3,$phone)) { return $phone;}
   else if (preg_match($pattern4,$phone)) { return $phone;}
   else {
      echo "error"; 
   }
   //test mobile number 
   //if its not then its an error      
}

/*
*  Makes sure post code is a number
*/

function validatePostCode($post){
  
   if(intval($post) != 0){
   //see if its a number
   		
   		return intval($post);

   //if its not then its an error		
   } else {

   	 echo "error";
   }

}

/*
*  Very basic validation of th3 card number 16 digits, not getting complex here.
*/

function validateCardNumber($post){
  


   if(intval($post) != 0  &&  strlen("" . $post) == 16){
   //see if its a number
   		
   		return intval($post);

   //if its not then its an error		
   } else {
   	 echo "error" ;
   }

}

/*
*  Very basic validation of the care date year, not getting complex here.
*/

function validateCardYear($post, $month){
  
		if(date("Y") == "" . $post ){
			if(intval($month) > intval(date("m"))){
				return intval($post);
			}else if($month != "" && $month !="invalid" ) {
				echo "out";
			} 
		}else if (intval(date("Y")) > intval($post)) {
			echo "error";
		} else {
			return intval($post);
		}

}

/*
*  Very basic validation of the care date month, not getting complex here.
*/

function validateExpiryMonth($post, $year){

  
	if(intval($post) >= 1 && intval($post) <= 12){
		
		if(date("Y") == "" . $year){
			if(intval($post) > intval(date("m"))){
				return intval($post);
			}else if($year != "invalid" && $year != ""){
				echo "out";
			} 
		}else if (intval(date("Y")) > intval($year)) {
			if($year == "") {return intval($post);}
			echo "out";
		} else {
			return intval($post);
		}
		
	}	else {
		echo "error";
	}

}

/*
*  Very basic validation of the care date cvv, not getting complex here.
*/

function validateCvv($post){
  	if(intval($post) != 0  &&  strlen("" . $post) == 3){
   //see if its a number
   		
   		return intval($post);

   //if its not then its an error		
   } else {
   	 echo "error" ;
   }


}

/*
*  Setups the pricing for the shipping when the order is placed.
*  suspected buggy. Needs review.
*/


function setShipping($post){

	if($post == 'delivery3'){

		$_SESSION['shipping'] = '40';

	} else if 	($post == 'delivery2'){
		$_SESSION['shipping'] = '15';
	} else {
		$_SESSION['shipping'] = '10';

	}

}
?>

