<?php

/**
 * @property int $TokenID Description
 * @property int $CustomerID Description
 * @property int $ApplicationID Description
 * @property int $UDID Description
 * @property int $ApplicationToken Description
 * @property int $DeviceToken Description
 * @property int $DeviceType Description
 * @property int $StatusID Description
 */
class Token extends Eloquent
{
	public static $timestamps = false;
	public static $table = 'Token';
	public static $key = 'TokenID';

}