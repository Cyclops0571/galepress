<?php

/**
 * @property int $PaymentAccountID Description
 * @property int $CustomerID Description
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
}
