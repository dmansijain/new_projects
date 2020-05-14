<?php
namespace App\Libraries;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

use Request;

class Paypal
{
	

    public $paypal_sandbox_account = 'raghavendra@business.com';
    public $paypal_sandbox_client_id = "ARMcszH-nIEXEkvPXt695vTHdphiLRFB7D4xZ2nzdIUPzXczPjNZvPZfW7gXqjlhPfAWp31f5Sb_earM";
    public $paypal_sandbox_secret = "EFHEXVB9dR-tGqb86t8YVhhyn0HZNXUOVZfjQwHrCx4TpbgR471kPvJF-BfKHTZxX0aWdGr6nHj-vCHb";
    public $paypal_sandbox_token_url = "https://api.sandbox.paypal.com/v1/oauth2/token";
    public $paypal_sandbox_payment_url = "https://api.sandbox.paypal.com/v1/payments/payment";
    public $error = array();
    public $data = array();
    public $return = array();

    public function paypal123()
    {
        $ch = curl_init();
        $clientId = "myId";
        $secret = "mySecret";

        curl_setopt($ch, CURLOPT_URL, "https://api.sandbox.paypal.com/v1/oauth2/token");
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERPWD, $clientId . ":" . $secret);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=client_credentials");

        $result = curl_exec($ch);

        if (empty($result))
            die("Error: No response.");
        else
        {
            $json = json_decode($result);
            print_r($json->access_token);
        }

