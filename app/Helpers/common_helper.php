<?php 

if(!function_exists('encrypt'))
{
  function encrypt($string) {
        return p_encrypt_decrypt('encrypt', $string);
    }
}
 if(!function_exists('decrypt'))
{
  function decrypt($string) {
        return p_encrypt_decrypt('decrypt', $string);
    }
}
if(!function_exists('p_encrypt_decrypt'))
{
  function p_encrypt_decrypt($action, $string) {
        $output = false;
        
        $encrypt_method = "AES-256-CBC";
        $secret_key = 'sessionID' ;//'This is my secret key';
        $secret_iv = 'sessionUID; ';//'This is my secret iv';
        
        // hash
        $key = hash('sha256', $secret_key);
        
        // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
        $iv = substr(hash('sha256', $secret_iv), 0, 16);
        $aad = "";
        if( $action == 'encrypt' ) {
            $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
            $output = base64_encode($output);
        }
        else if( $action == 'decrypt' ){
            $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
			
        }
        
        return $output;
    }
}

 if(!function_exists('send_mail'))
{
  function send_mail($mail_data = null) {
	  //echo "<pre>";print_r($mail_data);exit;
       $email = \Config\Services::email();

$email->setFrom('info@chawtechsolutions.ch', 'Raghav');
$email->setTo($mail_data['to']);
		

		$email->setSubject($mail_data['subject']);
		$email->setMessage($mail_data['message']);

		if($email->send()) {
			return true;
		} else {
			return false;
		}
    }
}
if(!function_exists('get_currency')) {
	function get_currency()
	{
		 $db  = \Config\Database::connect();
		$currencydata = $db->table('li_settings t1')->select('t2.currency_symbol')->join('li_currency t2','t2.currency_id = t1.currency_id')->get()->getRow();
	   return $currencydata->currency_symbol;
	}
}

if(!function_exists('get_admin_email')) {
	function get_admin_email()
	{
		 $db  = \Config\Database::connect();
		$adminemail = $db->table('li_users t1')->select('email')->where('Id', 1)->get()->getRow();
	   return $adminemail->email;
	}
}

if(!function_exists('generateRandomString')) {

function generateRandomString($length = 10) {
        
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        
        return $randomString;
    }
}

if(!function_exists('action_button_for_events')) {

function action_button_for_events($Alldata) {
	$model = new \App\Models\EventModel();
	
        $session = \Config\Services::session();
		foreach($Alldata as $key=>$eventdata) {
			$Alldata[$key]->full_btn = 0;
			$Alldata[$key]->login_btn = 0;
			$Alldata[$key]->alreadyregister_btn = 0;
			$Alldata[$key]->go_btn = 0;
			$eventorder = $model->getCountGroupEventOrders($eventdata->id);
			if($session->get('is_logged_in')==true )
				{
					$if_register    = $model->checkUserEventRegistration($eventdata->id, $session->get('user_data')->ID);
					if(!empty($if_register)) {
							
							$Alldata[$key]->alreadyregister_btn = 1;
						} else {
							if($eventorder > $eventdata->max_attendees && !empty($eventdata->group_id)) {
								$Alldata[$key]->full_btn = 1;
								
							} else {
								
								$Alldata[$key]->go_btn = 1;
							}
							
							
						}
					
				}else {
					if($eventorder >= $eventdata->max_attendees && !empty($eventdata->group_id)) {
						$Alldata[$key]->full_btn = 1;
						
					} else if($eventdata->skill_requirement != 0){
						$Alldata[$key]->login_btn = 1;
						
					}else {
						
						$Alldata[$key]->go_btn = 1;
					}
				}
		}
		return $Alldata;
      
    }
}


