<?php namespace App\Controllers\APi;
use App\Models\RosterModel;
use App\Models\UserModel;
use App\Models\EventModel;
use App\Models\SkillModel;

use CodeIgniter\RESTful\ResourceController;

class Roster extends ResourceController
{ 

    

    public function __construct()
    {
        helper(['cookie','common']);
		
    }


   
		
		 public function getAlladmindata() 
		{ 
		$postData = json_decode( file_get_contents('php://input'),true);
			
			$model = new RosterModel();
			$Alldata    = $model->getAlladmindata($postData['event_id']);
			foreach($Alldata as $key=>$data) {
				$paymentids = unserialize($data->payment_id);
				if(!empty($paymentids)) {
			    $paymentdata = $model->get_payment_by_payment_id(end($paymentids));
				$Alldata[$key]->payment_status = $paymentdata->payment_status;
				}
				
			}
			//echo "<pre>";print_r($Alldata);exit;exit;
			if($Alldata)
			{
				$return['success'] 		= "true";
				$return['message'] 		= "Get All Roaster list.";
				$return['data'] 		= $Alldata;	
				$return['error'] 		= $this->error;
				
				return $this->respond($return);
			}
			
			else
			{
				$return['success'] 		= "false";
				$return['message'] 		= "not found.";
				$return['error'] 		= "";
				$return['data'] 		= "";			
				
				return $this->respond($return);
			}	
		}
		
		public function getEventOrderDetail() {
			$postData = json_decode( file_get_contents('php://input'),true);
			$id = $postData['id'];
			$model = new RosterModel();
			$Alldata    = $model->get_event_order_by_order_id($id);
			$timperiods = array('weekly' => "Weekly", "monthly" => "Monthly", "days" => "Daywise");
			if(!empty($Alldata->payment_plan_time_period)) {
				foreach($timperiods as $key=>$time) {
					if($key == $Alldata->payment_plan_time_period) {
						$Alldata->payment_plan_time_period = $time;
					}
				}
			}
			$Alldata->currency =  get_currency();
			if($Alldata)
			{
				$return['success'] 		= "true";
				$return['message'] 		= "Event Order Data";
				$return['data'] 		= $Alldata;	
				$return['error'] 		= $this->error;
				
				return $this->respond($return);
			}
			
			else
			{
				$return['success'] 		= "false";
				$return['message'] 		= "not found.";
				$return['error'] 		= "";
				$return['data'] 		= "";			
				
				return $this->respond($return);
			}	
		}
		
		public function getrosterinfo(){
			$postData = json_decode( file_get_contents('php://input'),true);
			$id = $postData['id'];
			$model = new RosterModel();
			$table = $postData['table'];
			$joincolumn = $postData['joincolumn'];
			if($postData['table'] == "li_payment") {
				$data    = $model->get_event_order_by_order_id($id);
				$paymentids = unserialize($data->payment_id);
				
				$Alldata = array();
				foreach($paymentids as $key=>$paymentid) {
					$Alldata[$key] = $model->get_payment_by_payment_id($paymentid);
					$date = date_create($Alldata[$key]->payment_date);
					$Alldata[$key]->payment_date = date_format($date,"d M Y h:i a");
					$Alldata[$key]->currency =  get_currency();
				}
			    
				
			} else {
				$Alldata    = $model->get_roaster_info_by_order_id($table, $joincolumn, $id);
				
			}
			
			
			if($Alldata)
			{
				$return['success'] 		= "true";
				$return['message'] 		= "Get All Roaster info.";
				$return['data'] 		= $Alldata;	
				$return['error'] 		= $this->error;
				
				return $this->respond($return);
			}
			
			else
			{
				$return['success'] 		= "false";
				$return['message'] 		= "not found.";
				$return['error'] 		= "";
				$return['data'] 		= "";			
				
				return $this->respond($return);
			}	
			
		}
		
