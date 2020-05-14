<?php namespace App\Models;

use CodeIgniter\Model;

class GroupModel extends Model
{
        protected $table = 'li_groups';
		
		public function getAlldata()
		{
			$db  = \Config\Database::connect();
			$builder = $db->table('li_groups');
			$builder->select('li_groups.*, li_event_community.title');
			$builder->join('li_event_community','li_event_community.id = li_groups.community')->where('is_delete', 0);
			
			$query   = $builder->get();
			
			return $query->getResult();
		}
	
		public function getgroupDetail($group_id) {
			$db  = \Config\Database::connect();
			$builder = $db->table('li_groups');
			$builder->select('li_groups.*,li_events.id as event_id,li_events.*');
			$builder->join('li_events','li_events.group_id = li_groups.id');
			
			$builder->where('li_groups.id', $group_id);
			$query   = $builder->get();
			
			return $query->getRow();
		}
		
		public function updateData($data, $id)
		{
			$db  = \Config\Database::connect();
			$builder = $db->table('li_groups');
			$builder->where('id', $id); 
			return $builder->update($data);
		}
		public function saveData($data)
		{
				$db  = \Config\Database::connect();
				$builder = $db->table('li_groups');
				$builder->insert($data);
				return $db->insertID();
				
				
		}
		public function deleteGroup($id, $deleted_by) {
		$data =	array('is_delete' => 1);
		$db  = \Config\Database::connect();
        $builder = $db->table('li_groups');
		$builder->where('id', $id);
        $builder->update($data);
		$data =	array('is_delete' => 1, 'delete_by' => $deleted_by);
		$builder = $db->table('li_events');
		$builder->where('group_id', $id);
        return $builder->update($data);
	}
	
	public function checkUniqueGroupName($group_name, $group_id) {
		$db  = \Config\Database::connect();
        $builder = $db->table('li_groups');
		$builder->where('id !=', $group_id)->where('group_name', $group_name);
        return $builder->get()->getRow();
	}
	
	public function get_users_join_group($user_id) {
		$db  = \Config\Database::connect();
        $builder = $db->table('li_groups t1');
		$builder->select('t1.*, t4.title, COUNT(t5.event_order_id) as members_count')->join('li_events t2', 't2.group_id = t1.id');
		$builder->join('li_event_orders t3','t3.event_id = t2.id');
		$builder->join('li_event_community t4','t4.id = t1.community');
		$builder->join('li_event_orders t5','t5.event_id = t2.id');
		$builder->where('t3.user_id', $user_id)->where('t3.is_group', 1);
		
        return $builder->get()->getResult();
	}
	
	public function get_all_group_users($group_id) {
		$db  = \Config\Database::connect();
        $builder = $db->table('li_groups t1');
		$builder->select('t4.email, CONCAT(t4.first_name," ", t4.last_name) as full_name')->join('li_events t2', 't2.group_id = t1.id');
		$builder->join('li_event_orders t3','t3.event_id = t2.id');
		$builder->join('li_users t4','t4.id = t3.user_id');
		$builder->where('t1.id', $group_id);
		$builder->where('t3.is_group', 1);
        
		return $builder->get()->getResult();
	}


}

