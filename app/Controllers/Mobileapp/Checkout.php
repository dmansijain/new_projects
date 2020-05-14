<?php namespace App\Controllers\Mobileapp;

use App\Models\UserModel;
use App\Models\EventModel;
use App\Models\CheckoutModel;
use CodeIgniter\RESTful\ResourceController;
//$session = \Config\Services::session();

class Checkout extends ResourceController
{ 

    

    public function __construct()
    {
        helper(['validation','common']);
		validate_header_key();
		
    }
	
	public function addbilling_detail() {
		$postData = json_decode(file_get_contents('php://input'), true);
		if($postData == '')
		{
			$postData = $_POST;
			
			
		}
		
		$errors = validate_billing_data($postData);
		if(!empty($errors)) {
			
				$return['success'] 		= "false";
				$return['message'] 		= "Please fill All Fields";
				$return['error'] 		= $errors;
				$return['data'] 		= "";			
				return $this->respond($return);
		}
		$updateBilling 		= $postData;
		$model = new EventModel();
		if(!empty($postData['user_id'])) {
			$if_register    = $model->checkUserEventRegistration($postData['event_id'], $postData['user_id']);
			$usermodel = new UserModel();
			$userdetail = $usermodel->getuserDetail($user_id);
			$updateBilling['usertype'] = $userdetail->role;
			$updateBilling['user_id'] = $user_id;
		} else {
			$updateBilling['usertype'] = 'guest';
			$if_register    = $model->checkUserEventRegistration($postData['event_id'], $postData['email'], 'email');
		}
		
		if(!empty($if_register)) {
			
			$return['success'] 		= "false";
				$return['message'] 		= "You are already register for this event.";
				$return['error'] 		= "";
				$return['data'] 		= "";			
				return $this->respond($return);
		}
		
		$updateAttende 		= $updateBilling; 
		$data = array(
		'billinginfo'=> $updateBillings,
		'attendeinfo'=> $updateAttende,
		);
		$serializedata = serialize($data);
		$unique_number= "ORD_".generateRandomString();
		$tempdata = array(
					 'data' => $serializedata,
					 'unique_number' => $unique_number
					);
		$update = 	$model->saveDataby('li_checkout_temp', $tempdata);
		if($update)
			{
				$return['success'] 		= "true";
				$return['message'] 		= "Billing Info Saved.";
				$return['error'] 		= "";
				$return['data'] 		= $unique_number;			
				
				return $this->respond($return);
			}
			else
			{
				
				$return['success'] 		= "false";
				$return['message'] 		= "Something went wrong.";
				$return['error'] 		= "";
				$return['data'] 		= "";			
				return $this->respond($return);
			}
		
	}
	
	public function add_agreement(){
		$postData = json_decode(file_get_contents('php://input'), true);
		if($postData == '')
		{
			$postData = $_POST;
			
		}
		
		$errors = validate_agreement_detail($postData);
		if(!empty($errors)) {
			
				$return['success'] 		= "false";
				$return['message'] 		= "Please fill All Fields";
				$return['error'] 		= $errors;
				$return['data'] 		= "";			
				return $this->respond($return);
		}
		
		$agreementinfo = array(
			  'event_id' => $postData['event_id'],
			  'user_id' => $postData['user_id'],
			  'event_agreed' => $postData['event_agreed'],
			  'financial_agreed' => $postData['financial_agreed'],
			  'copyright_agreed' => $postData['copyright_agreed'],
			
			);
		$model = new CheckoutModel();
		$agreementdetail = $model->saveData('li_agreements', $agreementinfo);
			
		$order_data = array(
		 'agreement_id' => $agreementdetail,
		 
		); 
		
		
		$orderdata = $model->get_order_by_unique_id($postData['order_id']);
			
		
		$order = $model->updateOrder('li_event_orders', $order_data, $orderdata->event_order_id);
		if($order)
		{
			$return['success'] 		= "true";
			$return['message'] 		= "Agreement Agreed.";
			$return['error'] 		= "";
			$return['data'] 		= $postData['order_id'];			
			
			return $this->respond($return);
		}
		else
		{
			
			$return['success'] 		= "false";
			$return['message'] 		= "Something went wrong.";
			$return['error'] 		= "";
			$return['data'] 		= "";			
			return $this->respond($return);
		}
		
	}
	
