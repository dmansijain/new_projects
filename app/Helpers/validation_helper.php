<?php 
use CodeIgniter\HTTP\Header;

if(!function_exists('validate_header_key')) {
	
function validate_header_key()
{
    $request = \Config\Services::request();
	
	$headers = $request->getHeaderLine('x-api-key');
	if(empty($headers)){
		
		header("HTTP/1.0 403 Forbidden");
		echo '{"success":"false","message":"Empty header key","data":"","error":""}';
		die;
		
	} else {
		 $db  = \Config\Database::connect();
		
		$header_key = $db->table('li_keys')->select('key')->get()->getRow();
		if($header_key->key == $headers) {
			return true;
		} else {
			
			header("HTTP/1.0 403 Forbidden");
			echo '{"success":"false","message":"Invalid key","data":"","error":""}';
			die;
		}
	}
}
}


if(!function_exists('validate_login'))
{
	function validate_login($logindata)
	{
		
		$errors = array();
		if($logindata['email'] == "") {
			$errors['email'] = "Email is required";
		} else if(!email_validation($logindata['email'])) {
			$errors['email'] = "Email is not valid";
		} else {
			
		}
		
		if($logindata['password'] == "") {
			
			$errors['password'] = "Password is required";
		}
		if($logindata['device_id'] == "") {
			$errors['device_id'] = "Device Id is required";
		}
		if($logindata['device'] == "") {
			$errors['device'] = "Device is required";
		}
		if($logindata['fcm_key'] == "") {
			$errors['fcm_key'] = "Fcm Key is required";
		}
			return $errors;
		
	}
}

if(!function_exists('validate_register'))
{
	function validate_register($registerdata)
	{
		
		$errors = array();
		if($registerdata['first_name'] == "") {
			$errors['first_name'] = "First Name is required";
		} 
		
		if($registerdata['last_name'] == "") {
			$errors['last_name'] = "First Name is required";
		} 
		
		if($registerdata['email'] == "") {
			$errors['email'] = "Email is required";
		} else if(!email_validation($registerdata['email'])) {
			$errors['email'] = "Email is not valid";
		} else {
		    
		     $db  = \Config\Database::connect();
			$userdata = $db->table('li_users')->where('email', $registerdata['email'])->get()->getRow();
			
			if(!empty($userdata)){
				$errors['email'] = "This email is already registered";
			}
		}
		
		if($registerdata['password'] == "") {
			
			$errors['password'] = "Password is required";
		}else if(strlen($registerdata['password']) < 6 || strlen($registerdata['password']) > 15){
			$errors['password'] = "Password length must be between 6-15";
		} else {
			
		}
		
		if($registerdata['password'] != $registerdata['confirm_password']){
			$errors['confirm_password'] = "Confirm Password does not match with password";
		}
		
		if($registerdata['address'] == "") {
			$errors['address'] = "Address is required";
		}
		
		if($registerdata['city'] == "") {
			$errors['city'] = "City is required";
		}
		
		if($registerdata['state'] == "") {
			$errors['state'] = "State is required";
		}
		
		if($registerdata['zip'] == "") {
			$errors['zip'] = "Zip is required";
		}else if(!is_numeric($registerdata['zip'])){
			$errors['zip'] = "Zip is not valid";
		} else  {
			
		}
		
		if($registerdata['phone'] == "") {
			$errors['phone'] = "Phone Number is required";
		} else if(!validate_mobile($registerdata['phone'])){
			$errors['phone'] = "Phone Number is not valid";
		} else  {
			
		}
		
		if($registerdata['device_id'] == "") {
			$errors['device_id'] = "Device Id is required";
		}
		
		if($registerdata['device_id'] == "") {
			$errors['device_id'] = "Device Id is required";
		}
		
		if($registerdata['device'] == "") {
			$errors['device'] = "Device is required";
		}
		
		if($registerdata['fcm_key'] == "") {
			$errors['fcm_key'] = "Fcm Key is required";
		}
			return $errors;
		
	}
}

if(!function_exists('email_validation'))
{
	function email_validation($str) { 
		return (!preg_match( 
	"^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^", $str)) 
			? FALSE : TRUE; 
	} 
}

