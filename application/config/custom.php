<?php
$serverUrl = 'http://www.galepress.com';
$mailEmail = 'info@galepress.com';
if(Laravel\Request::env() == ENV_TEST) {
	$serverUrl = 'http://galetest.com';
	$mailEmail = 'info@galetest.com';
} else if(Laravel\Request::env() == ENV_LOCAL){
	$serverUrl = 'http://localhost';
	$mailEmail = 'info@galetest.com';
}

return array(
	
	/*
	|--------------------------------------------------------------------------
	| Company Name
	|--------------------------------------------------------------------------
	*/
	'companyname' => 'GALEPRESS',
	
	'mail_displayname' => 'GALEPRESS',
	'mail_email' => $mailEmail,
	
	'url' => $serverUrl,
	
	'admin_email_set' => array('hakan.sarier@detaysoft.com', 'serdar.saygili@detaysoft.com' ),
	'admin_email' => 'hakan.sarier@detaysoft.com',
	//'admin_email' => 'enes.taskiran@detaysoft.com',
	//'admin_email' => 'adem.karakollu@detaysoft.com',
	
	'pdflib_license' => 'L900202-010503-800050-T58UH2-3ASLA2',

	//'api_key' => 'AIzaSyBGyONehKJ2jCRF9YekkvWDXOI_UVxeVE4',
	'api_key1' => 'AIzaSyA7xMDIVl2332zCKP70HceFTuq2gdwBwx0',
	'api_key2' => 'AIzaSyCFt9FNEys_tXed-VHu5CaI2_9bezEiaJY',
	'api_key3' => 'AIzaSyDUt1iTUfNJ0V9gQolAkkCwGqxNaijJgdw',
	'api_key4' => 'AIzaSyDPKOO2Z0S_iJLEPcJhRXAukmCoci4_cbc',
	'api_key5' => 'AIzaSyAHKuxx9RlYxbCRLxZwnF8DGISKCOQtW6g',
	'api_key6' => 'AIzaSyAmkOB9C8of9kYJZs9r7oN1mr0KrN1xB4g',
	'api_key7' => 'AIzaSyBdrHaCvdrxc43otOND3GgRk69cB_CvoaI',
	'api_key8' => 'AIzaSyCg98n77pfxmBzCzptyD4op5T7VxO84p5w',
	'api_key9' => 'AIzaSyCfeHTzoY_xhcCogtb1XYYUZ4_bzDlruvs',
	
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
);