<?php namespace App\Controllers\Mobileapp;
use App\Models\LoginModel;
use App\Models\UserModel;
use App\Models\SkillModel;
use CodeIgniter\RESTful\ResourceController;
//$session = \Config\Services::session();

class Skill extends ResourceController
{ 

    

    public function __construct()
    {
        helper(['cookie','validation','common']);
		validate_header_key();
		
    }
	
	public function get_all_skills($user_id)
    {
		$model = new UserModel();
		$userdata = $model->getuserDetail($user_id);
		if(!empty($user_id) && !empty($userdata->ID)) { 
		
			
			$skillmodel = new SkillModel();
			$userskill = $skillmodel->getUserSkills($user_id);
			
			$sk_arr = array();
			foreach($userskill as $skill) {
				$sk_arr[] = $skill->skill_id;
			}
			$skilldata = $skillmodel->get_skill_not_in_user_skills($sk_arr);

			$return['success'] 		= "true";
			$return['message'] 		= "Data Found";
			$return['error'] 		= "";
			$return['data'] 		= $skilldata;
			return $this->respond($return);
		} else {
			$return['success'] 		= "false";
			$return['message'] 		= "invalid user";
			$return['error'] 		= "";
			$return['data'] 		= "";
			return $this->respond($return);
		}
		
    }
	
	public function add_skill()
    {
       $postdata 		= json_decode( file_get_contents('php://input'),true);
		
		if( count($postdata) == 0 )
		{
			$return['success'] 		= "false";
			
			$return['message'] 		= "Invalid data format";
			$return['error'] 		= "";
			$return['data'] 		= "";

			return $this->respond($return);
		}
		
		
			$validate = validate_skills($postdata);
			if(!empty($validate)) {
				$return['success'] 		= "false";
				$return['message'] 		= "Please fill all fields";
				$return['error'] 		= json_encode($validate);
				$return['data'] 		= "";			
				
				return $this->respond($return);
			}
			
			$model = new UserModel();
			$userdata = $model->getuserDetail($postdata['user_id']);
			if(!empty($userdata->ID)) {
				$skillmodel = new SkillModel();
				$insert = $skillmodel->AssignTouser($postdata);
				if($insert) {
					$return['success'] 		= "true";
					$return['message'] 		= "Skill add successfully";
					$return['error'] 		= "";
					$return['data'] 		= "";			
					
					return $this->respond($return);
				} else {
					
					$return['success'] 		= "false";
					$return['message'] 		= "Something Went wrong. Please try again!";
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
	
	public function delete_skill() {
		 $postdata 		= json_decode( file_get_contents('php://input'),true);
		
		if( count($postdata) == 0 )
		{
			$return['success'] 		= "false";
			
			$return['message'] 		= "Invalid data format";
			$return['error'] 		= "";
			$return['data'] 		= "";

			return $this->respond($return);
		}
		
		$validate = validate_delete_skills_data($postdata);
		
		if(!empty($validate)) {
				$return['success'] 		= "false";
				$return['message'] 		= "Please fill all fields";
				$return['error'] 		= json_encode($validate);
				$return['data'] 		= "";			
				
				return $this->respond($return);
			}
			
		$model = new UserModel();
			$userdata = $model->getuserDetail($postdata['user_id']);
			if(!empty($userdata->ID)) {
				$skillmodel = new SkillModel();
				if($skillmodel->delete_user_skills($postdata['user_skill_id'])) {
					$return['success'] 		= "true";
					$return['message'] 		= "Skill delete successfully!";
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
				$return['message'] 		= "Invalid User";
				$return['error'] 		= "";
				$return['data'] 		= "";			
				
				return $this->respond($return);
			}
			
	
	
	}
	

   
	
	
}
