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
 * @property int $BannerActive Description
 * @property int $BannerAutoplay Description
 * @property int $BannerIntervalTime Description
 * @property int $BannerTransitionRate Description
 * @property int $TabActive Description
 */
class Application extends Eloquent
{
	public static $timestamps = false;
	public static $table = 'Application';
	public static $key = 'ApplicationID';
	
	/**
	 * 
	 * @return Customer
	 */
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
	 * @return Tab
	 */
	public function Tabs() {
		return $this->has_many('Tab', $this->key())->where('StatusID', '=', eStatus::Active)->get();
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
	
	public function save($IncrementVersion = TRUE) {
		if(!$this->dirty()) {
			return true;
		}
		
		$userID = -1;
		if(Auth::User()) {
			$userID = Auth::User()->UserID;
		}
		
		if((int)$this->ApplicationID == 0) {
			$this->DateCreated = new DateTime();
			$this->ProcessTypeID = eProcessTypes::Insert;
			$this->CreatorUserID = $userID;
			$this->StatusID = eStatus::Active;
		} else {
			$this->ProcessTypeID = eProcessTypes::Update;
		}
		$this->ProcessUserID = $userID;
		$this->ProcessDate = new DateTime();
		if($IncrementVersion) {
			$this->Version = (int)$this->Version + 1;
		}
		parent::save();
	}
	
	public function incrementAppVersion() {
		$this->Version++;
		parent::save();
	}
	
	public function TabsForService() {
		$tabsForService = array();
		if(!$this->TabActive) {
			return $tabsForService;
		}
		$tabs = $this->Tabs();
		foreach($tabs as $tab) {
			if($tab->Status == eStatus::Active) {
				$tabsForService[] = array("tabLogoUrl" => Config::get('custom.url') . $tab->IconUrl, "tabUrl" => $tab->urlForService());
			}
		}
		return $tabsForService;
	}
}