	public function payment(){
		$postData = json_decode(file_get_contents('php://input'), true);
			if( count($postData) == 0 )
		{
				$return['success'] 		= "false";
				$return['message'] 		= "Invalid data format";
				$return['data'] 		= "";	
				$return['error'] 		= "";
				
				//print_r($return); die;
				return $this->respond($return);
		} 
		$_POST  = $postData;
		$errors = validate_payment_detail($postData);
		
		if(!empty($errors)){
			$return['success'] 		= "false";
				$return['message'] 		= $errors;
				$return['data'] 		= "";	
				$return['error'] 		= $errors;
				
				//print_r($return); die;
				return $this->respond($return);
		} 
		
		$model = new CheckoutModel();
		$eventmodel = new EventModel();
		$tempdata = $model->get_tempcheckout_data($postData['order_id']);
		$billingdata = unserialize($tempdata->data);
		if(!empty($tempdata)) {
			$event_detail =  $eventmodel->getDetail($postData['event_id']);
		    if(!empty($event_detail)) {
				
				if($postData['payment_type'] == "mindeposit") {
					$eventcost = $event_detail->min_deposit;
				}else{
					if($postData['cost']){
						$eventcost = $event_detail->cost;
					} else {
						$eventcost = 0;
					}
					
				}
				
				$paymentinfo = array(
				  'event_id' => $postData['event_id'],
				 'payment_type' => $postData['payment_type'],
				  'gateway' => $postData['gateway'],
				  'amount' => $eventcost,
				  'min_deposit' => !empty($event_detail->min_deposit) ? $event_detail->min_deposit : 0,
				  'cost' => !empty($event_detail->cost) ? $event_detail->cost : 0,
				  'payment_status' => 'Completed',
				  'unique_event_order' => $postData['order_id']
				
				); 
				
				if($this->save_user_info($postData, $paymentinfo))
				{
					
					$return['success'] 		= "true";
					$return['message'] 		= "Payment Successfully done.";
					$return['error'] 		= "";
					$return['data'] 		= "";			
					
					return $this->respond($return);
				}
				else
				{
					
					$return['success'] 		= "false";
					$return['message'] 		= "Something went wrong.";
					$return['error'] 		= "";
					$return['data'] 		= "";			
					return $this->respond($return);
				} 
				
			} else {
				$return['success'] 		= "false";
				$return['message'] 		= "Invalid Order";
				$return['data'] 		= "";	
				$return['error'] 		= "";
				
				//print_r($return); die;
				return $this->respond($return);
			}
		} else {
				$return['success'] 		= "false";
				$return['message'] 		= "Invalid Event";
				$return['data'] 		= "";	
				$return['error'] 		= "";
				
				//print_r($return); die;
				return $this->respond($return);
		}
		
	}
	
