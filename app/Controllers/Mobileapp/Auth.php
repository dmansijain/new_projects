<?php namespace App\Controllers\Mobileapp;
use App\Models\LoginModel;
use App\Models\UserModel;
use App\Models\DeviceModel;
use App\Models\EventModel;
use App\Models\GroupModel;
use CodeIgniter\RESTful\ResourceController;
use App\Libraries\Paypal;
use App\Libraries\Liminaltokenlib;
//$session = \Config\Services::session();

class Auth extends ResourceController
{ 

    

    public function __construct()
    {
        helper(['cookie','validation','common']);
		
		validate_header_key();
		
    }

   public function login()
	{
		
		$postdata 		= json_decode( file_get_contents('php://input'),true);
		
		if( count($postdata) == 0 )
		{
				$return['success'] 		= "false";
				$return['message'] 		= "Invalid data format";
				$return['data'] 		= "";	
				$return['error'] 		= "";
				
				//print_r($return); die;
				return $this->respond($return);
		}
		$_POST 			= $postdata;
		$username = $postdata['email'];
		$password = $postdata['password'];
		
        
		$validate = validate_login($postdata);
		
		if (empty($validate))
    {
		$model = new LoginModel();
		$userData = $model->getUser($username, $password);
			if($userData)
			{ 
		   
				$devicemodel = new DeviceModel();
				//echo "sdgsdg";exit;
				 $device_info = array(
				'user_id' => $userData->ID,
				 'device_id' => $postdata['device_id'],
				 'device' => $postdata['device'],
				 'fcm_key' => $postdata['fcm_key']
				); 
				
				$inserted = $devicemodel->save_user_device_info($device_info);
				$LiminaltokenlibObj 	= new Liminaltokenlib();
				$token 		= $LiminaltokenlibObj->createToken($userData->ID);
					$newtoken 	= false;
			if($token)
			{
				if($newtoken = $LiminaltokenlibObj->saveToken($token, $userData->ID))
				{
					$userData->token 	= $newtoken;
				}
				else
				{
					$return['success'] 		= "false";
					$return['message'] 		= "something went wrong on save token.";
					$return['error'] 		= (object)$this->error;
					$return['data'] 		= $this->data;

					return $this->respond($return);
				}
			}
			else
			{
				$return['success'] 		= "false";
				$return['message'] 		= "Something went wrong on create token.";
				$return['error'] 		= (object)$this->error;
				$return['data'] 		= $this->data;

				return $this->respond($return);
			}
				
				
				$return['success'] 		= "true";
				$return['message'] 		= "Login Successful.";
				$return['data'] 		= $userData;	
				$return['error'] 		= "";
				
				//print_r($return); die;
				return $this->respond($return);
			} else {
				$return['success'] 		= "false";
				$return['message'] 		= "Invalid Login Credentials";
				$return['error'] 		= "";
				$return['data'] 		= "";			
				
				return $this->respond($return);
			}		
	} else
			{
				$return['success'] 		= "false";
				$return['message'] 		= "Please fill all the fields!";
				$return['error'] 		= json_encode($validate);
				$return['data'] 		= "";			
				
				return $this->respond($return);
			}
			
		
	}
	
