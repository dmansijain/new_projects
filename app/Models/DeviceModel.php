<?php namespace App\Models;

use CodeIgniter\Model;

class DeviceModel extends Model
{
        protected $table = 'li_users_device_info';
		

	public function save_user_device_info($data)
	{
		
			$db  = \Config\Database::connect();
			$builder = $db->table('li_users_device_info');
			
		 $builder->insert($data);
		  
		   
			
			
	}

}

