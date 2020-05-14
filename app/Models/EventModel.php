<?php namespace App\Models;

use CodeIgniter\Model;

class EventModel extends Model
{
        protected $table = 'li_events';
		
		public function getAlldata($event_cat="", $event_type="", $orderby="", $keyword="", $skill="", $start="" , $limit = "")
{
	    $db  = \Config\Database::connect();
        $builder = $db->table('li_events');
		$builder->select('li_events.*, li_eventcategory.title as cattitle, li_eventtype.title as typetitle, li_eventtype_name.title as typenametitle, li_event_community.title as communitytitle');
		$builder->join('li_eventcategory', 'li_eventcategory.id = li_events.event_category');
		$builder->join('li_eventtype', 'li_eventtype.id = li_events.event_type');
		$builder->join('li_eventtype_name', 'li_eventtype_name.id = li_events.event_typename','LEFT');
		$builder->join('li_event_community', 'li_event_community.id = li_events.event_community');
		$builder->join('li_groups', 'li_groups.id = li_events.id','LEFT');
		if($skill!=""){
			$builder->where("FIND_IN_SET('$skill',li_events.skill_requirement) !=", 0);
		//$builder->FIND_IN_SET('li_events.skill_requirement', $skill);
		}
		
		if($event_cat!=""){
		$builder->where('li_events.event_category', $event_cat);
		}
		if($event_type!=""){
		$builder->where('li_events.event_type', $event_type);
		}
		
		$builder->where('li_events.start_date >=', date('Y-m-d'));
		if($keyword!=""){
		//$array = array('li_eventtype_name.title' => $keyword, 'li_events.location' => $keyword, 'li_events.details' => $keyword, 'li_events.details' => $keyword);
		
        $like_query = "(`li_eventtype_name`.`title` LIKE '%".$keyword."%' OR  `li_events`.`location` LIKE '%".$keyword."%' OR  `li_events`.`details` LIKE '%".$keyword."%' OR  `li_events`.`event_typename` LIKE '%".$keyword."%')";		
		$builder->where($like_query);
		
		
		//$builder->orLike($array);
		
		}
		
		$builder->where('li_events.is_delete', 0);
		if($orderby=="oldest"){
		$builder->orderBy('li_events.start_date', 'desc');
		}
		if($orderby=="newest"){
		$builder->orderBy('li_events.start_date', 'asc');
		}
		if($limit) {
			$builder->limit($limit, $start);
		}
        $query   = $builder->get();
		
		return $query->getResult();
}

public function getAlladmindata($from_date="", $end_date="", $orderby="")
{ 
	    $db  = \Config\Database::connect();
        $builder = $db->table('li_events');
		$builder->select('li_events.*, li_eventcategory.title as cattitle, li_eventtype.title as typetitle, li_eventtype_name.title as typenametitle, li_event_community.title as communitytitle, li_groups.group_name');
        $builder->join('li_eventcategory', 'li_eventcategory.id = li_events.event_category');
		$builder->join('li_eventtype', 'li_eventtype.id = li_events.event_type');
		$builder->join('li_eventtype_name', 'li_eventtype_name.id = li_events.event_typename','LEFT');
		$builder->join('li_event_community', 'li_event_community.id = li_events.event_community');
		$builder->join('li_groups', 'li_groups.id = li_events.id','LEFT');
		$builder->where('li_events.is_delete', 0);
		if($from_date!=""){
		$builder->where('li_events.start_date >=', $from_date);
		}
		if($end_date!=""){
		$builder->where('li_events.start_date <=', $end_date);
		}
		
		if($orderby=="oldest"){
		$builder->orderBy('li_events.start_date', 'desc');
		}
		if($orderby=="newest"){
		$builder->orderBy('li_events.start_date', 'asc');
		}
        $query   = $builder->get();
		//echo $db->getLastQuery();exit;
		return $query->getResult();
}

public function getAlleventmanagerdata($user_id, $from_date="", $end_date="", $orderby="")
{ 
	    $db  = \Config\Database::connect();
        $builder = $db->table('li_events');
		$builder->select('li_events.*, li_eventcategory.title as cattitle, li_eventtype.title as typetitle, li_eventtype_name.title as typenametitle, li_event_community.title as communitytitle');
        $builder->join('li_eventcategory', 'li_eventcategory.id = li_events.event_category');
		$builder->join('li_eventtype', 'li_eventtype.id = li_events.event_type');
		$builder->join('li_eventtype_name', 'li_eventtype_name.id = li_events.event_typename','LEFT');
		$builder->join('li_event_community', 'li_event_community.id = li_events.event_community');
		$builder->join('li_groups', 'li_groups.id = li_events.id','LEFT');
		$builder->where('li_events.created_by', $user_id);
		$builder->where('li_events.is_delete', 0);
		if($from_date!=""){
		$builder->where('li_events.start_date >=', $from_date);
		}
		if($end_date!=""){
		$builder->where('li_events.start_date <=', $end_date);
		}
		
		if($orderby=="oldest"){
		$builder->orderBy('li_events.start_date', 'desc');
		}
		if($orderby=="newest"){
		$builder->orderBy('li_events.start_date', 'asc');
		}
        $query   = $builder->get();
		
		return $query->getResult();
}


public function getDetail($id)
{ 

	    $db  = \Config\Database::connect();
        $builder = $db->table('li_events');
		$builder->select('li_events.*, li_eventcategory.title as cattitle, li_eventtype.title as typetitle, li_eventtype_name.title as typenametitle, li_event_community.title as communitytitle');
		$builder->join('li_eventcategory', 'li_eventcategory.id = li_events.event_category');
		$builder->join('li_eventtype', 'li_eventtype.id = li_events.event_type');
		$builder->join('li_eventtype_name', 'li_eventtype_name.id = li_events.event_typename','LEFT');
		$builder->join('li_event_community', 'li_event_community.id = li_events.event_community');
		$builder->where('li_events.id', $id);
        $query   = $builder->get();
		
		return $query->getRow();
}

public function updateData($data, $id)
{
	    $db  = \Config\Database::connect();
        $builder = $db->table('li_events');
        $builder->where('id', $id); 
        return $builder->update($data);
}
public function saveData($data)
{
	    $db  = \Config\Database::connect();
        $builder = $db->table('li_events');
        return $builder->insert($data);
		
		
}

public function getAlldataby($table, $data="", $limit = "")
{
	    $db  = \Config\Database::connect();
        $builder = $db->table($table);
		if($data!=""){
			$builder->where($data); 
		}
		if($limit) {
			$builder->limit($limit);
		}
        $query   = $builder->get();
		
		return $query->getResult();
}



public function saveDataby($table, $data)
{
	    $db  = \Config\Database::connect();
        $builder = $db->table($table);
        return $builder->insert($data);
		
		
}
 
public function getAllleader($data="", $skill="",  $condition="")
{
	$result1=array();
	foreach($skill as $skil){
	    $db  = \Config\Database::connect();
		$builder = $db->table('li_users');
          $builder->select('li_users.*, li_user_skills.skill_id, li_user_skills.user_id');
          $builder->join('li_user_skills', 'li_user_skills.user_id = li_users.ID');
		  if($skil!=""){
			$builder->where('li_user_skills.skill_id', $skil); 
		}
		  // if($skill!=""){
			  // $i=0;
			  // foreach($skill as $skil){
				  // if($condition[$i]=='OR'){
          // $builder->orHaving('li_user_skills.skill_id', $skil);
				  // } else {
					  // $builder->having('li_user_skills.skill_id', $skil);
				  // }
				  // $i++;
			  // }
		  // }
		  
		 
          $query = $builder->get();
		
		// echo $db->getLastQuery();
		// die;
		$result = $query->getResult('array');
		//print_r($result);
		$result1=array_merge($result1,$result);
		//echo "<pre>";
		//print_r($result);
	}
	//print_r(array_unique($result1));

foreach($result1 as $element) {
    $hash = $element['ID'];
    $unique_array[$hash] = $element;
}
//print_r($unique_array);

	//die;
	return $unique_array;
}

public function getconcatEventtypename($data="")
{
	    $db  = \Config\Database::connect();
        $builder = $db->table('li_events t1')->select("concat(t2.title,' ', DATE_FORMAT(t1.start_date, '%m/%d/%Y')) as event_name, t1.id, t2.title")->join('li_eventtype_name t2','t2.id = t1.event_typename');
		if($data!=""){
			$builder->where($data); 
		}
        $query   = $builder->get();
		//echo $db->getLastQuery();exit;
		return $query->getResult();
}

public function checkUserEventRegistration($eventId, $userinfo = "", $on_check = "user_id") {
	$db  = \Config\Database::connect();
	if(!empty($userinfo) && ($on_check == "user_id")) { 
        $builder = $db->table('li_event_orders t1')->select("*")->where('event_id', $eventId)->where('user_id', $userinfo)->get()->getRow();
	} else {
		$builder = $db->table('li_billing_info t1')->select("*")->where('event_id', $eventId)->where('email', $userinfo)->get()->getRow();
	}
		
		return $builder;
}

public function get_registered_events_by_user($user_id) {
	$db  = \Config\Database::connect();
        $builder = $db->table('li_events t1')->select('t1.*, t3.title')->join('li_event_orders t2', 't2.event_id = t1.id');
		$builder->join('li_eventtype_name t3', 't3.id = t1.event_typename');
		$builder->where('t2.user_id', $user_id);
		
		
		
        $query   = $builder->get();
		return $query->getResult();
}

public function get_user_upcoming_events($user_id = "", $event_cat="", $type="", $orderby="", $keyword="", $skill="", $start= 0, $limit="") {
	$db  = \Config\Database::connect();
        $builder = $db->table('li_events t1')->select('t1.*,t2.*, t3.title, t4.title as cattitle, t5.title as typetitle, t6.title as communitytitle')->join('li_event_orders t2', 't2.event_id = t1.id');
		$builder->join('li_eventtype_name t3', 't3.id = t1.event_typename','LEFT');
		$builder->join('li_eventcategory t4', 't4.id = t1.event_category');
		$builder->join('li_eventtype t5', 't5.id = t1.event_type');
		$builder->join('li_event_community t6', 't6.id = t1.event_community');
		if(!empty($user_id)) {
			$builder->where('t2.user_id', $user_id);
		}
		if($skill!=""){
			$builder->where("FIND_IN_SET('$skill',t1.skill_requirement) !=", 0);
		
		}
		if($event_cat!=""){
		$builder->where('t1.event_category', $event_cat);
		}
		if($type!=""){
		$builder->where('t1.event_type', $type);
		}
		$builder->where('t1.start_date >=', date('Y-m-d')); 
		
		if($keyword!=""){
		
		
        $like_query = "(`t3`.`title` LIKE '%".$keyword."%' OR  `t1`.`location` LIKE '%".$keyword."%' OR  `t1`.`details` LIKE '%".$keyword."%')";		
		$builder->where($like_query);
		
		
		
		
		}
		if($orderby=="oldest"){
			$builder->orderBy('t1.start_date', 'desc');
		}
		else if($orderby=="newest"){
			$builder->orderBy('t1.start_date', 'asc');
		} else {
			$builder->orderBy('t1.start_date','asc');
		}
		if(!empty($limit)){
			$builder->limit($limit, $start);
		}
		
        $query   = $builder->get();
		
		return $query->getResult();
}

public function get_user_past_events($user_id, $start= 0, $limit="") {
	$db  = \Config\Database::connect();
        $builder = $db->table('li_events t1')->select('t1.*,t3.title as typenametitle, t4.title as cattitle')->join('li_event_orders t2', 't2.event_id = t1.id');
		$builder->join('li_eventtype_name t3', 't3.id = t1.event_typename','LEFT');
		$builder->join('li_eventcategory t4', 't4.id = t1.event_category');
		$builder->where('t2.user_id', $user_id);
		$builder->where('t1.start_date <', date('Y-m-d')); 
		if(!empty($limit)){
			$builder->limit($limit, $start);
		}
        $query   = $builder->get();
		return $query->getResult();
}
	public function get_partcipate_users_registered_event($events, $eventparticipants, $event_cat="", $type="", $orderby="", $keyword="", $skill="", $start= 0, $limit="") {
		
			$db  = \Config\Database::connect();
			$builder = $db->table('li_events t1')->select('t1.*, t3.title,t4.title as cattitle, t5.title as typetitle, t6.title as communitytitle')->join('li_event_orders t2', 't2.event_id = t1.id');
			$builder->join('li_eventtype_name t3', 't3.id = t1.event_typename','LEFT');
			$builder->join('li_eventcategory t4', 't4.id = t1.event_category');
			$builder->join('li_eventtype t5', 't5.id = t1.event_type');
			$builder->join('li_event_community t6', 't6.id = t1.event_community');
			$builder->whereIn('t2.user_id', $eventparticipants);
			$builder->whereNotIn('t1.id', $events);
			if($skill!=""){
			
			$builder->where("FIND_IN_SET('$skill',t1.skill_requirement) !=", 0);
		
			}
			if($event_cat!=""){
				
			$builder->where('t1.event_category', $event_cat);
			
			}
			if($type!=""){
				
			$builder->where('t1.event_type', $type);
			
			}
			
			$builder->where('t1.start_date >=', date('Y-m-d'));

			if($keyword!=""){
		
				$like_query = "(`t3`.`title` LIKE '%".$keyword."%' OR  `t1`.`location` LIKE '%".$keyword."%' OR  `t1`.`details` LIKE '%".$keyword."%')";		
				$builder->where($like_query);
				
			}
			if($orderby=="oldest"){
				$builder->orderBy('t1.start_date', 'desc');
			}
			else if($orderby=="newest"){
				$builder->orderBy('t1.start_date', 'asc');
			} else {
				$builder->orderBy('t1.start_date','asc');
			}
			
			if(!empty($limit)){
			 $builder->limit($limit, $start);
			}
			
			$query   = $builder->get();
			 
			return $query->getResult();
	}

