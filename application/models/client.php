<?php

/**
 * @property int $ClientID Description
 * @property int $ApplicationID Description
 * @property int $Username Description
 * @property int $Password Description
 * @property int $Email Description
 * @property int $Token Description
 * @property int $DeviceToken Description
 * @property int $Name Description
 * @property int $Surname Description
 * @property int $PaidUntil Description
 * @property int $ContentIDSet Description
 * @property int $LastLoginDate Description
 * @property int $InvalidPasswordAttempts Description
 * @property int $PWRecoveryCode Description
 * @property int $PWRecoveryDate Description
 * @property int $StatusID Description
 * @property int $CreatorUserID Description
 * @property int $created_at Description
 * @property int $updated_at Description
 * @property Application $Application Description
 */
class Client extends Laravel\Database\Eloquent\Model {

    public static $table = 'Client';
    public static $key = 'ClientID';

    public function save() {
	if (!$this->dirty()) {
	    return true;
	}

	parent::save();
    }

    /**
     * 
     * @param int $ClientID
     * @return Client
     */
    public static function find($clientID, $columns = array('*')) {
	return Client::where(self::$key, "=", $clientID)->first($columns);
    }

    public function Application() {
	return $this->belongs_to('Application', 'ApplicationID')->first();
    }

    /**
     * 
     * @return ClientSubscription
     */
    public function ClientContents() {
	return $this->has_many("ClientSubscription", "ClientSubscription")->get();
    }

    /**
     * 
     * @return Content
     */
    public function Contents() {
	$contents = array();
	$contentIDSet = explode(",", $this->ContentIDSet);
	foreach($contentIDSet as $contentID) {
	    $tmpContent = Content::find($contentID);
	    if($tmpContent) {
		$contents[] = $tmpContent;
	    }
	}
	return $contents;
    }
    
    public static function getSampleXmlUrl() {
	return "/files/sampleFiles/SampleClientExcel_" . Laravel\Config::get("application.language") . ".xls";
    }
    
    public static function updateDeviceToken($accessToken, $deviceToken) {
	if(!empty($deviceToken)) {
	    /* @var $client Client */
	    $client = Client::where("Token", "=", $accessToken)->where("StatusID", "=", eStatus::Active)->first();
	    if($client && $client->DeviceToken !== $deviceToken) {
		$client->DeviceToken = $deviceToken;
		$client->save();
	    }
	}
    }
}
