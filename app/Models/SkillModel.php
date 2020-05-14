<?php namespace App\Models;

use CodeIgniter\Model;

class SkillModel extends Model
{
        protected $table = 'li_skills';
		
		public function getAlldata()
{
	    $db  = \Config\Database::connect();
        $builder = $db->table('li_skills');
        $query   = $builder->get();
		return $query->getResult();
}	

public function getAllActivedata()
{
	    $db  = \Config\Database::connect();
        $builder = $db->table('li_skills')->where('is_active', 1);
        $query   = $builder->get();
		return $query->getResult();
}

public function getDetail($id)
{ 

	    $db  = \Config\Database::connect();
        $builder = $db->table('li_skills');
		$builder->where('id', $id);
        $query   = $builder->get();
		
		return $query->getRow();
}

public function updateData($data, $id)
{
	    $db  = \Config\Database::connect();
        $builder = $db->table('li_skills');
        $builder->where('id', $id); 
        return $builder->update($data);
}
public function saveData($data)
{
	    $db  = \Config\Database::connect();
        $builder = $db->table('li_skills');
        return $builder->insert($data);		
}

public function AssignTouser($data)
{
	    $db  = \Config\Database::connect();
        $builder = $db->table('li_user_skills');
        return $builder->insert($data);		
}
public function getAssignskill($user_id)
{
	    $db  = \Config\Database::connect();
        $builder = $db->table('li_skills');
          $builder->select('li_skills.*, li_user_skills.skill_id, li_user_skills.user_id, li_user_skills.skill_count');
          $builder->join('li_user_skills', 'li_user_skills.skill_id = li_skills.id');
		  $builder->where('li_user_skills.user_id', $user_id);
          $query = $builder->get();
		
		 //echo $db->getLastQuery();
		 //die;
		return $query->getResult();
}
public function exist_user_skill($user_id, $skill_id)
{
	    $db  = \Config\Database::connect();
		$builder = $db->table('li_user_skills');
		$builder->where('user_id', $user_id);
		$builder->where('skill_id', $skill_id);
        $query   = $builder->countAllResults();
		//print_r($query);
		//echo $db->getLastQuery(); 
		//echo $query->numrows;
		//die;
		if($query > 0)
            {
                return true;
            }
            else
		return false;
}

public function deleteSkill($id) {
	$db  = \Config\Database::connect();
        $builder = $db->table('li_skills');
		$builder->where('id', $id);
        return $builder->delete();
}

public function add_skills_to_user($skilldata) {
	$db  = \Config\Database::connect();
		$builder = $db->table('li_user_skills');
		$builder->where('user_id', $skilldata['user_id']);
		$builder->where('skill_id', $skilldata['skill_id']);
		 $query   = $builder->get()->getRow();
		 if(!empty($query)) {
			 $skilldata = array('skill_count' => $query->skill_count + 1);
			 $builder = $db->table('li_user_skills');
			 $builder->where('id', $query->id);
			 return  $builder->update($skilldata);
		 } else {
			 $builder = $db->table('li_user_skills');
			 return  $builder->insert($skilldata);
		 }
}

}

