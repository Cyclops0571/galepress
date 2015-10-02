<?php

/**
 * @property int $ClientSubscriptionID Description
 * @property int $ClientID Description
 * @property int $SubscriptionType Description
 * @property int $SubscriptionDate Description
 * @property int $ContentID Description
 * @property int $StatusID Description
 */
class ClientSubscription extends Laravel\Database\Eloquent\Model {

    public static $table = 'ClientSubscription';
    public static $key = 'ClientSubscriptionID';

    public function save() {
	if (!$this->dirty()) {
	    return true;
	}

	parent::save();
    }

    /**
     * 
     * @param int $ClientSubscriptionID
     * @return ClientSubscription
     */
    public static function find($ClientSubscriptionID, $columns = array('*')) {
	return ClientContent::where(self::$key, "=", $ClientSubscriptionID)->first($columns);
    }

    /**
     * 
     * @return Client
     */
    public function Client() {
	return $this->belongs_to('Client', 'ClientID')->first();
    }

}
