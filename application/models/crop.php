<?php

/**
 * @property int $CropID Description
 * @property int $ObjectType Description
 * @property int $ParentID Description
 * @property int $Width Description
 * @property int $Height Description
 * @property int $Type Description
 * @property int $Radius Description
 * @property int $Description Description
 * @property int $Watermark Description
 */
class Crop extends Eloquent
{
	public static $timestamps = false;
	public static $table = 'Crop';
	public static $key = 'CropID';

}
