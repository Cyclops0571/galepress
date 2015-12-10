<?php

/**
 * @property int ProcessTypeID
 * @property DateTime ProcessDate
 * @property DateTime DateCreated
 * @property int StatusID
 * @property  Value
 * @property string Value
 * @property int Value
 * @property  Name
 * @property mixed PageComponentID
 * @property  Name
 */
class PageComponentProperty extends Eloquent {

    public static $timestamps = false;
    public static $table = 'PageComponentProperty';
    public static $key = 'PageComponentPropertyID';

    public function save() {
	if (!$this->dirty()) {
	    return true;
	}
	$userID = -1;
	if (Auth::User()) {
	    $userID = Auth::User()->UserID;
	}

	if ((int) $this->PageComponentPropertyID == 0) {
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

    public static function batchInsert($pageComponentID, array $nameValueSet) {
	foreach ($nameValueSet as $name => $value) {
	    $pcp = new PageComponentProperty();
	    $pcp->PageComponentID = $pageComponentID;
	    $pcp->Name = $name;
	    $pcp->Value = $value;
	    $pcp->save();
	}
    }

}
