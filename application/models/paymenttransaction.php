<?php

/**
 * @property int $PaymentTransactionID Description
 * @property int $PaymentAccountID Description
 * @property int $CustomerID Description
 * @property int $transaction_id Description
 * @property int $transaction_token Description
 * @property int $external_id Description
 * @property int $reference_id Description
 * @property int $state Description
 * @property int $amount Description
 * @property int $currency Description
 * @property int $request Description
 * @property int $response Description
 * @property int $response3d Description
 * @property int $paid Description
 * @property int $mail_send Description
 * @method  static PaymentTransaction find(int $id)
 */
class PaymentTransaction extends Eloquent {

	public static $table = 'PaymentTransaction';
	public static $key = 'PaymentTransactionID';
	
	/**
	 * 
	 * @return PaymentAccount
	 */
	public function PaymentAccount() {
            return $this->belongs_to('PaymentAccount', 'PaymentAccountID')->first();
	}

}
