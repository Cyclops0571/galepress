<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of test
 *
 * @author Detay
 */
class Test_Controller extends Base_Controller {

    public $restful = true;

    public function __construct() {
	parent::__construct();
    }

    public function post_index() {
	
	echo "aaa";
	var_dump($_POST);
	dd($_FILES);
    }

    public function get_download() {
	return Laravel\View::make('test.download');
    }

    public function post_download() {
	ob_start();
	$element = Input::get('element');
	$options = array(
	    'upload_dir' => path('public') . 'files/temp/',
	    'upload_url' => URL::base() . '/files/temp/',
	    'param_name' => $element,
	    'accept_file_types' => '/\.(xls)$/i'
	);
	$upload_handler = new UploadHandler($options);

	if (!Request::ajax()) {
	    return;
	}

	$upload_handler->post(false);

	$ob = ob_get_contents();
	ob_end_clean();

	$json = get_object_vars(json_decode($ob));
	$arr = $json[$element];
	$obj = $arr[0];
	return Response::json($obj);
    }

    public function get_index() {
	Laravel\Config::set("application.language", "tr");
	Laravel\Session::put("language", "tr");
	echo Laravel\Session::get("language");
	echo __('common.support');
	return;
	
	dd(Laravel\URL::to_route("clientsregistered"));
	echo strtotime("2015-09-07 17:15:00") . "   ----------------   ";
	echo time(); exit;
	$res = openssl_pkey_new();
	openssl_pkey_export($res, $privateKey);
	$pubkey=openssl_pkey_get_details($res);
	
	var_dump($privateKey);
	echo PHP_EOL . "---------------------------------" . PHP_EOL;
	var_dump($pubkey);
	
	
//	echo date(strtotime('2015-01-01')) . " ---- " . strtotime('2015-01-01');
	echo date("Y-m-d", strtotime("2015-08-26" . " +1 month"));
	exit;
	$pa = PaymentAccount::find(1);
	var_dump($pa);
	var_dump($pa->Application());
	exit;
	$a1 = array(1, 2, 3, 4, 5);
	$a2 = array(6, 7, 8);
	$a1[] = $a2;

	echo date("Y-m-d", strtotime("+1 month", date(strtotime("2015-04-01"))));
	exit;
//	$binarydata = pack("nvc*", 0x1234, 0x5678, 65, 66);
//	dd($binarydata);
//	var_dump(chr(0));
//	dd(pack('H*', 'aaaaaaaaa'));
	$token = 'APA91bEmfN-i8YRaILLgUJvneezm1GQti9eDmRtyqUSZCxqpbqXf-3anKW6tviVFt2stgQfD3LoIxgG8PRbZsfSJUDBCf4-DFh8Ct_TlcT0pdEKZd9KK_UrmudKCmGBGos-GetP84KDAvzyEJwMqGUYjcCFj5900QA';
	$token = 'APA91bEmfN-i8YRaILLgUJvneezm1GQti9eDmRtyqUSZCxqpbqXf-3anKW6tviVFt2stgQfD3LoIxgG8PRbZsfSJUDBCf4-DFh8Ct_TlcT0pdEKZd9KK_UrmudKCmGBGos-GetP84KDAvzyEJwMqGUYjcCFj5900QA';
	echo pack('H*', str_replace(' ', '', sprintf('%u', CRC32($token))));
//	echo pack('H*', $token);
	exit;

	include(path('public') . "ticket/bootstrap.php");
	$data = array(
	    'api_version' => '1',
	    'api_action' => 'authenticate',
	    'api_key' => '19664485-923e-46eb-8220-338300870052',
	    'username' => 'admin',
	    'password' => 'detay2006'
	);
	$result = $api->receive(array("data" => json_encode($data)));
	return \Laravel\Redirect::to(Laravel\Config::get('custom.url') . '/ticket');

	echo $result;
	exit;


	$add_array = array(
	    'name' => 'Test User',
	    'email' => 'user@example.com',
	    'authentication_id' => 1,
	    'allow_login' => 1,
	    'username' => 'test',
	    'password' => '1234',
	    'user_level' => 1,
	);
	$id = $users->add($add_array);
	var_dump($session);

	if ($user['password'] === $this->hash_password($password, $user['salt'])) {

	    $user['regenerate_id'] = true;
	    $this->login_session($user);

	    $log_array['event_severity'] = 'notice';
	    $log_array['event_number'] = E_USER_NOTICE;
	    $log_array['event_description'] = 'Local Login Successful "<a href="' . $config->get('address') . '/users/view/' . (int) $user['id'] . '/">' . safe_output($user['name']) . '</a>"';
	    $log_array['event_file'] = __FILE__;
	    $log_array['event_file_line'] = __LINE__;
	    $log_array['event_type'] = 'local_login_successful';
	    $log_array['event_source'] = 'auth';
	    $log_array['event_version'] = '1';
	    $log_array['log_backtrace'] = false;

	    $log->add($log_array);

	    $this->clear_failed_login($user);

	    return true;
	}




	exit;
	//
	echo 'New user added. ID: ' . (int) $id;
	exit;


	$ticketApi = new sts\api();
	$ticketApi->receive("test");
	var_dump($ticketApi);
	exit;
	var_dump(Auth::User());



//            return phpinfo();

	return View::make('test.javascripttest', array());
    }

