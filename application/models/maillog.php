<?php

/**
 * @property int MailID
 * @property int UserID
 * @property int Arrived
 * @property int StatusID
 */
class MailLog extends Eloquent
{
	public static $timestamps = true;
	public static $table = 'MailLog';
	public static $key = 'MailLogID';
}