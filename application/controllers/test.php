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
class Test_Controller extends Base_Controller{
	public $restful = true;
	
	public function __construct() {
		parent::__construct();
	}

	public function get_index() {
		echo date("Y-m-d", strtotime("-1 day"));
		exit;
		var_dump($GLOBALS['laravel_paths']);
		$list = array (
			array('aaa', 'bbb', 'ccc', 'dddd'),
			array('123', '456', '789'),
			array('"aaa"', '"bbb"')
		);

//		$fp = fopen('file.xls', 'w');
//
//		foreach ($list as $fields) {
//			fputcsv($fp, $fields);
//		}
		
		
		
		
		
	}

	public function get_moveInteractivite() {

		/***** HEDEF CONTENTIN SAYFALARI OLUSUTURLMUS OLMALI YANI INTERAKTIF TASARLAYICISI ACILMIS OLMALI!!!*****/
		// TAŞINACAK CONTENT'IN FILE ID'SINI GIRIN
		$contentFilePage = DB::table('ContentFilePage')
							->where('ContentFileID', '=', "15")//*************
							->get();

		foreach ($contentFilePage as $cfp) {

			$filePageComponent = DB::table('PageComponent')
							->where('ContentFilePageID', '=', $cfp->ContentFilePageID)
							->get();

			if(sizeof($filePageComponent)==0){
				continue;
			}

			//HANGI CONTENT'E TASINACAK
			$contentFilePageNew = DB::table('ContentFilePage')
						->where('ContentFileID', '=', "15")//****************
						->where('No', '=', $cfp->No)
						->first();
			if(isset($contentFilePageNew)){

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
		foreach($cropSet as $crop) {
            /** @var Crop $crop */
			echo $crop->CropID;

		}
//		$applicationID = (int) Input::get('applicationID', 20);
//		$app = Application::find($applicationID);
		$contentID = (int)Input::get("contentID" , 0);
		$contentID = 1893;
        /** @var ContentFile $contentFile */
		$contentFile = DB::table('ContentFile')
					->where('ContentID', '=', $contentID)
					->where('StatusID', '=', eStatus::Active)
					->order_by('ContentFileID', 'DESC')->first();
		/** @var ContentCoverImageFile $ccif */
		/** @var ContentCoverImageFile Description **/
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
		$contentID = (int)Input::get("contentID", 0);
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
		
		
		for($i = 0; $i < count($xCoordinateSet); $i++) {
            /** @var Crop $crop */
			$crop = Crop::find($cropIDSet[$i]);
			if(!$crop) {
				continue;
			}
			$im = new Imagick($imageInfo->absolutePath);
			$im->cropimage($widthSet[$i], $heightSet[$i], $xCoordinateSet[$i], $yCoordinateSet[$i]);
			$im->resizeImage($crop->Width,$crop->Height,Imagick::FILTER_LANCZOS,1, TRUE);
			$im->writeImage(path('public') .  $contentFile->FilePath . "/" . IMAGE_CROPPED_NAME . "_" . $crop->Width . "x" . $crop->Height . ".jpg" );
			$im->destroy();
		}
	}
}
