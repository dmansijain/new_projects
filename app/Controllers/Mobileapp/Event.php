<?php namespace App\Controllers\Mobileapp;

use App\Models\UserModel;
use App\Models\EventModel;
use App\Models\PagesModel;
use App\Models\SkillModel;
use CodeIgniter\RESTful\ResourceController;
use App\Libraries\Liminaltokenlib;
//$session = \Config\Services::session();

class Event extends ResourceController
{ 

    

    public function __construct()
    {
        helper(['validation','common']);
		validate_header_key();
		
    }
	
	public function get_all_event() {
		
		$event_cat = isset($_GET['category']) ? $_GET['category'] : '';
		$event_type = isset($_GET['type']) ? $_GET['type'] : '';
		$orderby = isset($_GET['orderby']) ? $_GET['orderby'] : 'newest';
		$page = isset($_GET['per_page']) ? $_GET['per_page'] : 0;
		$limit =  EVENT_APP_LIMIT;
		$start = $page * $limit;
		$eventmodel = new EventModel();
		$events = $eventmodel->getAlldata($event_cat, $event_type, $orderby, $keyword="", $skill="", $start, $limit);
		$totalevents = $eventmodel->getAlldata($event_cat, $event_type, $orderby, $keyword="", $skill="");
		$total_page = ceil(count($totalevents)/$limit);
		foreach($events as $event) {
			$event->typenametitle = $event->typenametitle ? $event->typenametitle : $event->event_typename;
		}
			//echo "<pre>";print_r($events);exit;
		if($events) {
				    $return['success'] 		    = "true";
					$return['message'] 		= "Data Found";
					$return['page_count'] 	= $total_page;
					$return['error'] 		= "";
					$return['data'] 		= $events;			
					
					return $this->respond($return);
		} else {
			$return['success'] 		= "false";
			$return['message'] 		= "not found";
			$return['error'] 		= "";
			$return['data'] 		= "";			
			
			return $this->respond($return);
		}
		
	}
	
	public function event_detail($event_id) 
		{
			 $pagemodel = new PagesModel();
			$AllSettings    = $pagemodel->get_payment_plan_settings();
			
			$model = new EventModel();
			$eventdetail    = $model->getDetail($event_id);
			$eventdetail->typenametitle = $eventdetail->typenametitle ? $eventdetail->typenametitle : $eventdetail->event_typename;
			$now = date_create(date('Y-m-d'));
			$start_date = date_create($eventdetail->start_date);
			$diff=date_diff($start_date,$now);
			$payment_plan = 0;
			$event_cost = $eventdetail->cost;
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
			$eventdetail->payment_plan = $payment_plan;
			$eventdetail->payment_plan_cost = round($event_cost);
			if(!empty($event_id) && $eventdetail)
			{
				$return['success'] 		= "true";
				$return['message'] 		= "Data Found.";
				$return['data'] 		= $eventdetail;	
				$return['error'] 		= "";
				
				return $this->respond($return);
			}
			
			else
			{
				$return['success'] 		= "false";
				$return['message'] 		= "Details not found.";
				$return['error'] 		= "";
				$return['data'] 		= "";			
				
				return $this->respond($return);
			}	
		}
		