		public function getrosterhealthinfo(){
			$postData = json_decode( file_get_contents('php://input'),true);
			$id = $postData['id'];
			$model = new RosterModel();
			$decryptdata = array();
			$healthinfo    = $model->get_roaster_info_by_order_id('li_health_info', 'healthinfo_id', $id);
			
			if($healthinfo) {
				 $decryptdata  = array(
			  'user_id' => isset($healthinfo->user_id) ? $healthinfo->user_id : null,
			 
			  'full_name' => isset($healthinfo->full_name) ? decrypt($healthinfo->full_name) : null,
			  'birth_date' => isset($healthinfo->birth_date) ? decrypt($healthinfo->birth_date) : null,
			  'address_1' => isset($healthinfo->address_1) ? decrypt($healthinfo->address_1) : null,
			 'address_2' => isset($healthinfo->address_2) ? decrypt($healthinfo->address_2) : null,
			  'city' => isset($healthinfo->city) ? decrypt($healthinfo->city) : null,
			  'state' => isset($healthinfo->state) ? decrypt($healthinfo->state) : null,
			   'zipcode' => isset($healthinfo->zipcode) ? decrypt($healthinfo->zipcode) : null,
			  'em_contactname' => isset($healthinfo->em_contactname) ? decrypt($healthinfo->em_contactname) : null,
			 'em_contactaddress' => isset($healthinfo->em_contactaddress) ? decrypt($healthinfo->em_contactaddress) : null,
			  'em_relation_withyou' => isset($healthinfo->em_relation_withyou) ? $healthinfo->em_relation_withyou : null,
			  'em_phone_number' => isset($healthinfo->em_phone_number) ? decrypt($healthinfo->em_phone_number) : null,
			    'health_insure_company' => isset($healthinfo->health_insure_company) ? $healthinfo->health_insure_company : null,
			  'health_insure_phone' => isset($healthinfo->health_insure_phone) ? $healthinfo->health_insure_phone : null,
			  'insure_primary_holder' => isset($healthinfo->insure_primary_holder) ? $healthinfo->insure_primary_holder : null,
			 'insure_group_number' => isset($healthinfo->insure_group_number) ? decrypt($healthinfo->insure_group_number) : null,
			  'insure_idnumber' => isset($healthinfo->insure_idnumber) ? decrypt($healthinfo->insure_idnumber) : null,
			  'primary_physician' => isset($healthinfo->primary_physician) ? $healthinfo->primary_physician : null,
			   'physician_address' => isset($healthinfo->physician_address) ? $healthinfo->physician_address : null,
			   'physician_phone' => isset($healthinfo->physician_phone) ? $healthinfo->physician_phone : null,
			  'list_all_medications' => isset($healthinfo->list_all_medications) ? decrypt($healthinfo->list_all_medications) : null,
			 'list_any_psychiatric' => isset($healthinfo->list_any_psychiatric) ? decrypt($healthinfo->list_any_psychiatric) : null,
			  'list_any_orthopedic' => isset($healthinfo->list_any_orthopedic) ? decrypt($healthinfo->list_any_orthopedic) : null,
			  'your_personal_safety' => isset($healthinfo->your_personal_safety) ? decrypt($healthinfo->your_personal_safety) : null,
			   'suffer_from_hiv' => isset($healthinfo->suffer_from_hiv) ? decrypt($healthinfo->suffer_from_hiv) : null,
			  'addicted_to_alcohol' => isset($healthinfo->addicted_to_alcohol) ? decrypt($healthinfo->addicted_to_alcohol) : null,
			  'otc_medications' => isset($healthinfo->otc_medications) ? decrypt($healthinfo->otc_medications) : null,
			   'other_contact_allergies' => isset($healthinfo->other_contact_allergies) ? decrypt($healthinfo->other_contact_allergies) : null,
			  'allergic_to_striped' => isset($healthinfo->allergic_to_striped) ? decrypt($healthinfo->allergic_to_striped) : null,
			 'list_food_allergies' => isset($healthinfo->list_food_allergies) ? $healthinfo->list_food_allergies : null,
			  'allow_staffmedic_review' => isset($healthinfo->allow_staffmedic_review) ? $healthinfo->allow_staffmedic_review : null,
			  'signature' => isset($healthinfo->signature) ? $healthinfo->signature : null,
			  'signature_date' => isset($healthinfo->signature_date) ? $healthinfo->signature_date : null,
			 
			);
			}
			
			
			if($decryptdata)
			{
				$return['success'] 		= "true";
				$return['message'] 		= "Get All Roaster info.";
				$return['data'] 		= $decryptdata ;	
				$return['error'] 		= $this->error;
				
				return $this->respond($return);
			}
			
			else
			{
				$return['success'] 		= "false";
				$return['message'] 		= "not found.";
				$return['error'] 		= "";
				$return['data'] 		= "";			
				
				return $this->respond($return);
			}	
			
		}
		
