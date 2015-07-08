<?php

class Customer extends Eloquent
{
	public static $timestamps = false;
	public static $table = 'Customer';
	public static $key = 'CustomerID';
	
	/**
	 * 
	 * @param type $statusID
	 * @return Application
	 */
	public function Applications($statusID)
	{
		return $this->has_many('Application', $this->key())->where('StatusID', '=', $statusID)->get();
	}
	
	/**
	 * 
	 * @param type $customerID
	 * @param type $columns
	 * @return Customer
	 */
	public static function find($customerID, $columns = array('*')) {
		return Customer::where(self::$key, "=", $customerID)->first($columns);
	}
	
	/**
	 * 
	 * @return PaymentAccount
	 */
	public function PaymentAccount() {
		return $this->has_one('PaymentAccount', "CustomerID")->first();
	}
}