<?php

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