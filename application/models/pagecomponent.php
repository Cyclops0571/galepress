<?php

/**
 * Class PageComponent
 * @property mixed PageComponentID
 * @property int ProcessTypeID
 * @property DateTime ProcessDate
 * @property DateTime DateCreated
 * @property int StatusID
 * @property int No
 * @property int ComponentID
 * @property int ContentFilePageID
 */
class PageComponent extends Eloquent {

    public static $timestamps = false;
    public static $table = 'PageComponent';
    public static $key = 'PageComponentID';

    public function Component() {
	return $this->belongs_to('Component', 'ComponentID')->first();
    }

    public function save() {
	if (!$this->dirty()) {
	    return true;
	}
	$userID = -1;
	if (Auth::User()) {
	    $userID = Auth::User()->UserID;
	}

	if ((int) $this->PageComponentID == 0) {
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
