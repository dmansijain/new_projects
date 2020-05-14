<?php
namespace App\Libraries;



class Liminaltokenlib
{
    public $isTokenValid 	= false;
	public $keyValue 		= '!@#$%^&*()_+';	
	public $token 			= false;
	
	public $user_id 		= NULL;
	
	public $tableName 		= 'user_token';
	
	public function createToken($user_id)
	{
		$currentTimeStamp 		= time();
		$tokendata = serialize(array(
				'user_id' => $user_id,
				'timestamp' => $currentTimeStamp
				));
		$this->token = encrypt($tokendata);
		
		return $this->token;
	}
	
	public function saveToken($tokenVal = false, $user_id = false)
	{
		if( (!$tokenVal) or (!$user_id) )
		{
			return false;
		}
		
		/* check if token already exists */
		$db  = \Config\Database::connect();
		$tokenRow = $db->table('user_token')
			->select('*')
			->where('user_token.token_id', $tokenVal)->where('user_id', $user_id)
			->orderBy('user_token.id', 'DESC')
			->get()->getResult();
			
		if(count($tokenRow) > 0)
		{
			//$user = $tokenRow->get()->first();
			$tokenVal = $this->createToken();
			$tokenVal = $this->saveToken($tokenVal, $user_id);
		}
		
		
		$session_expires 		= strtotime(Date("Y-m-d h:i:s", strtotime("+2 Month")));
		
		$session_data 			= array(
		
			'core' 				=> array(
			
				'remote_addr' 				=> $_SERVER['REMOTE_ADDR'],
				'request_time' 				=> $_SERVER['REQUEST_TIME'],
				'http_user_agent' 			=> $_SERVER['HTTP_USER_AGENT'],
				'session_expire_timestamp' 	=> $session_expires
			),			
			'user' 				=> array(
				'id' 			=> $user_id,
			),
		
		);
		
		$microtime 				= (microtime(true) * 10000);
		
		
		
		$data 	= [			
			
			'token_id' 		=> $tokenVal,
			'token_expire' 	=> $session_expires,
			'session_data' 	=> serialize($session_data),
			'user_id' 		=> $user_id,
			'microtime' 	=> $microtime,
			'random' 		=> $microtime,
			'updated_at' 	=> date('Y-m-d H:i:s'),
			
		];
		
		$id = $db->table('user_token')->insert($data);
		
		if( $id )
		{
			return $tokenVal;
		}
		
		return false;
		
	}
	
	public function updateTokenExpireTimestamp($tokenVal = false)
	{
		if(!$tokenVal)
		{
			return false;
		}
				
		$session_expires 		= strtotime(Date("Y-m-d h:i:s", strtotime("+2 Month")));
		$microtime 				= (microtime(true) * 10000);
		
		$data 	= [			
			'token_expire' 	=> $session_expires,
			'microtime' 	=> $microtime,
		];
		
		$update = DB::table('user_token')
				->where('token_id', $tokenVal)
				->update($data);
		
		
		if( $update )
		{
			return true;
		}
		
		return false;
		
	}
	
	public function validateToken($event = null)
	{
		 $request = \Config\Services::request();
		$tokenVal = $request->getHeaderLine('token');
		
		if(!$tokenVal)
		{
			header("HTTP/1.0 403 Forbidden");
			echo '{"success":"false","message":"Please send valid Token","token_valid":"false"}';
			die;
		}
			$decrypt_token = unserialize(decrypt($tokenVal));
				//echo "<pre>";print_r($decrypt_token);exit;
				$currentTimeStamp 		= time();
				
				$db  = \Config\Database::connect();
				
				$builder = $db->table('user_token');
				$builder = $builder->select("*");
				$builder = $builder->where("token_id", $tokenVal)->where('user_id', $decrypt_token['user_id']);
				
				$result = $builder->get()->getRowArray();
				
				
				if(!empty($result))
				{
					
					//echo "<pre>";print_r($result);exit;
					if($result['token_expire'] > $currentTimeStamp) {
						if($event == 'logout') {
							$builder = $db->table('user_token');
								$builder->where('id', $result['id']);
								$builder->delete();
						}
						return true;
						
					} else {
						header("HTTP/1.0 403 Forbidden");
						echo '{"success":"false","message":"Token Expired","token_valid":"false"}';
						die;
					}
					
				} else {
					header("HTTP/1.0 403 Forbidden");
					echo '{"success":"false","message":"Invalid Token","token_valid":"false"}';
					die;
				}
	}
	
	public function getTokenRow($tokenVal = false)
	{
		if(!$tokenVal)
		{
			return false;
		}
		//echo $tokenVal;
		$tokenRow = DB::table('user_token')
			->select('*')
			->where([
				['user_token.token_id', '=', "$tokenVal"]
				])
			->orderBy('user_token.id', 'DESC')
			->take(1);
			
		//echo 'fsda<pre>';echo $tokenRow->toSql(); die;
		
		if($tokenRow->count() > 0)
		{
			return $tokenRow->get()->first();
		}
		
		return false;
	}
	
	public function test()
	{
		return true;
	}
	
	public function fetchToken()
	{
		return (Request::header('apptoken')) ? Request::header('apptoken') : false;
	}
	
}
