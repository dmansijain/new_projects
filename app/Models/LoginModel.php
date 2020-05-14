<?php namespace App\Models;

use CodeIgniter\Model;

class LoginModel extends Model
{
        protected $table = 'li_users';
		
		public function getUser($username = false, $password=false)
{
		$db      = \Config\Database::connect();
        $builder = $db->table('li_users');
		$builder->where('login_id', $username);
        $builder->where('password', md5($password));
        $query   = $builder->get();
		
		return $query->getRow();
}

public function getPassword($email)
{
	    $db      = \Config\Database::connect();
        $builder = $db->table('li_users');
		$builder->where('login_id', $email);
        $query   = $builder->get();
		return $query->getRow();
		
}
public function ediUser($data, $email)
{
	     $db  = \Config\Database::connect();
        $builder = $db->table('li_users');
        $builder->where('email', $email);
        return $builder->update($data);
		
}

}