    public function get_moveInteractivite() {

	/*	 * *** HEDEF CONTENTIN SAYFALARI OLUSUTURLMUS OLMALI YANI INTERAKTIF TASARLAYICISI ACILMIS OLMALI!!!**** */
	// TAŞINACAK CONTENT'IN FILE ID'SINI GIRIN
	$contentFilePage = DB::table('ContentFilePage')
		->where('ContentFileID', '=', "15")//*************
		->get();

	foreach ($contentFilePage as $cfp) {

	    $filePageComponent = DB::table('PageComponent')
		    ->where('ContentFilePageID', '=', $cfp->ContentFilePageID)
		    ->get();

	    if (sizeof($filePageComponent) == 0) {
		continue;
	    }

	    //HANGI CONTENT'E TASINACAK
	    $contentFilePageNew = DB::table('ContentFilePage')
		    ->where('ContentFileID', '=', "15")//****************
		    ->where('No', '=', $cfp->No)
		    ->first();
	    if (isset($contentFilePageNew)) {

		foreach ($filePageComponent as $fpc) {
		    $s = new PageComponent();
		    $s->ContentFilePageID = $contentFilePageNew->ContentFilePageID;
		    $s->ComponentID = $fpc->ComponentID;
		    $s->No = $fpc->No;
		    $s->StatusID = eStatus::Active;
		    $s->DateCreated = new DateTime();
		    $s->ProcessDate = new DateTime();
		    $s->ProcessTypeID = eProcessTypes::Insert;
		    $s->save();

		    $filePageComponentProperty = DB::table('PageComponentProperty')
			    ->where('PageComponentID', '=', $fpc->PageComponentID)
			    ->where('StatusID', '=', eStatus::Active)
			    ->get();

		    foreach ($filePageComponentProperty as $fpcp) {
			$p = new PageComponentProperty();
			$p->PageComponentID = $s->PageComponentID;
			$p->Name = $fpcp->Name;
			$p->Value = $fpcp->Value;
			$p->StatusID = eStatus::Active;
			$p->DateCreated = new DateTime();
			$p->ProcessDate = new DateTime();
			$p->ProcessTypeID = eProcessTypes::Insert;
			$p->save();
		    }
		}
	    }
	}

	// İŞİN BİTİNCE PASİFLESTİRMEYİ UNUTMA YOKSA USTUNE YAZAR
    }

    public function get_image() {
	$cropSet = Crop::get();
	foreach ($cropSet as $crop) {
	    /** @var Crop $crop */
	    echo $crop->CropID;
	}
//		$applicationID = (int) Input::get('applicationID', 20);
//		$app = Application::find($applicationID);
	$contentID = (int) Input::get("contentID", 0);
	$contentID = 1893;
	/** @var ContentFile $contentFile */
	$contentFile = DB::table('ContentFile')
			->where('ContentID', '=', $contentID)
			->where('StatusID', '=', eStatus::Active)
			->order_by('ContentFileID', 'DESC')->first();
	/** @var ContentCoverImageFile $ccif */
	/** @var ContentCoverImageFile Description * */
	$ccif = DB::table('ContentCoverImageFile')
			->where('ContentFileID', '=', $contentFile->ContentFileID)
			->where('StatusID', '=', eStatus::Active)
			->order_by('ContentCoverImageFileID', 'DESC')->first();
	//bu contentin imageini bulalim....
	//calculate the absolute path of the source image
	$imagePath = $contentFile->FilePath . "/" . $ccif->SourceFileName;
	$imageInfo = new imageInfoEx($imagePath);
	$data = array();
	$data['cropSet'] = $cropSet;
	$data['imageInfo'] = $imageInfo;
	return View::make('test.image', $data);
    }

    public function post_image() {

	$xCoordinateSet = Input::get("xCoordinateSet");
	$yCoordinateSet = Input::get("yCoordinateSet");
	$heightSet = Input::get("heightSet");
	$widthSet = Input::get("widthSet");
	$cropIDSet = Input::get("cropIDSet");
	$contentID = (int) Input::get("contentID", 0);
	$contentID = 1893;
	/** @var ContentFile $contentFile */
	$contentFile = DB::table('ContentFile')
			->where('ContentID', '=', $contentID)
			->where('StatusID', '=', eStatus::Active)
			->order_by('ContentFileID', 'DESC')->first();
	/** @var ContentCoverImageFile $ccif */
	$ccif = DB::table('ContentCoverImageFile')
			->where('ContentFileID', '=', $contentFile->ContentFileID)
			->where('StatusID', '=', eStatus::Active)
			->order_by('ContentCoverImageFileID', 'DESC')->first();
	//bu contentin imageini bulalim....
	//calculate the absolute path of the source image
	$sourceImagePath = $contentFile->FilePath . "/" . $ccif->SourceFileName;
	$imageInfo = new imageInfoEx($sourceImagePath);


	for ($i = 0; $i < count($xCoordinateSet); $i++) {
	    /** @var Crop $crop */
	    $crop = Crop::find($cropIDSet[$i]);
	    if (!$crop) {
		continue;
	    }
	    $im = new Imagick($imageInfo->absolutePath);
	    $im->cropimage($widthSet[$i], $heightSet[$i], $xCoordinateSet[$i], $yCoordinateSet[$i]);
	    $im->resizeImage($crop->Width, $crop->Height, Imagick::FILTER_LANCZOS, 1, TRUE);
	    $im->writeImage(path('public') . $contentFile->FilePath . "/" . IMAGE_CROPPED_NAME . "_" . $crop->Width . "x" . $crop->Height . ".jpg");
	    $im->destroy();
	}
    }

    public function get_myhome() {
	return View::make('website.pages.home');
    }
    
    public function get_routetest($x) {
	echo  $x . "aaaaaaaaaaaaaa";
    }

}
