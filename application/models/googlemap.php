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
	
	/**
	 * 
	 * @param type $googleMapID
	 * @return GoogleMap
	 */
	public static function find($googleMapID) {
		return GoogleMap::where(self::$key, '=', $googleMapID)->where("StatusID", '=', eStatus::Active)->first();
	}

    public static function getSampleXmlUrl()
    {
        return "/files/sampleFiles/SampleMapExcel_" . Laravel\Config::get("application.language") . ".xls";
    }

    public function CheckOwnership($appID)
    {
        return $this->ApplicationID == $appID;
    }

    public function save()
    {
        if (!$this->dirty()) {
            return true;
        }

        if (!$this->GoogleMapID) {
            $this->StatusID = eStatus::Active;
        }
        parent::save();
    }
}
