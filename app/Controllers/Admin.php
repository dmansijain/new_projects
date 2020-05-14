<?php namespace App\Controllers;
use App\Models\LoginModel;
use CodeIgniter\Controller;

class Admin extends Controller
{
	public function __construct()
    {
		helper(['common']);
		
		
    }
	
	public function index()
	{
		$session = \Config\Services::session();
		//print_r($session->get('user_data')->role);
       if($session->get('is_logged_in')!=true || ($session->get('user_data')->role !='admin' && $session->get('user_data')->role !='event_manager'))
            {
               return redirect()->to(base_url().'login');
            } 
		return view('admin/index');
	}

    public function dashboard()
	{
		
		$model = new LoginModel();
		
		echo view('admin/dashboard');
	}
	
	public function availability()
	{
		
		$model = new LoginModel();
		
		echo view('admin/availability');
	}
	
	public function appointments()
	{
		
		$model = new LoginModel();
		
		echo view('admin/appointments');
	}
	
	public function users()
	{
		$session = \Config\Services::session();
		
		
		$model = new LoginModel();
		
		echo view('admin/allusers');
	}
	public function editUser()
	{
		
		$model = new LoginModel();
		
		echo view('admin/user-edit-form');
	}
	
	public function skillsJourney()
	{
		
		$model = new LoginModel();
		
		echo view('admin/user-skills-jorney');
	}
	
	public function testimonials()
	{
		
		$model = new LoginModel();
		
		echo view('admin/alltestimonial');
	}
	
	public function events()
	{
		
		$model = new LoginModel();
		
		echo view('admin/allevents');
	}
	
	public function eventDetail()
	{
		
		$model = new LoginModel();
		
		echo view('admin/eventdetail');
	}
	
	public function editEvent()
	{
		
		$model = new LoginModel();
		
		echo view('admin/event-edit-form');
	}
	
	public function skills()
	{
		
		$model = new LoginModel();
		
		echo view('admin/allskills');
	}
	
	public function editSkill()
	{
		
		$model = new LoginModel();
		
		echo view('admin/skill-edit-form');
	}
	
	
	public function editTestimonial()
	{
		
		$model = new LoginModel();
		
		echo view('admin/testimonial-edit-form');
	}
	public function pages()
	{
		
		$model = new LoginModel();
		echo view('admin/allpages');
	}
	public function editPage()
	{
		
		$model = new LoginModel();
		
		echo view('admin/page-edit-form');
	}
	public function settings()
	{
		
		$model = new LoginModel();
		echo view('admin/settings-edit-form');
	}
	
	public function payment_plan_setting()
	{
		
		$model = new LoginModel();
		echo view('admin/paymentplan-settings-edit-form');
	}
	
	public function group_manage()
	{
		
		$model = new LoginModel();
		echo view('admin/allgroups');
	}
	
	public function editGroup()
	{
		
		$model = new LoginModel();
		
		echo view('admin/group-edit-form');
	}
	
	public function emailGroup()
	{
		
		$model = new LoginModel();
		
		echo view('admin/group-email-form');
	}
	
	public function rosters()
	{
		
		$model = new LoginModel();
		
		echo view('admin/allrosters');
	}
	
	public function rosterDetail()
	{
		
		$model = new LoginModel();
		
		echo view('admin/roster_detail');
	}
	
	//--------------------------------------------------------------------

}
