<?php namespace App\Controllers\APi;
use App\Models\GroupModel;
use App\Models\EventModel;
use CodeIgniter\RESTful\ResourceController;

class Group extends ResourceController
{ 

    

    public function __construct()
    {
        helper(['common','validation']);
		
    }


   public function getAllGroups() 
		{
			
			$model = new GroupModel();
			$Alldata    = $model->getAlldata();
			
			if($Alldata)
			{
				$return['success'] 		= "true";
				$return['message'] 		= "Get All Group list.";
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
		}
	
		public function updateGroup() 
		{
			$session = \Config\Services::session();
			helper('form');
			$postData = json_decode(file_get_contents('php://input'), true);
			if($postData == '')
			{
				$postData = $_POST;
				
				
			}
			//echo "<pre>";print_r($postData);exit;
			$groupvalidate=true;
			$group_id=$_POST['group_id'];
			if($group_id == "") {
				$groupvalidate=$this->validate([
						'group_name' => 'trim|required|is_unique[li_groups.group_name]',
						'community'  => 'trim|required',
						'description'  => 'trim|required',
						
				]); 
			} else {
				$groupvalidate=$this->validate([
						'group_name' => 'trim|required',
						'community'  => 'trim|required',
						'description'  => 'trim|required',
						
				]); 
			}
			
			if(!$groupvalidate)
			{
				
				$return['success'] 		= "false";
				$return['message'] 		= \Config\Services::validation()->listErrors();
				$return['error'] 		= \Config\Services::validation()->listErrors();
				$return['data'] 		="";			
				
				return $this->respond($return);
			}
			
			$updateArr 		= array(
			'community' 	=> $_POST['community'],
			'group_name' 	=> $_POST['group_name'],
			'group_description' 	=> $_POST['description'],
			'group_email' 	=> $_POST['group_name'].'@liminalwork.com',
			
			); 
			//echo "<pre>";print_r($updateArr);exit;
			$model = new GroupModel();
			
			if($group_id!=""){
					
			$update = $model->updateData($updateArr, $group_id);
			} else { 
			
			$update = $model->saveData($updateArr);
			} 
			if($update)
			{
				$return['success'] 		= "true";
				$return['message'] 		= "Group successfully updated/created.";
				$return['error'] 		= "";
				$return['data'] 		= "";			
				
				return $this->respond($return);
			}
			else
			{
				
				$return['success'] 		= "false";
				$return['message'] 		= "Group is not update. Something went wrong.";
				$return['error'] 		= "";
				$return['data'] 		= "";			
				return $this->respond($return);
			}
		}
		
		public function groupDetail() {
			$postData = json_decode( file_get_contents('php://input'),true);
			$group_id = $postData['id'];  
			$model = new GroupModel();
			$group    = $model->getgroupDetail($group_id);
			if($group)
			{
				$return['success'] 		= "true";
				$return['message'] 		= "Get Group Details.";
				$return['data'] 		= $group;	
				$return['error'] 		= "";
				
				return $this->respond($return);
			}
			
			else
			{
				$return['success'] 		= "false";
				$return['message'] 		= "Group Detail not found.";
				$return['error'] 		= "";
				$return['data'] 		= "";			
				
				return $this->respond($return);
			}	
		}
		
		
		public function deleteGroup() {
			$session = \Config\Services::session();
		$postData = json_decode(file_get_contents('php://input'), true);
			if($postData == '')
			{
				$postData = $_POST;
				
				
			}
			
			$group_id = $postData['group_id'];
			$deleted_by = $session->get('user_data')->ID;
			$model = new GroupModel();
			$update = $model->deleteGroup($group_id, $deleted_by);
			if($update)
			{
				$return['success'] 		= "true";
				$return['message'] 		= "Group successfully deleted.";
				$return['error'] 		= "";
				$return['data'] 		= "";			
				
				return $this->respond($return);
			}
			else
			{
				
				$return['success'] 		= "false";
				$return['message'] 		= "Group is not delete. Something went wrong.";
				$return['error'] 		= "";
				$return['data'] 		= "";			
				return $this->respond($return);
			}
	}
	
	 public function updateGroupEvent() 
		{
			$session = \Config\Services::session();
			helper('form');
			$postData = json_decode(file_get_contents('php://input'), true);
			if($postData == '')
			{
				$postData = $_POST;
				
				
			}
			//echo "<pre>";print_r($_POST);exit;
			$uservalidate=true;
			$event_id=$_POST['event_id'];
			$group_id=$_POST['group_id'];
			
			if(empty($group_id)) {
				$uservalidate=$this->validate([
						'event_community' => 'trim|required',
						'event_category'  => 'trim|required',
						'event_type'  => 'trim|required',
						'group_name'  => 'trim|required|is_unique[li_groups.group_name]',
						'skill_requirement'  => 'trim|required',
						'skill_earned'  => 'trim|required',
						'start_date' => 'required|valid_date[Y-m-d]',
						'start_time' => 'required',
						'location'   => 'required',
				]);
			} else {
				$uservalidate=$this->validate([
						'event_community' => 'trim|required',
						'event_category'  => 'trim|required',
						'event_type'  => 'trim|required',
						'group_name'  => 'trim|required',
						'skill_requirement'  => 'trim|required',
						'skill_earned'  => 'trim|required',
						'start_date' => 'required|valid_date[Y-m-d]',
						'start_time' => 'required',
						'location'   => 'required',
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
			
			if($_POST['cost'] < $_POST['min_deposit']) {
				$return['success'] 		= "false";
				$return['message'] 		= "Group Event Cost should not be less than minimum deposite.";
				$return['error'] 		= "Group Event Cost should not be less than minimum deposite.";
				$return['data'] 		= "";			
				
				return $this->respond($return);
			}
			$model = new GroupModel();
			if(!empty($group_id)) {
				
				$checkGroup = $model->checkUniqueGroupName($_POST['group_name'], $group_id);
				if(!empty($checkGroup)) {
					$return['success'] 		= "false";
					$return['message'] 		= "Group Name should be unique";
					$return['error'] 		= "Group Name should be unique";
					$return['data'] 		="";			
					
					return $this->respond($return);
				}
				
			}
			$group_arr = array(
			'community' 	=> $_POST['event_community'],
			'group_name' 	=> $_POST['group_name'],
			'group_description' 	=> $_POST['details'],
			'group_email' 	=> preg_replace('/\s+/', '', $_POST['group_name']).'@liminalwork.com',
			);
			
			
			if($group_id!=""){
					
				$update = $model->updateData($group_arr, $group_id);
			} else { 
			
				$update = $model->saveData($group_arr);
				$group_id = $update;
			} 
			
			$updateArr 		= array(
			'event_community' 	=> $_POST['event_community'],
			'event_category' 	=> $_POST['event_category'],
			'event_type' 	=> $_POST['event_type'],
			'event_typename' 	=> $_POST['group_name'],
			'group_id'   => $group_id,
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
			$eventmodel = new EventModel();
			
			if($event_id!=""){
			
			$updateArr['modified_by'] = $session->get('user_data')->ID;				
			$update = $eventmodel->updateData($updateArr, $event_id);
			} else { 
			$updateArr['created_by'] = $session->get('user_data')->ID;
			$updateArr['modified_by'] = $session->get('user_data')->ID;
			$update = $eventmodel->saveData($updateArr);
			} 
			if($update)
			{
				$return['success'] 		= "true";
				$return['message'] 		= "Group Event successfully updated/created.";
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
		
	public function get_users_group() {
		$session = \Config\Services::session();
			$model = new GroupModel();
			$Alldata    = $model->get_users_join_group($session->get('user_data')->ID);
			foreach($Alldata as $key=>$data){
				$Alldata[$key]->encrypted = encrypt($data->id);
			}
			if($Alldata)
			{
				$return['success'] 		= "true";
				$return['message'] 		= "Get All Group list.";
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
	}
	
	public function send_group_mail() {
		$postData = json_decode(file_get_contents('php://input'), true);
			if($postData == '')
			{
				$postData = $_POST;
				
				
			}
			$mailvalidate = $this->validate([
						'subject' => 'trim|required',
						'message'  => 'trim|required',
						
				]);
			if(!$mailvalidate)
			{
				
				$return['success'] 		= "false";
				$return['message'] 		= \Config\Services::validation()->listErrors();
				$return['error'] 		= \Config\Services::validation()->listErrors();
				$return['data'] 		="";			
				
				return $this->respond($return);
			}
			
			$model = new GroupModel();
			$members    = $model->get_all_group_users($postData['group_id']);
			$view = \Config\Services::renderer();
			if(!empty($members)){
				foreach($members as $member){
					$view_data = array(
						'name' => $member->full_name,
						'content' => $postData['message']
						
						);
						$maildata = array(
						  'to' => $member->email,
						  'subject' => $postData['subject'],
						  'message' => $view->setData($view_data)->render('email/group_mail')
						);
						send_mail($maildata);
				}
				
				$return['success'] 		= "true";
				$return['message'] 		= "Mail sent successfully";
				$return['error'] 		= "";
				$return['data'] 		= "";			
				
				return $this->respond($return);
				
				
			}else{
				
				$return['success'] 		= "false";
				$return['message'] 		= "There are no members in this group.";
				$return['error'] 		= "";
				$return['data'] 		= "";			
				
				return $this->respond($return);
			}
			
			
	}
	
	public function get_decrypt_groupID(){
		$postData = json_decode( file_get_contents('php://input'),true);
			$group_id = $postData['group_id']; 
			$decrypted = decrypt($group_id);
			if($decrypted){
				$return['success'] 		= "true";
				$return['message'] 		= "Group ID decrypt successfully";
				$return['error'] 		= "";
				$return['data'] 		= $decrypted;			
				
				return $this->respond($return);
			} else {
				$return['success'] 		= "false";
				$return['message'] 		= "Invalid group";
				$return['error'] 		= "";
				$return['data'] 		= "";			
				
				return $this->respond($return);
			}
	}
		
		

}
