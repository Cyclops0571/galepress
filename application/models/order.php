<?php

class Order extends Eloquent
{
	public static $timestamps = false;
	public static $table = 'Order';
	public static $key = 'OrderID';
}