	public function register() {
	
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
		$_POST 			= $postData;
		
		$validate = validate_register($postData);
		
			
			if($validate)
			{
				
				$return['success'] 		= "false";
				$return['message'] 		= "Please fill all fields";
				$return['error'] 		= json_encode($validate);
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
			$updateArr['password'] = md5($password);
		
			
			//echo $user_id;
			
			
			
			
			$update = $model->saveUser($updateArr);
			
			if($update)
			{
				$devicemodel = new DeviceModel();
				
				$device_info = array(
				'user_id' => $update,
				 'device_id' => $_POST['device_id'],
				 'device' => $_POST['device'],
				 'fcm_key' => $_POST['fcm_key']
				);
				$inserted = $devicemodel->save_user_device_info($device_info);
				
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
	
	public function logout() {
		$LiminaltokenlibObj 	= new Liminaltokenlib();
		//$LiminaltokenlibObj->validateToken('logout');
		$postdata 		= json_decode( file_get_contents('php://input'),true);
		
		if( count($postdata) == 0 )
		{
			$return['success'] 		= "false";
			
			$return['message'] 		= "Invalid data format";
			$return['error'] 		= "";
			$return['data'] 		= "";

			return $this->respond($return);
		}
		
		$_POST 			= $postdata;
		$validate = validate_userId($postdata['user_id']);
		
		if (empty($validate)) {
			$model = new UserModel();
			$userdata = $model->getuserDetail($postdata['user_id']);
			//echo "<pre>";print_r($userdata);exit;
			if(!empty($userdata->ID)) {
				
					
						$return['success'] 		= "true";
						
						$return['message'] 		= "Logout Successfully.";
						$return['error'] 		= "";
						$return['data'] 		= "";
						return $this->respond($return);
					
				
			} else {
				
				
				$return['success'] 		= "false";
				$return['message'] 		= "Invalid User";
				$return['error'] 		=  "";
				$return['data'] 		= "";			
				
				return $this->respond($return);
			}
			
			
		} else {
			
				$return['success'] 		= "false";
				$return['message'] 		= $validate['user_id'];
				$return['error'] 		= json_encode($validate);
				$return['data'] 		= "";			
				
				return $this->respond($return);
		}
	}
	
	
	public function get_profile($user_id){
		$LiminaltokenlibObj 	= new Liminaltokenlib();
		//$LiminaltokenlibObj->validateToken();
		$validate = validate_userId($user_id);
		
		if (empty($validate)) {
			$model = new UserModel();
			$userdata = $model->getuserDetail($user_id);
			//echo "<pre>";print_r($userdata);exit;
			if(!empty($userdata->ID)) {
				
					
						$return['success'] 		= "true";
						$return['message'] 		= "Data Found";
						$return['error'] 		= "";
						$return['data'] 		= $userdata;
						return $this->respond($return);
					
				
			} else {
				
				
				$return['success'] 		= "false";
				$return['message'] 		= "Invalid User";
				$return['error'] 		=  "";
				$return['data'] 		= "";			
				
				return $this->respond($return);
			}
			
			
		} else {
			
				$return['success'] 		= "false";
				$return['message'] 		= $validate['user_id'];
				$return['error'] 		= json_encode($validate);
				$return['data'] 		= "";			
				
				return $this->respond($return);
		}
	}
	
	public function update_profile(){
		$LiminaltokenlibObj 	= new Liminaltokenlib();
		//$LiminaltokenlibObj->validateToken();
		$postdata = "";
		if (isset($_POST))
        {
            $postdata = $_POST;
        }
		
		if(empty($postdata))
		{
			$return['success'] 		= "false";
			
			$return['message'] 		= "Invalid data format";
			$return['error'] 		= "";
			$return['data'] 		= "";

			return $this->respond($return);
		}
		
		
		
		$validate = validate_update_profile($postdata);
		
		if (empty($validate)) {
			$model = new UserModel();
			$userdata = $model->getuserDetail($postdata['user_id']);
			
			if(!empty($userdata->ID)) {
				$profilepic = $userdata->profilepic;
				
				if(!empty($_FILES['profile_pic']['name']) && ($_FILES['profile_pic']['error'] == 0)) {
					$file = $this->request->getFile('profile_pic');
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
							$this->respond($return);
						}
						else
						{
							
							$profilepic = $newName;
							
						}
					} else {
						$return['success'] 		= "false";
						$return['message'] 		= "Please select only image";
						$return['error='] 		= "Please select only image";
						$return['data'] 		 ="";			
						return $this->respond($return);
					}
				}
				$updateArr = array(
					
					'first_name'=> $postdata['first_name'],
					'last_name' => $postdata['last_name'],
					'phone' 	=> $postdata['phone'],
					'address' 	=> $postdata['address'],
					'state' 	=> $postdata['state'],
					'city' 		=> $postdata['city'],
					'zip' 		=> $postdata['zip'],
					'bio' 		=> $postdata['bio'],
					'profilepic' => $profilepic
				);
				$postdata['profilepic'] = $profilepic;
				$model = new UserModel();
			$update = $model->updateUser($updateArr, $postdata['user_id']);

			if($update) {
					
						$return['success'] 		= "true";
						$return['message'] 		= "Profile Updated Successfully";
						$return['error'] 		= "";
						$return['data'] 		= $postdata;
						return $this->respond($return);
					
			} else {
				$return['success'] 		= "false";
				$return['message'] 		= "Something Went Wrong. Please Try Again";
				$return['error'] 		=  "";
				$return['data'] 		= "";			
				
				return $this->respond($return);
			}	
			} else {
				
				
				$return['success'] 		= "false";
				$return['message'] 		= "Invalid User";
				$return['error'] 		=  "";
				$return['data'] 		= "";			
				
				return $this->respond($return);
			}
			
			
		} else {
			
				$return['success'] 		= "false";
				$return['message'] 		= "Please fill all fields!";
				$return['error'] 		= json_encode($validate);
				$return['data'] 		= "";			
				
				return $this->respond($return);
		}
	}
	
	public function change_password() {
		$LiminaltokenlibObj 	= new Liminaltokenlib();
		//$LiminaltokenlibObj->validateToken();
		$postdata 		= json_decode( file_get_contents('php://input'),true);
		
		if( count($postdata) == 0 )
		{
			$return['success'] 		= "false";
			
			$return['message'] 		= "Invalid data format";
			$return['error'] 		= "";
			$return['data'] 		= "";

			return $this->respond($return);
		}
		
		$_POST 			= $postdata;
		$validate = validate_change_password($postdata);
		if (empty($validate)) {
			$model = new UserModel();
			$userdata = $model->getuserDetail($postdata['user_id']);
			
			if(!empty($userdata->ID)) {
				$updateArr['password'] = md5($postdata['password']);
				$model = new UserModel();
			$update = $model->updateUser($updateArr, $postdata['user_id']);

			if($update) {
					
						$return['success'] 		= "true";
						
						$return['message'] 		= "Password changed successfully!";
						$return['error'] 		= "";
						$return['data'] 		= "";
						return $this->respond($return);
					
			} else {
						$return['success'] 		= "false";
						$return['message'] 		= "Something went wrong. Please try again!";
						$return['error'] 		= "";
						$return['data'] 		= "";
						return $this->respond($return);
			}
			} else {
				
				
				$return['success'] 		= "false";
				$return['message'] 		= "Invalid User";
				$return['error'] 		=  "";
				$return['data'] 		= "";			
				
				return $this->respond($return);
			}
			
			
		} else {
			
				$return['success'] 		= "false";
				$return['message'] 		= "Please fill all fields";
				$return['error'] 		= json_encode($validate);
				$return['data'] 		= "";			
				
				return $this->respond($return);
		}
	}
	
	public function forget_password() {
	
			$postdata 		= json_decode( file_get_contents('php://input'),true);
		
		if( count($postdata) == 0 )
		{
			$return['success'] 		= "false";
			
			$return['message'] 		= "Invalid data format";
			$return['error'] 		= "";
			$return['data'] 		= "";

			return $this->respond($return);
		}
		
		$_POST 			= $postdata;
		if(empty($postdata['email'])) {
			$return['success'] 		= "false";
			
			$return['message'] 		= "Email is required";
			$return['error'] 		= "";
			$return['data'] 		= "";

			return $this->respond($return);
			
		} else if(!email_validation($postdata['email'])) {
			
			$return['success'] 		= "false";
			
			$return['message'] 		= "Email is not valid";
			$return['error'] 		= "";
			$return['data'] 		= "";

			return $this->respond($return);
			
		} else {
			
			$model = new LoginModel();
			$userData = $model->getPassword($postdata['email']);
			
			if(!empty($userData->ID)) {
				$now = date('Y-m-d H:i:s');
				
				$unserialized_token_array = array(
							'user_id' => $userData->ID,
							'insert_date' => $now,
							'email' => $userData->email
						);
				
				$serialize_token = serialize($unserialized_token_array);
				$access_token = encrypt($serialize_token);
				
				$usermodel = new UserModel();
				
		$update_arr = array(
				 'access_token' => $access_token
				);
			$update = $usermodel->updateUser($update_arr, $userData->ID);
			
				
				
			if($update) {
				$view = \Config\Services::renderer();
				$viewdata = array(
				   'url' => base_url('reset_password?access_token='.$access_token)
				);
					$maildata = array(
					  'to' => $postdata['email'],
					  'subject' => 'Reset Password Link',
					  'message' => $view->setData($viewdata)->render('email/forget_password')
					);
					
					if(send_mail($maildata)) {
					
						$return['success'] 		= "true";
						$return['message'] 		= "A Reset password link has been sent to you on email.";
						$return['error'] 		= "";
						$return['data'] 		= "";
						return $this->respond($return);
					} else {
						$return['success'] 		= "false";
						$return['message'] 		= "Mail does not send";
						$return['error'] 		= "";
						$return['data'] 		= "";
						return $this->respond($return);
					}
			} else {
				$return['success'] 		= "false";
				$return['message'] 		= "Something Went Wrong. Please Try Again";
				$return['error'] 		=  "";
				$return['data'] 		= "";			
				
				return $this->respond($return);
			}
				
			} else {
				$return['success'] 		= "false";
			
				$return['message'] 		= "This Email is not registered";
				$return['error'] 		= "";
				$return['data'] 		= "";

				return $this->respond($return);
			}
			
		}
		
		
	}
	
	public function get_user_health_info($user_id) {
		
		$validate = validate_userId($user_id);
		 if(empty($validate))
            {
			
			$model = new UserModel();
			$userdetail = $model->getuserDetail($user_id);
			if(!empty($userdetail)) {
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
	
	
	public function get_users_upcoming_event($user_id) {
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
				$users_upcoming_event = $model->get_user_upcoming_events($user_id);
				$allupcomingevents = $model->get_user_upcoming_events($user_id, $event_cat="", $type="", $orderby="", $keyword="", $skill="", $start, $limit);
				
				 foreach($allupcomingevents as $key=>$upcomingevents) {
					 
						$upcomingevents->title = $upcomingevents->title ? $upcomingevents->title : $upcomingevents->event_typename;
					
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
				
				$total_page = ceil(count($users_upcoming_event)/$limit);
				//echo "<pre>";print_r($allupcomingevents);exit;
				if($allupcomingevents) {
						$return['success'] 		= "true";
						$return['message'] 		= "Get All Upcoming Events.";
						$return['data'] 		= $allupcomingevents;
						$return['page_count'] 	= $total_page;						
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
				$return['message'] 		= "Invalid user";
				$return['error'] 		= "";
				$return['data'] 		= "";			
				return $this->respond($return);
			}	
			} else {
				$return['success'] 		= "false";
				$return['message'] 		= "Invalid user";
				$return['error'] 		= "";
				$return['data'] 		= "";			
				return $this->respond($return);
				
			}
	}
	
	public function get_training_staffing_event($user_id) {
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
			$allskillsevent    = $model->get_skills_requirement_events($user_id);
			$skillsevent    = $model->get_skills_requirement_events($user_id, $event_cat="", $type="", $orderby="", $keyword="", $skill="", $start, $limit);
			$total_page = ceil(count($allskillsevent)/$limit);
			
			foreach($skillsevent as $skill_event){
				
					$skill_event->title = $skill_event->title ? $skill_event->title : $skill_event->event_typename;
					
			}
			
			
			if($skillsevent)
			{
				$return['success'] 		= "true";
				$return['message'] 		= "Get training and staffing events.";
				$return['page_count'] 	= $total_page;
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
				$return['message'] 		= "Invalid User";
				$return['error'] 		= "";
				$return['data'] 		= "";			
				return $this->respond($return);
			}			
		} else {
				$return['success'] 		= "false";
				$return['message'] 		= "Invalid user";
				$return['error'] 		= "";
				$return['data'] 		= "";			
				return $this->respond($return);
		}	
	}
	
	public function get_users_reconnect_events($user_id) {
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
					
					$allreconnectevents = array();
					$model = new EventModel();
					$allevents = $model->get_registered_events_by_user($user_id);
					
					$userevents = array();
					foreach($allevents as $pastevents){
						$userevents[] = $pastevents->id;
						
						
					}
					
					$allparticipants = $model->get_all_participants_by_events($userevents, $user_id);
					$eventparticipants = array();
					foreach($allparticipants as $particpants) {
						
						$eventparticipants[] =  $particpants->ID;
						
					}
					
					$events = array();
					$allevents = array();
					$total_page = 0;
					if(!empty($eventparticipants)) { 
					$allevents = $model->get_partcipate_users_registered_event($userevents, $eventparticipants);
					$events = $model->get_partcipate_users_registered_event($userevents, $eventparticipants, $event_cat="", $type="", $orderby="", $keyword="", $skill="", $start, $limit);
					
					$total_page = ceil(count($allevents)/$limit);
					
					foreach($events as $event){
				
						$event->title = $event->title ? $event->title : $event->event_typename;
					
					}
			
					
					}
					
					if($events) {
						$return['success'] 		= "true";
						$return['message'] 		= "Data Found";
						$return['error'] 		= "";
						$return['page_count'] 	= $total_page;
						$return['data'] 		= $events;			
						return $this->respond($return);
					} else {
						$return['success'] 		= "false";
						$return['message'] 		= "Not Found";
						$return['error'] 		= "";
						$return['data'] 		= "";			
						return $this->respond($return);
					}
				
				}else {
					$return['success'] 		= "false";
					$return['message'] 		= "Invalid user!";
					$return['error'] 		= "";
					$return['data'] 		= "";			
					return $this->respond($return);
				}
			} else {
				
				$return['success'] 		= "false";
				$return['message'] 		= "Invalid user!";
				$return['error'] 		= "";
				$return['data'] 		= "";			
				return $this->respond($return);
				
			}
	}
	
	public function get_users_event($user_id){
		$LiminaltokenlibObj 	= new Liminaltokenlib();
		//$LiminaltokenlibObj->validateToken();
		$validate = validate_userId($user_id);
		 if(empty($validate))
            {
				$usermodel = new UserModel();
			$userdetail = $usermodel->getuserDetail($user_id);
			
				if(!empty($userdetail)) {
					$myevents = array();
					$model = new EventModel();
					$limit = MY_EVENT_LIMIT;
				$users_upcoming_event = $model->get_user_upcoming_events($user_id);
				$allupcomingevents = $model->get_user_upcoming_events($user_id, $event_cat="", $type="", $orderby="", $keyword="", $skill="", $start= 0, $limit);
				 foreach($allupcomingevents as $key=>$upcomingevents) {
					 
					 $upcomingevents->title = $upcomingevents->title ? $upcomingevents->title : $upcomingevents->event_typename;
					 
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
				
				$allskillsevent    = $model->get_skills_requirement_events($user_id);
				$skillsevent    = $model->get_skills_requirement_events($user_id, $event_cat="", $type="", $orderby="", $keyword="", $skill="", $start= 0, $limit);
				
				foreach($skillsevent as $skill_event){
				
					$skill_event->title = $skill_event->title ? $skill_event->title : $skill_event->event_typename;
					
				}
				
				$allevents = $model->get_registered_events_by_user($user_id);
					
					$userevents = array();
					foreach($allevents as $pastevents){
						$userevents[] = $pastevents->id;
						
						
					}
					
					$allparticipants = $model->get_all_participants_by_events($userevents, $user_id);
					$eventparticipants = array();
					foreach($allparticipants as $particpants) {
						
						$eventparticipants[] =  $particpants->ID;
						
					}
					$events = array();
					$allevents = array();
					if(!empty($eventparticipants)) { 
						$allevents = $model->get_partcipate_users_registered_event($userevents, $eventparticipants);
						$events = $model->get_partcipate_users_registered_event($userevents, $eventparticipants, $event_cat="", $type="", $orderby="", $keyword="", $skill="", $start= 0, $limit);
						foreach($events as $event){
					
							$event->title = $event->title ? $event->title : $event->event_typename;
						
						}
						
					}
				$myevents['upcoming_events']['events'] = $allupcomingevents;
				$myevents['upcoming_events']['view_more_btn'] = 0;
				if(count($users_upcoming_event) > 3) {
					$myevents['upcoming_events']['view_more_btn'] = 1;
				}
				$myevents['training_staffing']['events'] = $skillsevent;
				
				
				$myevents['training_staffing']['view_more_btn'] = 0;
				if(count($allskillsevent) > 3) {
					$myevents['training_staffing']['view_more_btn'] = 1;
				}
				
				$myevents['reconnect_events']['events'] = $events;
				$myevents['reconnect_events']['view_more_btn'] = 0;
				if(count($allevents) > 3) {
					$myevents['reconnect_events']['view_more_btn'] = 1;
				}
				
				if($myevents) {
						$return['success'] 		= "true";
						$return['message'] 		= "Get All Events.";
						$return['data'] 		= $myevents;	
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
				$return['message'] 		= "Invalid user!";
				$return['error'] 		= "";
				$return['data'] 		= "";			
				return $this->respond($return);
				
				}
			} else {
				
				$return['success'] 		= "false";
				$return['message'] 		= "Invalid user!";
				$return['error'] 		= "";
				$return['data'] 		= "";			
				return $this->respond($return);
				
			}
		}
		
		public function get_users_group($user_id) {
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
				$model = new GroupModel();
				$Alldata    = $model->get_users_join_group($user_id, $start, $limit);
				
				foreach($Alldata as $key=>$group) {
					$Alldata[$key]->location = "Meet at ".$group->location;
				}
				
				$totalgroup = $model->get_users_join_group($user_id);
				$total_page = ceil(count($totalgroup)/$limit);
				if($Alldata)
				{
					$return['success'] 		= "true";
					$return['message'] 		= "Get All Group list.";
					$return['page_count'] 		= $total_page;	
					$return['data'] 		= $Alldata;	
					$return['error'] 		= $this->error;
					
					return $this->respond($return);
				}
				
				else
				{
					$return['success'] 		= "false";
					$return['message'] 		= "groups not found.";
					$return['error'] 		= "";
					$return['data'] 		= "";			
					
					return $this->respond($return);
				}	
			
			} else {
				$return['success'] 		= "false";
				$return['message'] 		= "Invalid user";
				$return['error'] 		= "";
				$return['data'] 		= "";			
				return $this->respond($return);
			}	
			} else {
				$return['success'] 		= "false";
				$return['message'] 		= "Invalid user";
				$return['error'] 		= "";
				$return['data'] 		= "";			
				return $this->respond($return);
				
			}
	}
	
	  public function testPaypal_post()
    {
        //$this->load->library('paypal');
        //$this->load->library('paypal');
        $postdata = json_decode(file_get_contents('php://input'), true);

        //print_r($postdata); die;
        if (count($postdata) == 0)
        {
            $return['success'] = "false";
            $return['title'] = "error";
            $return['message'] = "Invalid data format";
            $return['error'] = (object) $this->error;
            $return['data'] = (object) $this->data;

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }

        $_POST = $postdata;
       
        $ammount =  $postdata['amount'];
        $card_type =  $postdata['card_type'];
        $card_number =  $postdata['card_number'];
        $card_expire_month =  $postdata['card_expire_month'];
        $card_expire_year =  $postdata['card_expire_year'];
        $card_cvv =  $postdata['card_cvv'];

        //print_r($postdata) ; die;
        /* validate card */
			$Paypalobj = 	new Paypal();	
        $vaildatecard = $Paypalobj->validateCCard($card_number);
        // print_r($vaildatecard); die;

        if (!$vaildatecard)
        {
            $return['success'] = "false";
            $return['title'] = "error";
            $return['message'] = "Card is not valid.";
            $return['error'] = $this->error;
            $return['data'] = $this->data;

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }

        /* validate credit card type */

        $creditcardtype = $Paypalobj->credit_card_type($card_number);
        // print_r($creditcardtype); die;

        if (strtolower($creditcardtype) != strtolower($card_type))
        {
            $return['success'] = "false";
            $return['title'] = "error";
            $return['message'] = "Card type is not valid.";
            $return['error'] = $this->error;
            $return['data'] = $this->data;

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }

        /* validate credit card cvv */
        // echo "Hello"; die;
        $validatecvv = $Paypalobj->validateCVV($card_number, $card_cvv);
        //print_r($validatecvv); die;
        if (!$validatecvv)
        {
            $return['success'] = "false";
            $return['title'] = "error";
            $return['message'] = "CVV is not valid.";
            $return['error'] = $this->error;
            $return['data'] = $this->data;

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }

        /* create paypal payment */

        $getPayPalAccessToken = $Paypalobj->getPayPalAccessToken();
        // echo $getPayPalAccessToken; die;
        if (!$getPayPalAccessToken)
        {
            $return['success'] = "false";
            $return['title'] = "error";
            $return['message'] = "Something went wrong in getting token from paypal.";
            $return['error'] = $this->error;
            $return['data'] = $this->data;

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }

        $paypalurl = $paypal_sandbox_payment_url = "https://api.sandbox.paypal.com/v1/payments/payment";

        $paypalTotal = (isset($ammount)) ? $ammount : 0.00;
        //$paypalTotal 		= 0.00;
        $paypalCurrency = 'USD';

        $paypaljsondata = '{
				"intent": "sale",
				"payer": {
				"payment_method": "credit_card",
				"funding_instruments": [{
									"credit_card": {
										"number": "' . $card_number . '",
										"type": "' . $card_type . '",
										"expire_month": "' . $card_expire_month . '",
										"expire_year": "' . $card_expire_year . '",
										"cvv2": "' . $card_cvv . '"	
									}
								}]
				},
				
				"transactions": [{
				"amount": {
				"total": "' . $paypalTotal . '",
				"currency": "' . $paypalCurrency . '"
				}
				}]
			}';


        /* do payment */



        $resultArray = $Paypalobj->pay($paypalurl, $paypaljsondata, $getPayPalAccessToken);
        print_r($resultArray);
        die;


        if ($result === false)
        {
            $this->error = "$result";
            $return['success'] = "false";
            $return['title'] = "error";
            $return['message'] = "Something went wrong.";
            $return['error'] = $this->error;
            $return['data'] = $this->data;

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }

		


        /* paypal error handle */
        if ($httpcode === 201)
        {
            if (empty($json))
            {
                $this->error = "$result";
                $return['success'] = "false";
                $return['title'] = "error";
                $return['message'] = "Something went wrong.";
                $return['error'] = $this->error;
                $return['data'] = $this->data;

                $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
            }

            $paymentResponse = $json;

            /* payment response variables */

            $payment_id = $paymentResponse->id;
            $payment_create_time = $paymentResponse->create_time;
            $payment_update_time = $paymentResponse->update_time;
            $payment_state = $paymentResponse->state;

            $payment_payer_payment_method = $paymentResponse->payer->payment_method;
            $payment_payer_funding_instruments = $paymentResponse->payer->funding_instruments;

            if (!$paymentResponse->transactions)
            {

                $return['success'] = "false";
                $return['title'] = "error";
                $return['message'] = "Something went wrong in getting transaction details from paypal.";
                $return['error'] = $this->error;
                $return['data'] = $this->data;

                $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
            }

            $payment_transactions_id = (isset($paymentResponse->transactions[0]->related_resources[0]->sale->id)) ? $paymentResponse->transactions[0]->related_resources[0]->sale->id : '';

            if (!$payment_transactions_id)
            {
                $return['success'] = "false";
                $return['title'] = "error";
                $return['message'] = "Something went wrong in getting transaction id from paypal.";
                $return['error'] = $this->error;
                $return['data'] = $this->data;

                $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
            }



            /* Add in wallet here */

            $userID = $this->user_id;
            $user_transaction_amount = $paypalTotal;
            $user_curr_running_record = $this->getUserAccMaxRunRec($userID);
            $user_next_running_record = $user_curr_running_record + 1;
            $user_date = date('Y-m-d H:i:s');
            $user_available_balance = 0;

            $user_through = 'system';

            /* get max run record of cusomter */
            $getCustomerAccMaxRunRecRow = $this->wallet_model->getCustomerAccMaxRunRecRow($userID, $user_curr_running_record);

            if ($getCustomerAccMaxRunRecRow)
            {
                $user_available_balance = $getCustomerAccMaxRunRecRow->total_balance + $user_transaction_amount;
            } else
            {
                $user_available_balance = $user_transaction_amount;
            }

            //$user_curr_available_balance 	= ($getCustomerAccMaxRunRecRow->available_balance) ? $getCustomerAccMaxRunRecRow->available_balance : $user_transaction_amount;

            $user_transaction_reference = $payment_transactions_id;
            $user_transaction_type = 'credit';

            $adminAccountNo = 1;
            $admin_transaction_amount = $paypalTotal;
            $admin_curr_running_record = $this->getAdminCropAccMaxRunRec();
            $admin_next_running_record = $admin_curr_running_record + 1;
            $admin_date = date('Y-m-d H:i:s');
            $admin_available_balance = 0;

            /* get max run record of admin */
            $getAdminCropAccMaxRunRecRow = $this->wallet_model->getAdminCropAccMaxRunRecRow(1, $admin_curr_running_record);

            if ($getAdminCropAccMaxRunRecRow)
            {
                $admin_available_balance = $getAdminCropAccMaxRunRecRow->total_balance - $admin_transaction_amount;
            }

            //$admin_curr_available_balance 	= ($getCustomerAccMaxRunRecRow->available_balance) ? $getCustomerAccMaxRunRecRow->available_balance : 10000;
            $admin_through = 'system';

            $admin_transaction_reference = $payment_transactions_id;
            $admin_transaction_type = 'debit';

            $this->db->trans_start();

            //$this->db->query('INSERT INTO customer_wallet (account_no, transaction_amount, available_balance, running_record, date, transaction_reference, transaction_type, through) VALUES ("'.$userAccountNo.'", "'.$user_transaction_amount.'", "'.$user_available_balance.'", "'.$user_next_running_record.'", "'.$user_date.'", "'.$user_transaction_reference.'", "'.$user_transaction_type.'", "'.$user_through.'")');

            $customer_wallet_array = array(
                'user_id' => $this->user_id,
                'ammount' => $user_transaction_amount,
                'total_balance' => $user_available_balance,
                'running_record' => $user_next_running_record,
                'date' => $user_date,
                'reference_no' => $user_transaction_reference,
                'transaction_type' => $user_transaction_type,
                'through' => $user_through,
            );

            $this->db->insert('customer_wallet', $customer_wallet_array);
            $customer_wallet_id = $this->db->insert_id();

            //echo $this->db->last_query().'<br/>'; //die;
            $admin_wallet_array = array(
                'transaction_id' => 0,
                'user_id' => 1,
                'ammount' => $admin_transaction_amount,
                'total_balance' => $admin_available_balance,
                'running_record' => $admin_next_running_record,
                'date' => $admin_date,
                'reference_no' => $admin_transaction_reference,
                'transaction_type' => $admin_transaction_type,
                'through' => $admin_through,
            );

            $this->db->insert('customer_wallet', $admin_wallet_array);
            $admin_wallet_id = $this->db->insert_id();

            //$this->db->query('INSERT INTO customer_wallet (account_no, transaction_amount, available_balance, running_record, date, transaction_reference, transaction_type, through) VALUES ("'.$adminAccountNo.'", "'.$admin_transaction_amount.'", "'.$admin_available_balance.'", "'.$admin_next_running_record.'", "'.$admin_date.'", "'.$admin_transaction_reference.'", "'.$admin_transaction_type.'", "'.$admin_through.'")');
            //echo $this->db->last_query(); //die;

            /* save the paypal transaction  */

            $wallet_paypal_tranasction = array(
                'wallet_id' => $customer_wallet_id,
                'token' => $getPayPalAccessToken,
                'txn_id' => $payment_transactions_id,
                'parent_txn_id' => NULL,
                'txn_type' => 'capture',
                'is_closed' => '1',
                'additional_information' => serialize($paymentResponse),
                'created_at' => date('Y-m-d H:i:s'),
            );

            $this->db->insert('customer_wallet_paypal_transaction', $wallet_paypal_tranasction);
            $wallet_paypal_tranasction_id = $this->db->insert_id();

            $this->db->trans_complete();
            //var_dump($this->db->trans_status());
            //die;


            if ($this->db->trans_status() === TRUE)
            {
                /* update wallet rows */

                $this->db->where_in('id', array($customer_wallet_id, $admin_wallet_id));
                $this->db->update('customer_wallet', array('transaction_id' => $wallet_paypal_tranasction_id));

                $return['success'] = "true";
                $return['message'] = "Money has been successfully added in wallet.";
                $return['error'] = $this->error;
                $return['data'] = (object) $this->data;

                $this->response($return, REST_Controller::HTTP_OK);
            }

            $return['success'] = "false";
            $return['message'] = "Something went wrong.";
            $return['error'] = $this->error;
            $return['data'] = (object) $this->data;

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        } elseif ($httpcode === 400)
        {
            $this->error = $json;
            $return['success'] = "false";
            $return['title'] = "error";
            //$return['message'] 		= "CODE: $httpcode, Request is not well-formed, syntactically incorrect, or violates schema.";
            $return['message'] = "CODE: $httpcode, Please provide valid card details.";
            $return['error'] = $this->error;
            $return['data'] = $this->data;

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        } elseif ($httpcode === 401)
        {
            $return['success'] = "false";
            $return['title'] = "error";
            $return['message'] = "CODE: $httpcode, Authentication failed due to invalid authentication credentials.";
            $return['error'] = $this->error;
            $return['data'] = $this->data;

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        } elseif ($httpcode === 403)
        {
            $return['success'] = "false";
            $return['title'] = "error";
            $return['message'] = "CODE: $httpcode, Authorization failed due to insufficient permissions.";
            $return['error'] = $this->error;
            $return['data'] = $this->data;

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        } elseif ($httpcode === 404)
        {
            $return['success'] = "false";
            $return['title'] = "error";
            $return['message'] = "CODE: $httpcode, The specified resource does not exist.";
            $return['error'] = $this->error;
            $return['data'] = $this->data;

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        } elseif ($httpcode === 405)
        {
            $return['success'] = "false";
            $return['title'] = "error";
            $return['message'] = "CODE: $httpcode, The server does not implement the requested HTTP method.";
            $return['error'] = $this->error;
            $return['data'] = $this->data;

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        } elseif ($httpcode === 406)
        {
            $return['success'] = "false";
            $return['title'] = "error";
            $return['message'] = "CODE: $httpcode, The server does not implement the media type that would be acceptable to the client.";
            $return['error'] = $this->error;
            $return['data'] = $this->data;

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        } elseif ($httpcode === 415)
        {
            $return['success'] = "false";
            $return['title'] = "error";
            $return['message'] = "CODE: $httpcode, The server does not support the request payload’s media type.";
            $return['error'] = $this->error;
            $return['data'] = $this->data;

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        } elseif ($httpcode === 422)
        {
            $return['success'] = "false";
            $return['title'] = "error";
            $return['message'] = "CODE: $httpcode, The API cannot complete the requested action, or the request action is semantically incorrect or fails business validation.";
            $return['error'] = $this->error;
            $return['data'] = $this->data;

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        } elseif ($httpcode === 429)
        {
            $return['success'] = "false";
            $return['title'] = "error";
            $return['message'] = "CODE: $httpcode, Too many requests. Blocked due to rate limiting.";
            $return['error'] = $this->error;
            $return['data'] = $this->data;

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        } elseif ($httpcode === 500)
        {
            $return['success'] = "false";
            $return['title'] = "error";
            $return['message'] = "CODE: $httpcode, An internal server error has occurred.";
            $return['error'] = $this->error;
            $return['data'] = $this->data;

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        } elseif ($httpcode === 503)
        {
            $return['success'] = "false";
            $return['title'] = "error";
            $return['message'] = "CODE: $httpcode, Service Unavailable..";
            $return['error'] = $this->error;
            $return['data'] = $this->data;

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        } else
        {
            $return['success'] = "false";
            $return['title'] = "error";
            $return['message'] = "CODE: $httpcode, Something went wrong.";
            $return['error'] = $this->error;
            $return['data'] = $this->data;

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }
	
	
	
	
	
	
}
