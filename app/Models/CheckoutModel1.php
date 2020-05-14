<?php 
namespace App\Models;

use CodeIgniter\Model;

class CheckoutModel extends Model
{
        protected $table = 'li_events';
		
		public function getAlldata($event_cat="", $event_type="", $orderby="")
{
	    $db  = \Config\Database::connect();
        $builder = $db->table('li_events');
		if($event_cat!=""){
		$builder->where('event_category', $event_cat);
		}
		if($event_type!=""){
		$builder->where('event_type', $event_type);
		}
		
		$builder->where('start_date >=', date('Y-m-d'));
		
		if($orderby=="oldest"){
		$builder->orderBy('start_date', 'desc');
		}
		if($orderby=="newest"){
		$builder->orderBy('start_date', 'asc');
		}
        $query   = $builder->get();
		return $query->getResult();
}

public function getDetail($id)
{ 

	    $db  = \Config\Database::connect();
        $builder = $db->table('li_events');
		$builder->where('id', $id);
        $query   = $builder->get();
		
		return $query->getRow();
}

public function updateData($tablename, $data, $id)
{
	    $db  = \Config\Database::connect();
        $builder = $db->table($tablename);
        $builder->where('id', $id); 
        return $builder->update($data);
}
public function saveData($tablename, $data) 
{ 

	    $db  = \Config\Database::connect();
        $builder = $db->table($tablename);
        $builder->insert($data);
		//echo $db->getLastQuery();
		return $db->insertID();
		
}

public function updateOrder($tablename, $data, $id)
{
	    $db  = \Config\Database::connect();
        $builder = $db->table($tablename);
        $builder->where('event_order_id', $id); 
        return $builder->update($data);
}

public function get_temp_data() {
	  $db  = \Config\Database::connect();
        $builder = $db->table('li_temp');
		builder->where('temp_id', 6); 
		$query   = $builder->get();
		
		return $query->getRow();
}

public function get_payment_by_txn_id($transaction_id) {
	$db  = \Config\Database::connect();
        $builder = $db->table('li_payment');
		builder->where('transaction_id', $transaction_id); 
		$query   = $builder->get();
		
		return $query->getRow();
}

}

