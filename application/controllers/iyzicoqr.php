<?php

class Iyzicoqr_Controller extends Base_Controller
{
    public $restful = true;

    public function get_index()
    {
        $errorMessage = Input::get('errMsg', "");
        $qrCodeId = Input::get('qrCodeId', 0);
        $qrCode = new Qrcode();

        if (empty($qrCodeId)) {
            $rules = array(
                "id" => 'required|integer',
                "price" => 'required',
                "cb" => 'required',
                "pm" => 'required'
            );
            $v = Validator::make(Input::all(), $rules);
            if ($v->fails()) {
                $errorMessage = $v->errors->first();
            }
            $cb = Input::get('cb');
            $price = Input::get('price');
            $id = Input::get('id');
            $pm = Input::get('pm');
            if (strpos($cb, 'https://') === false || strpos($cb, 'http://') === false) {
                $cb = 'http://' . $cb;
            }
        } else {
            /** @var Qrcode $qrCode */
            $qrCode = Qrcode::find(Input::get('qrCodeId'));
            if ($qrCode) {
                $cb = $qrCode->CallbackUrl;
                $price = $qrCode->Price;
                $id = $qrCode->QrSiteClientID;
                $pm = $qrCode->Parameter;
            }
        }


        $cities = array();
        $cities[] = City::where("CityID", "=", 34)->first();
        $cities[] = City::where("CityID", "=", 6)->first();
        $cities[] = City::where("CityID", "=", 35)->first();
        $orderedCities = City::where_not_in("CityID", array(6, 34, 35))->order_by('CityName')->get();
        $cities = array_merge($cities, $orderedCities);
        $data = array();
        $data["city"] = $cities;
        $data["id"] = $id;
        $data["price"] = $price;
        $data["cb"] = $cb;
        $data["pm"] = $pm;
        $data["errorMessage"] = $errorMessage;
        $data["qrCode"] = $qrCode;

        return View::make('iyzicoqr.iframebilling', $data);
    }

    public function post_save()
    {
        $rules = array(
            "qrCodeClientId" => 'required|integer',
            "price" => 'required',
            "callback" => 'required',
            "email" => 'required',
            "phone" => 'required',
            "tc" => 'required',
            "address" => 'required',
            "pm" => 'required'
        );
        $qrCode = new Qrcode();
        $qrCode->CallbackUrl = Input::get("callback", "");
        $qrCode->QrSiteClientID = Input::get("qrCodeClientId", "");
        $qrCode->Price = Input::get("price", "");
        $qrCode->Parameter = Input::get("pm", "");
        $qrCode->Name = Input::get("name", "");
        $qrCode->Email = Input::get("email", "");
        $qrCode->Phone = Input::get("phone", "");
        $qrCode->TcNo = Input::get("tc", "");
        $qrCode->City = Input::get("city", "");
        $qrCode->Address = Input::get("address", "");
        $qrCode->save();
        $v = Validator::make(Input::all(), $rules);
        if ($v->fails()) {
            return Redirect::to(URL::to('iyzicoqr', null, false, false) . '?errMsg=' . urlencode($v->errors->first()));
        }
        return Redirect::to(URL::to('open_iyzico_iframe', null, false, false) . '?qrCodeId=' . $qrCode->QrcodeID);
    }

    public function get_open_iyzico_iframe()
    {
        $rules = array('qrCodeId' => 'integer|exists:Qrcode,QrcodeID');
        $v = Validator::make(Input::all(), $rules);
        if ($v->fails()) {
            return Redirect::to(URL::to('iyzicoqr', null, false, false) . '?errMsg=' . urlencode($v->errors->first()));
        }
        /** @var Qrcode $qrCode */
        $qrCode = Qrcode::find(Input::get('qrCodeId'));
        $checkoutFormInitialize = $qrCode->makeIyzicoIframeRequrest();
        $errorMessage = $checkoutFormInitialize->getErrorMessage();
        if (!empty($errorMessage)) {
            return Redirect::to(URL::to('iyzicoqr', null, false, false) . '?qrCodeId=' . $qrCode->QrcodeID . '&errMsg=' . urlencode($errorMessage));
        }

        $data = array();
        $data["checkoutFormInitialize"] = $checkoutFormInitialize;
        return View::make('iyzicoqr.paymentiframe', $data);
    }

    public function post_checkout_result_form()
    {
        $rules = array("token" => "required", "qrCodeId" => "required|exists:Qrcode,QrcodeID");
        $v = \Laravel\Validator::make(Input::all(), $rules);
        if ($v->fails()) {
            return $v->errors->first();
        }

        /** @var Qrcode $qrCode */
        $qrCode = Qrcode::find(Input::get("qrCodeId"));
        $request = new \Iyzipay\Request\RetrieveCheckoutFormRequest();
        $request->setLocale(\Iyzipay\Model\Locale::TR);
        $request->setConversationId(Input::get("qrCodeId"));
        $request->setToken(Input::get('token'));
        # make request
        $options = new \Iyzipay\Options();
        $options->setApiKey(MyPayment::iyzicoApiKey);
        $options->setSecretKey(MyPayment::iyzicoSecretKey);
        $options->setBaseUrl(MyPayment::iyzicoBaseUrl);
        $checkoutForm = \Iyzipay\Model\CheckoutForm::retrieve($request, $options);
//        var_dump($checkoutForm); exit;
        /** @var Iyzipay\Model\PaymentItem[] $items */
        $items = $checkoutForm->getPaymentItems();

        $resultUrl = array();
        $resultUrl[] = $qrCode->CallbackUrl . "?success=" . $checkoutForm->getStatus();
        $resultUrl[] = "message=" . $checkoutForm->getErrorMessage();
        $resultUrl[] = "pm=" . $qrCode->Parameter;
        $resultUrl[] = "price=" . $qrCode->Price;
        $resultUrl[] = "id=" . $qrCode->QrSiteClientID;
        $resultUrl[] = "tid=" . ($items ? $items[0]->getPaymentTransactionId() : "");
        return Redirect::to(implode('&', $resultUrl));
    }

}