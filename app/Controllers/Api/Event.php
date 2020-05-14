<?php namespace App\Controllers\APi;
use App\Models\EventModel;
use App\Models\SkillModel;
use CodeIgniter\RESTful\ResourceController;

class Event extends ResourceController
{ 

    

    public function __construct()
    {
        helper(['cookie','common']);
		
    }


   public function getallevents() 
		{
			$postData = json_decode( file_get_contents('php://input'),true);
			$event_cat = isset($postData['category']) ? $postData['category'] : '';
			$event_type = isset($postData['type']) ? $postData['type'] : '';
			$orderby = isset($postData['orderby']) ? $postData['orderby'] : 'newest';
			$keyword = isset($postData['keyword']) ? $postData['keyword'] : '';
			$skill = isset($postData['skill']) ? $postData['skill'] : '';
			$model = new EventModel();
			$Alldata    = $model->getAlldata($event_cat, $event_type, $orderby, $keyword, $skill);
			
			//echo "<pre>";print_r($Alldata);exit;
			$currentuserid = "";
			$session = \Config\Services::session();
			if($session->get('is_logged_in')==true )
            {
				$currentuserid = $session->get('user_data')->ID;
				
			}
			$Alldata  = action_button_for_events($Alldata);
			
			
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
		
		 public function getAlladmindata() 
		{ 
			$postData = json_decode( file_get_contents('php://input'),true);
			$from_date = isset($postData['from_date']) ? $postData['from_date'] : '';
			$end_date = isset($postData['end_date']) ? $postData['end_date'] : '';
			$orderby = isset($postData['orderby']) ? $postData['orderby'] : 'newest';
			$model = new EventModel();
			$session = \Config\Services::session();
			
			if($session->get('user_data')->role == 'admin') {
			$Alldata    = $model->getAlladmindata($from_date, $end_date, $orderby);
			} else {
				
				$Alldata    = $model->getAlleventmanagerdata($session->get('user_data')->ID, $from_date, $end_date, $orderby);
			}
			
			
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
		
		public function getallcommunity() 
		{ 
			
			$model = new EventModel();
			$Alldata    = $model->getAlldataby('li_event_community');
			if($Alldata)
			{
				$return['success'] 		= "true";
				$return['message'] 		= "Get All Community list.";
				$return['data'] 		= $Alldata;	
				$return['error'] 		= $this->error;
				
				return $this->respond($return);
			}
			
			else
			{
				$return['success'] 		= "false";
				$return['message'] 		= "Community not found.";
				$return['error'] 		= $this->error;
				$return['data'] 		= $this->data;			
				
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
		
		public function getalltype() 
		{ 
			$postData = json_decode( file_get_contents('php://input'),true);
			$cat_id = $postData['cat_id'];
			$param= array('cat_id'=>$cat_id);
			$model = new EventModel();
			if($postData['limit']) {
				$Alldata    = $model->getAlldataby('li_eventtype', $param, $postData['limit']);
			} else {
				$Alldata    = $model->getAlldataby('li_eventtype', $param);
			
			}
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
		
		public function getalltypeInsteadgroup() 
		{ 
			$postData = json_decode( file_get_contents('php://input'),true);
			$cat_id = $postData['cat_id'];
			$param= array('cat_id' => $cat_id,'LOWER(title) !=' => 'groups');
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
		
		public function getgrouptype() 
		{ 
			$postData = json_decode( file_get_contents('php://input'),true);
			$cat_id = $postData['cat_id'];
			$param= array('cat_id' => $cat_id,'LOWER(title)' => 'groups');
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
		
		
		public function getalltypename() 
		{ 
			$postData = json_decode( file_get_contents('php://input'),true);
			$cat_id = $postData['cat_id'];
			$event_type_id = $postData['event_type_id'];
			$param= array('cat_id'=>$cat_id, 'event_type_id'=>$event_type_id);
			$model = new EventModel();
			$Alldata    = $model->getAlldataby('li_eventtype_name', $param);
			if($Alldata)
			{
				$return['success'] 		= "true";
				$return['message'] 		= "Get All Type Name list.";
				$return['data'] 		= $Alldata;	
				$return['error'] 		= $this->error;
				
				return $this->respond($return);
			}
			
			else
			{
				$return['success'] 		= "false";
				$return['message'] 		= "Type Name not found.";
				$return['error'] 		= $this->error;
				$return['data'] 		= $this->data;			
				
				return $this->respond($return);
			}	
		}
		
	public function eventDetail() 
		{
			$postData = json_decode( file_get_contents('php://input'),true);
			$id = $postData['id'];
			$model = new EventModel();
			$eventdetail    = $model->getDetail($id);
				
			if($eventdetail)
			{
				$currentuserid = "";
			$session = \Config\Services::session();
		
			
			if($session->get('is_logged_in')==true )
            {
				$currentuserid = $session->get('user_data')->ID;
				
			}
			$Alldata[0] = $eventdetail;
			$Alldata[0]->currency = get_currency();
			$eventdetail  = action_button_for_events($Alldata)[0];
			
				$return['success'] 		= "true";
				$return['message'] 		= "Get All Details.";
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
  
  
  public function updateEvent() 
		{
			$session = \Config\Services::session();
			helper('form');
			$postData = json_decode(file_get_contents('php://input'), true);
			if($postData == '')
			{
				$postData = $_POST;
				
				
			}
			$uservalidate=true;
			$event_id=$_POST['event_id'];
			
			$uservalidate=$this->validate([
					'event_community' => 'trim|required',
					'event_category'  => 'trim|required',
					'event_type'  => 'trim|required',
					'event_typename'  => 'trim|required',
					'skill_requirement'  => 'trim|required',
					'skill_earned'  => 'trim|required',
					'start_date' => 'required|valid_date[Y-m-d]',
					'end_date' => 'required|valid_date[Y-m-d]',
					'start_time' => 'required',
					'end_time'   => 'required',
					'location'   => 'required',
			]); 
			
			if(!$uservalidate)
			{
				
				$return['success'] 		= "false";
				$return['message'] 		= \Config\Services::validation()->listErrors();
				$return['error'] 		= \Config\Services::validation()->listErrors();
				$return['data'] 		= "";			
				
				return $this->respond($return);
			}
			if($_POST['cost'] < $_POST['min_deposit']) {
				$return['success'] 		= "false";
				$return['message'] 		= "Event Cost should not be less than minimum deposite.";
				$return['error'] 		= "Event Cost should not be less than minimum deposite.";
				$return['data'] 		= "";			
				
				return $this->respond($return);
			}
			
			$updateArr 		= array(
			'event_community' 	=> $_POST['event_community'],
			'event_category' 	=> $_POST['event_category'],
			'event_type' 	=> $_POST['event_type'],
			'event_typename' 	=> $_POST['event_typename'],
			'group_id'   => !empty($_POST['group_id']) ? $_POST['group_id'] : null,
			'start_date' 		=> $_POST['start_date'],
			'end_date' 		=> $_POST['end_date'],
			'start_time' 		=> $_POST['start_time'],
			'end_time' 		=> $_POST['end_time'],
			'cost' 		=> $_POST['cost'],
			'min_deposit' 		=> $_POST['min_deposit'],
			'max_attendees' 		=> $_POST['max_attendees'],
			'max_staff' 		=> $_POST['max_staff'],
			'details' 		=> $_POST['details'], 
			'details_popup' 		=> $_POST['details_popup'],
			'age_requirement' 		=> $_POST['age_requirement'],
			'location' 		=> $_POST['location'],
			'lat' 		=> $_POST['lat'],
			'lng' 		=> $_POST['lng'],
			'security' 		=> $_POST['security'],
			'skill_requirement' 		=> $_POST['skill_requirement'],
			'skill_condition' 		=> $_POST['skill_condition'],
			'leader' 		=> $_POST['leader'],
			'skill_earned' 		=> $_POST['skill_earned'],
			'role' 		=> $_POST['role'],
			'invite_code' 		=> $_POST['invite_code']
			); 
			//echo "<pre>";print_r($updateArr);exit;
			$model = new EventModel();
			
			if($event_id!=""){
			$updateArr['modified_by'] = $session->get('user_data')->ID;				
			$update = $model->updateData($updateArr, $event_id);
			} else { 
			$updateArr['created_by'] = $session->get('user_data')->ID;
			$updateArr['modified_by'] = $session->get('user_data')->ID;
			$update = $model->saveData($updateArr);
			} 
			if($update)
			{
				$return['success'] 		= "true";
				$return['message'] 		= "Event successfully updated/created.";
				$return['error'] 		= "";
				$return['data'] 		= "";			
				
				return $this->respond($return);
			}
			else
			{
				
				$return['success'] 		= "false";
				$return['message'] 		= "Event is not update. Something went wrong.";
				$return['error'] 		= "";
				$return['data'] 		= "";			
				return $this->respond($return);
			}
		}
		
		public function addcommunity() 
		{
			
			helper('form');
			$postData = json_decode(file_get_contents('php://input'), true);
			if($postData == '')
			{ $postData = $_POST; }
			$uservalidate=true;
			$event_id=$_POST['event_id'];
			
			$uservalidate=$this->validate([
        'title' => 'trim|required',
]); 
			
			if(!$uservalidate)
			{
				
				$return['success'] 		= "false";
				$return['message'] 		= \Config\Services::validation()->listErrors();
				$return['error'] 		= \Config\Services::validation()->listErrors();
				$return['data'] 		="";			
				
				return $this->respond($return);
			}
			
			$updateArr 		= array(
			'title' 	=> $_POST['title']
			); 
			//print_r($updateArr);
			$model = new EventModel();
			
			$update = $model->saveDataby('li_event_community', $updateArr);
			$Alldata    = $model->getAlldataby('li_event_community');
			if($Alldata)
			{
				$return['success'] 		= "true";
				$return['message'] 		= "Community successfully created.";
				$return['error'] 		= "";
				$return['data'] 		= $Alldata;			
				
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
		
		public function addcategory() 
		{
			
			helper('form');
			$postData = json_decode(file_get_contents('php://input'), true);
			if($postData == '')
			{ $postData = $_POST; }
			$uservalidate=true;
			$uservalidate=$this->validate([
        'title' => 'trim|required',
]); 
			
			if(!$uservalidate)
			{
				
				$return['success'] 		= "false";
				$return['message'] 		= \Config\Services::validation()->listErrors();
				$return['error'] 		= \Config\Services::validation()->listErrors();
				$return['data'] 		="";			
				
				return $this->respond($return);
			}
			
			$updateArr 		= array(
			'title' 	=> $_POST['title']
			); 
			//print_r($updateArr);
			$model = new EventModel();
			
			$update = $model->saveDataby('li_eventcategory', $updateArr);
			$Alldata    = $model->getAlldataby('li_eventcategory');
			if($Alldata)
			{
				$return['success'] 		= "true";
				$return['message'] 		= "Category successfully created.";
				$return['error'] 		= "";
				$return['data'] 		= $Alldata;			
				
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
		
		public function addtype() 
		{
			
			helper('form');
			$postData = json_decode(file_get_contents('php://input'), true);
			if($postData == '')
			{ $postData = $_POST; }
			$uservalidate=true;
			
			$uservalidate=$this->validate([
        'title' => 'trim|required',
		'category' => 'trim|required',
]); 
			
			if(!$uservalidate)
			{
				
				$return['success'] 		= "false";
				$return['message'] 		= \Config\Services::validation()->listErrors();
				$return['error'] 		= \Config\Services::validation()->listErrors();
				$return['data'] 		="";			
				
				return $this->respond($return);
			}
			
			$updateArr 		= array(
			'title' 	=> $_POST['title'],
			'cat_id' 	=> $_POST['category']
			); 
			//print_r($updateArr);
			$model = new EventModel();
			
			$update = $model->saveDataby('li_eventtype', $updateArr);
			$Alldata    = $model->getAlldataby('li_eventtype', array('cat_id'=>$_POST['category']));
			if($Alldata)
			{
				$return['success'] 		= "true";
				$return['message'] 		= "Event Type successfully created.";
				$return['error'] 		= "";
				$return['data'] 		= $Alldata;			
				
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
		
		public function addtypename() 
		{
			
			helper('form');
			$postData = json_decode(file_get_contents('php://input'), true);
			if($postData == '')
			{ $postData = $_POST; }
			$uservalidate=true;
			
			$uservalidate=$this->validate([
        'title' => 'trim|required',
		'category' => 'trim|required',
		'event_type' => 'trim|required',
]); 
			
			if(!$uservalidate)
			{
				
				$return['success'] 		= "false";
				$return['message'] 		= \Config\Services::validation()->listErrors();
				$return['error'] 		= \Config\Services::validation()->listErrors();
				$return['data'] 		="";			
				
				return $this->respond($return);
			}
			
			$updateArr 		= array(
			'title' 	=> $_POST['title'],
			'cat_id' 	=> $_POST['category'],
			'event_type_id' 	=> $_POST['event_type']
			); 
			//print_r($updateArr);
			$model = new EventModel();
			
			$update = $model->saveDataby('li_eventtype_name', $updateArr);
			$Alldata    = $model->getAlldataby('li_eventtype_name', array('cat_id'=>$_POST['category'], 'event_type_id'=>$_POST['event_type']));
			if($Alldata)
			{
				$return['success'] 		= "true";
				$return['message'] 		= "Event Type Name successfully created.";
				$return['error'] 		= "";
				$return['data'] 		= $Alldata;			
				
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
		
		public function getallleaders() 
		{ 
			$postData = json_decode( file_get_contents('php://input'),true);
			$skill = $postData['skill'];
			$condition = $postData['condition'];

			
			$param= array('li_users.role !=' =>'admin');
			
			$model = new EventModel();
			$Alldata    = $model->getAllleader($param, $skill, $condition);
		    
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
		
		
		public function gotocartstatus() 
		{ 
			$postData = json_decode( file_get_contents('php://input'),true);
			$event_id = $postData['event_id'];
			$skill_requirement = $postData['skill_requirement'];
			$session = \Config\Services::session();
		   
			$model = new EventModel();
			//$Alluser    = $model->getDetail($event_id);
			if($skill_requirement==0){
			$successmessage =true;	
			}
			elseif($skill_requirement!=0 && $session->get('is_logged_in')!=true ){
			$errormessage ="Please login to participate in this event.";
			}
			elseif($skill_requirement!=0 && $session->get('is_logged_in')==true ){
				$condition=array('skill_id'=>$skill_requirement,'user_id'=>$session->get('user_data')->ID);
			$Alldata    = $model->getAlldataby('li_user_skills', $condition);	
			if(!$Alldata){
			$smodel = new SkillModel();
			$skilldata    = $smodel->getDetail($skill_requirement);
			 if(!empty($postData['category'])) {
				 $condition = array('t1.skill_earned'=>$skill_requirement,'t1.id !='=> $event_id,'t1.event_category' => $postData['category']);
			 } else {
				$condition = array('t1.skill_earned'=>$skill_requirement,'t1.id !='=> $event_id);
			 }
			$eventdata    = $model->getconcatEventtypename($condition);	
			$eventsname = "";
			foreach($eventdata as $key=>$event) {
				if($key == 0) {
					$eventsname = '<a href="'.base_url('eventdetail/'.str_replace(" ","-",$event->title).'-'.$event->id).'">'.$event->event_name.'</a>';
				} else {
					$eventsname .= ', <a href="'.base_url('eventdetail/'.str_replace(" ","-",$event->title).'-'.$event->id).'">'.$event->event_name.'</a>';
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
			$errormessage ="Something went wrong";	
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
		}
	//--------------------------------------------------------------------
	
	public function get_event_order_by_unique_order_id() {
		$postData = json_decode(file_get_contents('php://input'), true);
			if($postData == '')
			{
				$postData = $_POST;
				
				
			}
		$model = new EventModel();
		$event_order =	$model->get_event_order_by_unique_event_order($postData['unique_event_order']);
		$paymentids = unserialize($event_order->payment_id);
		$paymentdata = $model->get_payment_by_payment_id(end($paymentids));
		$event_order->paymentdata = $paymentdata;
		if($event_order) {
				$return['success'] 		= "true";
				$return['message'] 		= "";
				$return['data'] 		= $event_order;	
				$return['error'] 		= "";
				
				return $this->respond($return);
		} else {
			$return['success'] 		= "false";
				$return['message'] 		= "";
				$return['data'] 		= "";	
				$return['error'] 		= "";
				
				return $this->respond($return);
		}
		
	}
	
	public function get_user_event_list() 
		{
			$session = \Config\Services::session();
			if($session->get('is_logged_in') != true)
			 {
					$return['success'] 		= "false";
					$return['message'] 		= "Please login to see all events";
					$return['error'] 		= "";
					$return['data'] 		= "";
					
					return $this->respond($return);
					
			}
			$postData = json_decode( file_get_contents('php://input'),true);
			$event_cat = isset($postData['category']) ? $postData['category'] : '';
			$type = isset($postData['type']) ? $postData['type'] : '';
			$orderby = isset($postData['orderby']) ? $postData['orderby'] : 'newest';
			$keyword = isset($postData['keyword']) ? $postData['keyword'] : '';
			$skill = isset($postData['skill']) ? $postData['skill'] : '';
			$event_type = $postData['event_type'];
			$model = new EventModel();
			if($event_type == "upcoming") {
				$Alldata    = $model->get_user_upcoming_events($session->get('user_data')->ID,$event_cat, $type, $orderby, $keyword, $skill);
					 foreach($Alldata as $key=>$upcomingevents) {
					$paymentids = unserialize($upcomingevents->payment_id);
					$paymentdata = $model->get_payment_by_payment_id(end($paymentids));
					
					 if($upcomingevents->cost > $upcomingevents->paid_amount && $paymentdata->payment_type == "mindeposit") {
						$Alldata[$key]->is_pay  = 1;
						 $Alldata[$key]->is_incomplete = 0;
					 } else {
						 $Alldata[$key]->is_pay = 0;
						  if(empty($upcomingevents->agreement_id)) {
							$Alldata[$key]->is_incomplete  = "agreement";
						 } else if(empty($upcomingevents->healthinfo_id)){
							 $Alldata[$key]->is_incomplete = "healthinfo";
						 } else if(empty($upcomingevents->notification_info_id)){
							  $Alldata[$key]->is_incomplete = "notificationinfo";
						 } else{
							 $Alldata[$key]->is_incomplete = 0;
						 }
					 }
					 
					
				}
				
			} else if($event_type == "reconnect"){
				$allevents = $model->get_registered_events_by_user($session->get('user_data')->ID);
				
				$userevents = array();
				foreach($allevents as $pastevents){
					$userevents[] = $pastevents->id;
					
					
				}
				
				$allparticipants = $model->get_all_participants_by_events($userevents, $session->get('user_data')->ID);
				$eventparticipants = array();
				foreach($allparticipants as $particpants) {
					
					$eventparticipants[] =  $particpants->ID;
					
				}
				$Alldata = array();
				//echo "<pre>";print_r($eventparticipants);exit;
				if(!empty($eventparticipants)) { 
					$Alldata = $model->get_partcipate_users_registered_event($userevents, $eventparticipants,$event_cat, $type, $orderby, $keyword, $skill);
				}
			}else {
				$Alldata    = $model->get_skills_requirement_events($session->get('user_data')->ID,$event_cat, $type, $orderby, $keyword, $skill);
			}
		
			
			
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
		
		public function deleteEvent() {
				$postData = json_decode(file_get_contents('php://input'), true);
			if($postData == '')
			{
				$postData = $_POST;
				
				
			}
			
			$model = new EventModel();
			$event_detail = $model->getDetail($postData['event_id']);
			$session = \Config\Services::session();
			if($session->get('user_data')->role == 'event_manager') {
				
				if($event_detail->created_by != $session->get('user_data')->ID){
					$return['success'] 		= "false";
					$return['message'] 		= "You can not delete this event";
					$return['error'] 		= "";
					$return['data'] 		= "";			
					return $this->respond($return);
				}
				
			}
			$event_id = $postData['event_id'];
			$updateArr = array(
			'delete_by' => $session->get('user_data')->ID,
			'is_delete' => 1
			);
			
			
			$update = $model->updateData($updateArr, $event_id);
			if($update)
			{
				$return['success'] 		= "true";
				$return['message'] 		= "Event successfully deleted.";
				$return['error'] 		= "";
				$return['data'] 		= "";			
				
				return $this->respond($return);
			}
			else
			{
				
				$return['success'] 		= "false";
				$return['message'] 		= "Event is not delete. Something went wrong.";
				$return['error'] 		= "";
				$return['data'] 		= "";			
				return $this->respond($return);
			}
			
		}
		
	public function geteventtypeByid() {
		$postData = json_decode( file_get_contents('php://input'),true);
			$type_id = $postData['id'];
			$param= array('id'=>$type_id);
			$model = new EventModel();
			$Alldata    = $model->getAlldataby('li_eventtype', $param);
			
			 
			foreach($Alldata as $eventtype) {
				$Alldata[0]->title  = strtolower($eventtype->title);
			}
			$eventtypedata = $Alldata[0];
			if($eventtypedata)
			{
				$return['success'] 		= "true";
				$return['message'] 		= "Get All Type list.";
				$return['data'] 		= $eventtypedata;	
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
		

}
