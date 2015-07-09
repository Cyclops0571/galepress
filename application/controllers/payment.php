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
		if(!$paymentAccount) {
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
		if(!$paymentAccount) {
			$paymentAccount = new PaymentAccount();
		}
		$paymentAccount->CustomerID = $customer->CustomerID;
		$paymentAccount->kurumsal = Input::get('customerType') == 'on' ? 0 : 1;
		$paymentAccount->email = Input::get('email');
		$paymentAccount->phone = Input::get('phone');
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
