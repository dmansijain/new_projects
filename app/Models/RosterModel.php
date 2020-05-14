<?php namespace App\Models;

use CodeIgniter\Model;

class RosterModel extends Model
{
        protected $table = 'li_events';
		
	

public function getAlladmindata($event_id, $from_date="", $end_date="", $orderby="")
{ 
	    $db  = \Config\Database::connect();
        $builder = $db->table('li_event_orders');
		$builder->select('li_event_orders.*,CONCAT(li_attende_info.first_name," ", li_attende_info.last_name) as full_name, li_attende_info.email, li_attende_info.phone_number,li_events.*, li_eventtype_name.title as typenametitle');
		$builder->join('li_attende_info', 'li_attende_info.id = li_event_orders.attende_id');
		$builder->join('li_events', 'li_events.id = li_event_orders.event_id');
         $builder->join('li_eventtype_name', 'li_eventtype_name.id = li_events.event_typename','LEFT');
		if(!empty($event_id)) {
			$builder->where('li_event_orders.event_id', $event_id);
		}
		
		$builder->orderBy('li_event_orders.event_order_id', 'desc');
		
        $query   = $builder->get();
		
		return $query->getResult();
}




public function get_roaster_info_by_order_id($table, $joincolumn, $id) {
	$db  = \Config\Database::connect();
	$data = 'li_event_orders.*,'. $table.'.*';
        $builder = $db->table('li_event_orders');
		$builder->select($data);
		if($table == 'li_notification_info') {
			$builder->join($table, $table.'.notification_id = li_event_orders.'.$joincolumn);
		} else {
			$builder->join($table, $table.'.id = li_event_orders.'.$joincolumn);
		}
		$builder->where('li_event_orders.event_order_id', $id);
        $query   = $builder->get();
		//echo $db->getLastQuery();exit;
		return $query->getRow();
}

public function get_event_order_by_order_id($id) {
	$db  = \Config\Database::connect();
	$builder = $db->table('li_event_orders');
	$builder->select('li_event_orders.*, li_events.event_typename,li_events.cost, li_eventtype_name.title as typenametitle, CONCAT(li_users.first_name," ",li_users.last_name) as full_name');
	$builder->join('li_events', 'li_events.id = li_event_orders.event_id');
	$builder->join('li_eventtype_name', 'li_eventtype_name.id = li_events.event_typename','LEFT');
	$builder->join('li_users', 'li_users.id = li_event_orders.user_id');
	$builder->where('li_event_orders.event_order_id', $id);
	 $query   = $builder->get();
		//echo $db->getLastQuery();exit;
		return $query->getRow();
}

public function get_payment_by_payment_id($payment_id) {
	$db  = \Config\Database::connect();
	$builder = $db->table('li_payment');
	$builder->where('id', $payment_id);
	 $query   = $builder->get();
		//echo $db->getLastQuery();exit;
		return $query->getRow();
}

 public function deleteRoster($order_id) {
	 $db  = \Config\Database::connect();
        $builder = $db->table('li_event_orders');
		$builder->where('event_order_id', $order_id);
        return $builder->delete();
	
	
}

public function delete_roster_detail_by_id($table, $id, $field="") {
	$db  = \Config\Database::connect();
	
	$builder = $db->table($table);
	if(!empty($field)){
		$builder->where($field, $id);
	} else {
		$builder->where('id', $id);
	}
	return $builder->delete();
}

public function complete_roster($roster_id) {
	$rosterdata = array(
     'is_complete' => 1	
	);
	 $db  = \Config\Database::connect();
        $builder = $db->table('li_event_orders');
		$builder->where('event_order_id', $roster_id);
        return $builder->update($rosterdata);
}



}

