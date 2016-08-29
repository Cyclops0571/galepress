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
 * @property string StackTrace
 */
class ServerErrorLog extends Eloquent
{
    public static $table = 'ServerErrorLog';
    public static $key = 'ServerErrorLogID';

    public function save()
    {
        $this->Parameters = json_encode($this->Parameters);
        return parent::save();
    }
}