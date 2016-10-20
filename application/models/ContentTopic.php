<?php

/**
 * Created by PhpStorm.
 * User: p1027
 * Date: 18.10.2016
 * Time: 12:44
 * @property int ContentID
 * @property int TopicID
 * @property Content Content
 * @property Topic Topic
 */
class ContentTopic extends \Laravel\Database\Eloquent\Model
{
    public static $timestamps = false;
    public static $table = 'ContentTopic';
    public static $key = 'ContentTopicID';

    public function Content() {
        return $this->has_one('Content', 'ContentID');
    }

    public function Topic() {
        return $this->has_one('Topic', 'TopicID');
    }

}