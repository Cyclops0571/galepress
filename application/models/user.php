<?php

class User extends Eloquent
{
	public static $timestamps = false;
	public static $table = 'User';
	public static $key = 'UserID';
	
	/*
	public function UserType()
	{
		return $this->has_one('GroupCode');
	}
	*/
	
	public function Customer()
	{
		return $this->belongs_to('Customer', 'CustomerID')->first();
	}
	/*
	public function Customers()
	{
		//return $this->has_one('Customer', 'CustomerID');
		return $this->has_many('Customer', 'CustomerID');
	}
	*/
}