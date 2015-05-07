<?php
/**
 * @property int $ApplicationID Description
 * @property int $CustomerID Description
 * @property int $Name Description
 * @property int $Detail Description
 * @property int $ThemeBackground Description
 * @property int $ThemeForeground Description
 * @property int $StartDate Description
 * @property int $ExpirationDate Description
 * @property int $ApplicationStatusID Description
 * @property int $IOSVersion Description
 * @property int $IOSLink Description
 * @property int $AndroidVersion Description
 * @property int $AndroidLink Description
 * @property int $Blocked Description
 * @property int $Status Description
 * @property int $Version Description
 * @property int $Force Description
 * @property int $TotalFileSize Description
 * @property int $NotificationText Description
 * @property int $CkPem Description
 * @property int $StatusID Description
 * @property int $CreatorUserID Description
 * @property int $DateCreated Description
 * @property int $ProcessUserID Description
 * @property int $ProcessDate Description
 * @property int $ProcessTypeID Description
 */
class Application extends Eloquent
{
	public static $timestamps = false;
	public static $table = 'Application';
	public static $key = 'ApplicationID';
	
	public function Customer()
	{
		return $this->belongs_to('Customer', 'CustomerID')->first();
	}
	
	public function ApplicationStatus($languageID)
	{
		if((int)$this->ApplicationStatusID > 0)
		{
			$gc = GroupCode::find($this->ApplicationStatusID)->first();
			if($gc) {
				return $gc->DisplayName($languageID);	
			}
		}
		return '';
	}
	
	public function Package()
	{
		return $this->belongs_to('Package', 'PackageID')->first();
	}

	public function Categories($statusID)
	{
		return $this->has_many('Category', $this->key())->where('StatusID', '=', $statusID)->get();
	}
	
	public function Contents($statusID)
	{
		return $this->has_many('Content', $this->key())->where('StatusID', '=', $statusID)->get();
	}
	
	public function Users()
	{
		return $this->has_many('ApplicationUser', $this->key());
	}
	
	public function Tags()
	{
		return $this->has_many('ApplicationTag', $this->key());
	}
	
	/**
	 * 
	 * @return Content
	 */
	public function getContentSet() {
		return Content::where('ApplicationID', '=', $this->ApplicationID)
			->where('StatusID', '=', eStatus::Active)
			->order_by('Name', 'ASC')
			->get();
	}
	
	/**
	 * 
	 * @param int $applicationID
	 * @return Application
	 */
	public static function find($applicationID, $columns = array('*')) {
		return Application::where(self::$key, "=", $applicationID)->first($columns);
	}
	
	public function CheckOwnership() {
		$currentUser = Auth::User();
		if ((int) $currentUser->UserTypeID == eUserTypes::Manager)  {
			return true;
		}
		
		if ((int) $currentUser->UserTypeID == eUserTypes::Customer) {
			if ((int) $this->StatusID == eStatus::Active) {
				$c = $this->Customer();
				if ((int) $c->StatusID == eStatus::Active) {
					if ((int) $currentUser->CustomerID == (int) $c->CustomerID) {
						return true;
					}
				}
			}
			return false;
		}
	}
}