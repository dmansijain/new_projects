<?php namespace App\Controllers;
use App\Models\LoginModel;
use CodeIgniter\Controller;

class Agent extends Controller
{
	public function __construct()
    {
		
		
		
    }
	
	public function index()
	{
		$session = \Config\Services::session();
       if($session->get('is_logged_in')!=true)
            {
               return redirect()->to(base_url().'login');
            } 
		return view('agent/index');
	}

    public function dashboard()
	{
		
		echo view('agent/dashboard');
	}
	
	public function availability()
	{
		
		echo view('agent/availability');
	}
	
	public function appointments()
	{
		
		echo view('agent/appointments');
	}
	
	public function editUser()
	{
		
		echo view('agent/user-edit-form');
	}
	
	//--------------------------------------------------------------------

}