if(!function_exists('validate_mobile')) {
function validate_mobile($mobile)
{
    return preg_match('/^[0-9]{10,12}+$/', $mobile);
}
}

if(!function_exists('validate_userId')) {
	function validate_userId($userID)
	{
		
		
		$errors = array();
	  if(empty($userID)){
		 $errors['user_id'] = 'User Id is required'; 
	  } else if(!is_numeric($userID)) {
		 $errors['user_id'] = 'User Id is not valid';  
	  }else {
		  
	  }
	  return $errors;
	}
}

if(!function_exists('validate_update_profile')) {
	function validate_update_profile($postdata)
	{
		$errors = array();
		if(empty($postdata['user_id'])){
		 $errors['user_id'] = 'User Id is required'; 
		  } else if(!is_numeric($postdata['user_id'])) {
			 $errors['user_id'] = 'User Id is not valid';  
		  }else {
			  
		  }
		if($postdata['first_name'] == "") {
			$errors['first_name'] = "First Name is required";
		} 
		
		if($postdata['last_name'] == "") {
			$errors['last_name'] = "First Name is required";
		} 
		
		if($postdata['address'] == "") {
			$errors['address'] = "Address is required";
		}
		
		if($postdata['city'] == "") {
			$errors['city'] = "City is required";
		}
		
		if($postdata['state'] == "") {
			$errors['state'] = "State is required";
		}
		
		if($postdata['zip'] == "") {
			$errors['zip'] = "Zip is required";
		}else if(!is_numeric($postdata['zip'])){
			$errors['zip'] = "Zip is not valid";
		} else  {
			
		}
		
		if($postdata['phone'] == "") {
			$errors['phone'] = "Phone Number is required";
		} else if(!validate_mobile($postdata['phone'])){
			$errors['phone'] = "Phone Number is not valid";
		} else  {
			
		}
		
		if($postdata['bio'] == "") {
			$errors['bio'] = "bio is required";
		}
	  return $errors;
	}
}

if(!function_exists('validate_change_password')) {
	function validate_change_password($postdata)
	{
		
		
		$errors = array();
		$errors = validate_userId($postdata['user_id']);
		if($postdata['old_password'] == "") {
			
			$errors['old_password'] = "Old Password is required";
		} else {
			 $db  = \Config\Database::connect();
			$userdata = $db->table('li_users')->where('password', md5($postdata['old_password']))->where('ID', $postdata['user_id'])->get()->getRow();
			if(empty($userdata)) {
				$errors['old_password'] = "Old Password is wrong";
			}
		}
		
	  if($postdata['password'] == "") {
			
			$errors['password'] = "New Password is required";
		}else if(strlen($postdata['password']) < 6 || strlen($postdata['password']) > 15){
			$errors['password'] = "New Password length must be between 6-15";
		} else {
			 $db  = \Config\Database::connect();
			$userdata = $db->table('li_users')->where('password', md5($postdata['password']))->where('ID', $postdata['user_id'])->get()->getRow();
			if(!empty($userdata)) {
				$errors['password'] = "New password should not be same as old password.";
			}
		}
		
		if($postdata['confirm_password'] == "") {
			
			$errors['confirm_password'] = "Confirm Password is required";
		}else if($postdata['password'] != $postdata['confirm_password']){
			$errors['confirm_password'] = "Confirm Password does not match with password";
		}
	  return $errors;
	}
}

if(!function_exists('validate_reset_password')) {
	function validate_reset_password($postdata)
	{
		
		
		$errors = array();
		
		
		
	  if($postdata['new_password'] == "" || $postdata['new_password'] == 'undefined') {
			
			$errors['new_password'] = "New Password is required";
		}else if(strlen($postdata['new_password']) < 6 || strlen($postdata['new_password']) > 15){
			$errors['new_password'] = "New Password length must be between 6-15";
		} else {
			 $db  = \Config\Database::connect();
			$userdata = $db->table('li_users')->where('password', md5($postdata['new_password']))->where('ID', $postdata['user_id'])->get()->getRow();
			//echo "<pre>";print_r($userdata);exit;
			if(!empty($userdata)) {
				$errors['new_password'] = "New password should not be same as old password.";
			}
		}
		
		if($postdata['confirm_password'] == "" || $postdata['confirm_password'] == 'undefined') {
			
			$errors['confirm_password'] = "Confirm Password is required";
		}else if($postdata['new_password'] != $postdata['confirm_password']){
			$errors['confirm_password'] = "Confirm Password does not match with password";
		}
	  return $errors;
	}
}

