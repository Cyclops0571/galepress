<?php

/**
 * @property mixed UID
 * @property int Type
 * @property mixed Time
 * @property bool|string RequestDate
 * @property mixed Lat
 * @property mixed Long
 * @property mixed DeviceID
 * @property int CustomerID
 * @property int ApplicationID
 * @property int ContentID
 * @property int Page
 * @property mixed Param5
 * @property mixed Param6
 * @property mixed Param7
 */
class Statistic extends Eloquent {

    public static $timestamps = false;
    public static $table = 'Statistic';
    public static $key = 'StatisticID';

    public function save() {
	if (!$this->dirty()) {
	    return true;
	}

	$userID = -1;
	if (Auth::User()) {
	    $userID = Auth::User()->UserID;
	}

	if ((int) $this->StatisticID == 0) {
	    $this->DateCreated = new DateTime();
	    $this->ProcessTypeID = eProcessTypes::Insert;
	    $this->CreatorUserID = $userID;
	    $this->StatusID = eStatus::Active;
	} else {
	    $this->ProcessTypeID = eProcessTypes::Update;
	}
	$this->ProcessUserID = $userID;
	$this->ProcessDate = new DateTime();
	parent::save();
    }

}
