<?php namespace App\Controllers;

class Home extends BaseController
{
	public function __construct()
    {
		 helper(['common']);
    }
	public function index()
	{
		 
		return view('frontend/index');
	}

    public function home()
	{
		
		echo view('frontend/home');
	}
	
	public function reset_password()
	{
		
		echo view('frontend/reset_password');
	}
	
	public function churches()
	{
		
		echo view('frontend/churches');
	}
	public function success(){
		
		echo view('frontend/checkout/success');
	}
	
	public function checkout()
	{
		
		echo view('frontend/checkout');
	}
	
	public function mens()
	{
		
		echo view('frontend/mens');
	}
	public function womens()
	{
		
		echo view('frontend/womens');
	}
	public function couples()
	{
		
		echo view('frontend/couples');
	}
	public function eventlist()
	{
		
		echo view('frontend/eventlist');
	}
	
	public function eventdetail()
	{
		
		echo view('frontend/eventdetail');
	}
	
	
	public function about()
	{
		
		echo view('frontend/about');
	}
	public function contact()
	{
		
		echo view('frontend/contact');
	}
	public function logout()
	{
		$session = \Config\Services::session();
		$session->destroy();
		die;
		//return redirect()->to(base_url().'login');
	}
	//--------------------------------------------------------------------

}
