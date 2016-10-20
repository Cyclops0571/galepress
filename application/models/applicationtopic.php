<?php

/**
 * Created by PhpStorm.
 * User: p1027
 * Date: 13.10.2016
 * Time: 17:42
 * @property int ApplicationID
 * @property int TopicID
 * @property Topic Topic
 */
class ApplicationTopic extends Eloquent
{
    public static $timestamps = false;
    public static $table = 'ApplicationTopic';
    public static $key = 'ApplicationTopicID';

    public function Topic() {
        return $this->has_one('Topic', 'TopicID');
    }
}