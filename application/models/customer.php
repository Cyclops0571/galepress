<?php

class Customer extends Eloquent
{
	public static $timestamps = false;
	public static $table = 'Customer';
	public static $key = 'CustomerID';
	
	public function Applications($statusID)
	{
		return $this->has_many('Application', $this->key())->where('StatusID', '=', $statusID)->get();
	}
}