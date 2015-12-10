<?php

/**
 * @property int ContentID
 * @property int CategoryID
 */
class ContentCategory extends Eloquent
{
	public static $timestamps = false;
	public static $table = 'ContentCategory';
	public static $key = 'ContentID';
}