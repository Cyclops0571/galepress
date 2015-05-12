<?php
/**
 * @property int $BannerID Description
 * @property int $ApplicationID Description
 * @property int $OrderNo Description
 * @property int $ImagePublicPath Description
 * @property int $ImageLocalPath Description
 * @property int $TargetUrl Description
 * @property int $TargetContent Description
 * @property int $Description Description
 * @property int $Autoplay Description
 * @property int $IntervalTime Description
 * @property int $TransitionRate Description
 * @property int $Status Description
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
	
	/**
	 * 
	 * @param Application $application
	 * @return type
	 */
	public function processImage($application) {
		if((int)Input::get("hdnImageFileSelected") != 1) {
			return;
		}
		
		$tmpFileName = Input::get("hdnCoverImageFileName");
		$tmpFilePath = path('public') . PATH_TEMP_FILE . '/' . $tmpFileName;
		$destinationFolder = path('public') . 'files/customer_' . $application->CustomerID . '/application_' . $application->ApplicationID . '/banner/';
		$sourcePicturePath = $destinationFolder . Auth::User()->UserID . '_' . date("YmdHis") . '_' . $tmpFileName;
		$targetPicturePath = $destinationFolder . $this->BannerID;
		if(!is_file($tmpFilePath)) {
			return;
		}
		
		if (!File::exists($destinationFolder)) {
			File::mkdir($destinationFolder);
		}
		
		File::move($tmpFilePath, $sourcePicturePath);
		
		$pictureInfoSet = array();
		$pictureInfoSet[] = array("width" => 110, "height" => 157, "imageName" => $targetMainFileName);
		foreach($pictureInfoSet as $pInfo) {			
			imageClass::cropImage($targetFileNameFull, $destinationFolder, $pInfo["width"], $pInfo["height"], $pInfo["imageName"], FALSE);
		}
		
	}
	
	public function save() {
		if(!$this->dirty()) {
			return;
		}
		
		if($this->BannerID == 0) {
			$this->StatusID = eStatus::Active;
		}
		parent::save();
	}
}
