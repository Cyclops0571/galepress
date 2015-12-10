<?php

/**
 * @property int ContentID
 * @property mixed Name
 * @property string Password
 * @property int Qty
 * @property int StatusID
 * @property int CreatorUserID
 * @property DateTime DateCreated
 * @property int ProcessUserID
 * @property DateTime ProcessDate
 * @property int ProcessTypeID
 */
class ContentPassword extends Eloquent
{
	public static $timestamps = false;
	public static $table = 'ContentPassword';
	public static $key = 'ContentPasswordID';
}