	public function add_healthinfo(){
	
			$postData = json_decode(file_get_contents('php://input'), true);
		if( count($postData) == 0 )
		{
				$return['success'] 		= "false";
				$return['message'] 		= "Invalid data format";
				$return['data'] 		= "";	
				$return['error'] 		= "";
				
				//print_r($return); die;
				return $this->respond($return);
		} 
		$_POST  = $postData;
			
	        $model = new CheckoutModel();
			$orderdata = $model->get_order_by_unique_id($postData['order_id']);
			
			 $validation_errors = validate_healthinfo_data($postData);
			 
			  if(!empty($validation_errors)) {
				 $return['success'] 		= "validation_error";
				$return['message'] 		= $validation_errors;
				$return['error'] 		= $validation_errors;
				$return['data'] 		= "";			
				
				return $this->respond($return);
			 } 
			 
			
			 $healthinfo = array(
			 
			'full_name' => isset($postData['healthinfo']['full_name']) ? encrypt($postData['healthinfo']['full_name']) : null,
			  'birth_date' => isset($postData['healthinfo']['birth_date']) ? encrypt($postData['healthinfo']['birth_date']) : null,
			  'address_1' => isset($postData['healthinfo']['address_1']) ? encrypt($postData['healthinfo']['address_1']) : null,
			 'address_2' => isset($postData['healthinfo']['address_2']) ? encrypt($postData['healthinfo']['address_2']) : null,
			  'city' => isset($postData['healthinfo']['city']) ? encrypt($postData['healthinfo']['city']) : null,
			  'state' => isset($postData['healthinfo']['state']) ? encrypt($postData['healthinfo']['state']) : null,
			   'zipcode' => isset($postData['healthinfo']['zipcode']) ? encrypt($postData['healthinfo']['zipcode']) : null,
			  'em_contactname' => isset($postData['healthinfo']['em_contactname']) ? encrypt($postData['healthinfo']['em_contactname']) : null,
			 'em_contactaddress' => isset($postData['healthinfo']['em_contactaddress']) ? encrypt($postData['healthinfo']['em_contactaddress']) : null,
			  'em_relation_withyou' => isset($postData['healthinfo']['em_relation_withyou']) ? $postData['healthinfo']['em_relation_withyou'] : null,
			  'em_phone_number' => isset($postData['healthinfo']['em_phone_number']) ? encrypt($postData['healthinfo']['em_phone_number']) : null,
			    'health_insure_company' => isset($postData['healthinfo']['health_insure_company']) ? $postData['healthinfo']['health_insure_company'] : null,
			  'health_insure_phone' => isset($postData['healthinfo']['health_insure_phone']) ? $postData['healthinfo']['health_insure_phone'] : null,
			  'insure_primary_holder' => isset($postData['healthinfo']['insure_primary_holder']) ? $postData['healthinfo']['insure_primary_holder'] : null,
			 'insure_group_number' => isset($postData['healthinfo']['insure_group_number']) ? encrypt($postData['healthinfo']['insure_group_number']) : null,
			  'insure_idnumber' => isset($postData['healthinfo']['insure_idnumber']) ? encrypt($postData['healthinfo']['insure_idnumber']) : null,
			  'primary_physician' => isset($postData['healthinfo']['primary_physician']) ? $postData['healthinfo']['primary_physician'] : null,
			   'physician_address' => isset($postData['healthinfo']['physician_address']) ? $postData['healthinfo']['physician_address'] : null,
			   'physician_phone' => isset($postData['healthinfo']['physician_phone']) ? $postData['healthinfo']['physician_phone'] : null,
			  'list_all_medications' => isset($postData['healthinfo']['list_all_medications']) ? encrypt($postData['healthinfo']['list_all_medications']) : null,
			 'list_any_psychiatric' => isset($postData['healthinfo']['list_any_psychiatric']) ? encrypt($postData['healthinfo']['list_any_psychiatric']) : null,
			  'list_any_orthopedic' => isset($postData['healthinfo']['list_any_orthopedic']) ? encrypt($postData['healthinfo']['list_any_orthopedic']) : null,
			  '	your_personal_safety' => isset($postData['healthinfo']['your_personal_safety']) ? encrypt($postData['healthinfo']['your_personal_safety']) : null,
			   'suffer_from_hiv' => isset($postData['healthinfo']['suffer_from_hiv']) ? encrypt($postData['healthinfo']['suffer_from_hiv']) : null,
			  'addicted_to_alcohol' => isset($postData['healthinfo']['addicted_to_alcohol']) ? encrypt($postData['healthinfo']['addicted_to_alcohol']) : null,
			  'otc_medications' => isset($postData['healthinfo']['otc_medications']) ? encrypt($postData['healthinfo']['otc_medications']) : null,
			   'other_contact_allergies' => isset($postData['healthinfo']['other_contact_allergies']) ? encrypt($postData['healthinfo']['other_contact_allergies']) : null,
			  'allergic_to_striped' => isset($postData['healthinfo']['allergic_to_striped']) ? encrypt($postData['healthinfo']['allergic_to_striped']) : null,
			 'list_food_allergies' => isset($postData['healthinfo']['list_food_allergies']) ? : null,
			  'allow_staffmedic_review' => isset($postData['healthinfo']['allow_staffmedic_review']) ? $postData['healthinfo']['allow_staffmedic_review'] : null,
			  'signature' => isset($postData['healthinfo']['signature']) ? $postData['healthinfo']['signature'] : null,
			  'signature_date' => isset($postData['healthinfo']['signature_date']) ? $postData['healthinfo']['signature_date'] : null,
			 
			); 
			
			$usermodel = new UserModel();
			$current_user_healthinfo = $usermodel->gethealthinfoDetail($orderdata->user_id);
			//echo "<pre>";print_r($current_user_healthinfo);exit;
			if(!empty($current_user_healthinfo)) { 
			
				$usermodel->updatehealthinfo($healthinfo,  $current_user_healthinfo->id);
				$healthdetail = $current_user_healthinfo->id;
			} else {
				 $healthinfo['user_id'] =  $orderdata->user_id;
				
				$healthdetail = $model->saveData('li_health_info', $healthinfo);
			}
			
			$order_data = array(
			  'healthinfo_id' => $healthdetail
			 
			); 
			
			$order = $model->updateOrder('li_event_orders', $order_data, $orderdata->event_order_id);
			
			if($order)
			{
				$return['success'] 		= "true";
				$return['message'] 		= "healthinfo Saved in cart.";
				$return['error'] 		= "";
				$return['data'] 		= $update;			
				
				return $this->respond($return);
			}
			else
			{
				
				$return['success'] 		= "false";
				$return['message'] 		= "Something went wrong.";
				$return['error'] 		= "";
				$return['data'] 		= "";			
				return $this->respond($return);
			}
	}
	
	
	