	public function get_user_past_event($user_id){
		
		$LiminaltokenlibObj 	= new Liminaltokenlib();
		//$LiminaltokenlibObj->validateToken();
		$page = isset($_GET['per_page']) ? $_GET['per_page'] : 0;
		
		$validate = validate_userId($user_id);
		 if(empty($validate))
            {
				$usermodel = new UserModel();
				$userdetail = $usermodel->getuserDetail($user_id);
				if(!empty($userdetail)) {
					$limit =  EVENT_APP_LIMIT;
					$start = $page * $limit;
					$model = new EventModel();
					$allpastevents = $model->get_user_past_events($user_id, $start, $limit);
					
					$totalpastevents = $model->get_user_past_events($user_id);
					
					$total_page = ceil(count($totalpastevents)/$limit);
					foreach($allpastevents as $event) {
						$event->typenametitle = $event->typenametitle ? $event->typenametitle : $event->event_typename;
					}
					//echo "<pre>";print_r($allupcomingevents);exit;
					if($allpastevents) {
							$return['success'] 		= "true";
							$return['message'] 		= "Get All Past Events.";
							$return['page_count'] 	= $total_page;
							$return['data'] 		= $allpastevents;	
							$return['error'] 		= "";
							
							return $this->respond($return);
					} else {
						$return['success'] 		= "false";
							$return['message'] 		= "Data not found";
							$return['data'] 		= "";	
							$return['error'] 		= "";
							
							return $this->respond($return);
					}
				} else {
					$return['success'] 		= "false";
					$return['message'] 		= "invalid user";
					$return['error'] 		= "";
					$return['data'] 		= "";			
					return $this->respond($return);
				}
				
				
			} else {
				$return['success'] 		= "false";
				$return['message'] 		= "invalid user";
				$return['error'] 		= "";
				$return['data'] 		= "";			
				return $this->respond($return);
				
			}
	}
	
	public function getallcategory() 
		{ 
			
			$model = new EventModel();
			$Alldata    = $model->getAlldataby('li_eventcategory');
			if($Alldata)
			{
				$return['success'] 		= "true";
				$return['message'] 		= "Get All Category list.";
				$return['data'] 		= $Alldata;	
				$return['error'] 		= $this->error;
				
				return $this->respond($return);
			}
			
			else
			{
				$return['success'] 		= "false";
				$return['message'] 		= "Category not found.";
				$return['error'] 		= $this->error;
				$return['data'] 		= $this->data;			
				
				return $this->respond($return);
			}	
		}
		
	public function getEventBycategory($cat_id) {
			$model = new EventModel();
			$Alldata    = $model->getAlldata($cat_id);
			
			if($Alldata)
			{
				$return['success'] 		= "true";
				$return['message'] 		= "Get All Event list.";
				$return['data'] 		= $Alldata;	
				$return['error'] 		= $this->error;
				
				return $this->respond($return);
			}
			
			else
			{
				$return['success'] 		= "false";
				$return['message'] 		= "All Event Details not found.";
				$return['error'] 		= "";
				$return['data'] 		= "";			
				
				return $this->respond($return);
			}	
	}
	
		public function getallEventtypeByCat($cat_id) 
		{ 
			
			$param= array('cat_id'=>$cat_id);
			$model = new EventModel();
			$Alldata    = $model->getAlldataby('li_eventtype', $param);
			
			if($Alldata)
			{
				$return['success'] 		= "true";
				$return['message'] 		= "Get All Type list.";
				$return['data'] 		= $Alldata;	
				$return['error'] 		= $this->error;
				
				return $this->respond($return);
			}
			
			else
			{
				$return['success'] 		= "false";
				$return['message'] 		= "Type not found.";
				$return['error'] 		= $this->error;
				$return['data'] 		= $this->data;			
				
				return $this->respond($return);
			}	
		}
	
