<?php

class Gmcode_Aove_Helper_Data extends Mage_Core_Helper_Abstract
{
	public function getAovePath()
	{
		return 'gmcode' . "/" . 'aove' . "/";
	}
	public function getThumbsPath($aovePath)
	{
		return str_replace("/aove/","/aove/thumbs/",$aovePath);
	}

	public function resizeImg($fileName, $width, $height = '')
	{
		//$fileName = "gmcode\aove\\".$fileName;

		$folderURL = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA);
		$imageURL = $folderURL . $fileName;

		$basePath = Mage::getBaseDir(Mage_Core_Model_Store::URL_TYPE_MEDIA) . DS . "gmcode". DS . "aove" . DS . $fileName;

		$newPath = Mage::getBaseDir(Mage_Core_Model_Store::URL_TYPE_MEDIA) . DS . "gmcode" . DS . "aove" . DS . "thumbs" . DS . $fileName;
		//if width empty then return original size image's URL
		if ($width != '') {
			//if image has already resized then just return URL
			if (file_exists($basePath) && is_file($basePath) && !file_exists($newPath)) {

				$imageObj = new Varien_Image($basePath);
				$imageObj->constrainOnly(TRUE);
				$imageObj->keepAspectRatio(FALSE);
				$imageObj->keepFrame(FALSE);
				$imageObj->resize($width, $height);
				$imageObj->save($newPath);

			}
			$resizedURL = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA) . "resized" . DS . $fileName;
		 } else {
			$resizedURL = $imageURL;
		 }
		 return $resizedURL;
	}

}
