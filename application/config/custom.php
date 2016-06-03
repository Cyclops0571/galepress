<?php

$serverUrl = 'http://www.galepress.com';
$mailEmail = 'info@galepress.com'; //sifre: detay2006
$paymentEnv = 'live';
$galepressHttpsUrl = 'https://www.galepress.com';
$iyzicoApiID = 'im015089500879819fdc991436189064';
$iyzicoSecret = 'im015536200eaf0002c8d01436189064';
$paymentAmount = 100;
$csrf = "|csrf";


if (\Laravel\Config::get('language') == 'usa') {
    $mailEmail = 'usa@galepress.com';
}

if (Laravel\Request::env() == ENV_TEST) {
    $iyzicoApiID = 'im095675100e6b443315841436188424';
    $iyzicoSecret = 'im09762570052d771a4b2d1436188424';
    $paymentEnv = 'test';
    $galepressHttpsUrl = 'https://www.galetest.com';
    $serverUrl = 'http://galetest.com';
    $paymentAmount = 1;
    $csrf = "";
} else if (Laravel\Request::env() == ENV_LOCAL) {
    $csrf = "";
    $iyzicoApiID = 'im095675100e6b443315841436188424';
    $iyzicoSecret = 'im09762570052d771a4b2d1436188424';
    $paymentEnv = 'test';
    $galepressHttpsUrl = 'http://localhost';
    $serverUrl = 'http://localhost';
    $paymentAmount = 1;
}


//
//$paymentEnv = 'live';
//$paymentUrl = 'https://www.galepress.com';
//$iyzicoApiID = 'im015089500879819fdc991436189064';
//$iyzicoSecret = 'im015536200eaf0002c8d01436189064';

return array(
    /*
      |--------------------------------------------------------------------------
      | Company Name
      |--------------------------------------------------------------------------
     */
    'csrf' => $csrf,
    'companyname' => 'GALE PRESS',
    'mail_displayname' => 'GALE PRESS',
    'mail_email' => $mailEmail,
    'url' => $serverUrl,
    'admin_email_set' => array('serdar.saygili@detaysoft.com'),
    'admin_email' => 'serdar.saygili@detaysoft.com',
    //'admin_email' => 'enes.taskiran@detaysoft.com',
    //'admin_email' => 'adem.karakollu@detaysoft.com',
    'pdflib_license' => 'L900202-010503-800050-T58UH2-3ASLA2',
    'api_key1' => 'AIzaSyA7xMDIVl2332zCKP70HceFTuq2gdwBwx0',
    'api_key2' => 'AIzaSyCFt9FNEys_tXed-VHu5CaI2_9bezEiaJY',
    'api_key3' => 'AIzaSyDUt1iTUfNJ0V9gQolAkkCwGqxNaijJgdw',
    'api_key4' => 'AIzaSyDPKOO2Z0S_iJLEPcJhRXAukmCoci4_cbc',
    'api_key5' => 'AIzaSyAHKuxx9RlYxbCRLxZwnF8DGISKCOQtW6g',
    'api_key6' => 'AIzaSyAmkOB9C8of9kYJZs9r7oN1mr0KrN1xB4g',
    'api_key7' => 'AIzaSyBdrHaCvdrxc43otOND3GgRk69cB_CvoaI',
    'api_key8' => 'AIzaSyCg98n77pfxmBzCzptyD4op5T7VxO84p5w',
    'api_key9' => 'AIzaSyCfeHTzoY_xhcCogtb1XYYUZ4_bzDlruvs',
    'payment_environment' => $paymentEnv,
    'iyzico_url' => 'https://iyziconnect.com/post/v1/',
    'galepress_https_url' => $galepressHttpsUrl,
    'iyzico_bin_check_url' => 'https://api.iyzico.com/bin-check',
    'iyzico_api_id' => $iyzicoApiID,
    'iyzico_secret' => $iyzicoSecret,
    'payment_delay_reminder_admin_mail_set' => array('serdar.saygili@detaysoft.com', 'enes.taskiran@detaysoft.com', 'ercan.solcun@detaysoft.com'),
    'payment_amount' => $paymentAmount,
    'payment_count' => 12,
    'rowcount' => 100,
    'passphrase' => '1234',
    'google_api_key' => 'AIzaSyCj2v2727lBWLeXbgM_Hw_VEQgzjDgb8KY',
    'testdeneme_task' => 1,
    'backupdatabase_task' => 2,
    'createinteractivepdf_task' => 3,
    'pushnotification_task' => 4,
    'pushwarningmail_task' => 5,
    'transferlogstodb_task' => 6,
    'updatelocation_task' => 7,
    'updatesize_task' => 8,
    'updatevirtualhost_task' => 9,
    'api_color_blue' => '#0082CA',
    'api_color_green' => '#009D4F',
    'api_color_yellow' => '#ECAA00',
    'api_color_red' => '#F63440',
    'api_color_orange' => '#FF6D37',
    'api_color_grey' => '#707271',
);
