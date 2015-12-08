<?php

/**
 * @property $CustomerID Description
 * @property $CustomerNo Description
 * @property $CustomerName Description
 * @property $Address Description
 * @property $City Description
 * @property $Country Description
 * @property $Phone1 Description
 * @property $Phone2 Description
 * @property $Email Description
 * @property $BillName Description
 * @property $BillAddress Description
 * @property $BillTaxOffice Description
 * @property $BillTaxNumber Description
 * @property $TotalFileSize Description
 * @property $StatusID Description
 * @property $CreatorUserID Description
 * @property $DateCreated Description
 * @property $ProcessUserID Description
 * @property $ProcessDate Description
 * @property $ProcessTypeID Description
 */
class Customer extends Eloquent {

    public static $timestamps = false;
    public static $table = 'Customer';
    public static $key = 'CustomerID';

    /**
     * 
     * @param int $statusID
     * @return Application
     */
    public function Applications($statusID) {
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
    public function getLastSelectedPaymentAccount() {
	return $this->has_one('PaymentAccount', "CustomerID")->order_by("selected_at", "DESC")->first();
    }
    
    /**
     * 
     * @return PaymentAccount
     */
    public function PaymentAccount() {
	return $this->has_one('PaymentAccount', "CustomerID")->first();
    }

}
