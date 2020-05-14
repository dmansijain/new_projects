<?php namespace App\Controllers;

class Customer extends BaseController
{
	
	public function __construct()
    {
		 helper(['common']);
    }
	public function index()
	{
		
		 $session = \Config\Services::session();
		//print_r($session->get('user_data')->role);
        if($session->get('is_logged_in')!=true )
            {
				return redirect()->to(base_url());
			}  
		
		
		return view('frontend/index');
	}

    public function home()
	{
		
		echo view('frontend/home');
	}
	
	public function churches()
	{
		
		echo view('frontend/churches');
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
		
		echo view('frontend/profileeventlist');
	}
	
	public function myprofile()
	{
		
		echo view('frontend/myprofile');
			
	} 
	
	public function changepassword() {
		echo view('frontend/change_password');
	}
	
	public function myevent()
	{
		
		echo view('frontend/myevent');
			
	}
	
	public function myskills()
	{
		
		echo view('frontend/myskills');
			
	}
	
	
	public function depositePayment()
	{
		
		echo view('frontend/checkout/depositepayment');
	}	
	
	public function healthinfo()
	{
		
		echo view('frontend/myhealthinfo');
			
	} 
	
	public function mygroup()
	{
		
		echo view('frontend/mygroup');
			
	} 
	public function myresults()
	{
		
		echo view('frontend/myresults');
			
	} 
	public function myjourney()
	{
		
		echo view('frontend/myjourney');
			
	} 
	
	public function myrewards() {
		echo view('frontend/myrewards');
	}
	
	
	public function about()
	{
		
		echo view('frontend/about');
	}
	public function contact()
	{
		
		echo view('frontend/contact');
	}
	
	public function group_mail() {
		echo view('frontend/group-mail-form');
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
