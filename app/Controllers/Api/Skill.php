<?php namespace App\Controllers\APi;
use App\Models\SkillModel;
use CodeIgniter\RESTful\ResourceController;

class Skill extends ResourceController
{ 

    

    public function __construct()
    {
        helper(['cookie','validation']);
		
    }


   public function getallskills() 
		{ 
			
			$model = new SkillModel();
			$Alldata    = $model->getAlldata();
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
		}
	
	 public function getallActiveskills() 
		{ 
			
			$model = new SkillModel();
			$Alldata    = $model->getAllActivedata();
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
		}
		
	public function skillDetail() 
		{
			$postData = json_decode( file_get_contents('php://input'),true);
			$id = $postData['id'];
			$model = new SkillModel();
			$Alluser    = $model->getDetail($id);
			if($Alluser)
			{
				$return['success'] 		= "true";
				$return['message'] 		= "Get All Details.";
				$return['data'] 		= $Alluser;	
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
  
  
  public function updateSkill() 
		{
			
			helper('form');
			$postData = json_decode(file_get_contents('php://input'), true);
			if($postData == '')
			{
				$postData = $_POST;
				
				
			}
			$uservalidate=true;
			$skill_id=$_POST['skill_id'];
			if(empty($skill_id)) {
			$skillvalidate=$this->validate([
				'name' => 'trim|required|is_unique[li_skills.name]',

			]); 
				
			if(!$skillvalidate)
			{
				
				$return['success'] 		= "false";
				$return['message'] 		= \Config\Services::validation()->listErrors();
				$return['error'] 		= \Config\Services::validation()->listErrors();
				$return['data'] 		="";			
				
				return $this->respond($return);
			}	
				
				
			} else {
				
				$skillvalidate = check_existing_skill($skill_id, $_POST['name']);
				
				if(!empty($skillvalidate)) {
					
					$return['success'] 		= "false";
					$return['message'] 		= $skillvalidate;
					$return['error'] 		= $skillvalidate;
					$return['data'] 		="";			
					
					return $this->respond($return);
				}
				
			}
			
			
			$updateArr 		= array(
			'name' 	=> $_POST['name'],
			'description' 		=> $_POST['description'],
			'is_active' 		=> $_POST['is_active']
			); 
			//print_r($updateArr);
			$model = new SkillModel();
			
			if($skill_id!=""){ 
			$update = $model->updateData($updateArr, $skill_id);
			} else { 
			$update = $model->saveData($updateArr);
			}
			 
			$Alldata    = $model->getAlldata();
			if($Alldata)
			{
				$return['success'] 		= "true";
				$return['message'] 		= "Skill successfully updated/created.";
				$return['error'] 		= "";
				$return['data'] 		= $Alldata;			
				
				return $this->respond($return);
			}
			else
			{
				
				$return['success'] 		= "false";
				$return['message'] 		= "Skill is not update. Something went wrong.";
				$return['error'] 		= "";
				$return['data'] 		= "";			
				return $this->respond($return);
			}
		}
		
		public function assignskill() 
		{
			
			helper('form');
			$postData = json_decode(file_get_contents('php://input'), true);
			if($postData == '')
			{
				$postData = $_POST;
			
			}
			$uservalidate=true;
			$skill_id=$_POST['skill_id'];
			$skill_id=$_POST['skill_id'];
			
			$uservalidate=$this->validate([
        'skill_id' => 'trim|required'
]); 
			
			if(!$uservalidate)
			{
				
				$return['success'] 		= "false";
				$return['message'] 		= \Config\Services::validation()->listErrors();
				$return['error'] 		= \Config\Services::validation()->listErrors();
				$return['data'] 		="";			
				
				return $this->respond($return);
			}
			
			$model = new SkillModel();
			$skillexist=$model->exist_user_skill($_POST['user_id'], $skill_id);
			//print_r($skillexist);
   if($skillexist==true)
   {
                $return['success'] 		= "false";
				$return['message'] 		= "That Skill is already Assigned";
				$return['error'] 		= "That Skill is already Assigned";
				$return['data'] 		= "";			
				
				return $this->respond($return);
   } 
			$updateArr 		= array(
			'user_id' 	=> $_POST['user_id'],
			'skill_id' 		=> $_POST['skill_id']
			); 
			//print_r($updateArr);
			//$model = new SkillModel();
			
			$update = $model->AssignTouser($updateArr);
			
			$Alldata    = $model->getAssignskill($_POST['user_id']);
			if($Alldata)
			{
				$return['success'] 		= "true";
				$return['message'] 		= "Skill successfully updated/created.";
				$return['error'] 		= "";
				$return['data'] 		= $Alldata;			
				
				return $this->respond($return);
			}
			else
			{
				
				$return['success'] 		= "false";
				$return['message'] 		= "Skill is not update. Something went wrong.";
				$return['error'] 		= "";
				$return['data'] 		= "";			
				return $this->respond($return);
			}
		}
		
		public function getassignskills() 
		{ 
			$postData = json_decode( file_get_contents('php://input'),true);
			$id = $postData['id'];
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
		}
		
		function validate_skill($user_id, $str)
{
   $field_value = $str; //this is redundant, but it's to show you how
   //the content of the fields gets automatically passed to the method
$model = new SkillModel();
   if($model->exist_user_skill($user_id, $field_value))
   {
     return TRUE;
   }
   else
   {
     return FALSE;
   }
}
	//--------------------------------------------------------------------
	
	public function deleteSkill() {
			$postData = json_decode(file_get_contents('php://input'), true);
			if($postData == '')
			{
				$postData = $_POST;
				
				
			}
			
			$skill_id = $postData['skill_id'];
			
			$model = new SkillModel();
			$update = $model->deleteSkill($skill_id);
			if($update)
			{
				$return['success'] 		= "true";
				$return['message'] 		= "Page successfully deleted.";
				$return['error'] 		= "";
				$return['data'] 		= "";			
				
				return $this->respond($return);
			}
			else
			{
				
				$return['success'] 		= "false";
				$return['message'] 		= "Page is not delete. Something went wrong.";
				$return['error'] 		= "";
				$return['data'] 		= "";			
				return $this->respond($return);
			}
	}

}
