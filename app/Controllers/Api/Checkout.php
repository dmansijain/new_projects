<?php namespace App\Controllers\APi;
use App\Models\CheckoutModel;
use CodeIgniter\RESTful\ResourceController;
use App\Libraries\Liminaltokenlib;
use App\Libraries\Braintree_lib;
use App\Models\EventModel;
use App\Models\UserModel;
use App\Models\PagesModel;

class Checkout extends ResourceController
{ 
    public function __construct()
    {
        helper(['cookie','common']);
		/* create token */
		$LiminaltokenlibObj 	= new Liminaltokenlib();
         
				
    }

		 
  public function updateAttende() 
		{
			
			helper('form');
			$postData = json_decode(file_get_contents('php://input'), true);
			if($postData == '')
			{
				$postData = $_POST;
				
				
			}
			
			$billing_id='';;
			$uservalidate=true;
			//$event_id=$_POST['event_id'];
			 
		
if($postData['billinginfo']['first_name'] == ""){			
			$error['billing']['firstname_error'] ='The Billing First Name field is required.';
 }
if($postData['billinginfo']['last_name'] == ""){			
			$error['billing']['lastname_error'] ='The Billing Last Name field is required.';
}

if($postData['billinginfo']['phone_number'] == ""){			
			$error['billing']['phone_error'] ='The Billing Phone Number field is required.';
 }
if($postData['billinginfo']['email'] == ""){			
			$error['billing']['email_error']='The Billing Email field is required.';
}
if($postData['billinginfo']['address'] == ""){			
			$error['billing']['address_error'] ='The Billing Address field is required.';
}
if($postData['billinginfo']['city'] == ""){			
			$error['billing']['city_error'] ='The Billing City field is required.';
}
if($postData['billinginfo']['state'] == ""){			
			$error['billing']['state_error'] ='The Billing State field is required.';
}
if($postData['billinginfo']['zip_code'] == ""){			
			$error['billing']['zip_error'] ='The Billing Zip Code field is required.';
}

if($postData['billinginfo']['different_attende']==1) {
if($postData['attendeinfo']['first_name'] == ""){			
			$error['attende']['firstname_error'] ='The Attendee First Name field is required.';
 }
if($postData['attendeinfo']['last_name'] == ""){			
			$error['attende']['lastname_error'] ='The Attendee Last Name field is required.';
}
if($postData['attendeinfo']['phone_number'] == ""){			
			$error['attende']['phone_error'] ='The Attendee Phone Number field is required.';
 }
if($postData['attendeinfo']['email'] == ""){			
			$error['attende']['email_error'] ='The Attendee Email field is required.';
}
if(!filter_var($postData['attendeinfo']['email'], FILTER_VALIDATE_EMAIL)){			
			$error['attende']['email_error'] ='Please enter valid The Attendee Email.';
}
if($postData['attendeinfo']['address'] == ""){			
			$error['attende']['address_error'] ='The Attendee Address field is required.';
}
if($postData['attendeinfo']['city'] == ""){			
			$error['attende']['city_error'] ='The Attendee City field is required.';
}
if($postData['attendeinfo']['state'] == ""){			
			$error['attende']['state_error'] ='The Attendee State field is required.';
}
if($postData['attendeinfo']['zip_code'] == ""){			
			$error['attende']['zip_error'] ='The Attendee Zip Code field is required.';
}

}		
			
			
			$diffattende=$postData['billinginfo']['different_attende'];
			$postData['billinginfo']['different_attende']= isset($postData['billinginfo']['different_attende']) ? $postData['billinginfo']['different_attende']: '';
			//unset($postData['billinginfo']['different_attende']);
			$updateBilling 		= $postData['billinginfo'];
			$session = \Config\Services::session();
		//print_r($session->get('user_data')->role);
		$model = new EventModel();
		
       if($session->get('is_logged_in')!=true )
            {
				$if_register    = $model->checkUserEventRegistration($postData['billinginfo']['event_id'], $postData['billinginfo']['email'], 'email');
				$updateBilling['usertype'] = 'guest';
				if(!empty($if_register)) {
						$error['billing']['register_validate'] = "You are already register for this event.";
				} 
			} else {
				
				 $if_register    = $model->checkUserEventRegistration($postData['billinginfo']['event_id'], $session->get('user_data')->ID);
				if(!empty($if_register)) {
						$error['billing']['register_validate'] = "You are already register for this event.";
				} 
				$updateBilling['usertype'] = $session->get('user_data')->role;
				$updateBilling['user_id'] = $session->get('user_data')->ID;
			}
			
	if($error)
			{
				
				$return['success'] 		= "false";
				$return['message'] 		= $error;
				$return['error'] 		= $error;
				$return['data'] 		="";			
				
				return $this->respond($return);
			}
			
if($diffattende==1){
	$updateBillings=$updateBilling;
	$updateAttende 		= $postData['attendeinfo']; 
} else {
	$updateBillings=$updateBilling;
	unset($updateBilling['usertype']);
	$updateAttende 		= $updateBilling; 
}	

			
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
			$data['event_order'] = $unique_number;
			$session = \Config\Services::session();
			$session->set($data);
			
			
			if($update)
			{
				$return['success'] 		= "true";
				$return['message'] 		= "Attende Info Saved.";
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
		
		public function paypalpayment() 
		{
			
		 
			$session = \Config\Services::session();
			
			if($_REQUEST['txn_id'])
			{
				
				
				$paymentinfo = array(
				  'event_id' => $_REQUEST['item_number'],
				 'payment_type' => $_REQUEST['actual_payment_type'],
				  'gateway' => $_REQUEST['actual_gateway'],
				  'amount' => (float)$_REQUEST['mc_gross'],
				  'min_deposit' => $_REQUEST['deposite_cost'],
				  'cost' => $_REQUEST['actual_cost'],
				  'payment_status' => $_REQUEST['payment_status'],
				  'transaction_id' => $_REQUEST['txn_id'],
				   'unique_event_order' =>$_REQUEST['order_id']
				
				); 
				
				
				if($this->save_user_info($_REQUEST, $paymentinfo))
				{
					$data = array(
					'paymentinfo'=> $paymentinfo,
					'order_id' => $update
					);
					$session->set($data);
					$sessions = $session->get();
							
					
					return redirect()->to(base_url('agreements/'.$_GET['event_slug'].'/'.$_REQUEST['order_id']));
				}
				else
				{
					return redirect()->to(base_url('payment/'.$_GET['event_slug'].'/'.$_REQUEST['order_id']));
				} 
				
			} else {
				$session->setFlashdata('error', 'Transaction Failed. Try again!');
						
				return redirect()->to(base_url('payment/'.$_GET['event_slug'].'/'.$_REQUEST['order_id']));
			}
		}
		
		
		public function dopayment() 
		{
		
			helper('form');
			$postData = json_decode(file_get_contents('php://input'), true);
			if($postData == '')
			{
				$postData = $_POST;
				
				
			}
			if($postData['paymentinfo']['payment_type'] == "mindeposit") {
				$eventcost = $postData['paymentinfo']['min_deposit'];
			}else{
				if($postData['paymentinfo']['cost']){
					$eventcost = $postData['paymentinfo']['cost'];
				} else {
					$eventcost = 0;
				}
				
			}
			
			$paymentinfo = array(
				  'event_id' => $postData['paymentinfo']['event_id'],
				 'payment_type' => $postData['paymentinfo']['payment_type'],
				  'gateway' => $postData['paymentinfo']['gateway'],
				  'amount' => $eventcost,
				  'min_deposit' => !empty($postData['paymentinfo']['min_deposit']) ? $postData['paymentinfo']['min_deposit'] : 0,
				  'cost' => !empty($postData['paymentinfo']['cost']) ? $postData['paymentinfo']['cost'] : 0,
				  'payment_status' => 'Completed',
				  'unique_event_order' => $postData['paymentinfo']['order_id']
				
				); 
		
			
			if($this->save_user_info($postData['paymentinfo'], $paymentinfo))
			{
				$session = \Config\Services::session();
				$data = array(
					'paymentinfo'=> $paymentinfo,
					'order_id' => $update
					);
					$session->set($data);
					$sessions = $session->get();	
				$return['success'] 		= "true";
				$return['message'] 		= "Payment Successfully done.";
				$return['error'] 		= "";
				$return['data'] 		= $sessions;			
				
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
		
		public function agreement() 
		{
			
			helper('form');
			$postData = json_decode(file_get_contents('php://input'), true);
			if($postData == '')
			{
				$postData = $_POST;
				
			}
			if($postData['agreementinfo']['event_agreed'] != 1){			
			$error['agreement']['event_agreed_error'] ='The Event Agreement field is required.';
 }
if($postData['agreementinfo']['financial_agreed'] != 1){			
			$error['agreement']['financial_agreed_error'] ='The Financial Agreement field is required.';
}

if($postData['agreementinfo']['copyright_agreed'] != 1){			
			$error['agreement']['copyright_agreed_error'] ='The Copyright Agreement field is required.';
 }
 
	if($error)
			{
				
				$return['success'] 		= "false";
				$return['message'] 		= $error;
				$return['error'] 		= $error;
				$return['data'] 		="";			
				
				return $this->respond($return);
			}
			
	        $model = new CheckoutModel();
			$orderdata = $model->get_order_by_unique_id($postData['agreementinfo']['order_id']);
			
			
			$agreementinfo = array(
			  'event_id' => $orderdata->event_id,
			  'user_id' => $orderdata->user_id,
			  'event_agreed' => $postData['agreementinfo']['event_agreed'],
			  'financial_agreed' => $postData['agreementinfo']['financial_agreed'],
			  'copyright_agreed' => $postData['agreementinfo']['copyright_agreed'],
			
			);
		
			//echo "<pre>";print_r($agreementinfo);exit;
			$agreementdetail = $model->saveData('li_agreements', $agreementinfo);
			
			$order_data = array(
			 'agreement_id' => $agreementdetail,
			 
			); 
			
			$order = $model->updateOrder('li_event_orders', $order_data, $orderdata->event_order_id);
			
			if($order)
			{
				$return['success'] 		= "true";
				$return['message'] 		= "Agreement Agreed.";
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
		
		
		public function healthinfo() 
		{
			
			helper('validation');
			$postData = json_decode(file_get_contents('php://input'), true);
			if($postData == '')
			{
				$postData = $_POST;
				
			}
			
	        $model = new CheckoutModel();
			$orderdata = $model->get_order_by_unique_id($postData['healthinfo']['order_id']);
			
			 $validation_errors['health'] = validate_healthinfo_data($postData['healthinfo']);
			 
			  if(!empty($validation_errors['health'])) {
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
		
		public function finalcheckout() 
		{
			
			helper('form');
			$postData = json_decode(file_get_contents('php://input'), true);
			if($postData == '')
			{
				$postData = $_POST;
				
			}
			
			if($postData['notificationinfo']['notification_check'] != 1){			
			$error['notificationinfo']['notification_check_error'] ='Please check the checkbox!';
			}

 
		if($error)
			{
				
				$return['success'] 		= "false";
				$return['message'] 		= $error;
				$return['error'] 		= $error;
				$return['data'] 		="";			
				
				return $this->respond($return);
			}
			 $session = \Config\Services::session();
			
	       

			
			
			$model = new CheckoutModel();
			$orderdata = $model->get_order_by_unique_id($postData['notificationinfo']['order_id']);
			
			
			
			$notificationdata = array(
			'notification_check'=> $postData['notificationinfo']['notification_check']
			);
			$notificationdetail = $model->saveData('li_notification_info', $notificationdata);
			
			 $order_data = array(
			 
			 'notification_info_id' =>  $notificationdetail,
			 
			 
			); 
			$order = $model->updateOrder('li_event_orders', $order_data, $orderdata->event_order_id);
			if($order)
			{
				$session = \Config\Services::session();
			
				$update= $session->get();
				$return['success'] 		= "true";
				$return['message'] 		= "You have Ordered event successfully.";
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
		
		
		
		public function getAllSessiondata() 
		{
			
			$session = \Config\Services::session();
			
			$Alldata= $session->get();
			
			//echo "<pre>";print_r($Alldata);exit;
			//$security = \Config\Services::security();
			//$model = new PagesModel();
			//$Alldata    = $model->getAlldata();
			if($Alldata)
			{
				$return['success'] 		= "true";
				$return['message'] 		= "Get All Page list.";
				$return['data'] 		= $Alldata;	
				$return['error'] 		= $this->error;
				
				return $this->respond($return);
			}
			
			else
			{
				$return['success'] 		= "false";
				$return['message'] 		= "All Page Details not found.";
				$return['error'] 		= "";
				$return['data'] 		= "";			
				
				return $this->respond($return);
			}	
		}
	//--------------------------------------------------------------------
	
	public function checkPaymentPlan() {
		$postData = json_decode(file_get_contents('php://input'), true);
			if($postData == '')
			{
				$postData = $_POST;
				
				
			}
		
		 $model = new PagesModel();
		$AllSettings    = $model->get_payment_plan_settings();
	
		$eventmodel = new EventModel();
		$eventdetail    = $eventmodel->getDetail($postData['event_id']);
		$now = date_create(date('Y-m-d'));
		$start_date = date_create($eventdetail->start_date);
        $diff=date_diff($start_date,$now);
		$payment_plan = 0;
		$event_cost = $eventdetail->cost;
        if(!empty($event_cost)) { 
		if($AllSettings->time_period == "monthly") {
			$total_payment = $diff->m + 1;
           if($AllSettings->payment_division > $total_payment) {
			   $payment_plan = 0;
			} else {
			   $payment_plan = 1;
			   $event_cost = $event_cost/$AllSettings->payment_division;
			}
		} else if($AllSettings->time_period == "weekly") {
			$total_payment = floor($diff->days/7) + 1;
			if($AllSettings->payment_division > $total_payment) {
			   $payment_plan = 0;
			} else {
			   $payment_plan = 1;
			    $event_cost = $event_cost/$AllSettings->payment_division;
			}
		} else if($AllSettings->time_period == "days") {
			$total_payment = $diff->days + 1;
			
			if($AllSettings->payment_division > $total_payment) {
			   $payment_plan = 0;
			} else {
			   $payment_plan = 1;
			    $event_cost = $event_cost/$AllSettings->payment_division;
			}
		}
			$return['success'] 		= "true";
			$return['message'] 		= "Get payment plan check.";
			$return['data'] 		= $payment_plan;	
			$return['payment_plan_cost'] 		= round($event_cost, 2);	
			$return['error'] 		= '';
			return $this->respond($return);
		} else {
				$return['success'] 		= "false";
				$return['message'] 		= "No Payment Plan";
				$return['data'] 		= "";	
				$return['payment_plan_cost'] 		= "";	
				$return['error'] 		= '';
				return $this->respond($return);
		}
		
	}
	
	public function subscription_payment() 
		{
			$session = \Config\Services::session();
			//echo "<pre>";print_r($_REQUEST);exit;
			if($_REQUEST['tx'])
			{
				$customdata = explode('-', $_REQUEST['cm']);
				$paymentinfo = array(
					'event_id' => $_REQUEST['item_number'],
					 'payment_type' => $customdata[1],
					  'gateway' => $customdata[2],
					  'amount' => (float)$_REQUEST['amt'],
					  'min_deposit' => (float)$_REQUEST['amt'],
					  'cost' => $customdata[3],
					  'payment_status' => $_REQUEST['st'],
					  'transaction_id' => $_REQUEST['tx'],
					  'unique_event_order' => $customdata[4]
				   );
				 
				if($this->save_user_info($_REQUEST, $paymentinfo))
				{
					
					$data = array(
					'paymentinfo'=> $paymentinfo,
					'order_id' => $update
					);
					$session->set($data);
					$sessions = $session->get();
					
					return redirect()->to(base_url('agreements/'.$_REQUEST['event_slug'].'/'.$_REQUEST['order_id']));
				}
				else
				{
					return redirect()->to(base_url('payment/'.$_REQUEST['event_slug'].'/'.$_REQUEST['order_id']));
				} 
				
			} else {
				$session->setFlashdata('error', 'Transaction Failed. Try again!');
						
				return redirect()->to(base_url('payment/'.$_REQUEST['event_slug'].'/'.$_REQUEST['order_id']));
			}
		}
	
	public function notify_subscription_payment() {
		 
			 
			// Retrieve transaction data from PayPal 
			 $session = \Config\Services::session();
			 $model = new CheckoutModel();
			
			$postdata = $_POST;
		 
			if(!empty($postdata['txn_id'])){ 
			    
				$paymentdata = $model->get_payment_by_txn_id($postdata['txn_id']);
				 $billinginfo = array(
				"txn_id" => $_POST['txn_id'],
				  "data" => serialize($_POST),
				"session_data" => "new plan"
				  
				);
				
				$model = new CheckoutModel();
				
				$billingdetail = $model->saveData('li_temp', $billinginfo);
				if(empty($paymentdata)) {
					$info = explode('-', $postdata['custom']);
				   $paymentinfo = array(
					'event_id' => $postdata['item_number'],
					 'payment_type' => $info[1],
					  'gateway' => $info[2],
					  'amount' => (float)$postdata['mc_gross'],
					  'min_deposit' => (float)$postdata['mc_gross'],
					  'cost' => $info[3],
					  'payment_status' => $postdata['payment_status'],
					  'transaction_id' => $postdata['txn_id'],
					  'unique_event_order' => $info[4]
				   );
				   
				   $paymentdetail = $model->saveData('li_payment', $paymentinfo);
				   $order_data = $model->get_order_by_unique_id($info[4]);
					if(!empty($order_data)) {
						$payment_ids = unserialize($order_data->payment_id);
						$paid_amt = $order_data->paid_amount + (float)$postdata['mc_gross'];
						array_push($payment_ids, $paymentdetail);
						$data = array('payment_id' => serialize($payment_ids), 'paid_amount' => $paid_amt);
						$model->updateOrder('li_event_orders', $data, $order_data->event_order_id);
					}
				   
				}
				
				die;
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
			
		/* 	$savedbillingdetail = $usermodel->get_user_billing_detail($user_id);
			if(empty($savedbillingdetail)) {
				
			} else {
				$model->updateData('li_billing_info', $billinginfo, $savedbillingdetail->id);
				$billingdetail =  $savedbillingdetail->id
			}
			
			$savedattendeedetail = $usermodel->get_user_attendee_detail($user_id);
			
			if(empty($savedattendeedetail)) {
				$attendedetail = $model->saveData('li_attende_info', $attendeinfo);
			} else {
				$model->updateData('li_attende_info', $attendeinfo, $savedattendeedetail->id);
				$billingdetail =  $savedattendeedetail->id
			} */
			
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
	
	public function validate_payment_user() 
	{
		helper('form');
			$postData = json_decode(file_get_contents('php://input'), true);
			if($postData == '')
			{
				$postData = $_POST;
				
				
			}
		$session = \Config\Services::session();
		$model = new CheckoutModel();
		$orderdata = $model->get_order_by_unique_id($postData['order_id']);
		 if(!empty($orderdata)) {
			if(!$session->get('is_logged_in')){
				$user_id = $session->get('user_id');
				
				if($orderdata->user_id != $user_id) {
					$return['success'] 		= "true";
					$return['message'] 		=  "No Order data found";
					$return['error'] 		= "";
					$return['redirect_url'] = "home";			
					
					return $this->respond($return);
				}
			} else {
				
				if($orderdata->user_id == $session->get('user_data')->ID){
					if(empty($orderdata->agreement_id)){
						$return['success'] 		= "true";
						$return['message'] 		=  "No Order data found";
						$return['error'] 		= "";
						$return['redirect_url'] = "agreements/".$postData['event_slug'].'/'.$postData['order_id'];			
						
						return $this->respond($return);
					} else if(empty($orderdata->healthinfo_id)){
						$return['success'] 		= "true";
						$return['message'] 		=  "No Order data found";
						$return['error'] 		= "";
						$return['redirect_url'] = "healthinfo/".$postData['event_slug'].'/'.$postData['order_id'];			
						
						return $this->respond($return);
						
						
					} else if(empty($orderdata->notification_info_id)) {
						$return['success'] 		= "true";
						$return['message'] 		=  "No Order data found";
						$return['error'] 		= "";
						$return['redirect_url'] = "notifications/".$postData['event_slug'].'/'.$postData['order_id'];			
						
						return $this->respond($return);
					} else {
						$return['success'] 		= "true";
						$return['message'] 		=  "Validate user";
						$return['error'] 		= "";
						$return['redirect_url'] = "home";			
						
						return $this->respond($return);
					}
					
				} else {
					$return['success'] 		= "true";
					$return['message'] 		=  "Validate user";
					$return['error'] 		= "";
					$return['redirect_url'] = "home";			
					
					return $this->respond($return);
				}
			}
			   
		} else {
			  $tempdata = $model->get_tempcheckout_data($postData['order_id']);
				if(!empty($tempdata->data)) {
					$billingdata = unserialize($tempdata->data);
					if($billingdata['billinginfo']['ID'] != $session->get('user_data')->ID) {
						
						$return['success'] 		= "true";
						$return['message'] 		=  "No Order data found";
						$return['error'] 		= "";
						$return['redirect_url'] = "home";			
						
						return $this->respond($return);
					} else {
						$return['success'] 		= "true";
						$return['message'] 		=  "No Order data found";
						$return['error'] 		= "";
						$return['redirect_url'] = "payment/".$postData['event_slug'].'/'.$postData['order_id'];			
						
						return $this->respond($return);
					}
					
					
				} else {
					$return['success'] 		= "true";
					$return['message'] 		=  "No Order data found";
					$return['error'] 		= "";
					$return['redirect_url'] = "home";			
					
					return $this->respond($return);
					
				}
		}
				$return['success'] 		= "false";
				$return['message'] 		=  "Validate user";
				$return['error'] 		= "";
				$return['redirect_url'] = "home";			
				
				return $this->respond($return);
		
		
		
		
	}
	
	public function depositepayment() {
		$postData = json_decode(file_get_contents('php://input'), true);
		if($postData == '')
		{
			$postData = $_POST;
			
			
		}
		
		$model = new CheckoutModel();
		$paymentinfo = array(
			  'event_id' => $postData['paymentinfo']['event_id'],
			 'payment_type' => $postData['paymentinfo']['paymentdata']['payment_type'],
			  'gateway' => $postData['paymentinfo']['paymentdata']['gateway'],
			  'amount' => $postData['paymentinfo']['depositeamount'],
			  'min_deposit' => $postData['paymentinfo']['depositeamount'],
			  'cost' => $postData['paymentinfo']['cost'] - $postData['paymentinfo']['paid_amount'],
			  'payment_status' => 'Completed',
			  'unique_event_order' => $postData['paymentinfo']['unique_event_order']
			
			); 
			
		$paymentids = unserialize($postData['paymentinfo']['payment_id']);	
		
		$paymentdetail = $model->saveData('li_payment', $paymentinfo);
		array_push($paymentids, $paymentdetail);
		$order_data = array(
		'payment_id' => serialize($paymentids),
		'paid_amount' => $postData['paymentinfo']['paid_amount'] + $postData['paymentinfo']['depositeamount']
		);
		
		$update = $model->updateOrder('li_event_orders',$order_data, $postData['paymentinfo']['event_order_id']);
		
		if(($postData['paymentinfo']['cost'] == $order_data['paid_amount']) && empty($postData['paymentinfo']['agreement_id'])) {
		
			$is_agreement = "agreement";
		} else if(($postData['paymentinfo']['cost'] == $order_data['paid_amount']) && empty($postData['paymentinfo']['healthinfo_id'])) {
		
			$is_agreement = "healthinfo";
		} else if(($postData['paymentinfo']['cost'] == $order_data['paid_amount']) && empty($postData['paymentinfo']['notification_info_id'])) {
		
			$is_agreement = "notificationinfo";
		} else {
			
			$is_agreement = 0;
		}
		
		
		if($update) {
				$return['success'] 		= "true";
				$return['message'] 		= "Payment Successfully done.";
				$return['error'] 		= "";
				$return['data'] 		= $is_agreement;			
				
				return $this->respond($return);
		} else {
				$return['success'] 		= "false";
				$return['message'] 		= "Something went wrong.";
				$return['error'] 		= "";
				$return['data'] 		= "";			
				return $this->respond($return);
			
		}
		
	}
	
	public function depositepaypalpayment() {
		
		
		if($_REQUEST['txn_id'])
			{
				$model = new EventModel();
				$event_order =	$model->get_event_order_by_order_id($_REQUEST['item_number']);
				$paymentids = unserialize($event_order->payment_id);
				$paymentinfo = array(
				  'event_id' => $_REQUEST['item_number'],
				 'payment_type' => 'mindeposit',
				  'gateway' => 'pay',
				  'amount' => (float)$_REQUEST['mc_gross'],
				  'min_deposit' => (float)$_REQUEST['mc_gross'],
				  'cost' => $event_order->cost - $event_order->paid_amount,
				  'payment_status' => $_REQUEST['payment_status'],
				  'transaction_id' => $_REQUEST['txn_id'],
				   'unique_event_order' =>$event_order->unique_event_order
				
				); 
				$cmodel = new CheckoutModel();
				$paymentdetail = $cmodel->saveData('li_payment', $paymentinfo);
				array_push($paymentids, $paymentdetail);
				$order_data = array(
					'payment_id' => serialize($paymentids),
					'paid_amount' => $event_order->paid_amount + (float)$_REQUEST['mc_gross']
				);
					
				$update = $cmodel->updateOrder('li_event_orders',$order_data, $event_order->event_order_id);
					
				if($update)
				{
					
					
				    if(($event_order->cost == $order_data['paid_amount']) && empty($event_order->agreement_id)) {
						return redirect()->to(base_url('agreements/'.$_REQUEST['event_slug'].'/'.$event_order->unique_event_order));
						
					} else if(($event_order->cost == $order_data['paid_amount']) && empty($event_order->agreement_id)){
						
						return redirect()->to(base_url('healthinfo/'.$_REQUEST['event_slug'].'/'.$event_order->unique_event_order));
						
					}else if(($event_order->cost == $order_data['paid_amount']) && empty($event_order->agreement_id)) {
						
						return redirect()->to(base_url('notifications/'.$_REQUEST['event_slug'].'/'.$event_order->unique_event_order));
						
					}else {
						return redirect()->to(base_url('myprofile/event'));
					} 
				}
				else
				{
					return redirect()->to(base_url('depositepay/'.$_REQUEST['order_id']));
				} 
				
			} else {
				$session->setFlashdata('error', 'Transaction Failed. Try again!');
						
				return redirect()->to(base_url('depositepay/'.$_REQUEST['order_id']));
			}
		
		
	}
	
	 
	
	
	
	
}