	public function get_all_participants_by_events($events, $user_id) {
		$db  = \Config\Database::connect();
			$builder = $db->table('li_events t1')->select('t3.*')->join('li_event_orders t2', 't2.event_id = t1.id')->join('li_users t3', 't3.id = t2.user_id');
			
			$builder->where('t2.user_id !=', $user_id);
			$builder->whereIn('t1.id', $events)->groupBy("t2.user_id"); 
			
			$query   = $builder->get();
			/* echo $db->getLastQuery();
			die; */
			return $query->getResult();
	}
		public function get_payment_by_payment_id($payment_id) {
			$db  = \Config\Database::connect();
			$builder = $db->table('li_payment');
			$builder->where('id', $payment_id);
			 $query   = $builder->get();
				//echo $db->getLastQuery();exit;
				return $query->getRow();
		}
		
		public function get_event_order_by_unique_event_order($order_id){
			$db  = \Config\Database::connect();
			$builder = $db->table('li_event_orders');
			$builder->select('li_event_orders.*, li_events.*, li_eventtype_name.title as typenametitle,CONCAT(li_attende_info.first_name," ", li_attende_info.last_name) as full_name');
			$builder->join('li_events', 'li_events.id = li_event_orders.event_id');
			$builder->join('li_eventtype_name', 'li_eventtype_name.id = li_events.event_typename');
			$builder->join('li_attende_info', 'li_attende_info.id = li_event_orders.attende_id');
			$builder->where('li_event_orders.unique_event_order', $order_id);
			 $query   = $builder->get();
				//echo $db->getLastQuery();exit;
				return $query->getRow();
		}
		public function get_event_order_by_order_id($order_id){
			$db  = \Config\Database::connect();
			$builder = $db->table('li_event_orders');
			$builder->select('li_event_orders.*, li_events.*, li_eventtype_name.title as typenametitle,CONCAT(li_attende_info.first_name," ", li_attende_info.last_name) as full_name');
			$builder->join('li_events', 'li_events.id = li_event_orders.event_id');
			$builder->join('li_eventtype_name', 'li_eventtype_name.id = li_events.event_typename');
			$builder->join('li_attende_info', 'li_attende_info.id = li_event_orders.attende_id');
			$builder->where('li_event_orders.event_order_id', $order_id);
			 $query   = $builder->get();
				//echo $db->getLastQuery();exit;
				return $query->getRow();
		}
		
