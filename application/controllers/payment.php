<?php

class Payment_Controller extends Base_Controller
{

    public $restful = true;

    public function get_shop()
    {
        $user = Auth::user();
        if (!$user) {
            setcookie(GO_BACK_TO_SHOP, GO_BACK_TO_SHOP, time() + Config::get('session.lifetime') * 60, "/");
            return Redirect::to(__('route.home'));
        }

        $customer = Customer::find($user->CustomerID);
        if (!$customer) {
            setcookie(GO_BACK_TO_SHOP, GO_BACK_TO_SHOP, time() + Config::get('session.lifetime') * 60, "/");
            return Redirect::to(__('route.home'));
        }

        $applications = array_merge($customer->Applications(eStatus::Active), $customer->Applications(eStatus::Passive));
        if (empty($applications) || $applications[0]->CustomerID != $customer->CustomerID) {
            return Redirect::to(__('route.home'));
        }

        $paymentAccount = $customer->getLastSelectedPaymentAccount();
        if (!$paymentAccount) {
            $paymentAccount = new PaymentAccount();
        }

        if ($paymentAccount->PaymentAccountID) {
            $selectedApp = $paymentAccount->Application;
        } else {
            $selectedApp = $applications[0];
        }

        $customerData = array();
        $customerData['city'] = City::all();
        $customerData['paymentAccount'] = $paymentAccount;
        $customerData['applications'] = $applications;
        $customerData['selectedApp'] = $selectedApp;
        setcookie(GO_BACK_TO_SHOP, GO_BACK_TO_SHOP, 1, "/");
        return View::make('payment.shop', $customerData);
    }

    public function get_payment_galepress()
    {
        return View::make('payment.payment-galepress');
    }

    public function post_payment_galepress()
    {
        $customerData = array();
        $customerEmail = Input::get('email');
        $customerTel = Input::get('phone');

        $customerData['email'] = $customerEmail;
        $customerData['phone'] = $customerTel;

        return View::make('payment.odeme', $customerData);
    }

    public function post_card_info()
    {
        $user = Auth::user();
        $customer = Customer::find($user->CustomerID);
        $application = Application::find(Input::get("applicationID"));
        if (!$customer) {
            return Redirect::to(__('route.home'));
        }

        if ($application->CustomerID != $customer->CustomerID) {
            return Redirect::to(__('route.home'));
        }

        $paymentAccount = $application->PaymentAccount();
        if (!$paymentAccount) {
            $paymentAccount = new PaymentAccount();
            $paymentAccount->CustomerID = $customer->CustomerID;
            $paymentAccount->ApplicationID = $application->ApplicationID;
        }

        $paymentAccount->kurumsal = Input::get('customerType') == 'on' ? 0 : 1;
        $paymentAccount->email = Input::get('email');
        $paymentAccount->phone = Input::get('phone');
        $paymentAccount->title = Input::get('customerTitle');
        $paymentAccount->tckn = Input::get('tc');
        $paymentAccount->CityID = Input::get('city'); //id
        $paymentAccount->address = Input::get('address');
        $paymentAccount->vergi_dairesi = Input::get('taxOffice');
        $paymentAccount->vergi_no = Input::get('taxNo');
        $paymentAccount->selected_at = date("Y-m-d H:i:s");
        $paymentAccount->StatusID = eStatus::Active;
        $paymentAccount->save();

        $data = array();
        $data["paymentAccount"] = $paymentAccount;
        $data["application"] = $application;

        return View::make('payment.card_info', $data);
    }

    public function get_payment_approval()
    {
        echo "Adsfadsf";
        exit;
    }

