<?php
/**
 * @property int $RequestTypeID Description
 * @property int $CustomerID Description
 * @property int $ApplicationID Description
 * @property int $ContentID Description
 * @property int $ContentFileID Description
 * @property int $ContentCoverImageFileID Description
 * @property int $RequestDate Description
 * @property int $IP Description
 * @property int $DeviceType Description
 * @property int $DeviceOS Description
 * @property int $FileSize Description
 * @property int $DataTransferred Description
 * @property int $Percentage Description
 * @property int $StatusID Description
 * @property int $CreatorUserID Description
 * @property int $DateCreated Description
 * @property int $ProcessUserID Description
 * @property int $ProcessDate Description
 * @property int $ProcessTypeID Description
 */
class Requestt extends Eloquent
{
	const IOS = 1;
	const ANDROID = 2;
	const WINDOWS = 3;
	const BLACKBARRY = 4;
	const LINUX = 5;
	
	
	public static $timestamps = false;
	public static $table = 'Request';
	public static $key = 'RequestID';
	
	
	public function save() {
		if(strpos($haystack, 'iPhone') !== FALSE) {
			$this->DeviceOS = self::IOS;
		} else if (strpos($haystack, 'iPad') !== FALSE) {
			$this->DeviceOS = self::IOS;
		} else if (strpos($haystack, 'iPod') !== FALSE) {
			$this->DeviceOS = self::IOS;
		} else if (strpos($haystack, 'Android') !== FALSE) {
			$this->DeviceOS = self::ANDROID;
		} else if (strpos($haystack, 'Windows') !== FALSE) {
			$this->DeviceOS = self::WINDOWS;
		} else if (strpos($haystack, 'BlackBerry') !== FALSE) {
			$this->DeviceOS = self::BLACKBARRY;
		} else if (strpos($haystack, 'Linux') !== FALSE) {
			$this->DeviceOS = self::LINUX;
		}
		
		parent::save();
	}
}