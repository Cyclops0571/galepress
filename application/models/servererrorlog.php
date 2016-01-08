<?php

/**
 * Created by PhpStorm.
 * User: Serdar Saygili
 * Date: 07.01.2016
 * Time: 12:33
 * @property int ServerErrorLogID
 * @property string Header
 * @property string Url
 * @property string Parameters
 * @property string ErrorMessage
 */
class ServerErrorLog extends Eloquent
{
    public static $table = 'ServerErrorLog';
    public static $key = 'ServerErrorLogID';
}