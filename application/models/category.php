<?php

class Category extends Eloquent
{
	public static $timestamps = false;
	public static $table = 'Category';
	public static $key = 'CategoryID';
	/*
	public function Application()
	{
		return $this->belongs_to('Application', 'ApplicationID');
	}
	*/
}