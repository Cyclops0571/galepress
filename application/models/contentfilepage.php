<?php

class ContentFilePage extends Eloquent {

    public static $timestamps = false;
    public static $table = 'ContentFilePage';
    public static $key = 'ContentFilePageID';

    public function save() {
	if (!$this->dirty()) {
	    return true;
	}
	$userID = -1;
	if (Auth::User()) {
	    $userID = Auth::User()->UserID;
	}

	if ((int) $this->ContentFilePageID == 0) {
	    $this->DateCreated = new DateTime();
	    $this->CreatorUserID = $userID;
	    $this->StatusID = eStatus::Active;
	    $this->ProcessTypeID = eProcessTypes::Insert;
	} else {
	    $this->ProcessTypeID = eProcessTypes::Update;
	}

	$this->ProcessUserID = $userID;
	$this->ProcessDate = new DateTime();
	parent::save();
    }

}
