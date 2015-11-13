<?php

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
