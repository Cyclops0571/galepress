<?php

class Crop_Controller extends Base_Controller {

	public $restful = true;
	private $errorPage = '';

	public function __construct() {
		parent::__construct();
	}

	public function get_image() {
		$cropSet = Crop::get();
		$cropSet instanceof Crop;
		$contentID = (int) Input::get("contentID", 0);

		$contentFile = DB::table('ContentFile')
						->where('ContentID', '=', $contentID)
						->where('StatusID', '=', eStatus::Active)
						->order_by('ContentFileID', 'DESC')->first();

		if (!$contentFile) {
			return Redirect::to($this->errorPage);
		}

		$contentFile instanceof ContentFile;
		$ccif = DB::table('ContentCoverImageFile')
						->where('ContentFileID', '=', $contentFile->ContentFileID)
						->where('StatusID', '=', eStatus::Active)
						->order_by('ContentCoverImageFileID', 'DESC')->first();
		if (!$ccif) {
			return Redirect::to($this->errorPage);
		}
		$ccif instanceof ContentCoverImageFile;
		//bu contentin imageini bulalim....
		//calculate the absolute path of the source image
		$imagePath = $contentFile->FilePath . "/" . IMAGE_ORIGINAL . IMAGE_EXTENSION;
		$imageInfo = new imageInfoEx($imagePath);
		if (!$imageInfo->isValid()) {
			$imagePath = $contentFile->FilePath . "/" . $ccif->SourceFileName;
			$imageInfo = new imageInfoEx($imagePath);
		}
		$data = array();
		$data['cropSet'] = $cropSet;
		$data['imageInfo'] = $imageInfo;
		return View::make('pages.cropview', $data);
	}

	public function post_image() {

		$xCoordinateSet = Input::get("xCoordinateSet");
		$yCoordinateSet = Input::get("yCoordinateSet");
		$heightSet = Input::get("heightSet");
		$widthSet = Input::get("widthSet");
		$cropIDSet = Input::get("cropIDSet");
		$contentID = (int) Input::get("contentID", 0);
		$contentFile = DB::table('ContentFile')
						->where('ContentID', '=', $contentID)
						->where('StatusID', '=', eStatus::Active)
						->order_by('ContentFileID', 'DESC')->first();
		if (!$contentFile) {
			return Redirect::to($this->errorPage);
		}
		$contentFile instanceof ContentFile;
		$ccif = ContentCoverImageFile::where('ContentFileID', '=', $contentFile->ContentFileID)
				->where('StatusID', '=', eStatus::Active)
				->order_by('ContentCoverImageFileID', 'DESC')
				->first();
		
		if (!$ccif) {
			return Redirect::to($this->errorPage);
		}
		
		$ccif instanceof ContentCoverImageFile;
		//bu contentin imageini bulalim....
		//calculate the absolute path of the source image
		$sourceImagePath = $contentFile->FilePath . "/" . IMAGE_ORIGINAL . IMAGE_EXTENSION;
		if (!File::exists(path("public") . $sourceImagePath)) {
			//old pdf files dont have an original.jpg
			$sourceImagePath = $contentFile->FilePath . "/" . $ccif->SourceFileName;
		}
		$imageInfo = new imageInfoEx($sourceImagePath);
		$fileSet = scandir(path("public") . $contentFile->FilePath . "/");
		$length = strlen(IMAGE_CROPPED_NAME);
		foreach ($fileSet as $fileName) {
			if (substr($fileName, 0, $length) === IMAGE_CROPPED_NAME) {
				unlink(path("public") . $contentFile->FilePath . "/" . $fileName);
			}
		}

		for ($i = 0; $i < count($xCoordinateSet); $i++) {
			$crop = Crop::find($cropIDSet[$i]);
			if (!$crop) {
				continue;
			}
			$crop instanceof Crop;

			$im = new Imagick($imageInfo->absolutePath);
			$im->cropimage($widthSet[$i], $heightSet[$i], $xCoordinateSet[$i], $yCoordinateSet[$i]);
			$im->resizeImage($crop->Width, $crop->Height, Imagick::FILTER_LANCZOS, 1, TRUE);
			$im->writeImage(path('public') . $contentFile->FilePath . "/" . IMAGE_CROPPED_NAME . "_" . $crop->Width . "x" . $crop->Height . ".jpg");
			$im->destroy();
		}
		
		$content = Content::find($contentID);
		$application = Application::find($content->ApplicationID);
		$content->CoverImageVersion++;
		$content->save();
		$application->incrementAppVersion();
		return Redirect::to($this->route . '#saved');
	}

}
