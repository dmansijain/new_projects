<?php namespace App\Controllers\APi;
use App\Models\TestimonialModel;
use CodeIgniter\RESTful\ResourceController;

class Testimonial extends ResourceController
{ 

    

    public function __construct()
    {
        helper(['cookie']);
		
    }


   public function getalltestimonials() 
		{
			
			$model = new TestimonialModel();
			$Alldata    = $model->getAlldata();
			if($Alldata)
			{
				$return['success'] 		= "true";
				$return['message'] 		= "Get All Testimonial list.";
				$return['data'] 		= $Alldata;	
				$return['error'] 		= $this->error;
				
				return $this->respond($return);
			}
			
			else
			{
				$return['success'] 		= "false";
				$return['message'] 		= "All Testimonial Details not found.";
				$return['error'] 		= $this->error;
				$return['data'] 		= $this->data;			
				
				return $this->respond($return);
			}	
		}
		
	public function getallActivetestimonials() 
		{
			
			$model = new TestimonialModel();
			$Alldata    = $model->getAllActivedata();
			if($Alldata)
			{
				$return['success'] 		= "true";
				$return['message'] 		= "Get All Testimonial list.";
				$return['data'] 		= $Alldata;	
				$return['error'] 		= $this->error;
				
				return $this->respond($return);
			}
			
			else
			{
				$return['success'] 		= "false";
				$return['message'] 		= "All Testimonial Details not found.";
				$return['error'] 		= $this->error;
				$return['data'] 		= $this->data;			
				
				return $this->respond($return);
			}	
		}
		
	public function testimonialDetail() 
		{
			 $postData = json_decode( file_get_contents('php://input'),true);
			$id = $postData['id'];  
			$model = new TestimonialModel();
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
  
  
  public function updateTestimonial() 
		{
			
			helper('form');
			$postData = json_decode(file_get_contents('php://input'), true);
			if($postData == '')
			{
				$postData = $_POST;
				
				
			}
			$uservalidate=true;
			$testimonial_id=$_POST['testimonial_id'];
			
			$uservalidate=$this->validate([
        'name' => 'trim|required',
        'description'  => 'trim|required|max_length[255]',
		'is_active'  => 'trim|required'
]); 
			
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
			
		
			$file = $this->request->getFile('user_image');
			
			//echo $ext;exit;
			if( ! empty($file) )
			{ 
				$ext = $file->getClientExtension();
				$valid_extensions = array('jpg','jpeg','gif','png');
				$newName = $file->getRandomName();
				if(in_array($ext, $valid_extensions)) {
					if ( ! $file->move(ROOTPATH.'uploads/testimonialImages', $newName))
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
						$uplodimg 			=     $newName;
						$profilepic 		=     $uplodimg;
						$hasFileUpload 		=     true;
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
				'name' 	=> $_POST['name'],
				'description' 		=> $_POST['description'],
				'is_active' 		=> $_POST['is_active'],
				'user_image' 	=> ($profilepic) ? $profilepic : '',
				);
			}else
			{
			   $updateArr 		= array(
					'name' 	=> $_POST['name'],
					'description' 		=> $_POST['description'],
					'is_active' 		=> $_POST['is_active']
					); 
			}
			$model = new TestimonialModel();
			if($hasFileUpload)
			{
				$updateArr['user_image'] = $profilepic;
			}
			
			if($testimonial_id!=""){ 
			$update = $model->updateDetail($updateArr, $testimonial_id);
			} else { 
			$update = $model->saveDetail($updateArr);
			} 
			if($update)
			{
				$return['success'] 		= "true";
				$return['message'] 		= "Testimonial successfully updated/created.";
				$return['error'] 		= "";
				$return['data'] 		= "";			
				
				return $this->respond($return);
			}
			else
			{
				
				$return['success'] 		= "false";
				$return['message'] 		= "Testimonial is not update. Something went wrong.";
				$return['error'] 		= "";
				$return['data'] 		= "";			
				return $this->respond($return);
			}
		}
	//--------------------------------------------------------------------
	
	public function deleteTestimonial() {
			$postData = json_decode(file_get_contents('php://input'), true);
			if($postData == '')
			{
				$postData = $_POST;
				
				
			}
			
			$testimonial_id = $postData['testimonial_id'];
			
			
			$model = new TestimonialModel();
			$update = $model->deleteTestimonial($testimonial_id);
			if($update)
			{
				$return['success'] 		= "true";
				$return['message'] 		= "Testimonial successfully deleted.";
				$return['error'] 		= "";
				$return['data'] 		= "";			
				
				return $this->respond($return);
			}
			else
			{
				
				$return['success'] 		= "false";
				$return['message'] 		= "Testimonial is not delete. Something went wrong.";
				$return['error'] 		= "";
				$return['data'] 		= "";			
				return $this->respond($return);
			}
	}

}