if(!function_exists('validate_skills')) {
	function validate_skills($postdata)
	{
		$errors = array();
	    $errors = validate_userId($postdata['user_id']);
		if(empty($postdata['skill_id'])) {
			$errors['skill'] = "Skill is required";
		} else {
			$db  = \Config\Database::connect();
			
			$skills = $db->table('li_skills')->select('id')->get()->getResult();
			$alskill = array();
			foreach($skills as $skill) {
				$alskill[] = $skill->id;
			}
			if(!in_array($postdata['skill_id'], $alskill)) {
				$errors['skill'] = "Skill is not valid";
			}
		
		}
		
		return $errors;
	}
}

if(!function_exists('validate_delete_skills_data')) {
	function validate_delete_skills_data($postdata)
	{
		$errors = array();
	    $errors = validate_userId($postdata['user_id']);
		if(empty($postdata['user_skill_id'])) {
			$errors['skill'] = "User Skill ID is required";
		} else {
			$db  = \Config\Database::connect();
			
			$skills = $db->table('li_user_skills')->select('*')->where('user_id', $postdata['user_id'])->where('id', $postdata['user_skill_id'])->get()->getRow();
			if(empty($skills)) {
				$errors['skill'] = "User Skill ID is not valid";
			}
		
		}
		
		return $errors;
	}
}


if(!function_exists('validate_healthinfo_data')) {
	function validate_healthinfo_data($healthinfo)
	{
		$errors = array();
		if($healthinfo['full_name'] == "") {
			$errors['full_name_error'] = "Full Name is required";
		} 
		if($healthinfo['birth_date'] == "") {
			$errors['birth_date_error'] = "Birth Date is required";
		} 
		if($healthinfo['address_1'] == "") {
			$errors['address_1_error'] = "Address-1 is required";
		}
if($healthinfo['address_2'] == "") {
			$errors['address_2_error'] = "Address-2 is required";
		}		
		if($healthinfo['city'] == "") {
			$errors['city_error'] = "City is required";
		}
		
		if($healthinfo['state'] == "") {
			$errors['state_error'] = "State is required";
		}
		
		if($healthinfo['zipcode'] == "") {
			$errors['zipcode_error'] = "Zip is required";
		}else if(!is_numeric($healthinfo['zipcode'])){
			$errors['zipcode_error'] = "Zip is not valid";
		} else  {
			
		}
		if($healthinfo['em_contactname'] == "") {
			$errors['em_contactname_error'] = "Emergency Contact Name is required";
		} 
		if($healthinfo['em_contactaddress'] == "") {
			$errors['em_contactaddress_error'] = "Emergency Contact Address is required";
		}
		if($healthinfo['em_relation_withyou'] == "") {
			$errors['em_relation_withyou_error'] = "Emergency Contact Relationship to you is required";
		} 
		
		if($healthinfo['em_phone_number'] == "") {
			$errors['em_phone_number_error'] = "Emergency Phone Number is required";
		} else if(!validate_mobile($healthinfo['em_phone_number'])){
			$errors['em_phone_number_error'] = "Emergency Phone Number is not valid";
		} else  {
			
		}
		if($healthinfo['health_insure_company'] == "") {
			$errors['health_insure_company_error'] = "Health insurance company name is required";
		} 
		if($healthinfo['health_insure_phone'] == "") {
			$errors['health_insure_phone_error'] = "Health insurance company Phone Number is required";
		} else if(!validate_mobile($healthinfo['health_insure_phone'])){
			$errors['health_insure_phone_error'] = "Health insurance company Phone Number is not valid";
		} else  {
			
		}
		if($healthinfo['insure_primary_holder'] == "") {
			$errors['insure_primary_holder_error'] = "Insurance Primary holder name is required";
		} 
		if($healthinfo['insure_group_number'] == "") {
			$errors['insure_group_number_error'] = "Insurance group number is required";
		} 
		if($healthinfo['insure_idnumber'] == "") {
			$errors['insure_idnumber_error'] = "Insurance Identification number is required";
		} 
		if($healthinfo['primary_physician'] == "") {
			$errors['primary_physician_error'] = "Primary Physician name is required";
		} 
		if($healthinfo['physician_address'] == "") {
			$errors['physician_address_error'] = "Physician address is required";
		} 
		if($healthinfo['physician_phone'] == "") {
			$errors['physician_phone_error'] = "Physician Phone Number is required";
		} else if(!validate_mobile($healthinfo['physician_phone'])){
			$errors['physician_phone_error'] = "Physician Phone Number is not valid";
		} else  {
			
		}
		
		if($healthinfo['otc_medications'] == "") {
			$errors['otc_medications_error'] = "Please choose any option";
		}
		if($healthinfo['allow_staffmedic_review'] == "") {
			$errors['allow_staffmedic_review_error'] = "Please choose any option";
		}
		if($healthinfo['signature'] == "") {
			$errors['signature_error'] = "Signature is required";
		}
		if($healthinfo['signature_date'] == "") {
			$errors['signature_date_error'] = "Signature date is required";
		}
		return $errors;
		
		
	    
	}
}