		public function updatehealthinfo() 
		{
				

		$postData = json_decode(file_get_contents('php://input'), true);
			if($postData == '')
			{
				$postData = $_POST;
				
			}
			
		
			$user_id = $postData['user_id'];
			$validate = validate_userId($user_id);
		if(empty($validate)){	
			$usermodel = new UserModel();
			$userdetail = $usermodel->getuserDetail($user_id);
			if(!empty($userdetail)) { 
			
			 $validation_errors = validate_healthinfo_data($postData);
			 
			  if(!empty($validation_errors)) {
				 $return['success'] 		= "false";
				$return['message'] 		= $validation_errors;
				$return['error'] 		= $validation_errors;
				$return['data'] 		= "";			
				
				return $this->respond($return);
			 } 
			// echo "<pre>";print_r($postData);exit;
			
			 $updatearr = array(
			  
			 
			  'full_name' => isset($postData['full_name']) ? encrypt($postData['full_name']) : null,
			  'birth_date' => isset($postData['birth_date']) ? encrypt($postData['birth_date']) : null,
			  'address_1' => isset($postData['address_1']) ? encrypt($postData['address_1']) : null,
			 'address_2' => isset($postData['address_2']) ? encrypt($postData['address_2']) : null,
			  'city' => isset($postData['city']) ? encrypt($postData['city']) : null,
			  'state' => isset($postData['state']) ? encrypt($postData['state']) : null,
			   'zipcode' => isset($postData['zipcode']) ? encrypt($postData['zipcode']) : null,
			  'em_contactname' => isset($postData['em_contactname']) ? encrypt($postData['em_contactname']) : null,
			 'em_contactaddress' => isset($postData['em_contactaddress']) ? encrypt($postData['em_contactaddress']) : null,
			  'em_relation_withyou' => isset($postData['em_relation_withyou']) ? $postData['em_relation_withyou'] : null,
			  'em_phone_number' => isset($postData['em_phone_number']) ? encrypt($postData['em_phone_number']) : null,
			    'health_insure_company' => isset($postData['health_insure_company']) ? $postData['health_insure_company'] : null,
			  'health_insure_phone' => isset($postData['health_insure_phone']) ? $postData['health_insure_phone'] : null,
			  'insure_primary_holder' => isset($postData['insure_primary_holder']) ? $postData['insure_primary_holder'] : null,
			 'insure_group_number' => isset($postData['insure_group_number']) ? encrypt($postData['insure_group_number']) : null,
			  'insure_idnumber' => isset($postData['insure_idnumber']) ? encrypt($postData['insure_idnumber']) : null,
			  'primary_physician' => isset($postData['primary_physician']) ? $postData['primary_physician'] : null,
			   'physician_address' => isset($postData['physician_address']) ? $postData['physician_address'] : null,
			   'physician_phone' => isset($postData['physician_phone']) ? $postData['physician_phone'] : null,
			  'list_all_medications' => isset($postData['list_all_medications']) ? encrypt($postData['list_all_medications']) : null,
			 'list_any_psychiatric' => isset($postData['list_any_psychiatric']) ? encrypt($postData['list_any_psychiatric']) : null,
			  'list_any_orthopedic' => isset($postData['list_any_orthopedic']) ? encrypt($postData['list_any_orthopedic']) : null,
			  'your_personal_safety' => isset($postData['your_personal_safety']) ? encrypt($postData['your_personal_safety']) : null,
			   'suffer_from_hiv' => isset($postData['suffer_from_hiv']) ? encrypt($postData['suffer_from_hiv']) : null,
			  'addicted_to_alcohol' => isset($postData['addicted_to_alcohol']) ? encrypt($postData['addicted_to_alcohol']) : null,
			  'otc_medications' => isset($postData['otc_medications']) ? encrypt($postData['otc_medications']) : null,
			   'other_contact_allergies' => isset($postData['other_contact_allergies']) ? encrypt($postData['other_contact_allergies']) : null,
			  'allergic_to_striped' => isset($postData['allergic_to_striped']) ? encrypt($postData['allergic_to_striped']) : null,
			 'list_food_allergies' => isset($postData['list_food_allergies']) ? $postData['list_food_allergies'] : null,
			  'allow_staffmedic_review' => isset($postData['allow_staffmedic_review']) ? $postData['allow_staffmedic_review'] : null,
			  'signature' => isset($postData['signature']) ? $postData['signature'] : null,
			  'signature_date' => isset($postData['signature_date']) ? $postData['signature_date'] : null,
			 
			);
			
			$model = new UserModel();
			$healthinfo = $model->gethealthinfoDetail($user_id);
			
			if(!empty($healthinfo)) {
				$update = $model->updatehealthinfo($updatearr, $healthinfo->id);
			} else {
				$updatearr['user_id'] =  $user_id;
				$update = $model->savehealthinfo($updatearr);
			}
			
			if($update)
			{
				$return['success'] 		= "true";
				$return['message'] 		= "Healthinfo successfully updated/created.";
				$return['error'] 		= "";
				$return['data'] 		= "";			
				
				return $this->respond($return);
			}
			else
			{
				
				$return['success'] 		= "false";
				$return['message'] 		= "Profile is not update. Something went wrong.";
				$return['error'] 		= "";
				$return['data'] 		= "";			
				return $this->respond($return);
			}
			} else {
				$return['success'] 		= "false";
				$return['message'] 		= "Invalid User";
				$return['error'] 		= "";
				$return['data'] 		= "";			
				return $this->respond($return);
			}
		} else {
				$return['success'] 		= "false";
				$return['message'] 		= "Invalid User";
				$return['error'] 		= "";
				$return['data'] 		= "";			
				return $this->respond($return);
		}
	}
	
