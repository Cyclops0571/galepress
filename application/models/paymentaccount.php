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
 * @property int $expiry_month Description
 * @property int $expiry_year Description
 * @property int $last_4_digits Description
 * @property int $holder Description
 * @property int $mail_send Description
 * @property int $selected_at Description
 */
class PaymentAccount extends Eloquent {

    public static $table = 'PaymentAccount';
    public static $key = 'PaymentAccountID';

    /**
     * 
     * @return City
     */
    public function city() {
	return $this->belongs_to('City', 'CityID')->first();
    }

    /**
     * 
     * @return Application
     */
    public function Application() {
	return $this->belongs_to('Application', 'ApplicationID')->first();
    }

    public function save() {
	if (!$this->dirty()) {
	    return true;
	}
	
	if($this->payment_count != 0 && !empty($this->FirstPayment)) {
	    $this->ValidUntil = date("Y-m-d", strtotime($this->FirstPayment . " +" . $this->payment_count . " month"));
	}
	parent::save();
    }

}
