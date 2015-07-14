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
		echo "zzzzzzz";
		var_dump($_POST); exit;
	}
	
	public function get_index() {
		
		echo "get"; exit;
		$data = 'api_id=im015089500879819fdc991436189064'
				. '&secret=im015536200eaf0002c8d01436189064'
				. '&response_mode=ASYNC&mode=live&external_id=orderid10'
				. '&customer_first_name=test_firstname'
				. '&customer_last_name=test_lastname'
				. '&customer_contact_email=test%40test.com'
				. '&type=DB&amount=100'
				. '&installment_count='
				. '&currency=TRY'
				. '&descriptor=Test_description'
				. '&card_number=4624490000912262'
				. '&card_expiry_year=2017'
				. '&card_expiry_month=07&card_brand=VISA'
				. '&card_holder_name=John+Doe'
				. '&card_verification=093'
				. '&connector_type=Garanti';
		$url = "https://iyziconnect.com/post/v1/";   // sorgularda kullanacağımız endpoint
//		$data = 'api_id=im0322080005c70f195bca1434712720' . //size özel iyzico api
//				'&secret=im0339018007d7a8f10f1c1434712720' . // size özel iyzico secret
//				'&external_id=' . $user->CustomerID . //sipariş numarası olarka kullanabileceğimizalan
//				'&mode=' . Config::get("custom.payment_environment") . // live olmalı, gerçek ödeme alabilmek için
//				'&type=RG.DB' . // iyzico form yükleme tipi. Kart saklayan form yüklemesi.
//				'&return_url=' . Config::get("custom.payment_url") . '/payment-response' . //bu ödemenin sonucunu ben hangi sayfaya dönmeliyim. Sitenizde bu ödemeye ait sonuç nereye dönsün. Başarılımı başarısız mı orada anlayacağız.
//				'&amount=10000' . // 100 ile çarpılmış bağış bedeli. 10,99 TL bağış için 1099 olmalı.  100 lira bağış için 10000 olmalı
//				'&currency=TRY' . //  para birimi. Bu sabit olarak TRY olmalı
//				'&customer_contact_ip=' . Request::ip() . // ödemeyi yapan kişinin ip adresi
//				'&customer_language=tr' . // ödeme formunun dili
//				'&installment=false' . // taksit açık kapalı. .
//				'&customer_contact_mobile=' . $phone . // mobil telefon
//				'&customer_contact_email=' . $email . // email
//				'&customer_presentation_usage=GalepressAylikOdeme_' . date('YmdHisu') . // iyzico kontrol panelde ilk bakışta ödemenin ne ile ilgili yapıldığını görebilme. Sipariş numarası ile aynı olabilir.
//				'&descriptor= GalepressAylikOdeme_' . date('YmdHisu'); // iyzico kontrol panelde ilk bakışta ödemenin ne ile ilgili yapıldığını görebilme. Sipariş numarası ile aynı olabilir.

		$params = array('http' => array(
				'method' => 'POST',
				'content' => $data
		));
		$ctx = stream_context_create($params);
		$fp = @fopen($url, 'rb', false, $ctx);
		if (!$fp) {
			throw new Exception("Problem with $url, $php_errormsg");
		}
		$response = @stream_get_contents($fp);
		if ($response === false) {
			throw new Exception("Problem reading data from $url, $php_errormsg");
		}
		$resultJson = json_decode($response, true);
		print_r($resultJson);
		//echo "email: " . $email . "phone: " . $phone;
	}

	public function get_moveInteractivite() {

		/*		 * *** HEDEF CONTENTIN SAYFALARI OLUSUTURLMUS OLMALI YANI INTERAKTIF TASARLAYICISI ACILMIS OLMALI!!!**** */
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

}
