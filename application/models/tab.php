<?php

/**
 * @property int $TabID Description
 * @property int $ApplicationID Description
 * @property int $TabTitle Description
 * @property int $Url Description
 * @property int $InhouseUrl Description
 * @property int $IconUrl Description
 * @property int $Status Description
 * @property int $StatusID Description
 * @property int $created_at Description
 * @property int $updated_at Description
 */
class Tab extends Eloquent {

	public static $table = 'Tabs';
	public static $key = 'TabID';

	/**
	 * 
	 * @param type $tabID
	 * @return Tab
	 */
	public static function find($tabID) {
		return Banner::where(self::$key, '=', $tabID)->first();
	}

	public static function getGalepresTabs() {
		return array(
			"StoreLocator" => __('common.map_title')
		);
	}

	public function urlForService() {
		if (!empty($this->Url) && $this->Url != "http://") {
			$url = $this->Url;
		} else {
			switch ($this->InhouseUrl) {
				case "StoreLocator":
					$url = Config::get('custom.url') .  "/maps/webview/" . $this->ApplicationID;
					break;
				default :
					$url = Config::get('custom.url');
			}
		}
		return $url;
	}

}
