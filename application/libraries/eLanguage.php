<?php

/**
 * Created by PhpStorm.
 * User: p1027
 * Date: 27.07.2016
 * Time: 12:14
 */
class eLanguage
{
    const tr = 'tr';
    const en = 'en';
    const de = 'de';
    const usa = 'usa';

    public static function isTr()
    {
        return Config::get('application.language') == self::tr;
    }
}