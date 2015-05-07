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
		var_dump(Auth::User());
		exit;
		echo Auth::User()->UserID;
		exit;
		$e = new Exception("asdfasdf");
		throw new Exception($e->getMessage());
//		$content = Content::find(1989);
//		$content instanceof Content;
//		echo $content->Version;
//		$content->Version++;
//		echo "-----" . $content->Version;
//		return;
//		Cookie::put(SHOW_IMAGE_CROP, SHOW_IMAGE_CROP);
//		echo Cookie::get(SHOW_IMAGE_CROP, 0);
//		return;
//		exit;
//		
//		$content = Content::find(1965);
//		$content instanceof Content;
//		var_dump($content->dirty());
//		$content->Name = "zzzzzzz";
//		var_dump($content->dirty());
//		exit;
//		$currentCategories = array();
//		var_dump($currentCategories);
//		$currentCategories = array_merge($currentCategories, array(""));
//		echo "---------------------";
//		var_dump($currentCategories);
//		exit;
//		
//		$path = "/home/admin/public_html/public/files/customer_178/application_187/content_1912/cropped_image";
//		$matches = glob($path . "*");
//		$dir = "/home/admin/public_html/public/files/customer_178/application_187/content_1912/";
//		$fileSet = scandir($dir);
//		$length = strlen(IMAGE_CROPPED_NAME);
//		foreach($fileSet as $fileName) {
//			if(substr($fileName, 0, $length) === IMAGE_CROPPED_NAME){
//				unlink($dir . $fileName);
//			}
//		}
//		exit;
		
		
//		return View::make('test.googlemaps');
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
