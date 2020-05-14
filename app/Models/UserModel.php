<?php namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
        protected $table = 'li_users';
		
		public function getAlluser()
{
	    $db  = \Config\Database::connect();
        $builder = $db->table('li_users')->orderBy('ID','DESC');
        $query   = $builder->get();
		return $query->getResult();
}

public function getuserDetail($id)
{
	    $db  = \Config\Database::connect();
        $builder = $db->table('li_users');
		$builder->where('id', $id);
        $query   = $builder->get();
		return $query->getRow();
}

public function updateUser($data, $id)
{
	    $db  = \Config\Database::connect();
        $builder = $db->table('li_users');
        $builder->where('id', $id);
        return $builder->update($data);
}
public function saveUser($data)
{
	    $db  = \Config\Database::connect();
        $builder = $db->table('li_users');
        $builder->insert($data);
        return $db->insertID();
		
		
}

public function validate_user_by_token_for_changepassword($auth_token) {
	
	 $db  = \Config\Database::connect();
	 $query = $db->table('li_users')->where('access_token', $auth_token)->get()->getRow();
	 
	
        if(!empty($query)) {
			 $user_data = $query;
			 $now = date('Y-m-d H:i:s');
            $serialize_token = decrypt($auth_token);
            $unserialized_token_array = unserialize($serialize_token);
            
            $datetime1 = date_create($unserialized_token_array['insert_date']);
            $datetime2 = date_create($now);
            $interval = date_diff($datetime1, $datetime2);
			
            $minute_diff = (int) $interval->format('%i');
            
			if ($minute_diff <= 15) {
                // Return 1 means users access_token is not expired yet.
                $result = array('status_code' => 1,
				'user_data' =>  $user_data
				 );
				 return $result;
            } else {
                // Return 2 means users access_token is expired.
                $result = array('status_code' => 2,
				
				 );
				 return $result;
            }
            
		} else {
			// Return 0 means users access_token is not valid.
            $result = array('status_code' => 0,
				
				 );
				 return $result;
		}
           
        
        
       
	}
	
	public function gethealthinfoDetail($user_id) {
		 $db  = \Config\Database::connect();
        $builder = $db->table('li_health_info');
		$builder->where('user_id', $user_id);
        $query   = $builder->get();
		return $query->getRow();
	}
	
	public function deleteUser($id) {
		$db  = \Config\Database::connect();
        $builder = $db->table('li_users');
		$builder->where('ID', $id);
        return $builder->delete();
	}
	
	public function updatehealthinfo($data, $healthinfoid){
		 $db  = \Config\Database::connect();
        $builder = $db->table('li_health_info');
        $builder->where('id', $healthinfoid);
        return $builder->update($data);
	}
	
	public function savehealthinfo($data){
		
	    $db  = \Config\Database::connect();
        $builder = $db->table('li_health_info');
        $builder->insert($data);
		
        return $db->insertID();
	}
	
	public function check_user_email($email) {
		$db  = \Config\Database::connect();
        $builder = $db->table('li_users');
		$builder->where('email', $email)->where('login_id', $email);
        $query   = $builder->get();
		return $query->getRow();
	}
	
	
	
	

}

