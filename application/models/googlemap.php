<?php

/**
 * @property int $GoogleMapID Description
 * @property int $ApplicationID Description
 * @property int $Name Description
 * @property int $Address Description
 * @property int $Description Description
 * @property int $Latitude Description
 * @property int $Longitude Description
 * @property int $StatusID Description
 * @property int $created_at Description
 * @property int $updated_at Description
 */
class GoogleMap extends Eloquent{
	public static $table = 'GoogleMap';
	public static $key = 'GoogleMapID';
	
	public function CheckOwnership($appID) {
		return $this->ApplicationID == $appID;
	}
	
	/**
	 * 
	 * @param type $googleMapID
	 * @return GoogleMap
	 */
	public static function find($googleMapID) {
		return GoogleMap::where(self::$key, '=', $googleMapID)->where("StatusID", '=', eStatus::Active)->first();
	}
}
