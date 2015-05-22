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

		$subject = __('common.confirm_email_title');
		$firstname = "hakan";
		$surname = "sarier";
		$url = "asasdasdasd";
		// $msg = __('common.confirm_email_message', array(
		//   'firstname' => $firstname,
		//   'lastname' => $surname,
		//   'url' => Config::get("custom.url") . '/'.Config::get('application.language').'/'.__('route.confirmemail').'?email='.$s->Email.'&code='.$confirmCode
		//   )
		// );
		$mailData = array(
			'name'	=> $firstname,
			'surname'	=> $surname,
			'url' => $url,
		);
		$msg = View::make('mail-templates.aktivasyon.index')->with($mailData)->render();
		// Common::sendHtmlEmail("hakan.sarier@detaysoft.com", $firstname.' '.$surname, $subject, $msg);
		$mailStatus = Common::sendHtmlEmail("hakan.sarier@detaysoft.com", $firstname.' '.$surname, $subject, $msg);

		// $m = new MailLog();
		// $m->MailID = 1;
		// $m->UserID = 58;
		// if(!$mailStatus){
		// 	$m->Arrived = 0;
		// }
		// else {
		// 	$m->Arrived = 1;
		// }
		// $m->StatusID = 1;
		// $m->save();
		
		return View::make('mail-templates.aktivasyon.index')->with($mailData);
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
