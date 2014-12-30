<?php

class Uploader
{
	public static function ContentsUploadFile($tempFile)
	{
		$filePath = path('public').'files/temp/';
		$imageFile = '';

		//if(Str::lower($fileExt) == 'pdf')
		if (File::is('pdf', $filePath.'/'.$tempFile))
		{
			//create zip archive
			$zipFile = $tempFile.'.zip';
			
			$zip = new ZipArchive();
			$res = $zip->open($filePath.'/'.$zipFile, ZIPARCHIVE::CREATE);
			if ($res === true)
			{
				$zip->addFile($filePath.'/'.$tempFile, 'file.pdf');
				$zip->close();
			}
			
			//create snapshot
			$imageFile = $tempFile.'.jpg';

			$im = new imagick();
			//TODO:postscript delegate failed hatasi vermesine neden oluyor!!!!!!
			$im->setOption('pdf:use-cropbox', 'true');
			//$im->setResourceLimit(Imagick::RESOURCETYPE_MEMORY, 32);
			//$im->setResourceLimit(Imagick::RESOURCETYPE_MAP, 32);
			//$im->setResourceLimit(6, 2);
			$im->setResolution(150, 150);
			$im->readImage($filePath."/".$tempFile."[0]");

			//convert color space to RGB
			//http://php.net/manual/en/imagick.setimagecolorspace.php
			if ($im->getImageColorspace() == Imagick::COLORSPACE_CMYK) {

				$profiles = $im->getImageProfiles('*', false);
				
				// we're only interested if ICC profile(s) exist
				$has_icc_profile = (array_search('icc', $profiles) !== false);
				
				// if it doesnt have a CMYK ICC profile, we add one
				if ($has_icc_profile === false) {
					//$icc_cmyk = file_get_contents(dirname(__FILE__).'/USWebUncoated.icc');
					$icc_cmyk = file_get_contents(path('public').'files/icc/USWebUncoated.icc');
					$im->profileImage('icc', $icc_cmyk);
					unset($icc_cmyk);
				}
			
				// then we add an RGB profile - 'AdobeRGB1998.icc'
				//$icc_rgb = file_get_contents(dirname(__FILE__).'/sRGB_v4_ICC_preference.icc');
				$icc_rgb = file_get_contents(path('public').'files/icc/AdobeRGB1998.icc');
				$im->profileImage('icc', $icc_rgb);
				unset($icc_rgb);

				$im->stripImage (); // this will drop down the size of the image dramatically (removes all profiles)
			}

			$im->resampleImage(72, 72, Imagick::FILTER_BOX, 1);
			//$im->setImageColorspace(255);
			$im->setCompression(Imagick::COMPRESSION_JPEG);
			$im->setCompressionQuality(80);
			//$im->setImageFormat('jpeg');
			$im->setImageFormat('jpg');

			$width = 400;
			$height = 524;
			$geo = $im->getImageGeometry();
			
			if(($geo['width'] / $width) < ($geo['height'] / $height))
			{
				$im->cropImage($geo['width'], floor($height*$geo['width']/$width), 0, (($geo['height']-($height*$geo['width']/$width))/2));
			}
			else
			{
				$im->cropImage(ceil($width*$geo['height']/$height), $geo['height'], (($geo['width']-($width*$geo['height']/$height))/2), 0);
			}
			$im->ThumbnailImage($width, $height, true);
			$im->writeImage($filePath.'/'.$imageFile);
			$im->clear();
			$im->destroy();
			unset($im);

			//$imageFile = $fileName.'_'.$rnd.'.jpg';
			//$im = new imagick($filePath.'/'.$tempFile.'[0]');
			//$im->setOption('pdf:use-cropbox', 'true');
			//$im->setImageFormat('jpg');
			//$width = 400;
			//$height = 524;
			//$geo = $im->getImageGeometry();
			//if(($geo['width'] / $width) < ($geo['height'] / $height))
			//{
			//	$im->cropImage($geo['width'], floor($height*$geo['width']/$width), 0, (($geo['height']-($height*$geo['width']/$width))/2));
			//}
			//else
			//{
			//	$im->cropImage(ceil($width*$geo['height']/$height), $geo['height'], (($geo['width']-($width*$geo['height']/$height))/2), 0);
			//}
			//$im->ThumbnailImage($width, $height, true);
			//$im->writeImages($filePath.'/'.$imageFile, true);

			//delete pdf file
			File::delete($filePath.'/'.$tempFile);
			
			$tempFile = $zipFile;
		}
		return array (
			'fileName' => $tempFile,
			'imageFile' => $imageFile
		);
	}

	public static function ContentsUploadCoverImage($tempFile)
	{
		$filePath = path('public').'files/temp/';

		$im = new imagick();
		$im->readImage($filePath."/".$tempFile);
		
		//convert color space to RGB
		//http://php.net/manual/en/imagick.setimagecolorspace.php
		if ($im->getImageColorspace() == Imagick::COLORSPACE_CMYK) {

			$profiles = $im->getImageProfiles('*', false);
			
			// we're only interested if ICC profile(s) exist
			$has_icc_profile = (array_search('icc', $profiles) !== false);
			
			// if it doesnt have a CMYK ICC profile, we add one
			if ($has_icc_profile === false) {
				//$icc_cmyk = file_get_contents(dirname(__FILE__).'/USWebUncoated.icc');
				$icc_cmyk = file_get_contents(path('public').'files/icc/USWebUncoated.icc');
				$im->profileImage('icc', $icc_cmyk);
				unset($icc_cmyk);
			}
		
			// then we add an RGB profile - 'AdobeRGB1998.icc'
			//$icc_rgb = file_get_contents(dirname(__FILE__).'/sRGB_v4_ICC_preference.icc');
			$icc_rgb = file_get_contents(path('public').'files/icc/AdobeRGB1998.icc');
			$im->profileImage('icc', $icc_rgb);
			unset($icc_rgb);

			$im->stripImage (); // this will drop down the size of the image dramatically (removes all profiles)	
			$im->writeImage($filePath.'/'.$tempFile);
		} 
		$im->clear();
		$im->destroy();
		unset($im);
		return array (
			'fileName' => $tempFile
		);
	}

	public static function OrdersUploadFile($tempFile, $type)
	{
		$filePath = path('public').'files/temp/';

		if($type == 'uploadpng1024x1024' || $type == 'uploadpng640x960' || $type == 'uploadpng640x1136' || $type == 'uploadpng1536x2048' || $type == 'uploadpng2048x1536')
		{
			$size = str_replace('uploadpng', '', $type);
			$arrSize = explode('x', $size);
			$width = (int)$arrSize[0];
			$height = (int)$arrSize[1];

			$im = new imagick();
			$im->readImage($filePath."/".$tempFile);
			$geo = $im->getImageGeometry();
			$w = (int)$geo['width'];
			$h = (int)$geo['height'];
			$im->clear();
			$im->destroy();
			unset($im);

			if($w != $width || $h != $height) {
				
				File::delete($filePath."/".$tempFile);

				throw new Exception('Invalid file dimension!');
			}
		}
	}

}