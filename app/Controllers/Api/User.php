<?php namespace App\Controllers\APi;
use App\Models\UserModel;
use App\Models\EventModel;
use App\Models\SkillModel;
use CodeIgniter\RESTful\ResourceController;

class User extends ResourceController
{ 

    

    public function __construct()
    {
        helper(['cookie','common']);
		
    }


   public function getallusers() 
		{
			$session = \Config\Services::session();
		
			$currentuserid = $session->get('user_data')->ID;
			
			$model = new UserModel();
			$Alluser    = $model->getAlluser();
			foreach($Alluser as $key=>$user) {
				if($user->role == "event_manager") {
					$Alluser[$key]->role = "Event Manager";
				}
				if($user->ID == $currentuserid) {
					$Alluser[$key]->is_login = 1;
				} else{
					$Alluser[$key]->is_login = 0;
				}
			}
			if($Alluser)
			{
				$return['success'] 		= "true";
				$return['message'] 		= "Get All User Details.";
				$return['data'] 		= $Alluser;	
				$return['error'] 		= $this->error;
				
				return $this->respond($return);
			}
			
			else
			{
				$return['success'] 		= "false";
				$return['message'] 		= "All Product Details not found.";
				$return['error'] 		= $this->error;
				$return['data'] 		= $this->data;			
				
				return $this->respond($return);
			}	
		}
		
		public function userDetail() 
		{
			$session = \Config\Services::session();
		
			$currentuserid = $session->get('user_data')->ID;
			 $postData = json_decode( file_get_contents('php://input'),true);
			$user_id = $postData['id'];  
			$model = new UserModel();
			$Alluser    = $model->getuserDetail($user_id);
			if($currentuserid == $user_id){
				$Alluser->is_login = 1;
			}else {
				$Alluser->is_login = 0;
			}
			
			if($Alluser)
			{
				$return['success'] 		= "true";
				$return['message'] 		= "Get All User Details.";
				$return['data'] 		= $Alluser;	
				$return['error'] 		= "";
				
				return $this->respond($return);
			}
			
			else
			{
				$return['success'] 		= "false";
				$return['message'] 		= "All Product Details not found.";
				$return['error'] 		= "";
				$return['data'] 		= "";			
				
				return $this->respond($return);
			}	
		}
		
