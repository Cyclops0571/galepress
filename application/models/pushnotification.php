<?php

/**
 * Class PushNotification
 * @property int $PushNotificationID
 * @property int $CustomerID
 * @property int $ApplicationID
 * @property string $NotificationText
 * @property int $StatusID
 * @property int $CreatorUserID
 * @property int $DateCreated
 * @property int $ProcessUserID
 * @property int $ProcessDate
 * @property int $ProcessTypeID
 */
class PushNotification extends Eloquent
{
	public static $timestamps = false;
	public static $table = 'PushNotification';
	public static $key = 'PushNotificationID';

}