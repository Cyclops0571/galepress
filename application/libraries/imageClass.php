<?php

class imageClass {

// <editor-fold defaultstate="collapsed" desc="private properties">
	private $img_id;
	private $img_element_id;
	private $img_type_id;
	private $img_source;
	private $ownerName;
// </editor-fold>
	public $isValid = false;

	public function __construct() {
		;
	}

// <editor-fold defaultstate="collapsed" desc="getter-setter">
	public function imgID($imgID = null) {
		if ($imgID != null && (int) $imgID > 0) {
			$this->img_id = (int) $imgID;
		}
		return $this->img_id;
	}
	
	/**
	 *
	 * @param type $objectID
	 * @return int ownerObjectID
	 */
	public function imgObjectID($objectID = null) {
		if ($objectID != null && (int) $objectID > 0) {
			$this->img_element_id = (int) $objectID;
		}
		return $this->img_element_id;
	}

	/**
	 *
	 * @param int $typeID owner object type
	 * @return int owner object type
	 */
	public function imgType($typeID = null) {
		get_class();
		if ($typeID != null && (int) $typeID > 0) {
			$this->img_type_id = (int) $typeID;
		}
		return $this->img_type_id;
	}

	public function imgSource($source = null) {
		if (!empty($source)) {
			$this->img_source = (int) $source;
		}
		return $this->img_source;
	}

// </editor-fold>
// <editor-fold defaultstate="collapsed" desc="database functions">
	public static function getObjectSet($where = array(), $showQuery = false) {
		$imageSet = array();
		$CI = &get_instance();
		$CI->db->where($where);
		$query = $CI->db->get('tbl_image');
		if ($showQuery) {
			$querySet[] = $CI->db->last_query();
		}
		$result = &$query->result_array();

		foreach ($result as $dbImage) {
			$imageSet[] = self::convertToImage($dbImage);
		}
		return $showQuery ? $querySet : $imageSet;
	}

// </editor-fold>

	/**
	 *
	 * @param type $dbImage
	 * @return ImageClass 
	 */
	public static function convertToImage($dbImage) {

		$image = new ImageClass();
		if (isset($dbImage['img_id']) && (int) $dbImage['img_id'] > 0) {
			$image->isValid = true;
			$image->img_id = $dbImage['img_id'];
			$image->img_element_id = $dbImage['img_element_id'];
			$image->img_type_id = $dbImage['img_type_id'];
			$image->img_source = $dbImage['img_source'];
		}
		return $image;
	}

	/**
	 *
	 * @param type $objectID
	 * @return ImageClass
	 */
	public static function cachedObject($objectID) {
		//this class does not need any cache 
		$CI = get_instance();
		$CI->db->where('img_id', $objectID);
		$query = $CI->db->get('tbl_image');
		$result = &$query->result_array();
		foreach ($result as $dbImage) {
			$imageSet[] = self::convertToImage($dbImage);
		}
		return isset($imageSet[0]) ? $imageSet[0] : new ImageClass();
	}

	/**
	 * 	
	 * @return mixed returns OwnerObject
	 */
	public function ownerObject() {
		$object = null;
		switch ($this->img_type_id) {
			case SeasonClass::OBJECT_TYPE:
				$object = SeasonClass::cachedObject($this->imgObjectID());
				break;
//			case IMAGE_TYPE_EPISODE:
//				$object = EpisodeClass::cachedObject($this->imgObjectID());
//				break;
//			case IMAGE_TYPE_PUBLISHER:
//				;
//				break;
//			case IMAGE_TYPE_DIRECTOR:
//				$object = DirectorClass::cachedObject($this->imgObjectID());
//				break;
//			case IMAGE_TYPE_ACTOR:
//				$object = ActorClass::cachedObject($this->imgObjectID());
//				break;
			case SerieClass::OBJECT_TYPE:
				$object = SerieClass::cachedObject($this->imgObjectID());
				break;
		}
		return $object;
	}

	public function ownerName() {
		if ($this->ownerName == '') {
			$ownerObject = $this->ownerObject();
			switch ($this->imgType()) {
				case SerieClass::OBJECT_TYPE:
					$this->ownerName = $ownerObject->serName();
					break;
				case SeasonClass::OBJECT_TYPE:
					$serie = SerieClass::cachedObject($ownerObject->ssnSerieID());
					$this->ownerName = $serie->serName();
					break;
				//TODO: add for other objects
			}
		}
		return $this->ownerName;
	}

	public function controlCMYK() {
		//TODO:check if it is cmyk if cmyk throw an exception
		;
	}

	/**
	 *
	 * @return string starts without a slash and finishes with a slash
	 */
	public function dateFolder() {
		$imageSourceSet = explode('/', $this->imgSource());
		if (count($imageSourceSet) != 7) {
			throw new Exception('Folder count doesnt match at file:' . __FILE__ . ' line: ' . __LINE__); //TODO: do a better exception class-jist steal it
		}
		return $imageSourceSet[2] . '/' . $imageSourceSet[3] . '/' . $imageSourceSet[4] . '/';
	}

	public static function cropImage($sourceFile, $destinationFolder, $width, $height, $outputImageName = IMAGE_CROPPED_NAME, $addHeightWidth = TRUE) {
		$im = new imagick($sourceFile);
		$im->setImageFormat("jpg");
		$geo = $im->getImageGeometry();

		if (($geo['width'] / $width) < ($geo['height'] / $height)) {
			$im->cropImage($geo['width'], floor($height * $geo['width'] / $width), 0, (($geo['height'] - ($height * $geo['width'] / $width)) / 2));
		} else {
			$im->cropImage(ceil($width * $geo['height'] / $height), $geo['height'], (($geo['width'] - ($width * $geo['height'] / $height)) / 2), 0);
		}
		$im->ThumbnailImage($width, $height, true);
		
		if(substr($destinationFolder, -1) != "/") {
			$destinationFolder = $destinationFolder . "/";
		}
		
		if($addHeightWidth) {
			$imageAbsolutePath = $destinationFolder . $outputImageName . "_" . $width . "x" . $height . IMAGE_EXTENSION;
		} else {
			$imageAbsolutePath = $destinationFolder . $outputImageName . IMAGE_EXTENSION;
		}
		
		$im->writeImages($imageAbsolutePath, true);
		$im->clear();
		$im->destroy();
		unset($im);
	}
}
