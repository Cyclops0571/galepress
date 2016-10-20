<?php

/**
 * Created by PhpStorm.
 * User: p1027
 * Date: 13.10.2016
 * Time: 17:42
 * @property int TopicID
 * @property int Name
 * @property int Order
 * @property int StatusID
 */
class Topic extends Eloquent
{
    public static $timestamps = false;
    public static $table = 'Topic';
    public static $key = 'TopicID';
}