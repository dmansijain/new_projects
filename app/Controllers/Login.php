<?php namespace App\Controllers;
use App\Models\LoginModel;
use CodeIgniter\Controller;

class Login extends Controller
{
	//protected $helpers = [];

    public function __construct()
    {
        helper(['cookie']);
    }
	public function index()
	{
		
		$model = new LoginModel();
		
		echo view('login');
	}


   public function loginform()
	{
		
		$model = new LoginModel();
		
		echo view('loginform');
	}
	
   public function validatelogin()
	{
		
		$model = new LoginModel();
		
		echo view('loginform');
	}
	
	public function resetpassword()
	{
		
		$model = new LoginModel();
		
		echo view('resetpassword');
	}
	
	public function logout()
	{
		$session = \Config\Services::session();
		$session->destroy();
		return redirect()->to(base_url().'login');
	}
	//--------------------------------------------------------------------

}
