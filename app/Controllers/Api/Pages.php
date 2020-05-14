<?php namespace App\Controllers\APi;
use App\Models\PagesModel;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\HTTP\Files\UploadedFile;

class Pages extends ResourceController
{ 

    public function __construct()
    {
        helper(['cookie','common']);
    }

public function getAllPage() 
		{
			
			//$result=send_mail();
			
			
			//$security = \Config\Services::security();
			$model = new PagesModel();
			$Alldata    = $model->getAlldata();
			if($Alldata)
			{
				$return['success'] 		= "true";
				$return['message'] 		= "Get All Page list.";
				$return['data'] 		= $Alldata;	
				$return['error'] 		= $this->error;
				
				return $this->respond($return);
			}
			
			else
			{
				$return['success'] 		= "false";
				$return['message'] 		= "All Page Details not found.";
				$return['error'] 		= "";
				$return['data'] 		= "";			
				
				return $this->respond($return);
			}	
		}

   public function settingsDetail() 
		{
			
			$model = new PagesModel();
			$AllSettings    = $model->getSettings();
			if($AllSettings)
			{
				$return['success'] 		= "true";
				$return['message'] 		= "Get All User Details.";
				$return['data'] 		= $AllSettings;	
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
		
		public function agreements() 
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
				$return['message'] 		= "All Product Details not found.";
				$return['error'] 		= $this->error;
				$return['data'] 		= $this->data;			
				
				return $this->respond($return);
			}	
		}
		
		public function pageDetail() 
		{ 
		
		//$reheaders=$this->input->request_headers('token');
		//print_r($_SERVERS); die;
		
			$postData = json_decode( file_get_contents('php://input'),true);
			$model = new PagesModel();
			$page_id = $postData['id'];
			$AllSettings    = $model->getpageDetail($page_id);
			
			
			if($AllSettings)
			{
				$return['success'] 		= "true";
				$return['message'] 		= "Get Page Details.";
				$return['data'] 		= $AllSettings;	
				$return['error'] 		= $this->error;
				
				return $this->respond($return);
			}
			
			else
			{
				$return['success'] 		= "false";
				$return['message'] 		= "Page Details not found.";
				$return['error'] 		= $this->error;
				$return['data'] 		= $this->data;			
				
				return $this->respond($return);
			}	
		}
		
		public function ActivepageDetail() 
		{ 
		
		//$reheaders=$this->input->request_headers('token');
		//print_r($_SERVERS); die;
		
			$postData = json_decode( file_get_contents('php://input'),true);
			$model = new PagesModel();
			$page_id = $postData['id'];
			$AllSettings    = $model->getActivepageDetail($page_id);
			
			
			if($AllSettings)
			{
				$return['success'] 		= "true";
				$return['message'] 		= "Get Page Details.";
				$return['data'] 		= $AllSettings;	
				$return['error'] 		= $this->error;
				
				return $this->respond($return);
			}
			
			else
			{
				$return['success'] 		= "false";
				$return['message'] 		= "Page Details not found.";
				$return['error'] 		= $this->error;
				$return['data'] 		= $this->data;			
				
				return $this->respond($return);
			}	
		}
		


        public function updatePage()
		{
			helper('form');
			$postData = json_decode(file_get_contents('php://input'), true);
			if($postData == '')
			{
				$postData = $_POST;
				
				
			}
			
			$page_id=$_POST['page_id']; 
			
			if(!$this->validate([
        'title' => 'trim|required',
    ]))
			{
				
				$return['success'] 		= "false";
				$return['message'] 		= "Please fill the required fields.";
				$return['error'] 		= \Config\Services::validation()->listErrors();;
				$return['data'] 		="";			
				
				return $this->respond($return);
			}
			
			$banner_image 		= '';
			$hasFileUpload 	= false;
			$file = $this->request->getFile('banner_image');
			//print_r($file); die;
			//$file = $this->request->getFile('logo')
			
			// echo ROOTPATH;  die;
			
			if( ! empty($file) )
			{ $newName = $file->getRandomName();
				if ( ! $file->move(ROOTPATH.'uploads/bannerimg', $newName))
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
					$uplodimg 				= $newName;
					$banner_image 				= $uplodimg;
					$hasFileUpload 			= true;
				}
			}
			
