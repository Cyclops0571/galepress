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


        return View::make('payment.shop', $customerData);
    }

    public function get_payment_galepress() {
        return View::make('payment.payment-galepress');
    }

    public function post_payment_galepress() {
        $customerData = array();
        $customerEmail = Input::get('email');
        $customerTel = Input::get('phone');

        $customerData['email'] = $customerEmail;
        $customerData['phone'] = $customerTel;

        return View::make('payment.odeme', $customerData);
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

        return View::make('payment.payment-galepress', $data);
    }

    /**
     * iyzco.com dan 6 hane icin kart bilgisi sorar.
     * sonrasinda gene iyzco.comdan odemeyi almaya calisir...
     * 3d secure yapilmis ise post_odemeResponse a gider.
     */
    public function post_payment_approval() {
        $user = Auth::User();
        $user instanceof User;
        $customer = Customer::find($user->CustomerID);
        if (!$customer) {
            return Redirect::to(__('route.home'));
        }
        $paymentAccount = $customer->PaymentAccount();
        if (!$paymentAccount) {
            return Redirect::to('shop');
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
        if ($secure3D) {
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
        $postData['customer_contact_mobile'] = str_replace(array(" ", "-", "(", ")"), "", $paymentAccount->phone);
        $postData['customer_contact_ip'] = Request::ip();
        $postData['customer_language'] = 'tr';
        $postData['customer_presentation_usage'] = 'GalepressAylikOdeme_' . date('YmdHisu');
        $postData['descriptor'] = 'GalepressAylikOdeme_' . date('YmdHisu');
        $postData['type'] = "DB";
        $postData['amount'] = ((int) (Config::get("custom.payment_amount") * 1.18)) * 100;
        $postData['installment_count'] = NULL;
        $postData['currency'] = "TRY";
        $postData['descriptor'] = 'GalepressAylikOdeme_' . date('YmdHisu');
        $postData['card_register'] = 1;
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
        //$url = "http://www.galepress.com/test";   // sorgularda kullanacağımız endpoint

        $postDataString = "";
        foreach ($postData as $key => $value) {
            if (empty($postDataString)) {
                $postDataString .= $key . "=" . $value;
            } else {
                $postDataString .= '&' . $key . "=" . $value;
            }
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postDataString);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
        //curl_setopt($ch, CURLOPT_FAILONERROR, true);
        $response = curl_exec($ch);

        if ($response === false) {
            $paymentResult = "Iyzico servis saglayıcısı şu anda cevap vermiyor. Lütfen daha sonra tekrar deneyiniz.";
            return Redirect::to_route("website_payment_result_get", array(urlencode($paymentResult)));
        }
        $paymentTransaction->response = $response;
        $paymentTransaction->save();

        $resultJson = json_decode($response, true);

        if (!$secure3D) {
            $paymentResult = "Error";
            if (isset($resultJson['transaction']['state']) && strstr($resultJson['transaction']['state'], "paid")) {
                $paymentResult = "Success";
                $paymentAccount->CustomerID = $user->CustomerID;
                $paymentAccount->payment_count = (int) $paymentAccount->payment_count + 1;
                $paymentAccount->last_payment_day = date("Y-m-d");
                $paymentAccount->card_token = $resultJson['card_token'];
                $paymentAccount->bin = $resultJson['account']['bin'];
                $paymentAccount->brand = $resultJson['account']['brand'];
                $paymentAccount->expiry_month = $resultJson['account']['expiry_month'];
                $paymentAccount->expiry_year = $resultJson['account']['expiry_year'];
                $paymentAccount->last_4_digits = $resultJson['account']['lastfourdigits'];
                $paymentAccount->holder = $resultJson['account']['holder'];
                $paymentAccount->save();

                $paymentTransaction->PaymentAccountID = $paymentAccount->PaymentAccountID;
                $paymentTransaction->CustomerID = $user->CustomerID;
                $paymentTransaction->transaction_id = $resultJson['transaction']['transaction_id'];
                $paymentTransaction->external_id = $resultJson['transaction']['external_id'];
                $paymentTransaction->reference_id = $resultJson['transaction']['reference_id'];
                $paymentTransaction->state = $resultJson['transaction']['state'];
                $paymentTransaction->amount = $resultJson['transaction']['amount'];
                $paymentTransaction->currency = $resultJson['transaction']['currency'];
                $paymentTransaction->save();
            } else {
                $paymentTransaction->PaymentAccountID = $paymentAccount->PaymentAccountID;
                $paymentTransaction->CustomerID = $user->CustomerID;
                $paymentTransaction->transaction_id = $resultJson['transaction']['transaction_id'];
                $paymentTransaction->external_id = $resultJson['transaction']['external_id'];
                $paymentTransaction->reference_id = $resultJson['transaction']['reference_id'];
                $paymentTransaction->state = $resultJson['transaction']['state'];
                $paymentTransaction->save();
                if (!empty($resultJson['response']["error_message_tr"])) {
                    $paymentResult = $resultJson['response']["error_message_tr"];
                } else {
                    $paymentResult = $resultJson['response']["error_message"];
                }
            }


            return Redirect::to_route("website_payment_result_get", array(urlencode($paymentResult)));
        } else {
            print_r($response);
        }
    }

    /**
     * 3d secure kullanilmis ise buraya geliyoruz
     * @return type
     */
    public function post_odemeResponse() {
        echo "POST";
        echo "--------------POST--------------";
        var_dump($_POST);
        echo "--------------GET--------------";
        var_dump($_GET);
        echo "--------------EXIT--------------";
        $user = Auth::User();
        $user instanceof User;
        $customer = Customer::find($user->CustomerID);
        if (!$customer) {
            return Redirect::to(__('route.home'));
        }
        $paymentAccount = $customer->PaymentAccount();
        if (!$paymentAccount) {
            return Redirect::to('shop');
        }
        $paymentResult = "Error";
        $response = Input::get("json");
        $resultJson = json_decode($response, true);
        if (isset($resultJson['transaction']['transaction_id'])) {
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
                $paymentAccount->payment_count = (int) $paymentAccount->payment_count + 1;
                $paymentAccount->last_payment_day = date("Y-m-d");
                $paymentAccount->card_token = $result['card_token'];
                $paymentAccount->bin = $result['account']['bin'];
                $paymentAccount->brand = $result['account']['brand'];
                $paymentAccount->expiry_month = $result['account']['expiry_month'];
                $paymentAccount->expiry_year = $result['account']['expiry_year'];
                $paymentAccount->last_4_digits = $result['account']['lastfourdigits'];
                $paymentAccount->holder = $result['account']['holder'];
                $paymentAccount->save();

                $paymentTransaction = new PaymentTransaction();
                $paymentTransaction->PaymentAccountID = $paymentAccount->PaymentAccountID;
                $paymentTransaction->CustomerID = $user->CustomerID;
                $paymentTransaction->transaction_id = $result['transaction']['transaction_id'];
                $paymentTransaction->external_id = $result['transaction']['external_id'];
                $paymentTransaction->reference_id = $result['transaction']['reference_id'];
                $paymentTransaction->state = $result['transaction']['state'];
                $paymentTransaction->amount = $result['transaction']['amount'];
                $paymentTransaction->currency = $result['transaction']['currency'];
                $paymentTransaction->save();
            } else {
                $paymentTransaction = new PaymentTransaction();
                $paymentTransaction->PaymentAccountID = $paymentAccount->PaymentAccountID;
                $paymentTransaction->CustomerID = $user->CustomerID;
                $paymentTransaction->transaction_id = $resultJson['transaction']['transaction_id'];
                $paymentTransaction->external_id = $resultJson['transaction']['external_id'];
                $paymentTransaction->reference_id = $resultJson['transaction']['reference_id'];
                $paymentTransaction->state = $resultJson['transaction']['state'];
                $paymentTransaction->save();
                if (!empty($resultJson['response']["error_message_tr"])) {
                    $paymentResult = $resultJson['response']["error_message_tr"];
                } else {
                    $paymentResult = $resultJson['response']["error_message"];
                }
            }
        }
        return Redirect::to_route("website_payment_result_get", array(urlencode($paymentResult)));
    }

    public function get_odemeResponse() {
        $user = Auth::User();
        $user instanceof User;
        $customer = Customer::find($user->CustomerID);
        if (!$customer) {
            return Redirect::to(__('route.home'));
        }
        $paymentAccount = $customer->PaymentAccount();
        if (!$paymentAccount) {
            return Redirect::to('shop');
        }
        $paymentResult = "Error";
        $response64decoded = Input::get("response");
        if (!empty($response64decoded)) {
            $paymentResult = "Iyzico servis saglayıcısı şu anda cevap vermiyor. Lütfen daha sonra tekrar deneyiniz.";
        }
        $response = json_decode(base64_decode($response64decoded), TRUE);
        if (!isset($response['transaction']['transaction_id'])) {
            $paymentResult = "Iyzico servis saglayıcısında bir hata oldu. Lütfen daha sonra tekrar deneyiniz"; //transaction_id dönmüyor ??
        }

        if (isset($response['transaction']['state']) && strstr($response['transaction']['state'], "paid")) {
            $paymentResult = "Success";
            $paymentAccount->payment_count = (int) $paymentAccount->payment_count + 1;
            $paymentAccount->last_payment_day = date("Y-m-d");
            $paymentAccount->card_token = $response['card_token'];
            $paymentAccount->bin = $response['account']['bin'];
            $paymentAccount->brand = $response['account']['brand'];
            $paymentAccount->expiry_month = $response['account']['expiry_month'];
            $paymentAccount->expiry_year = $response['account']['expiry_year'];
            $paymentAccount->last_4_digits = $response['account']['lastfourdigits'];
            $paymentAccount->holder = $response['account']['holder'];
            $paymentAccount->save();

            $paymentTransaction = PaymentTransaction::find($response['transaction']['external_id']);
            $paymentTransaction->PaymentAccountID = $paymentAccount->PaymentAccountID;
            $paymentTransaction->CustomerID = $user->CustomerID;
            $paymentTransaction->transaction_id = $response['transaction']['transaction_id'];
            $paymentTransaction->external_id = $response['transaction']['external_id'];
            $paymentTransaction->reference_id = $response['transaction']['reference_id'];
            $paymentTransaction->state = $response['transaction']['state'];
            $paymentTransaction->amount = $response['transaction']['amount'];
            $paymentTransaction->currency = $response['transaction']['currency'];
            $paymentTransaction->response = json_encode($response);
            $paymentTransaction->save();
        } else {
            $paymentTransaction = PaymentTransaction::find($response['transaction']['external_id']);
            $paymentTransaction->PaymentAccountID = $paymentAccount->PaymentAccountID;
            $paymentTransaction->CustomerID = $user->CustomerID;
            $paymentTransaction->transaction_id = $response['transaction']['transaction_id'];
            $paymentTransaction->external_id = $response['transaction']['external_id'];
            $paymentTransaction->state = "rejected";
            $paymentTransaction->response = json_encode($response);
            $paymentTransaction->save();
            if (!empty($response['response']["error_message_tr"])) {
                $paymentResult = $response['response']["error_message_tr"];
            } else {
                $paymentResult = $response['response']["error_message"];
            }
        }
        return Redirect::to_route("website_payment_result_get", array(urlencode($paymentResult)));
    }

    public function get_odemeSonuc($encodedResult) {
        $result = urldecode($encodedResult);
        $payDataMsg = "";
        $payDataTitle = "";
        if ($result == "Success") {
            $payDataMsg = "Ödemeniz başarıyla gerçekleşti, teşekkür ederiz...";
            $payDataTitle = "Ödeme Başarılı!";
        } else {
            $payDataMsg = $result;
            $payDataTitle = "Ödeme Başarısız!";
        }
        $data = array('payDataMsg' => $payDataMsg, 'payDataTitle' => $payDataTitle, 'result' => $result);
        return View::make('payment.odeme_sonuc', $data);
    }

}
