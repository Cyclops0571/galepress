<?php

class Tab extends Eloquent{
	public static $table = 'Tabs';
	public static $key = 'TabID';
	
	/**
	 * 
	 * @param type $tabID
	 * @return Tab
	 */
	public static function find($tabID) {
		return Banner::where(self::$key, '=', $tabID)->first();
	}
}
