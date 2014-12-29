<?php

class ContentFile extends Eloquent
{
	public static $timestamps = false;
	public static $table = 'ContentFile';
	public static $key = 'ContentFileID';
	/*
	public function Content()
	{
		return $this->belongs_to('Content', 'ContentID');
	}
	*/
	public function Pages($statusID)
	{
		return $this->has_many('ContentFilePage', $this->key())->where('StatusID', '=', $statusID)->get();
	}

	public function ActivePages()
	{
		return $this->has_many('ContentFilePage', $this->key())->where('StatusID', '=', eStatus::Active)->get();
	}

	public function ActiveCoverImageFile()
	{
		return $this->has_many('ContentCoverImageFile', $this->key())->where('StatusID', '=', eStatus::Active)->first();
	}
}