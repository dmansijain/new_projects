<?php namespace App\Controllers;

class Checkout extends BaseController
{
	public function index()
	{
		// die; 
		return view('frontend/index');
	}

    public function billing()
	{
		$session = \Config\Services::session();
		$sessiondata = $session->get();
		if($sessiondata['billinginfo']['event_id']){
		$array_items = array('billinginfo', 'attendeinfo', 'paymentinfo');
$session->remove($array_items);
		}
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
