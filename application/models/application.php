<?php

/**
 * @property int $ApplicationID Description
 * @property int $CustomerID Description
 * @property int $Name Description
 * @property int $Detail Description
 * @property int $ThemeBackground Description
 * @property int $ThemeForeground Description
 * @property int $Price Description
 * @property text $BundleText Description
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
 * @property int $SubscriptionWeekActive Description
 * @property int $WeekPrice Description
 * @property int $SubscriptionMonthActive Description
 * @property int $MonthPrice Description
 * @property int $SubscriptionYearActive Description
 * @property int $YearPrice Description
 */
class Application extends Eloquent {

    public static $timestamps = false;
    public static $table = 'Application';
    public static $key = 'ApplicationID';

    /**
     * 
     * @return Customer
     */
    public function Customer() {
	return $this->belongs_to('Customer', 'CustomerID')->first();
    }

    public function ApplicationStatus($languageID) {
	if ((int) $this->ApplicationStatusID > 0) {
	    $gc = GroupCode::find($this->ApplicationStatusID)->first();
	    if ($gc) {
		return $gc->DisplayName($languageID);
	    }
	}
	return '';
    }

    public function Package() {
	return $this->belongs_to('Package', 'PackageID')->first();
    }

    public function Categories($statusID) {
	return $this->has_many('Category', $this->key())->where('StatusID', '=', $statusID)->get();
    }

    /**
     * 
     * @param type $statusID
     * @return Content
     */
    public function Contents($statusID = eStatus::All) {
	$rs = $this->has_many('Content', $this->key());
	if ($statusID != eStatus::All) {
	    $rs->where('StatusID', '=', $statusID);
	}
	return $rs->get();
    }

    public function Users() {
	return $this->has_many('ApplicationUser', $this->key());
    }

    public function Tags() {
	return $this->has_many('ApplicationTag', $this->key());
    }

    /**
     * 
     * @return Tab
     */
    public function Tabs() {
	return $this->has_many('Tab', $this->key())->where('StatusID', '=', eStatus::Active)
			->take(TAB_COUNT)
			->get();
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
	if ((int) $currentUser->UserTypeID == eUserTypes::Manager) {
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
	if (!$this->dirty()) {
	    return true;
	}

	$userID = -1;
	if (Auth::User()) {
	    $userID = Auth::User()->UserID;
	}

	if ((int) $this->ApplicationID == 0) {
	    $this->DateCreated = new DateTime();
	    $this->ProcessTypeID = eProcessTypes::Insert;
	    $this->CreatorUserID = $userID;
	    $this->StatusID = eStatus::Active;
	} else {
	    $this->ProcessTypeID = eProcessTypes::Update;
	}
	$this->ProcessUserID = $userID;
	$this->ProcessDate = new DateTime();
	if ($IncrementVersion) {
	    $this->Version = (int) $this->Version + 1;
	}
	parent::save();
    }

    public function incrementAppVersion() {
	$this->Version++;
	parent::save();
    }

    public function TabsForService() {
	$tabsForService = array();
	if (!$this->TabActive) {
	    return $tabsForService;
	}
	$tabs = $this->Tabs();
	foreach ($tabs as $tab) {
	    if ($tab->Status == eStatus::Active) {
		$tabsForService[] = array(
		    "tabTitle" => $tab->TabTitle,
		    "tabLogoUrl" => Config::get('custom.url') . $tab->IconUrl,
		    "tabLogoUrl_1x" => Config::get('custom.url') . str_replace("app-icons", "app-icons/1x", $tab->IconUrl),
		    "tabLogoUrl_2x" => Config::get('custom.url') . str_replace("app-icons", "app-icons/2x", $tab->IconUrl),
		    "tabLogoUrl_3x" => Config::get('custom.url') . str_replace("app-icons", "app-icons/3x", $tab->IconUrl),
		    "tabUrl" => $tab->urlForService()
		);
	    }
	}
	return $tabsForService;
    }

    /**
     * 
     * @return PaymentAccount
     */
    public function PaymentAccount() {
	return $this->has_one('PaymentAccount', "ApplicationID")->first();
    }

    /**
     * 
     * @param int $type
     * @return type
     */
    public function getSubscriptionIdentifier($type = 1) {
	if (empty($this->BundleText)) {
	    return "www.galepress.com.appid." . $this->ApplicationID . "type" . $type;
	}
	return $this->BundleText . ".appid." . $this->ApplicationID . ".type" . $type;
    }

    /**
     * 
     * @param type $key
     * @param type $value
     * @return type
     */
    public function subscriptionStatus($key, $value = NULL) {
	$result = "";
	switch ($key) {
	    case Subscription::week:
		if ($value != NULL) {
		    $this->SubscriptionWeekActive = $value;
		}
		$result = $this->SubscriptionWeekActive;
		break;
	    case Subscription::mounth:
		if ($value != NULL) {
		    $this->SubscriptionMonthActive = $value;
		}
		$result = $this->SubscriptionMonthActive;
		break;
	    case Subscription::year:
		if ($value != NULL) {
		    $this->SubscriptionYearActive = $value;
		}
		$result = $this->SubscriptionYearActive;
		break;
	}
	return $result;
    }

    /**
     * 
     * @param type $key
     * @param type $value
     * @return type
     */
    public function subscriptionPrice($key, $value = NULL) {
	$result = "";
	switch ($key) {
	    case Subscription::week:
		if ($value != NULL) {
		    $this->WeekPrice = $value;
		}
		$result = $this->WeekPrice;
		break;
	    case Subscription::mounth:
		if ($value != NULL) {
		    $this->MonthPrice = $value;
		}
		$result = $this->MonthPrice;
		break;
	    case Subscription::year:
		if ($value != NULL) {
		    $this->YearPrice = $value;
		}
		$result = $this->YearPrice;
		break;
	}
	return $result;
    }

    public function sidebarClass() {
	if ($this->ExpirationDate < date("Y-m-d")) {
	    return array("class" => 'expired-app');
	}
	return array();
    }

}