		  public function updateUser() 
		{
			$view = \Config\Services::renderer();
			helper('form');
			$postData = json_decode(file_get_contents('php://input'), true);
			if($postData == '')
			{
				$postData = $_POST;
				
				
			}
			$uservalidate = true;
			$user_id=$_POST['user_id'];
		if($user_id == ""){			
			$uservalidate=$this->validate([
				'email' => 'trim|required|valid_email|is_unique[li_users.email]',
				'login_id'  => 'trim|required|is_unique[li_users.login_id]',
				'password'  => 'trim|required'
			]);

			}
			
			if(!$uservalidate)
			{
				
				$return['success'] 		= "false";
				$return['message'] 		= \Config\Services::validation()->listErrors();
				$return['error'] 		= \Config\Services::validation()->listErrors();
				$return['data'] 		="";			
				
				return $this->respond($return);
			}
			
			
			
			$profilepic 		= '';
			$hasFileUpload 	= false;
			$password 	= false;
			$file = $this->request->getFile('profilepic');
			//print_r($file); die;
			//$file = $this->request->getFile('logo')
			
			// echo ROOTPATH;  die;
			
			if( ! empty($file) )
			{
				$ext = $file->getClientExtension();
				$valid_extensions = array('jpg','jpeg','gif','png');
				$newName = $file->getRandomName();
				if(in_array($ext, $valid_extensions)) {
					if ( ! $file->move(ROOTPATH.'uploads/profilepic', $newName))
					{
						$uploaderror 			= $file->getError();
						$return['success'] 		= "false";
						$return['message'] 		= $uploaderror;
						$return['error'] 		= "";
						$return['data'] 		= "";			
						return $this->respond($return);
					}
					else
					{
						$uplodimg 				= $newName;
						$profilepic 				= $uplodimg;
						$hasFileUpload 			= true;
					}
				} else {
						$return['success'] 		= "false";
						$return['message'] 		= "Please select only image";
						$return['error'] 		= "";
						$return['data'] 		= "";			
						return $this->respond($return);
				}
			}
			
			if($profilepic != "")
			{
				$updateArr 		= array(
				'login_id' 		=> 	$_POST['login_id'],
				'email' 		=> 	$_POST['email'],
				'first_name' 	=> 	$_POST['first_name'],
				'last_name' 	=> 	$_POST['last_name'],
				'role' 			=> 	$_POST['role'],
				'active' 		=> 	$_POST['active'],
				'profilepic' 	=> ($profilepic) ? $profilepic : '',
				);
			}else
			{
				$updateArr 		= array(
				'login_id' 		=> $_POST['login_id'],
				'email' 		=> $_POST['email'],
				'first_name' 	=> $_POST['first_name'],
				'last_name' 	=> $_POST['last_name'],
				'role' 			=> $_POST['role'],
				'active' 		=> $_POST['active'],
				); 
			}
			$model = new UserModel();
			if($hasFileUpload)
			{
				$updateArr['profilepic'] = $profilepic;
			}
			$password 	=isset($_POST['password']) ? $_POST['password'] : false;
			if($password){
				$updateArr['password'] = md5($password);
		
			}
			//echo $user_id;
			//print_r($updateArr); die;
			
			
			if($user_id!=""){ 
			
				$update = $model->updateUser($updateArr, $user_id);
				$view_data = array(
							'name' => $_POST['first_name'].' '.$_POST['last_name'],
							'role' => $_POST['role'],
							'email' => $_POST['email'],
							'username' => $_POST['login_id'],
							'password' => $password,
							'email_content' => "Your detail has been updated by admin.Following are the detail:"
				);
				$maildata['subject'] = "Account Updated By Admin";
			
			} else { //print_r($updateArr);
			
				$update = $model->saveUser($updateArr);
				$view_data = array(
							'name' => $_POST['first_name'].' '.$_POST['last_name'],
							'role' => $_POST['role'],
							'email' => $_POST['email'],
							'username' => $_POST['login_id'],
							'password' => $password,
							'email_content' => "Your account has been created by admin.Following are the detail:"
				);
				
				$maildata['subject'] = "Account Created By Admin";
			
			}
			
			if($update)
			{
				
				$maildata['to'] = $_POST['email'];
				$maildata['message'] = $view->setData($view_data)->render('email/admin_user');
				
				send_mail($maildata);
				
				$return['success'] 		= "true";
				$return['message'] 		= "User successfully updated/created.";
				$return['error'] 		= "";
				$return['data'] 		= "";			
				
				return $this->respond($return);
			}
			else
			{
				
				$return['success'] 		= "false";
				$return['message'] 		= "User is not update. Something went wrong.";
				$return['error'] 		= "";
				$return['data'] 		= "";			
				return $this->respond($return);
			}
		}
		
		public function registration() 
		{
			
			helper('form');
			$postData = json_decode(file_get_contents('php://input'), true);
			if($postData == '')
			{
				$postData = $_POST;
				
				
			}
			$uservalidate=true;
			$user_id=$_POST['user_id'];
if($user_id == ""){			
			$uservalidate=$this->validate([
        'email' => 'trim|required|valid_email|is_unique[li_users.email]',
		'password'  => 'trim|required',
        'confirmpassword'  => 'trim|required|matches[password]'
]); }
			
			if(!$uservalidate)
			{
				
				$return['success'] 		= "false";
				$return['message'] 		= \Config\Services::validation()->listErrors();
				$return['error'] 		= \Config\Services::validation()->listErrors();
				$return['data'] 		="";			
				
				return $this->respond($return);
			}
			
			
			
			
			$updateArr = array(
			'login_id' 	=> $_POST['email'],
			'email' 	=> $_POST['email'],
			'first_name'=> $_POST['first_name'],
			'last_name' => $_POST['last_name'],
			'phone' 	=> $_POST['phone'],
			'address' 	=> $_POST['address'],
			'state' 	=> $_POST['state'],
			'city' 		=> $_POST['city'],
			'zip' 		=> $_POST['zip'],
			'role' 		=> 'customer',
			); 
			
			$model = new UserModel();
			
			$password 	=isset($_POST['password']) ? $_POST['password'] : false;
			if($password){
				$updateArr['password'] = md5($password);
		
			}
			//echo $user_id;
			//print_r($updateArr); die;
			
			
			
			$update = $model->saveUser($updateArr);
			
			if($update)
			{
				$return['success'] 		= "true";
				$return['message'] 		= "User successfully updated/created.";
				$return['error'] 		= "";
				$return['data'] 		= "";			
				
				return $this->respond($return);
			}
			else
			{
				
				$return['success'] 		= "false";
				$return['message'] 		= "User is not update. Something went wrong.";
				$return['error'] 		= "";
				$return['data'] 		= "";			
				return $this->respond($return);
			}
		}
  
