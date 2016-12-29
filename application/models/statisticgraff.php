<?php

/**
 * @property int ServiceVersion
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
 */
class StatisticGraff extends Eloquent
{

    public static $timestamps = true;
    public static $table = 'StatisticGraff';
    public static $key = 'StatisticGraffID';

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
        parent::save();
    }

}
