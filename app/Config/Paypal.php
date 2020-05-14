<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
 
// ------------------------------------------------------------------------ 
// PayPalPro library configuration 
// ------------------------------------------------------------------------ 
 
// PayPal environment, Sandbox or Live 
$config['sandbox'] = TRUE; // FALSE for live environment 
 
// PayPal API credentials 
$config['paypal_api_username']  = 'PayPal_API_Username'; 
$config['paypal_api_password']  = 'PayPal_API_Password'; 
$config['paypal_api_signature'] = 'PayPal_API_Signature';