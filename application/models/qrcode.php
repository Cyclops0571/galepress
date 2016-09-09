<?php

/**
 * Created by PhpStorm.
 * User: Serdar Saygili
 * Date: 07.01.2016
 * Time: 12:33
 * @property int QrcodeID
 * @property string QrSiteClientID
 * @property string Name
 * @property string Email
 * @property string Address
 * @property string City
 * @property string Phone
 * @property string TcNo
 * @property string Price
 * @property string Parameter
 * @property string CallbackUrl
 */
class Qrcode extends Eloquent
{
    public static $table = 'Qrcode';
    public static $key = 'QrcodeID';
}