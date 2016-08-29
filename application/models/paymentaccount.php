<?php

/**
 * @property int $PaymentAccountID Description
 * @property int $CustomerID Description
 * @property int $ApplicationID Description
 * @property int $email Description
 * @property int $phone Description
 * @property int $title Description
 * @property int $tckn Description
 * @property int $vergi_dairesi Description
 * @property int $vergi_no Description
 * @property int $CityID Description
 * @property int $kurumsal Description
 * @property int $address Description
 * @property int $payment_count Description
 * @property int $FirstPayment Description
 * @property int $last_payment_day Description
 * @property int $ValidUntil Description
 * @property int $WarningMailPhase Description
 * @property int $card_token Description
 * @property int $bin Description
 * @property int $brand Description
 * @property int $cardType Description
 * @property int $cardAssociation Description
 * @property int $cardFamily Description
 * @property int $cardToken Description
 * @property int $cardUserKey Description
 * @property int $expiry_month Description
 * @property int $expiry_year Description
 * @property int $last_4_digits Description
 * @property int $holder Description
 * @property int $card_verification Description
 * @property int $mail_send Description
 * @property int $StatusID Description
 * @property int $selected_at Description
 * @property Application $Application Description
 */
class PaymentAccount extends Eloquent
{

    public static $table = 'PaymentAccount';
    public static $key = 'PaymentAccountID';

    /**
     *
     * @return City
     */
    public function city()
    {
        return $this->belongs_to('City', 'CityID')->first();
    }

    /**
     *
     * @return Application
     */
    public function Application()
    {
        return $this->belongs_to('Application', 'ApplicationID');
    }

    public function save()
    {
        if (!$this->dirty()) {
            return true;
        }

        if (empty($this->FirstPayment)) {
            $this->FirstPayment = date('Y-m-d');
        }

        if ($this->payment_count != 0 && !empty($this->FirstPayment)) {
            $this->ValidUntil = date("Y-m-d", strtotime($this->FirstPayment . " +" . $this->payment_count . " month"));
        }
        return parent::save();
    }

    /**
     * @param \Iyzipay\Model\BasicPayment|\Iyzipay\Model\BasicThreedsPayment $basicPayment
     */
    public function updateAccount($basicPayment)
    {
        //\Iyzipay\Model\BasicPayment|
        if ($basicPayment->getStatus() == "success") {
            if ($this->payment_count == 0) {
                $this->FirstPayment = date('Y-m-d');
            }
            $this->last_payment_day = date("Y-m-d");
            $this->payment_count = (int)$this->payment_count + 1;
            $token = $basicPayment->getCardToken();
            if (!empty($token)) {
                $this->cardType = $basicPayment->getCardType();
                $this->cardAssociation = $basicPayment->getCardAssociation();
                $this->cardFamily = $basicPayment->getCardFamily();
                $this->cardToken = $basicPayment->getCardToken();
                $this->cardUserKey = $basicPayment->getCardUserKey();
                $this->bin = $basicPayment->getBinNumber();
            }
            $this->WarningMailPhase = 0;
            $this->save();
            $this->sendPaymentUserSuccessMail();
        }
    }

    public function sendPaymentUserSuccessMail()
    {
        $paymentAccount = $this;
        Bundle::start('messages');
        Message::send(function ($m) use ($paymentAccount) {
            $replacement = array('HOLDER' => $paymentAccount->Application->Name, 'PRICE' => $paymentAccount->Application->Price, 'CURRENCY' => \Iyzipay\Model\Currency::TL);
            $body = (string)__('maillang.payment_successful_body', $replacement);
            $m->from((string)__('maillang.contanct_email'), Config::get('custom.mail_displayname'));
            $m->to($paymentAccount->email);
            $m->subject((string)__('maillang.payment_successful_subject'));
            $m->body($body);
        });
    }

}