		public function get_skills_requirement_events($user_id, $event_cat="", $type="", $orderby="", $keyword="", $skill="", $start= 0, $limit=""){
			$db  = \Config\Database::connect();
        $builder = $db->table('li_events t1')->select('t1.*,t2.*, t3.title, t4.title as cattitle, t5.title as typetitle, t6.title as communitytitle')->join('li_event_orders t2', 't2.event_id = t1.id');
		$builder->join('li_eventtype_name t3', 't3.id = t1.event_typename','LEFT');
		$builder->join('li_eventcategory t4', 't4.id = t1.event_category');
		$builder->join('li_eventtype t5', 't5.id = t1.event_type');
		$builder->join('li_event_community t6', 't6.id = t1.event_community');
		$builder->where('t2.user_id', $user_id);
		if($skill!=""){
			$builder->where("FIND_IN_SET('$skill',t1.skill_requirement) !=", 0);
		
		} else {
			$builder->where("t1.skill_requirement !=", 0);
		}
		if($event_cat!=""){
		$builder->where('t1.event_category', $event_cat);
		}
		if($type!=""){
		$builder->where('t1.event_type', $type);
		}
		$builder->where('t1.start_date >=', date('Y-m-d')); 
		
		if($keyword!=""){
		
		
        $like_query = "(`t3`.`title` LIKE '%".$keyword."%' OR  `t1`.`location` LIKE '%".$keyword."%' OR  `t1`.`details` LIKE '%".$keyword."%')";		
		$builder->where($like_query);
		
		
		
		
		}
		if($orderby=="oldest"){
			$builder->orderBy('t1.start_date', 'desc');
		}
		else if($orderby=="newest"){
			$builder->orderBy('t1.start_date', 'asc');
		} else {
			$builder->orderBy('t1.start_date','asc');
		}
		if(!empty($limit)){
			$builder->limit($limit, $start);
		}
		
		
        $query   = $builder->get();
		
		return $query->getResult();
		}

