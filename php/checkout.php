

<?php
// ===============================
// AUTHOR     : Dieter Schmid   
// CREATE DATE     : 18/09/2017 (added header)
// PURPOSE     : backend business logic for process the users form details.
// SPECIAL NOTES:
// ===============================
// Change History:
//
//==================================



session_start();
$firstname = $_SESSION['firstname'];
$lastname = $_SESSION['lastname'];
$address = $_SESSION['address'];
$company = $_SESSION['company'];
$city = $_SESSION['city'];
$postcode = $_SESSION['postcode'];
$state = $_SESSION['state'];
$phone = $_SESSION['phone'];
$email = $_SESSION['email'];
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





function validateEmail($email){
	if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
     return $email;
	} else{
     echo "error";
	}

   //see if its a valid number
   //test normal numbar
   /*$pattern1 = "/^[a-zA-Z0-9._-]+@[a-zA-Z0-9-]+\.[a-zA-Z.]{2,5}$/";
  
  
   if (preg_match($pattern1,$email)) {  return $email;}
   else {echo "error"; }
   //test mobile number 
   //if its not then its an error */     
}

function validatePhone($phone){
   //see if its a valid number
   //test normal numbar
   $pattern1 = "/^\([0-9]{2}\)\s*[0-9]{4}\s*[0-9]{4}$/";
   $pattern2 = "/^[0-9]{2}[0-9]{4}[0-9]{4}$/";
  
   if (preg_match($pattern1,$phone)) {  return $phone;}
   else if (preg_match($pattern2,$phone)) { return $phone;}
   else {
      echo "error"; 
   }
   //test mobile number 
   //if its not then its an error      
}

function validatePostCode($post){
  
   if(intval($post) != 0){
   //see if its a number
   		echo "here" . intval($post);
   		return intval($post);

   //if its not then its an error		
   } else {
   	 echo "error";
   }

}

function validateCardNumber($post){
  
   if(intval($post) != 0  &&  strlen("" . $post) == 16){
   //see if its a number
   		
   		return intval($post);

   //if its not then its an error		
   } else {
   	 echo "error" ;
   }

}

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

function validateCvv($post){
  	if(intval($post) != 0  &&  strlen("" . $post) == 3){
   //see if its a number
   		
   		return intval($post);

   //if its not then its an error		
   } else {
   	 echo "error" ;
   }


}


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

