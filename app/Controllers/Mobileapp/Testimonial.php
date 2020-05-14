<?php namespace App\Controllers\Mobileapp;
use App\Models\TestimonialModel;
use CodeIgniter\RESTful\ResourceController;

class Testimonial extends ResourceController
{ 

    

    public function __construct()
    {
        helper(['validation','cookie']);
		validate_header_key();
    }


   public function getalltestimonials() 
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
		
	public function testimonialDetail($testimonial_id = "") 
		{
			
			
			if(!empty($testimonial_id)) {
				$model = new TestimonialModel();
				$testimonial    = $model->getDetail($testimonial_id);
				if(!empty($testimonial)) {
					$return['success'] 		= "true";
					$return['message'] 		= "Get All Details.";
					$return['data'] 		= $testimonial;	
					$return['error'] 		= "";
					
					return $this->respond($return);
				} else {
					$return['success'] 		= "false";
					$return['message'] 		= "Data not found";
					$return['error'] 		= "";
					$return['data'] 		= "";			
					
					return $this->respond($return);
				}
			} else {
				$return['success'] 		= "false";
				$return['message'] 		= "Invalid Testimonial";
				$return['error'] 		= "";
				$return['data'] 		= "";			
				
				return $this->respond($return);
			}
			
		}
  
  
 
	//--------------------------------------------------------------------

}