	public function get_upcoming_event_prior_to_somedays($day) {
		
		$db  = \Config\Database::connect();
		$date = strtotime(date('Y-m-d'));
		$date = strtotime($day, $date);
		$date = date('Y-m-d', $date);
		
        $builder = $db->table('li_events t1')->select('t1.*,t2.*, t3.title, t4.title as cattitle, t5.title as typetitle, t6.title as communitytitle, t7.email, CONCAT(t7.first_name," ",t7.last_name) as full_name')->join('li_event_orders t2', 't2.event_id = t1.id');
	
		$builder->join('li_eventtype_name t3', 't3.id = t1.event_typename');
		$builder->join('li_eventcategory t4', 't4.id = t1.event_category');
		$builder->join('li_eventtype t5', 't5.id = t1.event_type');
		$builder->join('li_event_community t6', 't6.id = t1.event_community');
		$builder->join('li_users t7', 't7.ID = t2.user_id');
		
		$builder->where('t1.start_date', $date); 
		$builder->orderBy('t1.start_date','asc');
		
		$query   = $builder->get();
		
		return $query->getResult();
	}
	
	public function getCountGroupEventOrders($event_id) {
		$db  = \Config\Database::connect();
		$result = $db->table('li_events t1')->join('li_event_orders t2','t2.event_id = t1.id')->where('t1.id', $event_id)->where('t2.is_group', 1)->get()->getResultArray();
		return count($result);
	}

}

