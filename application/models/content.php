<?php
/**
 * @property int $ContentID Description
 * @property int $ApplicationID Description
 * @property int $OrderNo Description
 * @property int $Name Description
 * @property int $Detail Description
 * @property int $MonthlyName Description
 * @property int $PublishDate Description
 * @property int $UnpublishDate Description
 * @property int $IsUnpublishActive Description
 * @property int $CategoryID Description
 * @property int $IsProtected Description
 * @property int $Password Description
 * @property int $IsBuyable Description
 * @property int $Price Description
 * @property int $CurrencyID Description
 * @property int $IsMaster Description
 * @property int $Orientation Description
 * @property int $Identifier Description
 * @property int $AutoDownload Description
 * @property int $Approval Description
 * @property int $Blocked Description
 * @property int $Status Description
 * @property int $Version Description
 * @property int $PdfVersion Description
 * @property int $CoverImageVersion Description
 * @property int $TotalFileSize Description
 * @property int $StatusID Description
 * @property int $CreatorUserID Description
 * @property int $DateCreated Description
 * @property int $ProcessUserID Description
 * @property int $ProcessDate Description
 * @property int $ProcessTypeID Description
 */
class Content extends Eloquent
{
	public static $timestamps = false;
	public static $table = 'Content';
	public static $key = 'ContentID';
	/*
	public function Application()
	{
		return $this->belongs_to('Application', 'ApplicationID');
	}
	
	public function Category()
	{
		return $this->belongs_to('Category', 'CategoryID');
	}
	*/
	public function Application()
	{
		return $this->belongs_to('Application', 'ApplicationID')->first();
	}

	public function Currency($languageID)
	{
		//return $this->belongs_to('GroupCode', 'GroupCodeID')->first();
		$gc = GroupCode::where('GroupCodeID', '=', $this->CurrencyID)->first();
		if($gc) {
			return $gc->DisplayName($languageID);
		}
		return '';
	}
	
	public function Files($statusID)
	{
		return $this->has_many('ContentFile', $this->key())->where('StatusID', '=', $statusID)->get();
	}

	public function ActiveFile()
	{
		return $this->has_many('ContentFile', $this->key())->where('StatusID', '=', eStatus::Active)->first();
	}
	
	public function CoverImageFiles($statusID)
	{
		return $this->has_many('ContentCoverImageFile', $this->key())->where('StatusID', '=', $statusID)->get();
	}
	
	public function Tags()
	{
		return $this->has_many('ContentTag', $this->key());
	}
}