		function send_notification_mail() {
			$postdata = json_decode( file_get_contents('php://input'),true);
			
			if(!empty($postdata['event_order_id'])) {
				$model = new RosterModel();
				$eventmodel = new EventModel();
				$Alldata    = $model->get_event_order_by_order_id($postdata['event_order_id']);
				
				
				if(!empty($Alldata)) {
					$event_data = $eventmodel->getDetail($Alldata->event_id);
					
					if(!empty($Alldata->user_id)) {
						$usermodel = new UserModel();
						$userdata    = $usermodel->getuserDetail($Alldata->user_id);
						
						$to_email = $userdata->email;
					} else {
						$billingdata    = $model->get_roaster_info_by_order_id('li_billing_info','billing_id',$postdata['event_order_id']);
						$to_email = $billingdata->email;
					}
					$view = \Config\Services::renderer();
					 $maildata = array(
					   "to" => $to_email,
					   "subject" => "Pay owed amount for the event ".$event_data->typenametitle." ".date_format(date_create($event_data->start_date),'d/m/Y'),
					  "message" => $view->render('email/payment_notification')
					);
					if(send_mail($maildata)) {
						
						$return['success'] 		= "true";
						$return['message'] 		= "Send Email Successfully";
						$return['error'] 		= "";
						$return['data'] 		= "";			
						
						return $this->respond($return);
						
					} else {
						$return['success'] 		= "false";
						$return['message'] 		= "Something went wrong.Please try again!";
						$return['error'] 		= "";
						$return['data'] 		= "";			
						
						return $this->respond($return);
					}
					 
					
				}else {
					$return['success'] 		= "false";
					$return['message'] 		= "Invalid data";
					$return['error'] 		= "";
					$return['data'] 		= "";			
					
					return $this->respond($return);
				}
				
			}
			
			
		}
		
		public function delete_roster(){
			$postData = json_decode(file_get_contents('php://input'), true);
			if($postData == '')
			{
				$postData = $_POST;
				
				
			}
			
			$roster_id = $postData['event_order_id'];
			$model = new RosterModel();
			$order_data = $model->get_event_order_by_order_id($roster_id);
			$update = $model->deleteRoster($roster_id);
			if($update)
			{
				if(!empty($order_data->agreement_id)) {
					$model->delete_roster_detail_by_id('li_agreements', $order_data->agreement_id);
				}
				if(!empty($order_data->billing_id)) {
					$model->delete_roster_detail_by_id('li_billing_info', $order_data->billing_id);
				}
				if(!empty($order_data->attende_id)) {
					$model->delete_roster_detail_by_id('li_attende_info', $order_data->billing_id);
				}
				if(!empty($order_data->payment_id)) {
					$paymentids = unserialize($order_data->payment_id);
					foreach($paymentids as $paymentid) {
						$model->delete_roster_detail_by_id('li_payment', $paymentid);
					}
					
				}
				if(!empty($order_data->healthinfo_id)) {
					$model->delete_roster_detail_by_id('li_health_info', $order_data->healthinfo_id);
				}
				if(!empty($order_data->notification_info_id)) {
					$model->delete_roster_detail_by_id('li_notification_info', $order_data->notification_info_id, 'li_notification_info');
				}
				$return['success'] 		= "true";
				$return['message'] 		= "Roster successfully deleted.";
				$return['error'] 		= "";
				$return['data'] 		= "";			
				
				return $this->respond($return);
			}
			else
			{
				
				$return['success'] 		= "false";
				$return['message'] 		= "Roster is not delete. Something went wrong.";
				$return['error'] 		= "";
				$return['data'] 		= "";			
				return $this->respond($return);
			}
		}
		
		public function complete_roster() {
				$postData = json_decode(file_get_contents('php://input'), true);
			if($postData == '')
			{
				$postData = $_POST;
				
				
			}
			
			if(!empty($postData['event_order_id'])) {
				$roster_ids = $postData['event_order_id'];
				
				$model = new RosterModel();
				$eventmodel = new EventModel();
				
				foreach($roster_ids as $roster_id) {
					$order_data = $model->get_event_order_by_order_id($roster_id);
					$update = $model->complete_roster($roster_id);
					if($update) {
						$eventdetail = $eventmodel->getDetail($order_data->event_id);
						
						if(!empty($eventdetail->skill_earned)) {
							$skilldata = array(
							'user_id' 	=> $order_data->user_id,
							'skill_id' 		=> $eventdetail->skill_earned
							);
							$skillmodel = new SkillModel();
							$skillmodel->add_skills_to_user($skilldata);
						}
						
					}
				}
				
			
					$return['success'] 		= "true";
					$return['message'] 		= "Roster successfully completed.";
					$return['error'] 		= "";
					$return['data'] 		= "";			
					
					return $this->respond($return);
				
			} else {
				$return['success'] 		= "false";
				$return['message'] 		= "Please select roster to complete";
				$return['error'] 		= "";
				$return['data'] 		= "";			
				return $this->respond($return);
			}
			
		}
		
		

}
