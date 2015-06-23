<?php

/**
 * @property int $PaymentTransactionID Description
 * @property int $transaction_id Description
 * @property int $external_id Description
 * @property int $reference_id Description
 * @property int $state Description
 * @property int $amount Description
 * @property int $currency Description
 */
class PaymentTransaction extends Eloquent {

	public static $table = 'PaymentTransaction';
	public static $key = 'PaymentTransactionID';

}