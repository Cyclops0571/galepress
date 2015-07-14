<?php

class Payment_Controller extends Base_Controller {

	public $restful = true;

	public function get_shop() {
		$user = Auth::User();
		$user instanceof User;
		$customer = Customer::find($user->CustomerID);
		if (!$customer) {
			return Redirect::to(__('route.home'));
		}
		$paymentAccount = $customer->PaymentAccount();
		if (!$paymentAccount) {
			$paymentAccount = new PaymentAccount();
		}

		$customerData = array();
		$customerData['city'] = City::all();
		$customerData['paymentAccount'] = $paymentAccount;


		return View::make('website.pages.shop', $customerData);
	}

	public function get_payment_galepress() {
		return View::make('website.pages.payment-galepress');
	}

	public function post_payment_galepress() {
		$customerData = array();
		$customerEmail = Input::get('email');
		$customerTel = Input::get('phone');

		$customerData['email'] = $customerEmail;
		$customerData['phone'] = $customerTel;

		return View::make('website.pages.odeme', $customerData);
	}

	public function post_odeme() {
		$user = Auth::User();
		$user instanceof User;
		$customer = Customer::find($user->CustomerID);
		if (!$customer) {
			return Redirect::to(__('route.home'));
		}

		$customer instanceof Customer;
		$paymentAccount = $customer->PaymentAccount();
		if (!$paymentAccount) {
			$paymentAccount = new PaymentAccount();
		}
		$paymentAccount->CustomerID = $customer->CustomerID;
		$paymentAccount->kurumsal = Input::get('customerType') == 'on' ? 0 : 1;
		$paymentAccount->email = Input::get('email');
		$paymentAccount->phone = Input::get('phone');
		$paymentAccount->title = Input::get('customerTitle');
		$paymentAccount->tckn = Input::get('tc');
		$paymentAccount->city_id = Input::get('city'); //id
		$paymentAccount->address = Input::get('address');
		$paymentAccount->vergi_dairesi = Input::get('taxOffice');
		$paymentAccount->vergi_no = Input::get('taxNo');
		$paymentAccount->save();

		$data = array();
		$data["paymentAccount"] = $paymentAccount;

		return View::make('website.pages.payment-galepress', $data);
	}

	/**
	 * iyzco.com dan 6 hane icin kart bilgisi sorar.
	 * sonrasinda gene iyzco.comdan odemeyi almaya calisir...
	 */
	public function post_payment_approval() {
		$user = Auth::User();
		$user instanceof User;
		$customer = Customer::find($user->CustomerID);
		if (!$customer) {
			return Redirect::to(__('route.home'));
		}
		$paymentAccount = $customer->PaymentAccount();
		if(!$paymentAccount) {
			return Redirect::to(__('route.home'));
		}
		
		
		//send data
		//response
		//paid
		//transactioni burada baslatayim....
		$paymentTransaction = new PaymentTransaction();
		$paymentTransaction->PaymentAccountID = $paymentAccount->PaymentAccountID;
		$paymentTransaction->CustomerID = $user->CustomerID;
		$paymentTransaction->save();
		$secure3D = Input::get("3d_secure", 0);
		
		$postData = array();
		if($secure3D) {
			$postData['response_mode'] = "ASYNC";
			$postData['return_url'] = Config::get("custom.payment_url") . '/payment-response';
		} else {
			$postData['response_mode'] = "SYNC";
		}
		$postData['api_id'] = Config::get("custom.iyzico_api_id");
		$postData['secret'] = Config::get("custom.iyzico_secret");
		$postData['mode'] = Config::get("custom.payment_environment");
		$postData['external_id'] = $paymentTransaction->PaymentTransactionID;
		$postData['customer_first_name'] = $user->FirstName;
		$postData['customer_last_name'] = $user->LastName;
		$postData['customer_contact_email'] = $paymentAccount->email;
		$postData['customer_contact_mobile'] = $paymentAccount->phone;
		$postData['customer_contact_ip'] = Request::ip();
		$postData['customer_language'] = 'tr';
		$postData['customer_presentation_usage'] = 'GalepressAylikOdeme_' . date('YmdHisu');
		$postData['descriptor'] = 'GalepressAylikOdeme_' . date('YmdHisu');
		$postData['type'] = "DB";
		$postData['amount'] = 100; //571571
		$postData['installment_count'] = NULL;
		$postData['currency'] = "TRY";
		$postData['descriptor'] = 'GalepressAylikOdeme_' . date('YmdHisu');
		$postData['card_number'] = str_replace(" ", "", Input::get("card_number"));
		$postData['card_expiry_year'] = Input::get("card_expiry_year");
		$postData['card_expiry_month'] = Input::get("card_expiry_month");
		$postData['card_brand'] = strtoupper(Input::get("card_brand"));
		$postData['card_holder_name'] = Input::get("card_holder_name");
		$postData['card_verification'] = Input::get("card_verification");
		$postData['connector_type'] = "Garanti";

		$paymentTransaction->request = json_encode($postData);
		$paymentTransaction->save();
		
		$url = "https://iyziconnect.com/post/v1/";   // sorgularda kullanacağımız endpoint
//		$url = "http://localhost/test";   // sorgularda kullanacağımız endpoint

		$postDataString = "";
		foreach($postData as $key => $value) {
			if(empty($postDataString)) {
				$postDataString .= $key . "=" . $value;
				
			} else {
				$postDataString .= '&' . $key . "=" . $value;
			}
		}
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postDataString);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
		$response = curl_exec($ch);
		curl_close($ch);
		if ($response === false) {
			throw new Exception("Problem reading data from $url, $php_errormsg");
		}
		$paymentTransaction->response = $response;
		$paymentTransaction->save();
		
