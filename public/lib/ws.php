<?php

/*
if((int)$applicationID === 95) {
	//loggy('applicationID='.(is_string($applicationID) ? $applicationID : ""));
	//loggy('applicationToken='.(is_string($applicationToken) ? $applicationToken : ""));
	//loggy('deviceToken='.(is_string($deviceToken) ? $deviceToken : ""));
	//loggy('username='.(is_string($username) ? $username : ""));
	//loggy('password='.(is_string($password) ? $password : ""));
	//loggy('categoryID='.$categoryID);	
}
*/

function getAppVersion($applicationID) {
	$default = array(
		'status' => 0,
		'error' => '', 
		'ApplicationID' => 0,
		'ApplicationBlocked' => false,
		'ApplicationStatus' => false,
		'ApplicationVersion' => 0
	);
	try {
		return request("/applications/".(int)$applicationID."/version", $default);
		//$ret = request_GetAppVersion($applicationID);
	}
	catch (Exception $e) { 
		$default['status'] = $e->getCode();
		$default['error'] = $e->getMessage();
	}
	return $default;
}

function getAppDetail($applicationID) {
	$default = array(
		'status' => 0,
		'error' => '', 
		'CustomerID' => 0,
		'CustomerName' => "",
		'ApplicationID' => 0,
		'ApplicationName' => "",
		'ApplicationDetail' => "",
		'ApplicationExpirationDate' => "",
		'ApplicationBlocked' => false,
		'ApplicationStatus' => false,
		'ApplicationVersion' => 0
	);
	try {
		return request("/applications/".(int)$applicationID."/detail", $default);
		//$ret = request_GetAppDetail($applicationID);
	}
	catch (Exception $e) {
		$default['status'] = $e->getCode();
		$default['error'] = $e->getMessage();
	}
	return $default;
}

function getAppCategories($applicationID) {
	$default = array(
		'status' => 0,
		'error' => '', 
		'Categories' => array()
	);
	try {
		return request("/applications/".(int)$applicationID."/categories", $default);
		//$ret = request_GetAppCategories($applicationID);
	}
	catch (Exception $e) {
		$default['status'] = $e->getCode();
		$default['error'] = $e->getMessage();
	}
	return $default;
}

function getCategoryDetail($categoryID) {
	$default = array(
		'status' => 0,
		'error' => '', 
		'CategoryID' => 0,
		'CategoryName' => ""
	);
	try {
		$applicationID = getApplicationID((int)$categoryID);
		return request("/applications/".(int)$applicationID."/categories/".(int)$categoryID."/detail", $default);
		//$ret = request_GetCategoryDetail($categoryID);
	}
	catch (Exception $e) {
		$default['status'] = $e->getCode();
		$default['error'] = $e->getMessage();
	}
	return $default;
}

function getAppContents($applicationID, $applicationToken, $deviceToken, $username, $password) {
	$default = array(
		'status' => 0,
		'error' => '', 
		'Contents' => array()
	);
	try {
		return request("/applications/".(int)$applicationID."/contents?applicationToken=".$applicationToken."&deviceToken=".$deviceToken."&username=".$username."&password=".$password, $default);
		//$ret = request_GetAppContents($applicationID, $applicationToken, $deviceToken, $username, $password);
	}
	catch (Exception $e) {
		$default['status'] = $e->getCode();
		$default['error'] = $e->getMessage();
	}
	return $default;
}

function getAppContentsWithCategories($applicationID, $applicationToken, $deviceToken, $username, $password, $categoryID) {
	$default = array(
		'status' => 0,
		'error' => '', 
		'Contents' => array()
	);
	try {
		return request("/applications/".(int)$applicationID."/contents?applicationToken=".$applicationToken."&deviceToken=".$deviceToken."&username=".$username."&password=".$password."&categoryID".(int)$categoryID, $default);
		//$ret = request_GetAppContentsWithCategories($applicationID, $applicationToken, $deviceToken, $username, $password, $categoryID);
	}
	catch (Exception $e) {
		$default['status'] = $e->getCode();
		$default['error'] = $e->getMessage();
	}
	return $default;
}

function getContentVersion($contentID) {
	$default = array(
		'status' => 0,
		'error' => '', 
		'ContentID' => 0,
		'ContentBlocked' => false,
		'ContentStatus' => false,
		'ContentVersion' => 0
	);
	try {
		return request("/contents/".(int)$contentID."/version", $default);
		//$ret = request_GetContentVersion($contentID);
	}
	catch (Exception $e) {
		$default['status'] = $e->getCode();
		$default['error'] = $e->getMessage();
	}
	return $default;
}

