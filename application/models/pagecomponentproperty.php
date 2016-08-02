<?php

/**
 * @property int PageComponentPropertyID
 * @property int PageComponentID
 * @property string Name
 * @property string Value
 * @property int ProcessTypeID
 * @property DateTime ProcessDate
 * @property DateTime DateCreated
 * @property int StatusID
 * @property int CreatorUserID
 * @property int ProcessUserID
 */
class PageComponentProperty extends Eloquent
{

    public static $timestamps = false;
    public static $table = 'PageComponentProperty';
    public static $key = 'PageComponentPropertyID';

    public static function batchInsert($pageComponentID, array $nameValueSet)
    {
        foreach ($nameValueSet as $name => $value) {
            $pcp = new PageComponentProperty();
            $pcp->PageComponentID = $pageComponentID;
            $pcp->Name = $name;
            $pcp->Value = $value;
            $pcp->save();
        }
    }

    public function save()
    {
        if (!$this->dirty()) {
            return true;
        }
        $userID = -1;
        if (Auth::user()) {
            $userID = Auth::user()->UserID;
        }

        if ((int)$this->PageComponentPropertyID == 0) {
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
