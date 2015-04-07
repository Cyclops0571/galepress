<?php
class imageInfoEx {

	public $width = 0;
	public $height = 0;
	public $type = "";
	public $attr = "";
	public $absolutePath = "";
	public $webUrl = "";
	private $_isValid = FALSE;

	/**
	 * @param string $inputFile absolute path to image
	 */
	public function __construct($inputFile) {
		if (($imageSize = @getimagesize(path('public') . $inputFile)) !== false) {
			$this->_isValid = true;
			$this->width = $imageSize[0];
			$this->height = $imageSize[1];
			$this->type = $imageSize[2];
			$this->attr = $imageSize[3];
			$this->absolutePath = path('public') . $inputFile;
			$this->webUrl = "/" . $inputFile;
		}
	}

	public function isValid() {
		return $this->_isValid;
	}
}
