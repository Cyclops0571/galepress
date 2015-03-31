<?php
/**
 * @property int $RequestTypeID Description
 * @property int $CustomerID Description
 * @property int $ApplicationID Description
 * @property int $ContentID Description
 * @property int $ContentFileID Description
 * @property int $ContentCoverImageFileID Description
 * @property int $RequestDate Description
 * @property int $IP Description
 * @property int $DeviceType Description
 * @property int $FileSize Description
 * @property int $DataTransferred Description
 * @property int $Percentage Description
 * @property int $StatusID Description
 * @property int $CreatorUserID Description
 * @property int $DateCreated Description
 * @property int $ProcessUserID Description
 * @property int $ProcessDate Description
 * @property int $ProcessTypeID Description
 */
class Requestt extends Eloquent
{
	public static $timestamps = false;
	public static $table = 'Request';
	public static $key = 'RequestID';
	
}