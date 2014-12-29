<?php

class PageComponent extends Eloquent
{
	public static $timestamps = false;
	public static $table = 'PageComponent';
	public static $key = 'PageComponentID';
	
	public function Component()
	{
		return $this->belongs_to('Component', 'ComponentID')->first();
	}
	
}