if(!function_exists('validate_contact_data')) {
	function validate_contact_data($postdata)
	{
		
		$errors = array();
	    if($postdata['name'] == "" || $postdata['name'] == "undefined") {
			$errors['name_error'] = "First Name is required";
		} 
		if($postdata['email'] == "" || $postdata['email'] == "undefined") {
			$errors['email_error'] = "Email is required";
		} else if(!email_validation($postdata['email'])) {
			$errors['email_error'] = "Email is not valid";
		} else {
			
		}
		
		if($postdata['phone'] == ""  || $postdata['phone'] == "undefined") {
			$errors['phone_error'] = "Phone Number is required";
		} else if(!validate_mobile($postdata['phone'])){
			$errors['phone_error'] = "Phone Number is not valid";
		} else  {
			
		}
		
		if($postdata['message'] == ""  || $postdata['message'] == "undefined") {
			$errors['message_error'] = "Message is required";
		} else if(strlen($postdata['message']) < 3 || strlen($postdata['message']) > 1000){
			$errors['message_error'] = "Message length should be between 3-1000";
		} else  {
			
		}
		
		
		return $errors;
	}
}

if(!function_exists('check_existing_skill')) {
function check_existing_skill($skill_id, $skill_name) {
	$errors = "";
	if($skill_name == ""){
		$errors = "Skill Name is required";
	} else{
		$db  = \Config\Database::connect();
		$skilldata = $db->table('li_skills')->where('id !=', $skill_id)->where('name', $skill_name)->get()->getRow();
		if(!empty($skilldata)) {
			$errors = "Skill Name should be unique";
		}
			
	}
	return $errors;
}
}

if(!function_exists('validate_billing_data')) {
function validate_billing_data($billing_data) {
	
	$errors = array();
	
	if(!empty($billing_data['user_id'])){
		if(!is_numeric($billing_data['user_id'])){
			$errors['userid_error'] ='Invalid User ID.';
		} else {
			 $db  = \Config\Database::connect();
			$userdata = $db->table('li_users')->where('ID', $billing_data['user_id'])->get()->getRow();
			if(empty($userdata)) {
				$errors['userid_error'] = "Invalid User ID.";
			}
			
		}
	}
	
	if($billing_data['event_id'] == "" || !is_numeric($billing_data['event_id'])){ 			
				$errors['event_error'] =  'Invalid Event';
	} else  {
		 $db  = \Config\Database::connect();
			$eventdata = $db->table('li_events')->where('id', $billing_data['event_id'])->where('is_delete', 0)->get()->getRow();
			if(empty($eventdata)) {
				$errors['event_error'] = "Invalid Event.";
			}		
	}
	
	if($billing_data['first_name'] == ""){			
			$errors['firstname_error'] ='The Billing First Name field is required.';
	 }
	if($billing_data['last_name'] == ""){			
				$errors['lastname_error'] ='The Billing Last Name field is required.';
	}

	if($billing_data['phone_number'] == ""){			
				$errors['phone_error'] ='The Billing Phone Number field is required.';
	 }else if(!validate_mobile($billing_data['phone_number'])){
				$errors['phone_error'] = "Phone Number is not valid";
	} else  {
				
	}
	if($billing_data['email'] == ""){			
				$errors['email_error']='The Billing Email field is required.';
	}else if(!email_validation($billing_data['email'])) {
			$errors['email_error'] = "Email is not valid";
	} else {
		
	}
	if($billing_data['address'] == ""){			
				$errors['address_error'] ='The Billing Address field is required.';
	}
	if($billing_data['city'] == ""){			
				$errors['city_error'] ='The Billing City field is required.';
	}
	if($billing_data['state'] == ""){			
				$errors['state_error'] ='The Billing State field is required.';
	}
	if($billing_data['zip_code'] == ""){			
				$errors['zip_error'] ='The Billing Zip Code field is required.';
	}else if(!is_numeric($billing_data['zip_code'])){
			$errors['zip_error'] = "The Billing Zip Code is not valid";
		} else  {
			
		}

	return $errors;
		
}	
	
}