		public function save_user_info($postData, $paymentinfo) {
		helper('form');
		$view = \Config\Services::renderer();
		$model = new CheckoutModel();
		$usermodel = new UserModel();
		$eventmodel = new EventModel();
		$event_detail =  $eventmodel->getDetail($paymentinfo['event_id']);
			$tempdata = $model->get_tempcheckout_data($postData['order_id']);
			$billingdata = unserialize($tempdata->data);
			
			if(empty($billingdata['billinginfo']['ID'])) {
					
					$checkuser = $usermodel->check_user_email($billingdata['billinginfo']['email']);
					if(!empty($checkuser)) {
						$user_id = $checkuser->ID;
					} else {
						
						$password = generateRandomString();
						
						$userdata = array(
							'login_id' 	=> $billingdata['billinginfo']['email'],
							'email' 	=> $billingdata['billinginfo']['email'],
							'password'  => md5($password),
							'first_name'=> $billingdata['billinginfo']['first_name'],
							'last_name' => $billingdata['billinginfo']['last_name'],
							'phone' 	=> $billingdata['billinginfo']['phone_number'],
							'address' 	=> $billingdata['billinginfo']['address'],
							'state' 	=> $billingdata['billinginfo']['state'],
							'city' 		=> $billingdata['billinginfo']['city'],
							'zip' 		=> $billingdata['billinginfo']['zip_code'],
							'role' 		=> 'customer'
						);
						
					
						$createuser = $usermodel->saveUser($userdata);
						
						if($createuser) {
							
							$view_data = array(
							'name' => $billingdata['billinginfo']['first_name'].' '.$billingdata['billinginfo']['last_name'],
							'email' => $billingdata['billinginfo']['email'],
							'password' => $password
							);
							$maildata = array(
							  'to' => $billingdata['billinginfo']['email'],
							  'subject' => "Account created",
							  'message' => $view->setData($view_data)->render('email/register')
							);
							
							send_mail($maildata);
							$user_id = $createuser;
							
						}
						
					}
					
				
			}else {
				
				$user_id = $billingdata['billinginfo']['ID'];
				
			}
			
			
			
			$billinginfo = array(
			  'event_id' => $paymentinfo['event_id'],
			  'user_id' => $user_id,
			  'first_name' => $billingdata['billinginfo']['first_name'],
			  'last_name' => $billingdata['billinginfo']['last_name'],
			  'phone_number' => $billingdata['billinginfo']['phone_number'],
			  'email' => $billingdata['billinginfo']['email'],
			  'address' => $billingdata['billinginfo']['address'],
			  'city' => $billingdata['billinginfo']['city'],
			  'state' => $billingdata['billinginfo']['state'],
			  'zip_code' => $billingdata['billinginfo']['zip_code'],
			  'usertype' => $billingdata['billinginfo']['usertype'],
			  'different_attende' => !empty($billingdata['billinginfo']['different_attende']) ? $billingdata['billinginfo']['different_attende'] : 0
			);
			
			$attendeinfo = array(
			  'event_id' => $paymentinfo['event_id'],
			  'user_id' => $user_id,
			  'first_name' => $billingdata['attendeinfo']['first_name'],
			  'last_name' => $billingdata['attendeinfo']['last_name'],
			  'phone_number' => $billingdata['attendeinfo']['phone_number'],
			  'email' => $billingdata['attendeinfo']['email'],
			  'address' => $billingdata['attendeinfo']['address'],
			  'city' => $billingdata['attendeinfo']['city'],
			  'state' => $billingdata['attendeinfo']['state'],
			  'zip_code' => $billingdata['attendeinfo']['zip_code'],
			 
			);
			
		
			
			$billingdetail = $model->saveData('li_billing_info', $billinginfo);
			$attendedetail = $model->saveData('li_attende_info', $attendeinfo);
			$paymentdata = array();
			if($paymentinfo['gateway'] == "pay" && !empty($paymentinfo['transaction_id'])) {
				$paymentdata = $model->get_payment_by_txn_id($paymentinfo['transaction_id']);
			}
			
			if(empty($paymentdata)) {
				$paymentdetail[] = $model->saveData('li_payment', $paymentinfo);
			} else {
				$paymentdetail[] = $paymentdata->id;
			}
			
				$oderdata = array (
					'user_id' => $user_id,
				  'billing_id' => $billingdetail,
				  'attende_id' => $attendedetail,
				  'event_id' => $paymentinfo['event_id'],
				  'payment_id' => serialize($paymentdetail),
				  'paid_amount' => $paymentinfo['amount'],
				  'unique_event_order' => $postData['order_id'],
				  'is_group' => !empty($event_detail->group_id) ? 1 : 0
				);
				
			if($paymentinfo['payment_type'] == "paymentplan") {
				$pagemodel = new PagesModel();
				$paymentplan = $pagemodel->get_payment_plan_settings();
				$oderdata['payment_plan_time_period'] = $paymentplan->time_period;
				$oderdata['payment_division'] = $paymentplan->payment_division;
				
			}
			
			$update = $model->saveData('li_event_orders', $oderdata);
			if($update) {
				$model->delete_temp_checkout_data($postData['order_id']);
				$eventmodel = new EventModel();
				$event_detail =  $eventmodel->getDetail($paymentinfo['event_id']);
				$view_data = array(
				'name' => $billingdata['billinginfo']['first_name'].' '.$billingdata['billinginfo']['last_name'],
							'event_name' => $event_detail->typenametitle.','.$event_detail->location.', '.$event_detail->start_date,
							
							);
				$maildata = array(
				  'to' => $billingdata['billinginfo']['email'],
				  'subject' => "Order Success",
				  'message' => $view->setData($view_data)->render('email/order')
				);
				
				send_mail($maildata);
				$session = \Config\Services::session();
				$data['user_id'] = $user_id;
				$session->set($data);
				
			}
			return $update;
	}
	
	

	
	
}