    /**
     * iyzco.com dan 6 hane icin kart bilgisi sorar.
     * sonrasinda gene iyzco.comdan odemeyi almaya calisir...
     * 3d secure yapilmis ise get_secure_3d_response a gider.
     */
    public function post_payment_approval()
    {
        $user = Auth::user();
        $customer = Customer::find($user->CustomerID);
        if (!$customer) {
            return Redirect::to(__('route.home'));
        }
        $paymentAccount = $customer->getLastSelectedPaymentAccount();
        if (!$paymentAccount) {
            return Redirect::to('shop');
        }


        //eger kullanici bugun icinde bir odeme yapmis ise baska bir odeme almayalim...
        $oldPaymentTransactions = PaymentTransaction::where('PaymentAccountID', '=', $paymentAccount->PaymentAccountID)
            ->where('created_at', ">", date('Y-m-d'))
            ->where('paid', '=', 1)
            ->get();

        if (FALSE && count($oldPaymentTransactions)) {
            $paymentResult = (string)__('error.cannot_make_two_payment_in_the_same_day');
            return Redirect::to_route("website_payment_result_get", array(urlencode($paymentResult)));
        }

        $paymentCard = new \Iyzipay\Model\PaymentCard();
        $paymentCard->setCardHolderName(Input::get("card_holder_name"));
        $paymentCard->setCardNumber(str_replace(" ", "", Input::get("card_number")));
        $paymentCard->setExpireMonth(Input::get("card_expiry_month"));
        $paymentCard->setExpireYear(Input::get("card_expiry_year"));
        $paymentCard->setCvc(Input::get("card_verification"));
        $paymentCard->setRegisterCard(1);
        $secure3D = Input::get("3d_secure", 0);

        $payment = new MyPayment();
        if ($secure3D) {
            $basicThreedsInitialize = $payment->paymentFromWebThreeD($paymentCard);
            return $basicThreedsInitialize->getHtmlContent();
        } else {
            $basicPayment = $payment->paymentFromWeb($paymentCard);
            if ($basicPayment->getStatus() == 'success') {
                $paymentResult = "Success";
            } else {
                $paymentResult = $basicPayment->getErrorMessage();
            }
            return Redirect::to_route("website_payment_result_get", array(str_replace('%2F', '/', urlencode($paymentResult))));
        }
    }

    /**
     * 3d secure kullanilmis ise buraya geliyoruz
     * @return Laravel\Redirect
     */
    public function post_secure_3d_response() {
        $response = Input::all();
        if (empty($response)) {
            $errorLog = new ServerErrorLog();
            $errorLog->Header = 571;
            $errorLog->Url = 'Server 3ds payment';
            $errorLog->Parameters = Input::all();
            $errorLog->ErrorMessage = 'Response Data';
            $errorLog->save();
            $responseText = (string)__('error.service_supplier_do_not_answer_try_again_later');
        } else if (!isset($response['status'])) {
            $errorLog = new ServerErrorLog();
            $errorLog->Header = 571;
            $errorLog->Url = 'Server 3ds payment';
            $errorLog->Parameters = Input::all();
            $errorLog->ErrorMessage = 'Response status does not exists.';
            $errorLog->save();
            $responseText = (string)__('error.there_is_an_error_on_the_service_supplier_please_try_again_later');
        } else {
            $iyzicoResponse = new iyzico3dsResponse($response);
            $payment = new MyPayment();
            $responseText = $payment->get3dsResponse($iyzicoResponse);

        }

        return Redirect::to(str_replace("(:all)", urlencode($responseText), (string)__("route.website_payment_result")));
    }

    public function get_payment_result($encodedResult)
    {
        $result = urldecode($encodedResult);
        if ($result == "Success") {
            $payDataMsg = __('website.payment_result_successful');
            $payDataTitle = __('website.payment_successful');
        } else {
            $payDataMsg = $result;
            $payDataTitle = __('website.payment_failure');
        }
        $data = array('payDataMsg' => $payDataMsg, 'payDataTitle' => $payDataTitle, 'result' => $result);
        return View::make('payment.odeme_sonuc', $data);
    }

    public function get_paymentAccountByApplicationID($appID)
    {
        $paymentAccount = PaymentAccount::where('ApplicationID', "=", $appID)->first();
        return json_encode($paymentAccount);
    }
}
