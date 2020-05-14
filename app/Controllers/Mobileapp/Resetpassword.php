<?php namespace App\Controllers\Mobileapp;
use App\Models\LoginModel;
use App\Models\UserModel;
use App\Models\DeviceModel;
use CodeIgniter\RESTful\ResourceController;
//$session = \Config\Services::session();

class Resetpassword extends ResourceController
{ 

    

    public function __construct()
    {
        helper(['cookie','validation','common']);
		
		
    }

  public function index() {
	  
	   if(!empty($_POST['access_token'])) {
		    $auth_token = $_POST['access_token'];
			$model = new UserModel();
            $result = $model->validate_user_by_token_for_changepassword($auth_token);
			
			$serialize_token = decrypt($auth_token);
            $unserialized_token_array = unserialize($serialize_token);
            
            $email = $unserialized_token_array['email'];
            $user_id = $unserialized_token_array['user_id'];
            //echo "<pre>";print_r($result);exit;
			if ($result['status_code'] == 1 && !empty($result['user_data'])) {
                $user = $result['user_data'];
			$validate = validate_reset_password($_POST);
			//echo "<pre>";print_r($_POST);exit;
                if (!empty($validate)) {
					$return['success'] 		= "false";
					$return['message'] 		= "Please fill all fields";
					$return['error'] 		= json_encode($validate);
					$return['data'] 		= "";			
					
					return $this->respond($return);                } else {
						$updatearr['password'] = md5($_POST['new_password']);
					  $updatearr['access_token'] = null;
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
				} else if($result['status_code'] == 2) {
				$return['success'] 		= "false";
				$return['message'] 		= "Reset Password Link is expired";
				$return['data'] 		= "";	
				$return['error'] 		= "";
				
				return $this->respond($return);
			} else {
                
				$return['success'] 		= "false";
				$return['message'] 		= "You have provided wrong Authentication Token!";
				$return['data'] 		= "";	
				$return['error'] 		= "";
				
				return $this->respond($return);
				
                
                
            }
	   } else {
            
            $return['success'] 		= "false";
				$return['message'] 		= "Illigal Attempt Denied";
				$return['data'] 		= "";	
				$return['error'] 		= "";
				
				return $this->respond($return);
            
        }
	}
	
	
}
