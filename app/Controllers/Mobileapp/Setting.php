<?php namespace App\Controllers\Mobileapp;

use App\Models\UserModel;
use App\Models\PagesModel;
use CodeIgniter\RESTful\ResourceController;


class Setting extends ResourceController
{ 

    

    public function __construct()
    {
        helper(['validation','common']);
		validate_header_key();
		
    }
	
	public function get_web_setting(){
		$model = new PagesModel();
		$AllSettings    = $model->getSettings();
		if($AllSettings)
		{
			$return['success'] 		= "true";
			$return['message'] 		= "Setting detail found";
			$return['data'] 		= $AllSettings;	
			$return['error'] 		= $this->error;
			
			return $this->respond($return);
		}
		
		else
		{
			$return['success'] 		= "false";
			$return['message'] 		= "setting detail not found.";
			$return['error'] 		= $this->error;
			$return['data'] 		= $this->data;			
			
			return $this->respond($return);
		}	
	}
	
	public function contact_us(){
		
	

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
	
		
		   $validate = validate_contact_data($_POST);
		   
		   if (!empty($validate)) {
					$return['success'] 		= "error";
					$return['message'] 		= "Please fill all fields";
					$return['error'] 		= $validate;
					$return['data'] 		= "";			
					
					return $this->respond($return);                
			} else {
				$view = \Config\Services::renderer();
				$view_data = array(
							'name' => $_POST['name'],
							'email' => $_POST['email'],
							'phone' => $_POST['phone'],
							'message' => $_POST['message'],
							);
					$maildata = array(
					  'to' => get_admin_email(),
					  'subject' => "Contact Us",
					  'message' => $view->setData($view_data)->render('email/contact_us')
					);
					
					
				
				if(send_mail($maildata)) {
						$return['success'] 		= "true";
						$return['message'] 		= "Thank you for contacting us. We will get back to you soon!";
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
		
		
	}
	
		public function get_agreements() 
		{
			
			$model = new PagesModel();
		
			$eventagreements    = $model->getpageDetail(3);
			$copyrightagreements    = $model->getpageDetail(5);
			$financialagreements    = $model->getpageDetail(4);
			$Alldata = array(
			'eventagreements'=>$eventagreements->description,
			'copyrightagreements'=>$copyrightagreements->description,
			'financialagreements'=>$financialagreements->description
			);
			if($Alldata)
			{
				$return['success'] 		= "true";
				$return['message'] 		= "Get All Agreements Details.";
				$return['data'] 		= $Alldata;	
				$return['error'] 		= $this->error;
				
				return $this->respond($return);
			}
			
			else
			{
				$return['success'] 		= "false";
				$return['message'] 		= "Agreement Details not found.";
				$return['error'] 		= $this->error;
				$return['data'] 		= $this->data;			
				
				return $this->respond($return);
			}	
		}
	
	

	
	
}
