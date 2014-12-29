<?php

class ContentFilePage extends Eloquent
{
	public static $timestamps = false;
	public static $table = 'ContentFilePage';
	public static $key = 'ContentFilePageID';
	/*
	public function Content()
	{
		return $this->belongs_to('Content', 'ContentID');
	}
	*/
}