			if($banner_image != "")
			{
			$updateArr 		= array(
			'title' 	=> $_POST['title'],
			'description' 		=> $_POST['description'],
			'short_description' 		=> $_POST['short_description'],
			'is_active' 		=> $_POST['is_active'],
			'banner_image' 	=> ($banner_image) ? $banner_image : '',
			);
			}else
			{
			$updateArr 		= array(
			'title' 	=> $_POST['title'],
			'description' 		=> $_POST['description'],
			'short_description' 		=> $_POST['short_description'],
			'is_active' 		=> $_POST['is_active'],
			
			); 
			}
			$model = new PagesModel();
			if($hasFileUpload)
			{
				$updateArr['banner_image'] = $banner_image;
			}
			if($page_id!=""){ 
			
			$update = $model->updateDetail($updateArr, $page_id);
			} else {
			$update = $model->saveDetail($updateArr);
			} 
			if($update)
			{
				$return['success'] 		= "true";
				$return['message'] 		= "Page successfully created/updated.";
				$return['error'] 		= "";
				$return['data'] 		= "";			
				
				return $this->respond($return);
			}
			else
			{
				
				$return['success'] 		= "false";
				$return['message'] 		= "Settings is not update. Something went wrong.";
				$return['error'] 		= "";
				$return['data'] 		= "";			
				return $this->respond($return);
			}
			
		}
		
		
		public function updateSettings()
		{
			helper('form');
			$postData = json_decode(file_get_contents('php://input'), true);
			if($postData == '')
			{
				$postData = $_POST;
				
				
			}
			
			$settings_id=$_POST['settings_id']; 
			
			if(!$this->validate([
        'title' => 'trim|required',
        'tagline'  => 'trim|required'
    ]))
			{
				
				$return['success'] 		= "false";
				$return['message'] 		= "Please fill the required fields.";
				$return['error'] 		= \Config\Services::validation()->listErrors();;
				$return['data'] 		="";			
				
				return $this->respond($return);
			}
			
			$logo 		= '';
			$hasFileUpload 	= false;
			$file = $this->request->getFile('logo');
			//print_r($file); die;
			//$file = $this->request->getFile('logo')
			
			// echo ROOTPATH;  die;
			
			if( ! empty($file) )
			{ $newName = $file->getRandomName();
				if ( ! $file->move(ROOTPATH.'uploads/sitelogo', $newName))
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
					$uplodimg 				= $newName;
					$logo 				= $uplodimg;
					$hasFileUpload 			= true;
				}
			}
			
			if($logo != "")
			{
			$updateArr 		= array(
			'title' 	=> $_POST['title'],
			'tagline' 		=> $_POST['tagline'],
			'website' 		=> $_POST['website'],
			'email' 		=> $_POST['email'],
			'phone_number' 		=> $_POST['phone_number'],
			'copyright' 		=> $_POST['copyright'],
			'currency_id'  =>  !empty($_POST['currency_id']) ? $_POST['currency_id'] : null,
			'address' 		=> $_POST['address'],
			'facebook' 		=> $_POST['facebook'],
			'twitter' 		=> $_POST['twitter'],
			'instagram' 		=> $_POST['instagram'],
			'logo' 	=> ($logo) ? $logo : '',
			);
			}else
			{
			   $updateArr 		= array(
			'title' 	=> $_POST['title'],
			'tagline' 		=> $_POST['tagline'],
			'website' 		=> $_POST['website'],
			'email' 		=> $_POST['email'],
			'phone_number' 		=> $_POST['phone_number'],
			'copyright' 		=> $_POST['copyright'],
			'currency_id'  =>  !empty($_POST['currency_id']) ? $_POST['currency_id'] : null,
			'address' 		=> $_POST['address'],
			'facebook' 		=> $_POST['facebook'],
			'twitter' 		=> $_POST['twitter'],
			'instagram' 		=> $_POST['instagram'],
			); 
			}
			$model = new PagesModel();
			if($hasFileUpload)
			{
				$updateArr['logo'] = $logo;
			}
			if($settings_id!=""){
				$update = $model->updateSettings($updateArr, $settings_id);
			} 
			if($update)
			{
				$return['success'] 		= "true";
				$return['message'] 		= "Settings successfully updated.";
				$return['error'] 		= "";
				$return['data'] 		= "";			
				
				return $this->respond($return);
			}
			else
			{
				
				$return['success'] 		= "false";
				$return['message'] 		= "Settings is not update. Something went wrong.";
				$return['error'] 		= "";
				$return['data'] 		= "";			
				return $this->respond($return);
			}
			
		}
		
		public function getPaymentPlans() {
			$model = new PagesModel();
			$AllSettings    = $model->get_payment_plan_settings();
			$timperiods = array('weekly' => "Weekly", "monthly" => "Monthly", "days" => "Daywise");
			
			foreach($timperiods as $key=>$time) {
				if($key == $AllSettings->time_period) {
					$AllSettings->time_period = $time;
				}
			}
			if($AllSettings)
			{
				$return['success'] 		= "true";
				$return['message'] 		= "Get payment plan setting.";
				$return['data'] 		= $AllSettings;	
				$return['error'] 		= $this->error;
				
				return $this->respond($return);
			}
			
			else
			{
				$return['success'] 		= "false";
				$return['message'] 		= "All setting Details not found.";
				$return['error'] 		= $this->error;
				$return['data'] 		= $this->data;			
				
				return $this->respond($return);
			}	
		}
		
		public function update_payment_plan_settings()
		{
			helper('form');
			$postData = json_decode(file_get_contents('php://input'), true);
			if($postData == '')
			{
				$postData = $_POST;
				
				
			}
			
			$payment_plan_id = $_POST['payment_plan_id']; 
			
			if(!$this->validate([
				'time_period' => 'trim|required',
				'payment_division'  => 'trim|required'
				]))
			{
				
				$return['success'] 		= "false";
				$return['message'] 		= "Please fill the required fields.";
				$return['error'] 		= \Config\Services::validation()->listErrors();;
				$return['data'] 		="";			
				
				return $this->respond($return);
			}
			
			$timperiods = array('weekly' => "Weekly", "monthly" => "Monthly", "days" => "Daywise");
			$time_pe = $_POST['time_period'];
			foreach($timperiods as $key=>$time) {
				if($time == $_POST['time_period']) {
					$time_pe = $key;
				}
			}
			
			   $updateArr 		= array(
				'time_period' 	=> $time_pe,
				'payment_division' 		=> $_POST['payment_division'],
			
			); 
			
			
			$model = new PagesModel();
			
			if($payment_plan_id !=""){
				
				$update = $model->update_payment_plan_settings($updateArr, $payment_plan_id);
			} else {
				
				$update = $model->add_payment_plan_settings($updateArr);
			} 
			if($update)
			{
				$return['success'] 		= "true";
				$return['message'] 		= "Settings successfully updated.";
				$return['error'] 		= "";
				$return['data'] 		= "";			
				
				return $this->respond($return);
			}
			else
			{
				
				$return['success'] 		= "false";
				$return['message'] 		= "Settings is not update. Something went wrong.";
				$return['error'] 		= "";
				$return['data'] 		= "";			
				return $this->respond($return);
			}
			
		}
		
		public function currencyList() 
		{ 
		
		//$reheaders=$this->input->request_headers('token');
		//print_r($_SERVERS); die;
		
			
			$model = new PagesModel();
			
			$Allcurrencies    = $model->getcurrencylist();
			
			if($Allcurrencies)
			{
				$return['success'] 		= "true";
				$return['message'] 		= "All Currencies.";
				$return['data'] 		= $Allcurrencies;	
				$return['error'] 		= $this->error;
				
				return $this->respond($return);
			}
			
			else
			{
				$return['success'] 		= "false";
				$return['message'] 		= "not found";
				$return['error'] 		= $this->error;
				$return['data'] 		= $this->data;			
				
				return $this->respond($return);
			}	
		}
  
	//--------------------------------------------------------------------
	
	public function deletePage() {
			$postData = json_decode(file_get_contents('php://input'), true);
			if($postData == '')
			{
				$postData = $_POST;
				
				
			}
			
			$page_id = $postData['page_id'];
			
			$model = new PagesModel();
			$update = $model->deletePage($page_id);
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
	
	public function contact_us(){
		
		 helper(['validation']);

		$postData = json_decode(file_get_contents('php://input'), true);
			if($postData == '')
			{
				$postData = $_POST;
				
				
			}
		
		
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

}
