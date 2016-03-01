<?php

/**
 * @property int $ClientReceiptID Description
 * @property int $ClientID Description
 * @property int $SubscriptionID Description
 * @property mixed PackageName
 * @property int $SubscriptionType Description
 * @property int $SubscriptionStartDate Description
 * @property int $SubscriptionEndDate Description
 * @property int $Receipt Description
 * @property int $MarketResponse Description
 * @property int $StatusID Description
 */
class ClientReceipt extends Laravel\Database\Eloquent\Model
{

    public static $table = 'ClientReceipt';
    public static $key = 'ClientReceiptID';

    /**
     *
     * @param int $ClientReceiptID
     * @return ClientReceipt
     */
    public static function find($ClientReceiptID, $columns = array('*'))
    {
        return ClientContent::where(self::$key, "=", $ClientReceiptID)->first($columns);
    }

    public function save()
    {
        if (!$this->dirty()) {
            return true;
        }

        parent::save();
    }

    /**
     *
     * @return Client
     */
    public function Client()
    {
        return $this->belongs_to('Client', 'ClientID')->first();
    }

}
