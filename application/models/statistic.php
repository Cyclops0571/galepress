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
 * @property mixed StatisticID
 * @property DateTime DateCreated
 * @property int ProcessTypeID
 * @property int CreatorUserID
 * @property int StatusID
 * @property int ProcessUserID
 * @property DateTime ProcessDate
 */
class Statistic extends Eloquent
{

    public static $timestamps = false;
    public static $table = 'Statistic';
    public static $key = 'StatisticID';

    public function save()
    {
        /*
        applicationActive = 1;
        applicationPassive = 2;
        applicationTerminated = 3;
        contentDownloaded = 10;
        contentUpdated = 11;
        contentOpened = 12;
        contentClosed = 13;
        contentDeleted = 14;
        pageOpenedPortrait = 21;
        pageOpenedLandscape = 22;
         */

        if (!$this->dirty()) {
            return true;
        }

        $validTypes = array(1, 2, 3, 10, 11, 12, 13, 14, 21, 22);
        if (!in_array($this->Type, $validTypes)) {
            throw new Exception('Invalid file type!');
        }

        $userID = -1;
        if (Auth::user()) {
            $userID = Auth::user()->UserID;
        }

        if ((int)$this->StatisticID == 0) {
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
