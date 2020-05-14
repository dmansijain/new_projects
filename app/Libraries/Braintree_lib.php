<?php
namespace App\Libraries;
include APPPATH.'ThirdParty/Braintree/Braintree.php';
//defined('BASEPATH') OR exit('No direct script access allowed');

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

use Request; 



/*
 *  Braintree_lib
 *	Braintree PHP SDK v3.*
 *  For Codeigniter 3.*
 */

class Braintree_lib{

		function __construct() {
			//$CI = &get_instance();
			//$CI->config->load('braintree', TRUE);
			//$braintree = $CI->config->item('braintree');
			//echo "<pre>";print_r($braintree);exit;
			\Braintree_Configuration::environment('sandbox');
			\Braintree_Configuration::merchantId('q4475f8z9dpxjdj5');
			\Braintree_Configuration::publicKey('7fk9xpfnffqbqtx3');
			\Braintree_Configuration::privateKey('371208dc6192e7ea645fa99e1a344247');
		}

    function create_transaction($payment_detail){
    	//$clientToken = \Braintree_ClientToken::generate();
		 $result = \Braintree_Transaction::sale(array(
			 'amount' => $payment_detail['amount'],
			  // 'token' => $clientToken,
			 'creditCard' => array(
			 'number' => $payment_detail['card_number'],
			 'expirationDate' => $payment_detail['card_expire_month'].'/'.$payment_detail['card_expire_year'],
			 'cvv' => $payment_detail['card_cvv']
			)
		  ));
		$settle = /Braintree_Configuration::gateway()->transaction()->submitForSettlement($result->transaction->id);
		

		echo "<pre>";print_r($settle);exit;
		//return $result;
    	
    }
}