<?php

/**
 * Created by PhpStorm.
 * User: p1027
 * Date: 18.08.2016
 * Time: 15:54
 */
class MyPayment
{
    const iyzicoApiKey = "lGdLZQMXMGjJKAPX7RJtyWP3XLYnvWbT";
    const iyzicoSecretKey = "jYhw4nt0Zy55TtceMj320WAVzApj7sPL";
    const iyzicoBaseUrl = "https://api.iyzipay.com/";

    /** @var Iyzipay\Options */
    public $options = null;
    /** @var PaymentTransaction */
    private $paymentTransaction = null;

    /** @var PaymentAccount */
    private $paymentAccount = null;

    public function __construct($options = null)
    {
        if (!$options) {
            $this->options = new Iyzipay\Options();
            $this->options->setApiKey(MyPayment::iyzicoApiKey);
            $this->options->setSecretKey(MyPayment::iyzicoSecretKey);
            $this->options->setBaseUrl(MyPayment::iyzicoBaseUrl);
        } else {
            $this->options = $options;
        }
    }

    public static function getLang()
    {
        switch (Config::get('application.language')) {
            case 'tr':
                return \Iyzipay\Model\Locale::TR;
                break;
            default:
                return \Iyzipay\Model\Locale::EN;
        }
    }

    /**
     * @return User
     */
    private function getUser()
    {
        if (Laravel\Request::env() == ENV_LOCAL) {
            return User::find(65);
        }
        return Auth::user();
    }

    public function paymentFromWeb(\Iyzipay\Model\PaymentCard $pc)
    {
        $user = $this->getUser();
        $this->setPaymentAccount($user);
        $this->setPaymentTransaction($this->paymentAccount);
        $request = $this->getRequest();
        $pc->setRegisterCard(1);
        $request->setPaymentCard($pc);
        $basicPayment = \Iyzipay\Model\BasicPayment::create($request, $this->options);
        $this->paymentTransaction->updateTransaction($basicPayment);
        $this->paymentAccount->updateAccount($basicPayment);
        return $basicPayment;
    }

    /**
     * @param \Iyzipay\Model\PaymentCard $pc
     * @return \Iyzipay\Model\BasicThreedsInitialize
     */
    public function paymentFromWebThreeD(\Iyzipay\Model\PaymentCard $pc)
    {
        $user = $this->getUser();
        $this->setPaymentAccount($user);
        $this->setPaymentTransaction($this->paymentAccount);

        $request = $this->getRequest(Config::get("custom.galepress_https_url") . '/' . Config::get('application.language') . '/3d-secure-response');
        $pc->setRegisterCard(1);
        $request->setPaymentCard($pc);
        $basicThreedsInitialize = \Iyzipay\Model\BasicThreedsInitialize::create($request, $this->options);
        $this->paymentTransaction->update3dTransaction($basicThreedsInitialize);
        return $basicThreedsInitialize;
    }

    public function paymentWithToken(PaymentAccount $paymentAccount)
    {
        $this->paymentAccount = $paymentAccount;

        $userInfoSet = array();
        //if we charge within the mounth then dont charge anymore
        $lastPaymentFlag = $paymentAccount->last_payment_day < date("Y-m-d", strtotime("-1 month +1 day"));
        $installmentFlag = $paymentAccount->payment_count < $paymentAccount->Application->Installment;
        if ($paymentAccount->payment_count > 0 && $paymentAccount->ValidUntil <= date("Y-m-d") && $lastPaymentFlag && $installmentFlag) {
            $cardToken = $this->paymentAccount->cardToken;
            if(empty($cardToken)) {
                return $userInfoSet;
            }
            //sleep before getting blocked ...
            $this->setPaymentTransaction($this->paymentAccount);
            $request = $this->getRequest();
            $paymentCard = new \Iyzipay\Model\PaymentCard();
            $paymentCard->setCardToken($this->paymentAccount->cardToken);
            $paymentCard->setCardUserKey($this->paymentAccount->cardUserKey);
            $request->setPaymentCard($paymentCard);

            $basicPayment = \Iyzipay\Model\BasicPayment::create($request, $this->options);
            $this->paymentTransaction->updateTransaction($basicPayment);
            $this->paymentAccount->updateAccount($basicPayment);

            if ($basicPayment->getStatus() !== 'success') {
                $paymentAccount->WarningMailPhase++;
                if ($paymentAccount->WarningMailPhase < 3) {
                    $paymentAccount->save();
                }

                $userInfoSet["customerID"] = $paymentAccount->CustomerID;
                $userInfoSet["error_reason"] = $basicPayment->getErrorMessage();
                $userInfoSet["email"] = $paymentAccount->email;
                $userInfoSet["name_surname"] = $paymentAccount->holder;
                $userInfoSet["last_payment_day"] = $paymentAccount->last_payment_day;
                $userInfoSet["warning_mail_phase"] = $paymentAccount->WarningMailPhase;
            }
        }
        return $userInfoSet;
    }

