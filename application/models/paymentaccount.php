<?php

/**
 * @property int $PaymentAccountID Description
 * @property int $CustomerID Description
 * @property int $payment_count Description
 * @property int $email Description
 * @property int $phone Description
 * @property int $title Description
 * @property int $tckn Description
 * @property int $vergi_dairesi Description
 * @property int $vergi_no Description
 * @property int $city_id Description
 * @property int $kurumsal Description
 * @property int $address Description
 * @property int $last_payment_day Description
 * @property int $card_token Description
 * @property int $bin Description
 * @property int $brand Description
 * @property int $expiry_month Description
 * @property int $expiry_year Description
 * @property int $last_4_digits Description
 * @property int $holder Description
 */
class PaymentAccount extends Eloquent{
	public static $table = 'PaymentAccount';
	public static $key = 'PaymentAccountID';
	
	/**
	 * 
	 * @return City
	 */
	public function city() {
		return $this->has_one('City', 'city_id')->first();
	}
}
