<?php

/**
 * @property int $PushNotificationID Description
 * @property int $TokenID Description
 * @property int $UDID Description
 * @property int $ApplicationToken Description
 * @property int $DeviceToken Description
 * @property int $DeviceType Description
 * @property int $Sent Description
 * @property int $ErrorCount Description
 * @property int $LastErrorDetail Description
 * @property int $StatusID Description
 * @property int $CreatorUserID Description
 * @property int $DateCreated Description
 * @property int $ProcessUserID Description
 * @property int $ProcessDate Description
 * @property int $ProcessTypeID Description
 * @property PushNotification $PushNotification Description
 */
class PushNotificationDevice extends Eloquent
{
    public static $timestamps = false;
    public static $table = 'PushNotificationDevice';
    public static $key = 'PushNotificationDeviceID';

    public function PushNotification()
    {
        return $this->belongs_to('PushNotification', 'PushNotificationID');
    }

}