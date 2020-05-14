<?php namespace App\Models;

use CodeIgniter\Model;

class TestimonialModel extends Model
{
        protected $table = 'li_testimonials';
		
		public function getAlldata()
{
	    $db  = \Config\Database::connect();
        $builder = $db->table('li_testimonials');
        $query   = $builder->get();
		return $query->getResult();
}
		
		public function getAllActivedata()
{
	    $db  = \Config\Database::connect();
        $builder = $db->table('li_testimonials')->where('is_active', 1);
        $query   = $builder->get();
		return $query->getResult();
}

public function getDetail($id)
{
	    $db  = \Config\Database::connect();
        $builder = $db->table('li_testimonials');
		$builder->where('id', $id);
        $query   = $builder->get();
		return $query->getRow();
}

public function updateDetail($data, $id)
{
	    $db  = \Config\Database::connect();
        $builder = $db->table('li_testimonials');
        $builder->where('id', $id);
        return $builder->update($data);
}
public function saveDetail($data)
{
	    $db  = \Config\Database::connect();
        $builder = $db->table('li_testimonials');
        return $builder->insert($data);
		
		
}

public function deleteTestimonial($id)
{
	    $db  = \Config\Database::connect();
        $builder = $db->table('li_testimonials');
		$builder->where('id', $id);
        return $builder->delete();
		
		
}

}

