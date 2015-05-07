<?php
/**
 * @property int $BannerID Description
 * @property int $ApplicationID Description
 * @property int $OrderNo Description
 * @property int $ImagePublicPath Description
 * @property int $ImageLocalPath Description
 * @property int $TargetUrl Description
 * @property int $TargetContent Description
 * @property int $StatusID Description
 * @property int $created_at Description
 * @property int $updated_at Description
 */
class Banner extends Eloquent{
	public static $table = 'Banner';
	public static $key = 'BannerID';
	
	/**
	 * 
	 * @param type $bannerID
	 * @return Banner
	 */
	public static function find($bannerID) {
		return Banner::where(self::$key, '=', $bannerID)->where("StatusID", '=', eStatus::Active)->first();
	}
	
	/**
	 * 
	 * @param type $applicationID
	 * @return Banner
	 */
	public static function getAppBanner($applicationID) {
		return Banner::where("ApplicationID", "=", $applicationID)
				->where("StatusID", "=", eStatus::Active)
				->order_by("OrderNo", "Desc")
				->get();
	}
}
