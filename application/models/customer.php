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
class Customer extends Eloquent
{

    public static $timestamps = false;
    public static $table = 'Customer';
    public static $key = 'CustomerID';

    public static function CustomerFileSize()
    {
        $command = 'du -ha ' . path('public') . 'files/ --max-depth=1| sort -hr';
        $folderStructure = shell_exec($command);
        $folders = explode(PHP_EOL, $folderStructure);
        $folderSizes = array();
        foreach ($folders as $folder) {
            $list = explode("\t", $folder);
            if (count($list) == 2) {
                if (strpos($list[1], "customer_")) {
                    $customerID = str_replace(path('public') . 'files/customer_', '', $list[1]);
                    $folderSizes[$list[0]] = Customer::find($customerID);;
                }
            }
        }

        return $folderSizes;
    }

    /**
     *
     * @param int $customerID
     * @param array $columns
     * @return Customer
     */
    public static function find($customerID, $columns = array('*'))
    {
        return Customer::where(self::$key, "=", $customerID)->first($columns);
    }

    /**
     *
     * @param int $statusID
     * @return Application[]
     */
    public function Applications($statusID)
    {
        return $this->has_many('Application', $this->key())->where('StatusID', '=', $statusID)->get();
    }

    /**
     *
     * @return PaymentAccount
     */
    public function getLastSelectedPaymentAccount()
    {
        return $this->has_one('PaymentAccount', "CustomerID")->order_by("selected_at", "DESC")->first();
    }

    /**
     *
     * @return PaymentAccount
     */
    public function PaymentAccount()
    {
        return $this->has_one('PaymentAccount', "CustomerID")->first();
    }

}
