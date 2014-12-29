<?php

class ContentCoverImageFile extends Eloquent
{
	public static $timestamps = false;
	public static $table = 'ContentCoverImageFile';
	public static $key = 'ContentCoverImageFileID';
	/*
	public function Content()
	{
		return $this->belongs_to('Content', 'ContentID');
	}
	*/
}