		public function getprofile() 
		{
			$session = \Config\Services::session();
		//print_r($session->get('user_data')->role);
       if($session->get('is_logged_in')==true )
            {
				$currentuserid=$session->get('user_data')->ID;
			}
			 $postData = json_decode( file_get_contents('php://input'),true);
			//$user_id = $postData['id'];  
			$model = new UserModel();
			$Alluser    = $model->getuserDetail($currentuserid);
			if($Alluser)
			{
				$return['success'] 		= "true";
				$return['message'] 		= "Get All User Details.";
				$return['data'] 		= $Alluser;	
				$return['error'] 		= "";
				
				return $this->respond($return);
			}
			
			else
			{
				$return['success'] 		= "false";
				$return['message'] 		= "All Product Details not found.";
				$return['error'] 		= "";
				$return['data'] 		= "";			
				
				return $this->respond($return);
			}	
		}
		
				public function updateprofile() 
		{
			
			
			
			helper('form');
			$postData = json_decode(file_get_contents('php://input'), true);
			
			$session = \Config\Services::session();
		//print_r($session->get('user_data')->role);
       if($session->get('is_logged_in')==true )
            {
				$currentuserid=$session->get('user_data')->ID;
			}
			if($postData == '')
			{
				$postData = $_POST;
				
				
			}
			$uservalidate=true;
			$user_id=$_POST['user_id'];
			
		if($user_id == ""){			
			$uservalidate=$this->validate([
				'email' => 'trim|required|valid_email|is_unique[li_users.email]',
				'login_id'  => 'trim|required|is_unique[li_users.login_id]'
				]); 
		} else {
			$errors = validate_update_profile($_POST);
			if(!empty($errors)) {
				$return['success'] 		= "false";
				$return['message'] 		= $errors;
				$return['error'] 		= $errors;
				$return['data'] 		="";			
				
				return $this->respond($return);
			}
		}
		if($user_id==$currentuserid){	
			if(!$uservalidate)
			{
				
				$return['success'] 		= "false";
				$return['message'] 		= \Config\Services::validation()->listErrors();
				$return['error'] 		= \Config\Services::validation()->listErrors();
				$return['data'] 		="";			
				
				return $this->respond($return);
			}
			
			$profilepic 		= '';
			$hasFileUpload 	= false;
			$password 	= false;
			$file = $this->request->getFile('profilepic');
			//print_r($file); die;
			//$file = $this->request->getFile('logo')
			
			// echo ROOTPATH;  die;
			
			if( ! empty($file) )
			{ 
				$ext = $file->getClientExtension();
				$valid_extensions = array('jpg','jpeg','gif','png');
				$newName = $file->getRandomName();
				if(in_array($ext, $valid_extensions)) {
				if ( ! $file->move(ROOTPATH.'uploads/profilepic', $newName))
				{
					$uploaderror 			= $file->getError();
					$return['success'] 		= "false";
					$return['message'] 		= $uploaderror;
					$return['error'] 		= "";
					$return['data'] 		= "";			
					return $this->respond($return);
				}
				else
				{
					$uplodimg 				= $newName;
					$profilepic 				= $uplodimg;
					$hasFileUpload 			= true;
				}
				} else {
					$return['success'] 		= "false";
						$return['message'] 		= "Please select only image";
						$return['error='] 		= "Please select only image";
						$return['data'] 		= "";			
						return $this->respond($return);
				}
			}
			
			if($profilepic != "")
			{
			$updateArr 		= array(
			'first_name' 		=> $_POST['first_name'],
			'last_name' 		=> $_POST['last_name'],
			'phone' 		=> $_POST['phone'],
			'address' 		=> $_POST['address'],
			'city' 		=> $_POST['city'],
			'state' 		=> $_POST['state'],
			'zip' 		=> $_POST['zip'],
			'bio' 		=> $_POST['bio'],
			'profilepic' 	=> ($profilepic) ? $profilepic : '',
			);
			}else
			{
			   $updateArr 		= array(
			'first_name' 		=> $_POST['first_name'],
			'last_name' 		=> $_POST['last_name'],
			'phone' 		=> $_POST['phone'],
			'address' 		=> $_POST['address'],
			'city' 		=> $_POST['city'],
			'state' 		=> $_POST['state'],
			'zip' 		=> $_POST['zip'],
			'bio' 		=> $_POST['bio'],
			); 
			}
			$model = new UserModel();
			if($hasFileUpload)
			{
				$updateArr['profilepic'] = $profilepic;
			}
			$password 	=isset($_POST['password']) ? $_POST['password'] : false;
			if($password){
				$updateArr['password'] = md5($password);
		
			}
			//echo $user_id;
			//print_r($updateArr); die;
			
			
			if($user_id!=""){ 
			$update = $model->updateUser($updateArr, $user_id);
			} } 
			if($update)
			{
				$return['success'] 		= "true";
				$return['message'] 		= "Profile successfully updated/created.";
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
		}
		
		public function validate_event_manager() {
		$session = \Config\Services::session();
		if($session->get('user_data')->role == 'event_manager') {
			
			if($_GET['page'] == 'edituser' && !empty($_GET['userid'])) {
				
				if($_GET['userid'] == $session->get('user_data')->ID) {
					$return['success'] 		= "false";
					$return['message'] 		= "not found";
					$return['error'] 		= "";
					$return['data'] 		= "";			
					return $this->respond($return);
				} 
			} else if($_GET['page'] == 'editevent' && !empty($_GET['eventid'])) {
				$model = new EventModel();
				$event_detail = $model->getDetail($_GET['eventid']);
				if($event_detail->created_by == $session->get('user_data')->ID){
					$return['success'] 		= "false";
					$return['message'] 		= "not found";
					$return['error'] 		= "";
					$return['data'] 		= "";			
					return $this->respond($return);
				}
			} else {
				$return['success'] 		= "true";
				$return['message'] 		= "login user is event manager";
				$return['error'] 		= "";
				$return['data'] 		= "";			
				
				return $this->respond($return);
			}
		} else {
			$return['success'] 		= "false";
				$return['message'] 		= "not found";
				$return['error'] 		= "";
				$return['data'] 		= "";			
				return $this->respond($return);
		}
		
	}
	
	public function get_users_upcoming_event() {
		$session = \Config\Services::session();
		
		 if($session->get('is_logged_in')==true )
            {
				$model = new EventModel();
				$allupcomingevents = $model->get_user_upcoming_events($session->get('user_data')->ID);
				 foreach($allupcomingevents as $key=>$upcomingevents) {
					$paymentids = unserialize($upcomingevents->payment_id);
					$paymentdata = $model->get_payment_by_payment_id(end($paymentids));
					
					 if($upcomingevents->cost > $upcomingevents->paid_amount && $paymentdata->payment_type == "mindeposit") {
						$allupcomingevents[$key]->is_pay  = 1;
						 $allupcomingevents[$key]->is_incomplete = 0;
					 } else {
						 $allupcomingevents[$key]->is_pay = 0;
						  if(empty($upcomingevents->agreement_id)) {
							$allupcomingevents[$key]->is_incomplete  = "agreement";
						 } else if(empty($upcomingevents->healthinfo_id)){
							 $allupcomingevents[$key]->is_incomplete = "healthinfo";
						 } else if(empty($upcomingevents->notification_info_id)){
							  $allupcomingevents[$key]->is_incomplete = "notificationinfo";
						 } else{
							 $allupcomingevents[$key]->is_incomplete = 0;
						 }
					 }
					 
					
				} 
				//echo "<pre>";print_r($allupcomingevents);exit;
				if($allupcomingevents) {
						$return['success'] 		= "true";
						$return['message'] 		= "Get All Upcoming Events.";
						$return['data'] 		= $allupcomingevents;	
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
				$return['message'] 		= "Please login to see your upcoming events!!";
				$return['error'] 		= "";
				$return['data'] 		= "";			
				return $this->respond($return);
				
			}
	}
	
	public function get_users_reconnect_events() {
		$session = \Config\Services::session();
		
		 if($session->get('is_logged_in')==true )
            {
				$allreconnectevents = array();
				$model = new EventModel();
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
				$events = array();
				//echo "<pre>";print_r($eventparticipants);exit;
				if(!empty($eventparticipants)) { 
				$events = $model->get_partcipate_users_registered_event($userevents, $eventparticipants);
				}
				if($events) {
					$return['success'] 		= "true";
					$return['message'] 		= "Data Found";
					$return['error'] 		= "";
					$return['data'] 		= $events;			
					return $this->respond($return);
				} else {
					$return['success'] 		= "false";
					$return['message'] 		= "Not Found";
					$return['error'] 		= "";
					$return['data'] 		= "";			
					return $this->respond($return);
				}
				
				
			} else {
				
				$return['success'] 		= "false";
				$return['message'] 		= "Please login to see your upcoming events!!";
				$return['error'] 		= "";
				$return['data'] 		= "";			
				return $this->respond($return);
				
			}
	}
	
	public function get_users_past_event() {
		$session = \Config\Services::session();
		
		 if($session->get('is_logged_in')==true )
            {
				$model = new EventModel();
				$allpastevents = $model->get_user_past_events($session->get('user_data')->ID);
				
				//echo "<pre>";print_r($allupcomingevents);exit;
				if($allpastevents) {
						$return['success'] 		= "true";
						$return['message'] 		= "Get All Upcoming Events.";
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
				$return['message'] 		= "Please login to see your upcoming events!!";
				$return['error'] 		= "";
				$return['data'] 		= "";			
				return $this->respond($return);
				
			}
	}
	
	public function get_user_health_info() {
		
			$session = \Config\Services::session();
		
		 if($session->get('is_logged_in')==true )
            {
			$user_id = $session->get('user_data')->ID;  
			$model = new UserModel();
			$decryptdata = array();
			$healthinfo    = $model->gethealthinfoDetail($user_id);
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
			if($decryptdata)
			{
				$return['success'] 		= "true";
				$return['message'] 		= "Get User health info.";
				$return['data'] 		= $decryptdata;	
				$return['error'] 		= "";
				
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
		} else {
				$return['success'] 		= "false";
				$return['message'] 		= "Please login to see your healthinfo!!";
				$return['error'] 		= "";
				$return['data'] 		= "";			
				return $this->respond($return);
		}
	}
	
	public function get_training_staffing_event() {
		$session = \Config\Services::session();
		
		 if($session->get('is_logged_in') == true)
            {
			$user_id = $session->get('user_data')->ID;  
			$model = new EventModel();
			$skillsevent    = $model->get_skills_requirement_events($user_id);
			if($skillsevent)
			{
				$return['success'] 		= "true";
				$return['message'] 		= "Get training and staffing events.";
				$return['data'] 		= $skillsevent;	
				$return['error'] 		= "";
				
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
		} else {
				$return['success'] 		= "false";
				$return['message'] 		= "Please login to see your healthinfo!!";
				$return['error'] 		= "";
				$return['data'] 		= "";			
				return $this->respond($return);
		}	
	}
	
	public function updatehealthinfo() 
		{
			
			helper('validation');
			
		
		$postData = json_decode(file_get_contents('php://input'), true);
			if($postData == '')
			{
				$postData = $_POST;
				
			}
			
			$session = \Config\Services::session();
		//print_r($session->get('user_data')->role);
       if($session->get('is_logged_in') != true )
            {
				$return['success'] 		= "false";
				$return['message'] 		= "Please login to update your information";
				$return['error'] 		= "";
				$return['data'] 		= "";			
				return $this->respond($return);
			}
			
			
			
			$currentuserid=$session->get('user_data')->ID;
			$user_id = $postData['user_id'];
			
		if($user_id==$currentuserid){	
			
			
			 $validation_errors['health'] = validate_healthinfo_data($postData);
			 
			  if(!empty($validation_errors['health'])) {
				 $return['success'] 		= "validation_error";
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
	}
	
	public function deleteUser() {
		$postData = json_decode(file_get_contents('php://input'), true);
			if($postData == '')
			{
				$postData = $_POST;
				
				
			}
			
			$user_id = $postData['user_id'];
			
			$model = new UserModel();
			$update = $model->deleteUser($user_id);
			if($update)
			{
				$return['success'] 		= "true";
				$return['message'] 		= "User successfully deleted.";
				$return['error'] 		= "";
				$return['data'] 		= "";			
				
				return $this->respond($return);
			}
			else
			{
				
				$return['success'] 		= "false";
				$return['message'] 		= "User is not delete. Something went wrong.";
				$return['error'] 		= "";
				$return['data'] 		= "";			
				return $this->respond($return);
			}
	}
	
	public function changepassword(){
		helper(['validation']);
		$session = \Config\Services::session();
		$model = new UserModel();
		$postData = json_decode(file_get_contents('php://input'), true);
			if($postData == '')
			{
				$postData = $_POST;
				
				
			}
		
		$currentuserid= "";
		 if($session->get('is_logged_in')==true )
            {
				$currentuserid = $session->get('user_data')->ID;
			}
		$user_id=$_POST['user_id'];
		if($user_id==$currentuserid){	
		   $validate = validate_reset_password($_POST);
		   
		   if (!empty($validate)) {
					$return['success'] 		= "error";
					$return['message'] 		= "Please fill all fields";
					$return['error'] 		= $validate;
					$return['data'] 		= "";			
					
					return $this->respond($return);                
			} else {
				$updatearr['password'] = md5($_POST['new_password']);
				$setupd = $model->updateUser($updatearr , $user_id);
				if($setupd) {
						$return['success'] 		= "true";
						$return['message'] 		= "Password reset successfully!";
						$return['error'] 		= "";
						$return['data'] 		= "";			
						
						return $this->respond($return);
				} else {
						$return['success'] 		= "false";
						$return['message'] 		= "Something went wrong. Please try again";
						$return['data'] 		= "";	
						$return['error'] 		= "";
						
						return $this->respond($return);
				}		
			}
		
		} else {
			
				$return['success'] 		= "false";
				$return['message'] 		= "not found.";
				$return['error'] 		= "";
				$return['data'] 		= "";			
				
				return $this->respond($return);
		}
		
	}
	
	public function getuserskills() 
		{ 
		$session = \Config\Services::session();
			$postData = json_decode( file_get_contents('php://input'),true);
			 if($session->get('is_logged_in')==true )
            {
			$id = $session->get('user_data')->ID;
			$model = new SkillModel();
			$Alldata    = $model->getAssignskill($id);
			
			if($Alldata)
			{
				$return['success'] 		= "true";
				$return['message'] 		= "Get All Skill list.";
				$return['data'] 		= $Alldata;	
				$return['error'] 		= $this->error;
				
				return $this->respond($return);
			}
			
			else
			{
				$return['success'] 		= "false";
				$return['message'] 		= "All Skill Details not found.";
				$return['error'] 		= $this->error;
				$return['data'] 		= $this->data;			
				
				return $this->respond($return);
			}	
			} else {
				$return['success'] 		= "false";
				$return['message'] 		= "Please login to see your skills";
				$return['error'] 		= $this->error;
				$return['data'] 		= $this->data;			
				
				return $this->respond($return);
			}
		}
	

}
