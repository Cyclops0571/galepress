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
 * @property int $Version Version
 * @property int $Status Description
 * @property int $StatusID Description
 * @property int $created_at Description
 * @property int $updated_at Description
 * @property Application $Application Description
 */
class Banner extends Eloquent
{

    public static $table = 'Banner';
    public static $key = 'BannerID';
    public static $slideAnimations = array("slide", "fade", "cube", "coverflow", "flip");

    /**
     *
     * @param int $bannerID
     * @return Banner
     */
    public static function find($bannerID)
    {
        return Banner::where(self::$key, '=', $bannerID)->where("StatusID", '=', eStatus::Active)->first();
    }

    /**
     *
     * @param int $applicationID
     * @param bool $showPassive
     * @return Banner
     */
    public static function getAppBanner($applicationID, $showPassive = true)
    {
        if ($showPassive) {
            return Banner::where("ApplicationID", "=", $applicationID)
                ->where("StatusID", "=", eStatus::Active)
                ->order_by("OrderNo", "Desc")
                ->get();

        }

        return Banner::where("ApplicationID", "=", $applicationID)
            ->where("StatusID", "=", eStatus::Active)
            ->where("Status", "=", eStatus::Active)
            ->order_by("OrderNo", "Desc")
            ->get();
    }

    /**
     *
     * @return void
     */
    public function processImage($tmpFileName)
    {
        $application = $this->Application;
        $tmpFilePath = path('public') . PATH_TEMP_FILE . '/' . $tmpFileName;
        $destinationFolder = path('public') . 'files/customer_' . $application->CustomerID . '/application_' . $application->ApplicationID . '/banner/';
        $sourcePicturePath = $destinationFolder . Auth::User()->UserID . '_' . date("YmdHis") . '_' . $tmpFileName;
        if (!is_file($tmpFilePath)) {
            return;
        }

        if (!File::exists($destinationFolder)) {
            File::mkdir($destinationFolder);
        }

        File::move($tmpFilePath, $sourcePicturePath);

        $pictureInfoSet = array();
        $pictureInfoSet[] = array("width" => 1480, "height" => 640, "imageName" => $this->BannerID);
        foreach ($pictureInfoSet as $pInfo) {
            ImageClass::cropImage($sourcePicturePath, $destinationFolder, $pInfo["width"], $pInfo["height"], $pInfo["imageName"], FALSE);
        }
    }

    /**
     *
     * @return Application
     */
    public function Application()
    {
        return $this->belongs_to('Application', 'ApplicationID');
    }

    public function save($updateAppVersion = TRUE)
    {
        if (!$this->dirty()) {
            return;
        }

        if ($this->BannerID == 0) {
            $this->StatusID = eStatus::Active;
        }
        $this->Version = (int)$this->Version + 1;
        if ($updateAppVersion) {
            $App = Application::find($this->ApplicationID);
            if ($App) {
                $App->incrementAppVersion();
            }
        }
        parent::save();
    }

    public function statusText()
    {
        return __('common.banners_list_status' . $this->Status);
    }

    public function getImagePath()
    {
        return '/files/customer_' . $this->Application->CustomerID . '/application_' . $this->ApplicationID . '/banner/' . $this->BannerID . IMAGE_EXTENSION;
    }

}
