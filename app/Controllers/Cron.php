<?php namespace App\Controllers;
use App\Models\EventModel;
use App\Models\CheckoutModel;
use CodeIgniter\RESTful\ResourceController;
//$session = \Config\Services::session();

class Cron extends ResourceController
{ 

    

    public function __construct()
    {
        helper(['common']);
		
    }
	
	public function event_reminder_mail() {
		$model = new EventModel();
		$eventorders = $model->get_upcoming_event_prior_to_somedays("+7 day");
		$view = \Config\Services::renderer();
		foreach($eventorders as $orders) {
			
			$view_data = array(
						'name' => $orders->full_name,
						'event_content' => 'Thank you for registering for '. $orders->title.', '.$orders->location.', '.$orders->start_date.' .It is a reminder email that this event is coming up soon. The event details are as follows:',
						'event_title' => $orders->title,
						'event_start_date' => $orders->start_date,
						'event_location' => $orders->location
						
				);
				$maildata = array(
				  'to' => $orders->email,
				  'subject' => "Event reminder",
				  'message' => $view->setData($view_data)->render('email/event_reminder')
				);
				send_mail($maildata);
		}
		
		
	}
	
		public function event_followup_mail() {
		$model = new EventModel();
		$eventorders = $model->get_upcoming_event_prior_to_somedays("-1 day");
		$view = \Config\Services::renderer();
		foreach($eventorders as $orders) {
			
			$view_data = array(
						'name' => $orders->full_name,
						'event_content' => 'Thank you for atteding '. $orders->title.', '.$orders->location.', '.$orders->start_date.' .We hope you find it valuable information. Details related to this event are as follows:',
						'event_title' => $orders->title,
						'event_start_date' => $orders->start_date,
						'event_location' => $orders->location
						
				);
				$maildata = array(
				  'to' => $orders->email,
				  'subject' => "Event Follow Up email",
				  'message' => $view->setData($view_data)->render('email/event_reminder')
				);
				send_mail($maildata);
		}
		
		
	}
	
	public function event_healthinfo_confirmation_mail() {
		$model = new EventModel();
		$eventorders = $model->get_upcoming_event_prior_to_somedays("+3 day");
		$view = \Config\Services::renderer();
		foreach($eventorders as $orders) {
			
			if($orders->healthinfoid) {
				$view_data = array(
						'name' => $orders->full_name,
						'event_content' => 'Your health info details has confirmed for '. $orders->title.', '.$orders->location.', '.$orders->start_date.'. Details related to this event are as follows:',
						'event_title' => $orders->title,
						'event_start_date' => $orders->start_date,
						'event_location' => $orders->location
						
				);
			} else {
				$view_data = array(
						'name' => $orders->full_name,
						'event_content' => 'Please fill your healthinfo related to '. $orders->title.', '.$orders->location.', '.$orders->start_date.' . Details related to this event are as follows:',
						'event_title' => $orders->title,
						'event_start_date' => $orders->start_date,
						'event_location' => $orders->location
						
				);
			}
			
				$maildata = array(
				  'to' => $orders->email,
				  'subject' => "Event Follow Up email",
				  'message' => $view->setData($view_data)->render('email/event_reminder')
				);
				send_mail($maildata);
		}
		
		
	}
	
	public function delete_temporary_billing_data() {
		$model = new CheckoutModel();
		$model->delete_previous_temporary_data();
	}

   
}
