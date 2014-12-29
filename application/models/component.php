<?php

class Component extends Eloquent
{
	public static $timestamps = false;
	public static $table = 'Component';
	public static $key = 'ComponentID';
	/*
	public function Application()
	{
		return $this->belongs_to('Application', 'ApplicationID');
	}
	*/
}