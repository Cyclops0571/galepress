<?php

/**
 * Class Component
 * @property int $ComponentID
 * @property int $DisplayOrder
 * @property string $Name
 * @property string $Description
 * @property string $Class
 * @property int $StatusID
 * @property int $CreatorUserID
 * @property string $DateCreated
 * @property int $ProcessUserID
 * @property string $ProcessDate
 * @property int $ProcessTypeID
 */
class Component extends Eloquent
{

    public static $timestamps = false;
    public static $table = 'Component';
    public static $key = 'ComponentID';
    const ComponentVideo = 1;
    const ComponentAudio = 2;
    const ComponentMap = 3;
    const ComponentLink = 4;
    const ComponentWeb = 5;
    const ComponentTooltip = 6;
    const ComponentScroller = 7;
    const ComponentSlideShow = 8;
    const Component360 = 9;
    const ComponentBookmark = 10;
    const ComponentAnimation = 11;

    public function getPath() {
        return path('public') . '/files/components/' . $this->Class;
    }

    public function getZipPath() {
        return $this->getPath() . '/files.zip';
    }

}