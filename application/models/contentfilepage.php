<?php

/**
 * @property int ContentFilePageID
 * @property int ProcessTypeID
 * @property int ContentFileID
 * @property int No
 * @property int OperationStatus
 * @property int Width
 * @property int Height
 * @property string FilePath
 * @property string FileName
 * @property string FileName2
 * @property int FileSize
 * @property int StatusID
 * @property DateTime ProcessDate
 * @property int ProcessUserID
 * @property DateTime DateCreated
 * @property int CreatorUserID
 * @property PageComponent[] $PageComponent
 */
class ContentFilePage extends Eloquent
{

    public static $timestamps = false;
    public static $table = 'ContentFilePage';
    public static $key = 'ContentFilePageID';

    public function save()
    {
        if (!$this->dirty()) {
            return true;
        }
        $userID = -1;
        if (Auth::User()) {
            $userID = Auth::User()->UserID;
        }

        if ((int)$this->ContentFilePageID == 0) {
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

    public function PageComponent()
    {
        return $this->has_many('PageComponent', $this->key())->where('StatusID', '=', eStatus::Active);
    }

}