if(!function_exists('validate_agreement_detail')){
	function validate_agreement_detail($agreement_data){
		$errors = array();
		
		if(empty($agreement_data['user_id'])){
			$errors['userid_error'] ='Invalid User ID.';
		}elseif(!is_numeric($agreement_data['user_id'])){
				$errors['userid_error'] ='Invalid User ID.';
		} else {
				 $db  = \Config\Database::connect();
				$userdata = $db->table('li_users')->where('ID', $agreement_data['user_id'])->get()->getRow();
				if(empty($userdata)) {
					$errors['userid_error'] = "Invalid User ID.";
				}
				
			}
		
		if(empty($agreement_data['order_id'])){
			$errors['orderid_error'] =  'Invalid order';
			
		} else{
			 $db  = \Config\Database::connect();
			$orderdata = $db->table('li_event_orders')->where('unique_event_order', $agreement_data['order_id'])->where('user_id', $agreement_data['user_id'])->where('event_id', $agreement_data['event_id'])->get()->getRow();
			if(empty($orderdata)) {
					$errors['orderid_error'] = "Invalid Order.";
				}		
		}
	
		if($agreement_data['event_id'] == "" || !is_numeric($agreement_data['event_id'])){ 			
					$errors['event_error'] =  'Invalid Event';
		} else  {
			 $db  = \Config\Database::connect();
				$eventdata = $db->table('li_events')->where('id', $agreement_data['event_id'])->where('is_delete', 0)->get()->getRow();
				if(empty($eventdata)) {
					$errors['event_error'] = "Invalid Event.";
				}		
		}
		
		if($agreement_data['event_agreed'] != 1){
			$errors['event_agreed_error'] ='The Event Agreement field is required.';
		}
		
		if($agreement_data['financial_agreed'] != 1){
			$errors['financial_agreed_error'] ='The Event Agreement field is required.';
		}
		
		if($agreement_data['copyright_agreed'] != 1){
			$errors['copyright_agreed_error'] ='The Event Agreement field is required.';
		}
		
		return $errors;
	
	}
	
}

if(!function_exists('validate_group_mail')) {
function validate_group_mail($postdata)
{
	$errors = array();
   if(empty($postdata['group_id'])) {
	   $errors['group_error'] = "invalid group";
	   
   } else if(!is_numeric($postdata['group_id'])){
	   
	   $errors['group_error'] = "invalid group";
	   
   } else{
	   
   }
   
   if(empty($postdata['subject'])) {
	   $errors['subject_error'] = "Subject is required!";
   }
   
   if(empty($postdata['message'])) {
	   $errors['message_error'] = "Message is required!";
   }
   return $errors;
   
}
}

if(!function_exists('validate_payment_detail')) {
function validate_payment_detail($postdata)
{
	$errors = array();
	
	if(empty($postdata['order_id'])){
		$errors['order_error'] = "invalid Order";
	}
	
	if(empty($postdata['event_id'])){
		$errors['event_error'] = "invalid Event";
	}
	
	if(empty($postdata['payment_type'])){
		$errors['paymenttype_error'] = "Please select Payment type";
	}
	
	if(empty($postdata['gateway'])){
		$errors['gateway_error'] = "Please select Payment Method";
	}
	
	if(empty($postdata['amount'])){
		$errors['amount_error'] = "Amount is required";
	}
	
	return $errors;
	
}
}


?>