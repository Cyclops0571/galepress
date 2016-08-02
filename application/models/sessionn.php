<?php

/**
 * @property int $SessionID Description
 * @property int $UserID Description
 * @property int $IP Description
 * @property int $Session Description
 * @property int $LoginDate Description
 * @property int $LocalLoginDate Description
 * @property int $LogoutDate Description
 * @property int $CreatorUserID Description
 * @property int $DateCreated Description
 * @property int $ProcessUserID Description
 * @property int $ProcessDate Description
 * @property int $ProcessTypeID Description
 */
class Sessionn extends Eloquent {

    public static $timestamps = false;
    public static $table = 'Session';
    public static $key = 'SessionID';

    public function save() {
	if (!$this->dirty()) {
	    return true;
	}

	$userID = -1;
	if (Auth::user()) {
	    $userID = Auth::user()->UserID;
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
	parent::save();
    }

}