function getContentDetail($contentID) {
	$default = array(
		'status' => 0,
		'error' => '', 
		'ContentID' => 0,
		'ContentName' => "",
		'ContentDetail' => "",
		'ContentCategoryID' => 0,
		'ContentCategoryName' => "",
		'ContentMonthlyName' => "",
		'ContentIsProtected' => false,
		'ContentIsBuyable' => false,
		'ContentPrice' => "0",
		'ContentCurrency' => "",
		'ContentIdentifier' => "",
		'ContentAutoDownload' => false,
		'ContentBlocked' => false,
		'ContentStatus' => false,
		'ContentVersion' => 0,
		'ContentPdfVersion' => 0,
		'ContentCoverImageVersion' => 0
	);
	try {
		return request("/contents/".(int)$contentID."/detail", $default);
		//$ret = request_GetContentDetail($contentID);
	}
	catch (Exception $e) {
		$default['status'] = $e->getCode();
		$default['error'] = $e->getMessage();
	}
	return $default;
}

function getContentDetailWithCategories($contentID) {
	$default = array(
		'status' => 0,
		'error' => '', 
		'ContentID' => 0,
		'ContentName' => "",
		'ContentDetail' => "",
		'ContentCategories' => array(),
		'ContentMonthlyName' => "",
		'ContentIsProtected' => false,
		'ContentIsBuyable' => false,
		'ContentPrice' => "0",
		'ContentCurrency' => "",
		'ContentIdentifier' => "",
		'ContentAutoDownload' => false,
		'ContentBlocked' => false,
		'ContentStatus' => false,
		'ContentVersion' => 0,
		'ContentPdfVersion' => 0,
		'ContentCoverImageVersion' => 0
	);
	try {
		return request("/contents/".(int)$contentID."/detail", $default);
		//$ret = request("/contents/".(int)$contentID."/detail?withCategories=true");
		//$ret = request_GetContentDetailWithCategories($contentID);
	}
	catch (Exception $e) {
		$default['status'] = $e->getCode();
		$default['error'] = $e->getMessage();
	}
	return $default;
}

function getContentCoverImage($contentID, $size) {
	$default = array(
		'status' => 0,
		'error' => '', 
		'ContentID' => 0,
		'Url' => ""
	);
	try {
		return request("/contents/".(int)$contentID."/cover-image?size=".(int)$size, $default);
		////request_GetResponse202($cContentID);
		////request_GetResponse204($cContentID);
		//$ret = request_GetContentCoverImage($contentID, $size);
	}
	catch (Exception $e) {
		$default['status'] = $e->getCode();
		$default['error'] = $e->getMessage();
	}
	return $default;
}

function getContentFile($contentID, $password) {
	$default = array(
		'status' => 0,
		'error' => '', 
		'ContentID' => 0,
		'Url' => ""
	);
	try {
		return request("/contents/".(int)$contentID."/file?password=".$password, $default);
		////request_GetResponse203($cContentID, $cPassword);
		//$ret = request_GetContentFile($contentID, $password);
	}
	catch (Exception $e) {
		$default['status'] = $e->getCode();
		$default['error'] = $e->getMessage();
	}
	return $default;
}

function submitStatistic($id, $type, $time, $lat, $long, $deviceID, $contentID, $page, $param5, $param6, $param7) {
	$default = array(
		'status' => 0,
		'error' => '', 
		'id' => ''
	);
	try {
		return request("/statistics", $default, true, array(
			'id' => $id,
			'type' => $type,
			'time' => $time,
			'lat' => $lat,
			'long' => $long,
			'deviceID' => $deviceID,
			'contentID' => $contentID,
			'page' => $page,
			'param5' => $param5,
			'param6' => $param6,
			'param7' => $param7
		));
		//$ret = request_SubmitStatistic($id, $type, $time, $lat, $long, $deviceID, $contentID, $page, $param5, $param6, $param7);
	}
	catch (Exception $e) {
		$default['status'] = $e->getCode();
		$default['error'] = $e->getMessage();
	}
	return $default;
}

function submitStatisticWithApplicationID($id, $type, $time, $lat, $long, $deviceID, $applicationID, $contentID, $page, $param5, $param6, $param7) {
	$default = array(
		'status' => 0,
		'error' => '', 
		'id' => ''
	);
	try {
		return request("/statistics", $default, true, array(
			'id' => $id,
			'type' => $type,
			'time' => $time,
			'lat' => $lat,
			'long' => $long,
			'deviceID' => $deviceID,
			'applicationID' => $applicationID,
			'contentID' => $contentID,
			'page' => $page,
			'param5' => $param5,
			'param6' => $param6,
			'param7' => $param7
		));
		//$ret = request_SubmitStatisticWithApplicationID($id, $type, $time, $lat, $long, $deviceID, $applicationID, $contentID, $page, $param5, $param6, $param7);
	}
	catch (Exception $e) {
		$default['status'] = $e->getCode();
		$default['error'] = $e->getMessage();
	}
	return $default;
}

?>