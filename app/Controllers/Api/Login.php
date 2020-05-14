<?php namespace App\Controllers\APi;
use App\Models\LoginModel;
use CodeIgniter\RESTful\ResourceController;
//$session = \Config\Services::session();

class Login extends ResourceController
{ 

    

    public function __construct()
    {
        helper(['cookie']);
		
    }

   public function validatelogin()
	{
		$model = new LoginModel();
		helper('form');
		$session = \Config\Services::session();
		$username=$_POST['username'];
		$password=$_POST['password'];
		
		if ($this->validate([
        'username' => 'required|min_length[3]|max_length[255]',
        'password'  => 'required'
    ]))
    {
		
		 $userData=$model->getUser($username, $password);
		 if($userData)
			{  
		        $remember = $_POST['rememberme'];
                
                if($remember == true)
                {
					
                    set_cookie('username',$_POST['username'], 3600);
                    set_cookie('password',$_POST['password'], 3600);
                    
                }
                
                 $data=array(
                    'is_logged_in'=>true,
					'user_data'=>$userData,
					'user_role'=>$userData->role
					);
                
                $session->set($data);
		//print_r($session->get());
		//die;	 
		//echo $userData->role;	
		
		if($userData->role == 'admin' || $userData->role == 'event_manager'){
		$redirect_url="admindashboard";	
		}
		else if($userData->role=='customer'){
			if(!empty($_POST['redirect_url'])) {
				$redirect_url= $_POST['redirect_url'];
			} else {
				$redirect_url= "";
			}
		}
		else if($userData->role=='staff'){
			//$redirect_url="driverdashboard";
			$redirect_url=$_POST['redirect_url'];
		}
		else {
			$redirect_url="login";
		}
				
				
				$return['success'] 		= "true";
				$return['message'] 		= "Login Successful.";
				$return['data'] 		= $userData;	
				$return['error'] 		= "";
				$return['url'] 		= $redirect_url;
				//print_r($return); die;
				return $this->respond($return);
			}
			else
			{
				$return['success'] 		= "false";
				$return['message'] 		= "Invalid Login Credentials";
				$return['error'] 		= "";
				$return['data'] 		= "";			
				
				return $this->respond($return);
			}
    }
			else
			{
				$return['success'] 		= "false";
				$return['message'] 		= \Config\Services::validation()->listErrors();
				$return['error'] 		= "";
				$return['data'] 		= "";			
				
				return $this->respond($return);
			}
		//$this->respond($this->model->findAll());
	}
	
	
	public function resetpassword()
	{
		$model = new LoginModel();
		helper(['form','common']);
		$session = \Config\Services::session();
		$email=$_POST['email'];
		if ($this->validate([
        'email' => 'required|min_length[3]|max_length[255]|valid_email',
    ]))
    {
		 $userData = $model->getPassword($email);

		 if($userData)
			{   
				$view = \Config\Services::renderer();
		
		                $password = $this->createpass(8); 
	                  
/*                         $to = $userdata->email;
						$subject = "New Password Mail By Icornerstone";
						$headers  = "From: info@chawtechsolutions.ch\r\n";
						$headers .= "Reply-To: info@chawtechsolutions.ch\r\n";
						$headers .= "X-Mailer: PHP/".phpversion();
						$message = "Your Username :".$userdata->login_id;
						$message .= "Your new password :".$password;
						$message = wordwrap($message, 70);

						$return = mail($to, $subject, $message, $headers); */	
						
						
						$view_data = array(
						'name' => $userData->first_name.' '.$userData->last_name,
						'email' => $userData->email,
						'password' => $password
						
						);
						$maildata = array(
					  'to' => $userData->email,
					  'subject' => "Reset Your Password",
					  'message' => $view->setData($view_data)->render('email/forgetpassword')
					);
				
					$return = send_mail($maildata);
			            if($return == true) {
						$data = array(
                            
                            'PASSWORD'=> md5($password)
                        );	
						$model->ediUser($data,$userdata->email);
						
				$return['success'] 		= "true";
				$return['message'] 		= "Password Sent, Please Check Your Email....";
				$return['data'] 		= "";	
				$return['error'] 		= "";
				$return['url'] 		= "";
				//print_r($return);
				return $this->respond($return);
				} else {
				$return['success'] 		= "false";
				$return['message'] 		= "Some Problem in sending email Server Problem.";
				$return['error'] 		= "";
				$return['data'] 		= "";			
				
				return $this->respond($return);
				}
			}
			else
			{
				$return['success'] 		= "false";
				$return['message'] 		= "That email/username id is not exists.";
				$return['error'] 		= "";
				$return['data'] 		= "";			
				
				return $this->respond($return);
			}
    }
			else
			{
				$return['success'] 		= "false";
				$return['message'] 		= \Config\Services::validation()->listErrors();
				$return['error'] 		= "";
				$return['data'] 		= "";			
				
				return $this->respond($return);
			}
		//$this->respond($this->model->findAll());
	}
	//--------------------------------------------------------------------
 public function createpass($num){ 
		//Under the string $Caracteres you write all the characters you want to be used to randomly generate the code. 
		$Caracteres = 'ABCDEF0GHI0JKLMq50076OPQRSTUVXWYZ0123456789'; 
		$QuantidadeCaracteres = strlen($Caracteres); 
		$QuantidadeCaracteres--; 
		
		$Hash=NULL; 
		    for($x=1;$x<=$num;$x++){ 
		        $Posicao = rand(0,$QuantidadeCaracteres); 
		        $Hash .= substr($Caracteres,$Posicao,1); 
		    } 
		    //Here you specify how many characters the returning string must have
		return $Hash; 
	}
	
	public function getcookiedata(){
		$data = array();
		
	  if(!empty($_COOKIE['username'])) {
		  $data['username'] = $_COOKIE['username'];
		  
	  }
	  
	  if(!empty($_COOKIE['password'])) {
		  $data['password'] = $_COOKIE['password'];
		  
	  }
	  
	  if($data) {
		  	$return['success'] 		= "true";
				$return['message'] 		= "get cookie data";
				$return['data'] 		= $data;	
				$return['error'] 		= "";
	  } else {
		  $return['success'] 		= "false";
				$return['message'] 		= "no data";
				$return['data'] 		= "";	
				$return['error'] 		= "";
	  }
	  return $this->respond($return);
	
	}
}
