<?php namespace App\Models;

use CodeIgniter\Model;

class PagesModel extends Model
{
        protected $table = 'li_settings';
		
		
		public function getAlldata()
{
	    $db  = \Config\Database::connect();
        $builder = $db->table('li_cms');
        $query   = $builder->get();
		return $query->getResult();
}
public function getpageDetail($id)
{
	    $db  = \Config\Database::connect();
        $builder = $db->table('li_cms');
		$builder->where('id', $id);
        $query   = $builder->get();
		
		//echo $db->getLastQuery();
		return $query->getRow();
}

public function getActivepageDetail($id)
{
	    $db  = \Config\Database::connect();
        $builder = $db->table('li_cms');
		$builder->where('id', $id)->where("is_active", 1);
        $query   = $builder->get();
		
		//echo $db->getLastQuery();
		return $query->getRow();
}

public function updateDetail($data, $id)
{
	    $db  = \Config\Database::connect();
        $builder = $db->table('li_cms');
        $builder->where('id', $id);
        return $builder->update($data);
}
public function saveDetail($data)
{
	    $db  = \Config\Database::connect();
        $builder = $db->table('li_cms');
        return $builder->insert($data);
		
		
}

		public function getSettings()
{
	    $db  = \Config\Database::connect();
        $builder = $db->table('li_settings');
        $query   = $builder->get();
		return $query->getRow();
}

public function updateSettings($data, $id)
{
	    $db  = \Config\Database::connect();
		$builder = $db->table('li_settings');
        $builder->where('id', $id);
        return $builder->update($data); 
		
}

public function getcurrencylist()
{
	    $db  = \Config\Database::connect();
        $builder = $db->table('li_currency');
		
        $query   = $builder->get();
		
		//echo $db->getLastQuery();
		return $query->getResult();
}

public function update_payment_plan_settings($data, $id)
{
	    $db  = \Config\Database::connect();
		$builder = $db->table('li_payment_plan');
        $builder->where('payment_plan_id', $id);
        return $builder->update($data); 
		
}

public function add_payment_plan_settings($data)
{
	
	    $db  = \Config\Database::connect();
		$builder = $db->table('li_payment_plan');
      return $builder->insert($data);
	
		
}

public function get_payment_plan_settings() {
	 $db  = \Config\Database::connect();
        $builder = $db->table('li_payment_plan');
        $query   = $builder->get();
		
		return $query->getRow();
}

public function deletePage($id) {
	$db  = \Config\Database::connect();
        $builder = $db->table('li_cms');
		$builder->where('id', $id);
        return $builder->delete();
}
}

