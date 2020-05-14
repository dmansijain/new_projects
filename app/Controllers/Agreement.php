<?php namespace App\Controllers;

class Agreement extends BaseController
{
	public function index()
	{
		// die; 
		return view('frontend/index');
	}

    public function billing()
	{
		
		echo view('frontend/checkout/billing');
	}
	
	public function payment()
	{
		
		echo view('frontend/checkout/payment');
	}
	
	public function agreements()
	{
		
		echo view('frontend/checkout/agreements');
	}
	public function eventagreement()
	{
		
		echo view('frontend/checkout/event-agreement');
	}
	
	public function healthinfo()
	{
		
		echo view('frontend/checkout/healthinfo');
	}
	public function notifications()
	{
		
		echo view('frontend/checkout/notifications');
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