        curl_close($ch);
    }

    /* get token form paypal */

    public function getPayPalAccessToken()
    {
        $url = $this->paypal_sandbox_token_url;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "$url");
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERPWD, $this->paypal_sandbox_client_id . ":" . $this->paypal_sandbox_secret);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=client_credentials");


        $result = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if ($result === false)
        {
            return false;
        }

        $json = json_decode($result);

        curl_close($ch);

        if (empty($json))
        {
            return false;
        }

        return (isset($json->access_token)) ? $json->access_token : false;
    }
    

    public function pay_via_credit_card($postdata)
    {
      
         
        $_POST = $postdata;
       /* $validation =  \Config\Services::validation();

        //$form_validation->set_data($_POST);

        $validation->set_rule('amount', 'Amount', 'trim|required|numeric');
        $validation->set_rule('card_type', 'Card Type', 'trim|required');
        $validation->set_rule('card_number', 'Card Number', 'trim|required|numeric');
        $validation->set_rule('card_expire_month', 'Card Expire Month', 'trim|required|numeric');
        $validation->set_rule('card_expire_year', 'Card Expire Year', 'trim|required|numeric');
        $validation->set_rule('card_cvv', 'Card CVV', 'trim|required');

        if ($validation->run() === false)
        {
			echo "<pre>";print_r($postdata);exit;
            $this->error = $this->form_validation->error_array();
            $message = validation_errors();

            $return['success'] = "false";
            $return['title'] = "error";
            $return['message'] = "$message";
            $return['error'] = $this->error;
            $return['data'] = (object) $this->data;

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        } */
		
        $ammount = $postdata['amount'];
        $card_type = $postdata['card_type'];
        $card_number = $postdata['card_number'];
        $card_expire_month = $postdata['card_expire_month'];
        $card_expire_year = $postdata['card_expire_year'];
        $card_cvv = $postdata['card_cvv'];

        /* validate card */

        $vaildatecard = $this->validateCCard($card_number);

        if (!$vaildatecard)
        {
            $return['success'] = "false";
            $return['title'] = "error";
            $return['message'] = "Card is not valid.";
            $return['error'] = $this->error;
            $return['data'] = $this->data;

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }

        /* validate credit card type */

        $creditcardtype = $this->credit_card_type($card_number);

        if (strtolower($creditcardtype) != strtolower($card_type))
        {
            $return['success'] = "false";
            $return['title'] = "error";
            $return['message'] = "Card type is not valid.";
            $return['error'] = $this->error;
            $return['data'] = $this->data;

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }

        /* validate credit card cvv */

        $validatecvv = $this->validateCVV($card_number, $card_cvv);

        if (!$validatecvv)
        {
            $return['success'] = "false";
            $return['title'] = "error";
            $return['message'] = "CVV is not valid.";
            $return['error'] = $this->error;
            $return['data'] = $this->data;

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }

        /* create paypal payment */

        $getPayPalAccessToken = $this->getPayPalAccessToken();
       
        if (!$getPayPalAccessToken)
        {
            $return['success'] = "false";
            $return['title'] = "error";
            $return['message'] = "Something went wrong in getting token from paypal.";
            $return['error'] = $this->error;
            $return['data'] = $this->data;

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
         echo $getPayPalAccessToken;exit;
        $paypalurl = $this->paypal_sandbox_payment_url;
       
        $paypalTotal = (isset($ammount)) ? $ammount : 0.00;
        //$paypalTotal 		= 0.00;
        $paypalCurrency = 'USD';

        /* $paypaljsondata = '{
				"intent": "sale",
				"payer": {
				"payment_method": "credit_card",
				"funding_instruments": [{
                                                            "credit_card": {
                                                                    "number": "' . $card_number . '",
                                                                    "type": "' . $card_type . '",
                                                                    "expire_month": "' . $card_expire_month . '",
                                                                    "expire_year": "' . $card_expire_year . '",
                                                                    "cvv2": "' . $card_cvv . '"	
                                                            }
                                                        }]
				},
				
				"transactions": [{
				"amount": {
				"total": "' . $paypalTotal . '",
				"currency": "' . $paypalCurrency . '"
				}
				}]
			}'; */
			$paypaljsondata = '{
				"intent": "sale",
				"payer": {
				"payment_method": "credit_card",
				"funding_instruments": [{
									"credit_card": {
										"number": "' . $card_number . '",
										"type": "' . $card_type . '",
										"expire_month": "' . $card_expire_month . '",
										"expire_year": "' . $card_expire_year . '",
										"cvv": "' . $card_cvv . '"	
									}
								}]
				},
				
				"transactions": [{
				"amount": {
				"total": "' . $paypalTotal . '",
				"currency": "' . $paypalCurrency . '"
				}
				}]
			}';

echo "<pre>";print_r($paypaljsondata);exit;
        /* do payment */
        
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, "$paypalurl");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $paypaljsondata);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json", "Authorization: Bearer " . $getPayPalAccessToken));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $result = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if ($result === false)
        {
            $this->error = "$result";
            $return['success'] = "false";
            $return['title'] = "error";
            $return['message'] = "Something went wrong.";
            $return['error'] = $this->error;
            $return['data'] = $this->data;

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }


        $json = json_decode($result);
        curl_close($ch);

        /* paypal error handle */
        if ($httpcode === 201)
        {
            if (empty($json))
            {
                $this->error = "$result";
                $return['success'] = "false";
                $return['title'] = "error";
                $return['message'] = "Something went wrong.";
                $return['error'] = $this->error;
                $return['data'] = $this->data;

                $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
            }

            $paymentResponse = $json;

            /* payment response variables */

			echo "<pre>";print_r($paymentResponse);exit;
            $payment_id = $paymentResponse->id;
            $payment_create_time = $paymentResponse->create_time;
            $payment_update_time = $paymentResponse->update_time;
            $payment_state = $paymentResponse->state;

            $payment_payer_payment_method = $paymentResponse->payer->payment_method;
            $payment_payer_funding_instruments = $paymentResponse->payer->funding_instruments;

            if (!$paymentResponse->transactions)
            {

                $return['success'] = "false";
                $return['title'] = "error";
                $return['message'] = "Something went wrong in getting transaction details from paypal.";
                $return['error'] = $this->error;
                $return['data'] = $this->data;

                $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
            }

            $payment_transactions_id = (isset($paymentResponse->transactions[0]->related_resources[0]->sale->id)) ? $paymentResponse->transactions[0]->related_resources[0]->sale->id : '';

            if (!$payment_transactions_id)
            {
                $return['success'] = "false";
                $return['title'] = "error";
                $return['message'] = "Something went wrong in getting transaction id from paypal.";
                $return['error'] = $this->error;
                $return['data'] = $this->data;

                $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
            }



            /* Add in wallet here */

            $userID = $this->user_id;
            $user_transaction_amount = $paypalTotal;
            $user_curr_running_record = $this->getUserAccMaxRunRec($userID);
            $user_next_running_record = $user_curr_running_record + 1;
            $user_date = date('Y-m-d H:i:s');
            $user_available_balance = 0;

            $user_through = 'system';

            /* get max run record of cusomter */
            $getCustomerAccMaxRunRecRow = $this->wallet_model->getCustomerAccMaxRunRecRow($userID, $user_curr_running_record);

            if ($getCustomerAccMaxRunRecRow)
            {
                $user_available_balance = $getCustomerAccMaxRunRecRow->total_balance + $user_transaction_amount;
            } else
            {
                $user_available_balance = $user_transaction_amount;
            }

            //$user_curr_available_balance 	= ($getCustomerAccMaxRunRecRow->available_balance) ? $getCustomerAccMaxRunRecRow->available_balance : $user_transaction_amount;

            $user_transaction_reference = $payment_transactions_id;
            $user_transaction_type = 'credit';

            $adminAccountNo = 1;
            $admin_transaction_amount = $paypalTotal;
            $admin_curr_running_record = $this->getAdminCropAccMaxRunRec();
            $admin_next_running_record = $admin_curr_running_record + 1;
            $admin_date = date('Y-m-d H:i:s');
            $admin_available_balance = 0;

            /* get max run record of admin */
            $getAdminCropAccMaxRunRecRow = $this->wallet_model->getAdminCropAccMaxRunRecRow(1, $admin_curr_running_record);

            if ($getAdminCropAccMaxRunRecRow)
            {
                $admin_available_balance = $getAdminCropAccMaxRunRecRow->total_balance - $admin_transaction_amount;
            }

            //$admin_curr_available_balance 	= ($getCustomerAccMaxRunRecRow->available_balance) ? $getCustomerAccMaxRunRecRow->available_balance : 10000;
            $admin_through = 'system';

            $admin_transaction_reference = $payment_transactions_id;
            $admin_transaction_type = 'debit';

            $this->db->trans_start();

            //$this->db->query('INSERT INTO customer_wallet (account_no, transaction_amount, available_balance, running_record, date, transaction_reference, transaction_type, through) VALUES ("'.$userAccountNo.'", "'.$user_transaction_amount.'", "'.$user_available_balance.'", "'.$user_next_running_record.'", "'.$user_date.'", "'.$user_transaction_reference.'", "'.$user_transaction_type.'", "'.$user_through.'")');

            $customer_wallet_array = array(
                'user_id' => $this->user_id,
                'ammount' => $user_transaction_amount,
                'total_balance' => $user_available_balance,
                'running_record' => $user_next_running_record,
                'date' => $user_date,
                'reference_no' => $user_transaction_reference,
                'transaction_type' => $user_transaction_type,
                'through' => $user_through,
            );

            $this->db->insert('customer_wallet', $customer_wallet_array);
            $customer_wallet_id = $this->db->insert_id();

            //echo $this->db->last_query().'<br/>'; //die;
            $admin_wallet_array = array(
                'transaction_id' => 0,
                'user_id' => 1,
                'ammount' => $admin_transaction_amount,
                'total_balance' => $admin_available_balance,
                'running_record' => $admin_next_running_record,
                'date' => $admin_date,
                'reference_no' => $admin_transaction_reference,
                'transaction_type' => $admin_transaction_type,
                'through' => $admin_through,
            );

            $this->db->insert('customer_wallet', $admin_wallet_array);
            $admin_wallet_id = $this->db->insert_id();

            //$this->db->query('INSERT INTO customer_wallet (account_no, transaction_amount, available_balance, running_record, date, transaction_reference, transaction_type, through) VALUES ("'.$adminAccountNo.'", "'.$admin_transaction_amount.'", "'.$admin_available_balance.'", "'.$admin_next_running_record.'", "'.$admin_date.'", "'.$admin_transaction_reference.'", "'.$admin_transaction_type.'", "'.$admin_through.'")');
            //echo $this->db->last_query(); //die;

            /* save the paypal transaction  */

            $wallet_paypal_tranasction = array(
                'wallet_id' => $customer_wallet_id,
                'token' => $getPayPalAccessToken,
                'txn_id' => $payment_transactions_id,
                'parent_txn_id' => NULL,
                'txn_type' => 'capture',
                'is_closed' => '1',
                'additional_information' => serialize($paymentResponse),
                'created_at' => date('Y-m-d H:i:s'),
            );

            $this->db->insert('customer_wallet_paypal_transaction', $wallet_paypal_tranasction);
            $wallet_paypal_tranasction_id = $this->db->insert_id();

            $this->db->trans_complete();
            //var_dump($this->db->trans_status());
            //die;


            if ($this->db->trans_status() === TRUE)
            {
                /* update wallet rows */

                $this->db->where_in('id', array($customer_wallet_id, $admin_wallet_id));
                $this->db->update('customer_wallet', array('transaction_id' => $wallet_paypal_tranasction_id));

                $return['success'] = "true";
                $return['message'] = "Money has been successfully added in wallet.";
                $return['error'] = $this->error;
                $return['data'] = (object) $this->data;

                $this->response($return, REST_Controller::HTTP_OK);
            }

            $return['success'] = "false";
            $return['message'] = "Something went wrong.";
            $return['error'] = $this->error;
            $return['data'] = (object) $this->data;

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        } elseif ($httpcode === 400)
        {
            $this->error = $json;
            $return['success'] = "false";
            $return['title'] = "error";
            //$return['message'] 		= "CODE: $httpcode, Request is not well-formed, syntactically incorrect, or violates schema.";
            $return['message'] = "CODE: $httpcode, Please provide valid card details.";
            $return['error'] = $this->error;
            $return['data'] = $this->data;

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        } elseif ($httpcode === 401)
        {
            $return['success'] = "false";
            $return['title'] = "error";
            $return['message'] = "CODE: $httpcode, Authentication failed due to invalid authentication credentials.";
            $return['error'] = $this->error;
            $return['data'] = $this->data;

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        } elseif ($httpcode === 403)
        {
            $return['success'] = "false";
            $return['title'] = "error";
            $return['message'] = "CODE: $httpcode, Authorization failed due to insufficient permissions.";
            $return['error'] = $this->error;
            $return['data'] = $this->data;

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        } elseif ($httpcode === 404)
        {
            $return['success'] = "false";
            $return['title'] = "error";
            $return['message'] = "CODE: $httpcode, The specified resource does not exist.";
            $return['error'] = $this->error;
            $return['data'] = $this->data;

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        } elseif ($httpcode === 405)
        {
            $return['success'] = "false";
            $return['title'] = "error";
            $return['message'] = "CODE: $httpcode, The server does not implement the requested HTTP method.";
            $return['error'] = $this->error;
            $return['data'] = $this->data;

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        } elseif ($httpcode === 406)
        {
            $return['success'] = "false";
            $return['title'] = "error";
            $return['message'] = "CODE: $httpcode, The server does not implement the media type that would be acceptable to the client.";
            $return['error'] = $this->error;
            $return['data'] = $this->data;

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        } elseif ($httpcode === 415)
        {
            $return['success'] = "false";
            $return['title'] = "error";
            $return['message'] = "CODE: $httpcode, The server does not support the request payload’s media type.";
            $return['error'] = $this->error;
            $return['data'] = $this->data;

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        } elseif ($httpcode === 422)
        {
            $return['success'] = "false";
            $return['title'] = "error";
            $return['message'] = "CODE: $httpcode, The API cannot complete the requested action, or the request action is semantically incorrect or fails business validation.";
            $return['error'] = $this->error;
            $return['data'] = $this->data;

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        } elseif ($httpcode === 429)
        {
            $return['success'] = "false";
            $return['title'] = "error";
            $return['message'] = "CODE: $httpcode, Too many requests. Blocked due to rate limiting.";
            $return['error'] = $this->error;
            $return['data'] = $this->data;

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        } elseif ($httpcode === 500)
        {
            $return['success'] = "false";
            $return['title'] = "error";
            $return['message'] = "CODE: $httpcode, An internal server error has occurred.";
            $return['error'] = $this->error;
            $return['data'] = $this->data;

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        } elseif ($httpcode === 503)
        {
            $return['success'] = "false";
            $return['title'] = "error";
            $return['message'] = "CODE: $httpcode, Service Unavailable..";
            $return['error'] = $this->error;
            $return['data'] = $this->data;

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        } else
        {
            $return['success'] = "false";
            $return['title'] = "error";
            $return['message'] = "CODE: $httpcode, Something went wrong.";
            $return['error'] = $this->error;
            $return['data'] = $this->data;

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    /* validate CVV of credit card */

    public function validateCVV($cardnumber, $cvv)
    {
        // Get the first number of the credit card so we know how many digits to look for
        $firstnumber = (int) substr($cardnumber, 0, 1);
        if ($firstnumber === 3)
        {
            if (!preg_match("/^\d{4}$/", $cvv))
            {
                // The credit card is an American Express card but does not have a four digit CVV code
                return false;
            }
        } else if (!preg_match("/^\d{3}$/", $cvv))
        {
            // The credit card is a Visa, MasterCard, or Discover Card card but does not have a three digit CVV code
            return false;
        }
        return true;
    }

    /* validate number of credit card */

    public function validateCCard($card_number)
    {

        $card_number = preg_replace('/[^\d]/', '', $card_number);

        $card_length = strlen($card_number);

        $is_even = false;
        $total = $digit = 0;

        if ($card_length < 13 || $card_length > 19)
        {
            return false;
        }

        for ($i = $card_length - 1; $i >= 0; $i--)
        {
            $char = substr($card_number, $i, 1);
            $digit = intval($char, 10);
            if ($is_even)
            {
                if (( $digit *= 2 ) > 9)
                {
                    $digit -= 9;
                }
            }
            $total += $digit;
            $is_even = !$is_even;
        }

        return ( $total % 10 ) === 0;
    }

    /* validate the credit card type  */

    public function credit_card_type($cardNumber)
    {
        $cardNumber = isset($cardNumber) ? $cardNumber : '';

        $number = preg_replace('/[^\d]/', '', $cardNumber);

        if (preg_match('/^3[47][0-9]{13}$/', $number))
        {
            return 'Americanexpress';
        } elseif (preg_match('/^3(?:0[0-5]|[68][0-9])[0-9]{11}$/', $number))
        {
            return 'Dinersclub';
        } elseif (preg_match('/^6(?:011|5[0-9][0-9])[0-9]{12}$/', $number))
        {
            return 'Discover';
        } elseif (preg_match('/^(?:2131|1800|35\d{3})\d{11}$/', $number))
        {
            return 'JCB';
        } elseif (preg_match('/^5[1-5][0-9]{14}$/', $number))
        {
            return 'Mastercard';
        } elseif (preg_match('/^4[0-9]{12}(?:[0-9]{3})?$/', $number))
        {
            return 'Visa';
        } else
        {
            return 'Unknown';
        }
    }

    public function customerWalletLoadMoney_post()
    {
        $this->issetRequiredField();
        //var_dump($this->user_id); die;
        $getUser = $this->wallet_model->getUserById($this->user_id);

        if (!$getUser)
        {
            $return['success'] = "false";
            $return['message'] = "unable to get user.";
            $return['error'] = $this->error;
            $return['data'] = $this->data;

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }

        if (!$getUser->account_no)
        {
            $return['success'] = "false";
            $return['message'] = "user account no not found.";
            $return['error'] = $this->error;
            $return['data'] = $this->data;

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }


        $userAccountNo = $getUser->account_no;
        $user_transaction_amount = 100;
        $user_curr_running_record = $this->getUserAccMaxRunRec($userAccountNo);
        $user_next_running_record = $user_curr_running_record + 1;
        $user_date = date('Y-m-d H:i:s');
        $user_available_balance = 0;

        $user_through = 'system';
        /* get max run record of cusomter */
        $getCustomerAccMaxRunRecRow = $this->wallet_model->getCustomerAccMaxRunRecRow($userAccountNo, $user_curr_running_record);

        if ($getCustomerAccMaxRunRecRow)
        {
            $user_available_balance = $getCustomerAccMaxRunRecRow->available_balance + $user_transaction_amount;
        } else
        {
            $user_available_balance = $user_transaction_amount;
        }

        //$user_curr_available_balance 	= ($getCustomerAccMaxRunRecRow->available_balance) ? $getCustomerAccMaxRunRecRow->available_balance : $user_transaction_amount;

        $user_transaction_reference = 1234567890;
        $user_transaction_type = 'credit';

        $adminAccountNo = $this->admin_crop_acc_no;
        $admin_transaction_amount = 100;
        $admin_curr_running_record = $this->getAdminCropAccMaxRunRec();
        $admin_next_running_record = $admin_curr_running_record + 1;
        $admin_date = date('Y-m-d H:i:s');
        $admin_available_balance = 0;

        /* get max run record of admin */
        $getAdminCropAccMaxRunRecRow = $this->wallet_model->getAdminCropAccMaxRunRecRow($adminAccountNo, $admin_curr_running_record);

        if ($getAdminCropAccMaxRunRecRow)
        {
            $admin_available_balance = $getAdminCropAccMaxRunRecRow->available_balance - $admin_transaction_amount;
        }

        //$admin_curr_available_balance 	= ($getCustomerAccMaxRunRecRow->available_balance) ? $getCustomerAccMaxRunRecRow->available_balance : 10000;
        $admin_through = 'system';

        $admin_transaction_reference = 1234567890;
        $admin_transaction_type = 'debit';

        $this->db->trans_start();

        //$this->db->query('INSERT INTO customer_wallet (account_no, transaction_amount, available_balance, running_record, date, transaction_reference, transaction_type, through) VALUES ("'.$userAccountNo.'", "'.$user_transaction_amount.'", "'.$user_available_balance.'", "'.$user_next_running_record.'", "'.$user_date.'", "'.$user_transaction_reference.'", "'.$user_transaction_type.'", "'.$user_through.'")');

        $customer_wallet_array = array(
            'account_no' => $userAccountNo,
            'transaction_amount' => $user_transaction_amount,
            'available_balance' => $user_available_balance,
            'running_record' => $user_next_running_record,
            'date' => $user_date,
            'transaction_reference' => $user_transaction_reference,
            'transaction_type' => $user_transaction_type,
            'through' => $user_through,
        );

        $this->db->insert('customer_wallet', $customer_wallet_array);
        //echo $this->db->last_query().'<br/>'; //die;
        $admin_wallet_array = array(
            'account_no' => $adminAccountNo,
            'transaction_amount' => $admin_transaction_amount,
            'available_balance' => $admin_available_balance,
            'running_record' => $admin_next_running_record,
            'date' => $admin_date,
            'transaction_reference' => $admin_transaction_reference,
            'transaction_type' => $admin_transaction_type,
            'through' => $admin_through,
        );


        $this->db->insert('customer_wallet', $admin_wallet_array);


        //$this->db->query('INSERT INTO customer_wallet (account_no, transaction_amount, available_balance, running_record, date, transaction_reference, transaction_type, through) VALUES ("'.$adminAccountNo.'", "'.$admin_transaction_amount.'", "'.$admin_available_balance.'", "'.$admin_next_running_record.'", "'.$admin_date.'", "'.$admin_transaction_reference.'", "'.$admin_transaction_type.'", "'.$admin_through.'")');
        //echo $this->db->last_query(); //die;

        $this->db->trans_complete();
        //var_dump($this->db->trans_status());
        //die;


        if ($this->db->trans_status() === TRUE)
        {
            $return['success'] = "true";
            $return['message'] = "Money has been successfully added in wallet.";
            $return['error'] = $this->error;
            $return['data'] = (object) $this->data;

            $this->response($return, REST_Controller::HTTP_OK);
        }

        $return['success'] = "false";
        $return['message'] = "Something went wrong.";
        $return['error'] = $this->error;
        $return['data'] = (object) $this->data;

        $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
    }

    public function getAdminCropAccMaxRunRec()
    {
        $maxRunningRec = 0;
        $getAdminCropAccMaxRunRec = $this->wallet_model->getAdminCropAccMaxRunRec(1);
        if ($getAdminCropAccMaxRunRec)
        {
            $maxRunningRec = $getAdminCropAccMaxRunRec;
        }
        return $maxRunningRec;
    }

    public function getUserAccMaxRunRec($user_crop_acc_no = false)
    {
        if (!$user_crop_acc_no)
        {
            return false;
        }

        $maxRunningRec = 0;
        $getAdminCropAccMaxRunRec = $this->wallet_model->getUserAccMaxRunRec($user_crop_acc_no);

        if ($getAdminCropAccMaxRunRec)
        {
            $maxRunningRec = $getAdminCropAccMaxRunRec;
        }
        return $maxRunningRec;
    }

    public function sayHello_post()
    {
        echo 'hello';
        die;
    }

    public function pay($paypalurl, $paypaljsondata, $getPayPalAccessToken)
    {
        //echo $paypaljsondata; die;
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, "$paypalurl");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $paypaljsondata);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json", "Authorization: Bearer " . $getPayPalAccessToken));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $result = curl_exec($ch);
        print_r($result);
        die;
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $json = json_decode($result);
        curl_close($ch);
        return array($result, $httpcode, $json);
    }

    public function parellelPaypalPayment($currency, $memo, $amount1, $email1, $amount2, $email2, $return_url, $cancel_url)
    {
        $curl = curl_init();
        $postField = "{\r\n\"actionType\":\"PAY_PRIMARY\" ,"
                . "\r\n\"currencyCode\":\"$currency\","
                . "\r\n\"feesPayer\":\"EACHRECEIVER\","
                . "\r\n\"memo\":\"$memo\","
                . "\r\n\"receiverList.receiver(0).amount\":\"$amount1\","
                . "\r\n\"receiverList.receiver(0).email\":\"$email1\","
                . "\r\n\"receiverList.receiver(0).primary\":\"true\","
                . "\r\n\"receiverList.receiver(1).amount\":\"$amount2\","
                . "\r\n\"receiverList.receiver(1).email\":\"$email2\","
                . "\r\n\"receiverList.receiver(1).primary\":\"false\","
                . "\r\n\"requestEnvelope.errorLanguage\":\"en_US\","
                . "\r\n\"returnUrl\":\"$return_url\","
                . "\r\n\"cancelUrl\":\"$cancel_url\"\r\n}";
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://svcs.sandbox.paypal.com/AdaptivePayments/Pay",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $postField,
            CURLOPT_HTTPHEADER => array(
                "Accept: */*",
                "Accept-Encoding: gzip, deflate",
                "Cache-Control: no-cache",
                "Connection: keep-alive",
                "Content-Length: 549",
                "Content-Type: application/json",
                "Cookie: X-PP-SILOVER=name%3DSANDBOX3.APIT.1%26silo_version%3D1880%26app%3Dapapiserv%26TIME%3D1836819549%26HTTP_X_PP_AZ_LOCATOR%3Dsandbox.slc",
                "Host: svcs.sandbox.paypal.com",
                "Postman-Token: 4f1b167c-b599-490a-aaf0-3808c359b105,27b546e0-e892-4e9f-bcf3-b651864a9279",
                "User-Agent: PostmanRuntime/7.18.0",
                "X-PAYPAL-APPLICATION-ID: APP-80W284485P519543T",
                "X-PAYPAL-REQUEST-DATA-FORMAT: NV",
                "X-PAYPAL-RESPONSE-DATA-FORMAT: NV",
                "X-PAYPAL-SECURITY-PASSWORD: VUJCU7PRSEPBN9W4",
                "X-PAYPAL-SECURITY-SIGNATURE: ACXkC-4djPnwJ2bq3YdARSzMIQVgAPIO1ONASu7qlpb84HoNlL9K7M44",
                "X-PAYPAL-SECURITY-USERID: info_api1.mamnoonak.com",
                "cache-control: no-cache"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err)
        {
            echo "cURL Error #:" . $err;
        } else
        {
            echo $response;
        }
    }

    public function generateToken()
    {
        $url = $this->paypal_sandbox_token_url;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "$url");
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERPWD, $this->paypal_sandbox_client_id . ":" . $this->paypal_sandbox_secret);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=client_credentials");


        $result = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if ($result === false)
        {
            return false;
        }

        $json = json_decode($result);

        curl_close($ch);

        if (empty($json))
        {
            return false;
        }

        return (isset($json->access_token)) ? $json->access_token : false;
    }
    public function generateToken123456789()
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.sandbox.paypal.com/v1/oauth2/token",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "grant_type=client_credentials",
            CURLOPT_HTTPHEADER => array(
                "Accept: */*",
                "Accept-Encoding: gzip, deflate",
                "Authorization: Basic QWZjOGU0WENzc19TYkJPdVJtVHB0a0FvM3VZVmgyaFR5ellVYWp1c085QXJHLU13Z3B4Tl9uS2FGUHRWb3ZveHNwUWhJRU1KSDU4ZVNxM3U6RUIzZXhsUlVacW5Zc01MVTRFVDBjYWVCUmZwN0lPZ3AzdDlybWZFV3R6ZV9XcWQzRnZScUoxcXR0cWdiVGNYWEZBYlhQb1E1YVhaZkdUNTI=",
                "Cache-Control: no-cache",
                "Connection: keep-alive",
                "Content-Length: 29",
                "Content-Type: application/x-www-form-urlencoded",
                "Cookie: X-PP-SILOVER=name%3DSANDBOX3.API.1%26silo_version%3D1880%26app%3Dapiplatformproxyserv%26TIME%3D3332941149%26HTTP_X_PP_AZ_LOCATOR%3Dsandbox.slc",
                "Host: api.sandbox.paypal.com",
                "Postman-Token: cf7d9719-d82c-4a13-8e9d-1819bb711449,e4e3beca-aab7-4932-854f-c4a23172eab3",
                "User-Agent: PostmanRuntime/7.18.0",
                "cache-control: no-cache"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err)
        {
            return "cURL Error #:" . $err;
        } else
        {
            return $response;
        }
    }

    public function makeBatchPayment11($acessToken, $batch_id, $amount1, $email1, $amount2, $email2, $currency, $dialing_code1, $mobile_number1, $dialing_code2, $mobile_number2, $item_id)
    {

        $payment_data = array();

        $payment_data['sender_batch_header'] = array(
            "sender_batch_id" => $batch_id,
            "email_subject" => "You have a payout!",
            "email_message" => "You have received a payout! Thanks for using our service!"
        );

        $payment_data['items'][] = array(
            "recipient_type" => "EMAIL",
            "amount" => array(
                "value" => "$amount1",
                "currency" => "$currency"
            )
            ,
            "note" => "Thanks for your patronage!",
            "sender_item_id" => "$item_id",
            "receiver" => "$email1",
            "alternate_notification_method" => array(
                "phone" => array(
                    "country_code" => "$dialing_code1",
                    "national_number" => "$mobile_number1"
                )
            )
        );
        $payment_data['items'][] = array(
            "recipient_type" => "EMAIL",
            "amount" => array(
                "value" => "$amount2",
                "currency" => "$currency"
            )
            ,
            "note" => "Thanks for your patronage!",
            "sender_item_id" => "$item_id",
            "receiver" => "$email2",
            "alternate_notification_method" => array(
                "phone" => array(
                    "country_code" => "$dialing_code2",
                    "national_number" => "$mobile_number2"
                )
            )
        );
//        print_r($payment_data); die;
        //echo json_encode($payment_data); die;
        $curl = curl_init();
        $http_url = "https://api.sandbox.paypal.com/v1/payments/payouts";


        $postFields = json_encode($payment_data);
        // echo $postFields;die;

        curl_setopt_array($curl, array(
            CURLOPT_URL => $http_url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $postFields,
            CURLOPT_HTTPHEADER => array(
                "Accept: */*",
                "Accept-Encoding: gzip, deflate",
                "Authorization: Bearer " . $acessToken,
                "Cache-Control: no-cache",
                "Connection: keep-alive",
                "Content-Length: 1058",
                "Content-Type: application/json",
                "Cookie: X-PP-SILOVER=name%3DSANDBOX3.API.1%26silo_version%3D1880%26app%3Dapiplatformproxyserv%26TIME%3D162899293%26HTTP_X_PP_AZ_LOCATOR%3Dsandbox.slc",
                "Host: api.sandbox.paypal.com",
                "Postman-Token: 2185cb00-812e-4e8d-9478-c8df12281742,2025f009-b669-45b6-8940-a0eae88e5c00",
                "User-Agent: PostmanRuntime/7.18.0",
                "cache-control: no-cache"
            ),
        ));

        $response = curl_exec($curl);
        //print_r($response); die;
        $err = curl_error($curl);

        curl_close($curl);

        if ($err)
        {
            return "cURL Error #:" . $err;
        } else
        {
            return $response;
        }
    }

    public function makeBatchPayment($acessToken, $batch_id, $amount1, $email1, $amount2, $email2, $currency, $dialing_code1, $mobile_number1, $dialing_code2, $mobile_number2, $item_id)
    {
        $postFields = "{\r\n    \"sender_batch_header\": {\r\n        \"sender_batch_id\": \"$batch_id\",\r\n        \"email_subject\": \"You have a payout!\",\r\n        \"email_message\": \"You have received a payout! Thanks for using our service!\"\r\n    },"
                . "\r\n    \"items\": ["
                . "\r\n        {"
                . "\r\n            \"recipient_type\": \"EMAIL\","
                . "\r\n            \"amount\": {"
                . "\r\n                \"value\": \"$amount1\","
                . "\r\n                \"currency\": \"$currency\""
                . "\r\n            },"
                . "\r\n            \"note\": \"Thanks for your patronage!\","
                . "\r\n            \"sender_item_id\": \"$item_id\","
                . "\r\n            \"receiver\": \"$email1\","
                . "\r\n            \"alternate_notification_method\": {"
                . "\r\n                \"phone\": {"
                . "\r\n                    \"country_code\": \"$dialing_code1\","
                . "\r\n                    \"national_number\": \"$mobile_number1\""
                . "\r\n                }"
                . "\r\n            }"
                . "\r\n        },"
                . "\r\n        {"
                . "\r\n            \"recipient_type\": \"EMAIL\","
                . "\r\n            \"amount\": {"
                . "\r\n                \"value\": \"$amount2\","
                . "\r\n                \"currency\": \"$currency\""
                . "\r\n            },\r\n            \"note\": \"Thanks for your patronage!\","
                . "\r\n            \"sender_item_id\": \"$item_id\","
                . "\r\n            \"receiver\": \"$email2\","
                . "\r\n            \"alternate_notification_method\": {"
                . "\r\n                \"phone\": {"
                . "\r\n                    \"country_code\": \"$dialing_code2\","
                . "\r\n                    \"national_number\": \"$mobile_number2\""
                . "\r\n                }\r\n            }\r\n        }\r\n    ]\r\n}";
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.sandbox.paypal.com/v1/payments/payouts",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS =>$postFields ,
            CURLOPT_HTTPHEADER => array(
                "Accept: */*",
                "Accept-Encoding: gzip, deflate",
                "Authorization: Bearer ".$acessToken,
                "Cache-Control: no-cache",
                "Connection: keep-alive",
                "Content-Length: 1331",
                "Content-Type: application/json",
                "Cookie: X-PP-SILOVER=name%3DSANDBOX3.API.1%26silo_version%3D1880%26app%3Dapiplatformproxyserv%26TIME%3D2103422301%26HTTP_X_PP_AZ_LOCATOR%3Dsandbox.slc",
                "Host: api.sandbox.paypal.com",
                "Postman-Token: 825b21b3-16f3-4dcd-8d77-f059ec4745e4,ba820cc1-d19d-4092-9d30-3eff8f78ade8",
                "User-Agent: PostmanRuntime/7.18.0",
                "cache-control: no-cache"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err)
        {
            return "cURL Error #:" . $err;
        } else
        {
            return  $response;
        }
    }
    
    public function makeBatchPaymentSingle12165005($acessToken, $batch_id, $amount1, $email1, $currency, $dialing_code1, $mobile_number1, $item_id)
    {
       // echo $acessToken;
        $postFieldss = '
{
    "sender_batch_header": {
        "sender_batch_id": "Payouts_2019_441736",
        "email_subject": "You have a payout!",
        "email_message": "You have received a payout! Thanks for using our service!"
    },
    "items": [
        {
            "recipient_type": "EMAIL",
            "amount": {
                "value": "4500",
                "currency": "USD"
            },
            "note": "Thanks for your patronage!",
            "sender_item_id": "201403140001",
            "receiver": "sb-d9xpl358016@personal.example.com",
            "alternate_notification_method": {
                "phone": {
                    "country_code": "1",
                    "national_number": "9748816556"
                }
            }
        }
    ]
}';
        $postFields = "{\r\n    \"sender_batch_header\": {\r\n        \"sender_batch_id\": \"$batch_id\",\r\n        \"email_subject\": \"You have a payout!\",\r\n        \"email_message\": \"You have received a payout! Thanks for using our service!\"\r\n    },\r\n    \"items\": [\r\n        {\r\n            \"recipient_type\": \"EMAIL\",\r\n            \"amount\": {\r\n                \"value\": \"$amount1\",\r\n                \"currency\": \"$currency\"\r\n            },\r\n            \"note\": \"Thanks for your patronage!\",\r\n            \"sender_item_id\": \"$item_id\",\r\n            \"receiver\": \"$email1\",\r\n            \"alternate_notification_method\": {\r\n                \"phone\": {\r\n                    \"country_code\": \"$dialing_code1\",\r\n                    \"national_number\": \"$mobile_number1\"\r\n                }\r\n            }\r\n        }\r\n    ]\r\n}";
        $postFields = "\r\n{\r\n    \"sender_batch_header\": {\r\n        \"sender_batch_id\": \"Payouts_2019_121736\",\r\n        \"email_subject\": \"You have a payout!\",\r\n        \"email_message\": \"You have received a payout! Thanks for using our service!\"\r\n    },\r\n    \"items\": [\r\n        {\r\n            \"recipient_type\": \"EMAIL\",\r\n            \"amount\": {\r\n                \"value\": \"4500\",\r\n                \"currency\": \"USD\"\r\n            },\r\n            \"note\": \"Thanks for your patronage!\",\r\n            \"sender_item_id\": \"201403140001\",\r\n            \"receiver\": \"sb-d9xpl358016@personal.example.com\",\r\n            \"alternate_notification_method\": {\r\n                \"phone\": {\r\n                    \"country_code\": \"1\",\r\n                    \"national_number\": \"9748816556\"\r\n                }\r\n            }\r\n        }\r\n    ]\r\n}";
        $curl = curl_init();
        
        echo $acessToken; 
        echo $postFields; die;
       // echo "Hello "; die;
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.sandbox.paypal.com/v1/payments/payouts",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS =>$postFields ,
            CURLOPT_HTTPHEADER => array(
                "Accept: */*",
                "Accept-Encoding: gzip, deflate",
                "Authorization: Bearer ".$acessToken,
                "Cache-Control: no-cache",
                "Connection: keep-alive",
                "Content-Length: 1331",
                "Content-Type: application/json",
                "Cookie: X-PP-SILOVER=name%3DSANDBOX3.API.1%26silo_version%3D1880%26app%3Dapiplatformproxyserv%26TIME%3D2103422301%26HTTP_X_PP_AZ_LOCATOR%3Dsandbox.slc",
                "Host: api.sandbox.paypal.com",
                "Postman-Token: 825b21b3-16f3-4dcd-8d77-f059ec4745e4,ba820cc1-d19d-4092-9d30-3eff8f78ade8",
                "User-Agent: PostmanRuntime/7.18.0",
                "cache-control: no-cache"
            ),
        ));

        $response = curl_exec($curl);
       
        $err = curl_error($curl);
         print_r($err); die;
        print_r($response); die;

        curl_close($curl);
        
        if ($err)
        {
            return "cURL Error #:" . $err;
        } else
        {
            return  $response;
        }
    }
    
    public function makeBatchPaymentSingle($acessToken, $batch_id, $amount1, $email1, $currency, $dialing_code1, $mobile_number1, $item_id)
    {
       $amount1=  number_format((float)$amount1, 2, '.', '');
       // echo $amount1; die;
       $curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://api.sandbox.paypal.com/v1/payments/payouts",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => "{\r\n    \"sender_batch_header\": {\r\n        \"sender_batch_id\": \"$batch_id\",\r\n        \"email_subject\": \"You have a payout!\",\r\n        \"email_message\": \"You have received a payout! Thanks for using our service!\"\r\n    },\r\n    \"items\": [\r\n        {\r\n            \"recipient_type\": \"EMAIL\",\r\n            \"amount\": {\r\n                \"value\": \"$amount1\",\r\n                \"currency\": \"$currency\"\r\n            },\r\n            \"note\": \"Thanks for your patronage!\",\r\n            \"sender_item_id\": \"201403140001\",\r\n            \"receiver\": \"$email1\",\r\n            \"alternate_notification_method\": {\r\n                \"phone\": {\r\n                    \"country_code\": \"$dialing_code1\",\r\n                    \"national_number\": \"$mobile_number1\"\r\n                }\r\n            }\r\n        }\r\n    ]\r\n}",
  CURLOPT_HTTPHEADER => array(
    "Accept: */*",
    "Accept-Encoding: gzip, deflate",
    "Authorization: Bearer ".$acessToken,
    "Cache-Control: no-cache",
    "Connection: keep-alive",
    "Content-Length: 789",
    "Content-Type: application/json",
    "Cookie: X-PP-SILOVER=name%3DSANDBOX3.API.1%26silo_version%3D1880%26app%3Dapiplatformproxyserv%26TIME%3D3814305885%26HTTP_X_PP_AZ_LOCATOR%3Dsandbox.slc",
    "Host: api.sandbox.paypal.com",
    "Postman-Token: b8edc390-1f4e-47a5-ab4c-aab8f0d51ec1,53b69186-1d0d-4216-95d5-1f52fedd9290",
    "User-Agent: PostmanRuntime/7.18.0",
    "cache-control: no-cache"
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  return "cURL Error #:" . $err;
} else {
  return $response;
}
    }
}
    