		$resultJson = json_decode($response, true);
		print_r($resultJson);
	}

	public function post_odemeResponse() {
		$user = Auth::User();
		$paymentResult = "Error";
		$response = Input::get("json");
		$resultJson = json_decode($response, true);
		if (isset($resultJson['transaction']['transaction_id'])) {
//			var_dump($resultJson); exit;
			$orderToken = $resultJson['transaction_token'];
			$curl = curl_init('https://api.iyzico.com/getStatus?token=' . $orderToken);
			curl_setopt($curl, CURLOPT_FAILONERROR, true);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, true);
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
			$resultCurl = curl_exec($curl);
			$result = json_decode($resultCurl, true);
			if (isset($result['transaction']['state']) && strstr($result['transaction']['state'], "paid")) {
				$paymentResult = "Success";
			}

			$paymentAccount = new PaymentAccount();
			$paymentAccount->CustomerID = $user->CustomerID;
			$paymentAccount->payment_count = (int) $paymentAccount->payment_count + 1;
			$paymentAccount->last_payment_day = date("Y-m-d");
			$paymentAccount->card_token = $result['card_token'];
			$paymentAccount->bin = $result['account']['bin'];
			$paymentAccount->brand = $result['account']['brand'];
			$paymentAccount->expiry_month = $result['account']['expiry_month'];
			$paymentAccount->expiry_year = $result['account']['expiry_year'];
			$paymentAccount->last_4_digits = $result['account']['last_4_digits'];
			$paymentAccount->holder = $result['account']['holder'];
			$paymentAccount->save();

			$paymentTransaction = new PaymentTransaction();
			$paymentTransaction->PaymentAccountID = $paymentAccount->PaymentAccountID;
			$paymentTransaction->CustomerID = $user->CustomerID;
			$paymentTransaction->transaction_id = $result['transaction']['transaction_id'];
			$paymentTransaction->transaction_token = $result['transaction_token'];
			$paymentTransaction->external_id = $result['transaction']['external_id'];
			$paymentTransaction->reference_id = $result['transaction']['reference_id'];
			$paymentTransaction->state = $result['transaction']['state'];
			$paymentTransaction->amount = $result['transaction']['amount'];
			$paymentTransaction->currency = $result['transaction']['currency'];
			$paymentTransaction->save();
		}
		// var_dump($resultJson);
		// die;
		return Redirect::to_route("website_payment_result_get", array($paymentResult));
	}

	public function get_odemeSonuc($result) {
		// die($result);
		$payDataMsg = "";
		$payDataTitle = "";
		if ($result == "Success") {
			$payDataMsg = "Ödemeniz başarıyla gerçekleşti, teşekkür ederiz...";
			$payDataTitle = "Ödeme Başarılı!";
		} else {
			$payDataMsg = "Ödeme esnasında bir problem oluştu, lütfen yetkililerle irtibata geçiniz.";
			$payDataTitle = "Ödeme Başarısız!";
		}
		$data = array('payDataMsg' => $payDataMsg, 'payDataTitle' => $payDataTitle, 'result' => $result);
		return View::make('website.pages.odemeSonuc', $data);
	}

}
