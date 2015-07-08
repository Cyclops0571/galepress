<?php

/**
 * @property int $CityID Description
 * @property int $CityName Description
 * @property int $StatusID Description
 */
class City extends Eloquent {

	public static $timestamps = false;
	public static $table = 'Cities';
	public static $key = 'CityID';

	//put your code here

	public static function all($orderyBy = "CityName", $sort = "ASC") {
		return City::order_by($orderyBy, $sort)->get();
	}

}