    /**
     * @param User $user
     * @return PaymentAccount
     */
    private function setPaymentAccount(User $user)
    {
        $customer = Customer::find($user->CustomerID);
        return $this->paymentAccount = $customer->getLastSelectedPaymentAccount();
    }

    /**
     * @param User $user
     * @param PaymentAccount $paymentAccount
     * @return PaymentTransaction
     */
    private function setPaymentTransaction(PaymentAccount $paymentAccount)
    {
        $this->paymentTransaction = new PaymentTransaction();
        $this->paymentTransaction->PaymentAccountID = $paymentAccount->PaymentAccountID;
        $this->paymentTransaction->CustomerID = $paymentAccount->CustomerID;
        $this->paymentTransaction->amount = $this->paymentAccount->Application->Price;
        $this->paymentTransaction->currency = \Iyzipay\Model\Currency::TL;
        $this->paymentTransaction->save();
        return $this->paymentTransaction;
    }

    /**
     * @param string $callbackUri
     * @return \Iyzipay\Request\CreateBasicPaymentRequest
     */
    private function getRequest($callbackUri = '')
    {
        $request = new \Iyzipay\Request\CreateBasicPaymentRequest();
        $request->setLocale(MyPayment::getLang());
        $request->setConversationId($this->paymentTransaction->PaymentTransactionID);
        $request->setBuyerEmail($this->paymentAccount->email);
        $request->setBuyerId($this->paymentAccount->CustomerID);
        $request->setBuyerIp(Request::ip());
        $request->setConnectorName("690-garanti");
        $request->setInstallment(1);
        $request->setPaidPrice($this->paymentAccount->Application->Price);
        $request->setPrice($this->paymentAccount->Application->Price);
        $request->setCurrency(\Iyzipay\Model\Currency::TL);
        if ($callbackUri) {
            $request->setCallbackUrl($callbackUri);
        }
        return $request;
    }

    public function get3dsResponse(iyzico3dsResponse $response)
    {
        $this->paymentTransaction = PaymentTransaction::find($response->conversationId);
        if (!$this->paymentTransaction) {
            $errorLog = new ServerErrorLog();
            $errorLog->Header = 571;
            $errorLog->Url = 'Server 3ds payment';
            $errorLog->Parameters = $response;
            $errorLog->ErrorMessage = 'Payment Transaction Data does not exists in Database.';
            $errorLog->save();
        }

        //lets get the PaymentAccount now
        $this->paymentAccount = PaymentAccount::find($this->paymentTransaction->PaymentAccountID);
        if($response->status == 'success') {
            $request = new \Iyzipay\Request\CreateThreedsPaymentRequest();
            $request->setLocale(MyPayment::getLang());
            $request->setConversationId($response->conversationId);
            $request->setPaymentId($response->paymentId);
            $basicThreedsPayment = \Iyzipay\Model\BasicThreedsPayment::create($request, $this->options);
            $this->paymentAccount->updateAccount($basicThreedsPayment);
            $this->paymentTransaction->updateTransaction($basicThreedsPayment);
            return "Success";
        }
        return (string)__('error.something_went_wrong');
    }
}