	public function gotocart(){
		$postData = json_decode( file_get_contents('php://input'),true);
		
			if( count($postData) == 0 )
		{
				$return['success'] 		= "false";
				$return['message'] 		= "Invalid data format";
				$return['data'] 		= "";	
				$return['error'] 		= "";
				
				//print_r($return); die;
				return $this->respond($return);
		} 
		
		$model = new EventModel();
		
			$_POST 			= $postData;
			$event_id = $postData['event_id'];
			$eventdetail    = $model->getDetail($event_id);
			if(!empty($event_id) && !empty($eventdetail)) {
			$skill_requirement = $eventdetail->skill_requirement;
			$session = \Config\Services::session();
		   
			
			//$Alluser    = $model->getDetail($event_id);
			if($skill_requirement==0){
				$successmessage =true;	
			}
			elseif($skill_requirement!=0 && empty($postData['user_id'])){
				$errormessage ="Please login to participate in this event.";
			}
			elseif($skill_requirement!=0 && !empty($postData['user_id'])){
				$condition=array('skill_id'=>$skill_requirement,'user_id'=>$postData['user_id']);
			$Alldata    = $model->getAlldataby('li_user_skills', $condition);	
			if(!$Alldata){
				$smodel = new SkillModel();
				$skilldata    = $smodel->getDetail($skill_requirement);
				 if(!empty($postData['category'])) {
					 $condition = array('t1.skill_earned'=>$skill_requirement,'t1.id !='=> $event_id,'t1.event_category' => $eventdetail->category);
				 } else {
					$condition = array('t1.skill_earned'=>$skill_requirement,'t1.id !='=> $event_id);
				 }
				$eventdata    = $model->getconcatEventtypename($condition);	
				$eventsname = "";
				foreach($eventdata as $key=>$event) {
					if($key == 0) {
						$eventsname = '<a href="'.base_url('eventdetail/'.str_replace(" ","-",$eventdetail->title).'-'.$eventdetail->id).'">'.$eventdetail->event_name.'</a>';
					} else {
						$eventsname .= ', <a href="'.base_url('eventdetail/'.str_replace(" ","-",$eventdetail->title).'-'.$eventdetail->id).'">'.$eventdetail->event_name.'</a>';
					}
				}
				
				//echo "<pre>";print_r($eventdata);exit;			
				$errormessage = "In order to attend this event you need to have the following pre-requisites:  ".$skilldata->name;
				if(!empty($eventsname)) {
					$errormessage = $errormessage."<br>Here are some upcoming events that you can attend to achieve this: ".$eventsname;
				}

			} else {
				$successmessage = true;
			}
			} else {
				$errormessage = "Something went wrong";	
			}
			
			
			if($successmessage)
			{
				$return['success'] 		= "true";
				$return['message'] 		= "";
				$return['data'] 		= $Alldata;	
				$return['error'] 		= $this->error;
				
				return $this->respond($return);
			}
			
			else
			{
				$return['success'] 		= "false";
				$return['message'] 		= $errormessage;
				$return['error'] 		= $this->error;
				$return['data'] 		= $this->data;			
				
				return $this->respond($return);
			}	
			} else {
				$return['success'] 		= "false";
				$return['message'] 		= "invalid event";
				$return['error'] 		= "";
				$return['data'] 		= "";			
				
				return $this->respond($return);
			}
	}
	
	
}
