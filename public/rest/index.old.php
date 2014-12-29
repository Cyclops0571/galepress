<?php
@ini_set("default_charset","UTF-8");
header('Content-Type: text/html; charset=utf-8');
header('Content-type: text/json');
header('Content-type: application/json');
ini_set('display_errors', 1);
error_reporting(E_ALL);

require 'flight/Flight.php';
require($_SERVER["DOCUMENT_ROOT"]."/lib/common.php");


Flight::route('POST|GET /getAppVersion', 'getAppVersion');
Flight::route('POST|GET /getAppDetail', 'getAppDetail');
Flight::route('POST|GET /getAppContents', 'getAppContents');
Flight::route('POST|GET /getContentCoverImage', 'getContentCoverImage');
Flight::route('POST|GET /getContentDetail', 'getContentDetail');
Flight::route('POST|GET /getContentFile', 'getContentFile');
Flight::route('POST|GET /getContentVersion', 'getContentVersion');
Flight::route('POST|GET /getAppCategories', 'getAppCategories');
Flight::route('POST|GET /getCategoryDetail', 'getCategoryDetail');
Flight::route('POST|GET /getContentDetailWithCategories', 'getContentDetailWithCategories');
Flight::route('POST|GET /submitStatistic', 'submitStatistic');




Flight::map('notFound', function(){
    echo "Not Found";
});

function getAppVersion() {	
	$ret = array();
	try {
		$applicationID = Flight::request()->data['applicationID'];	 	
		$ret = request_GetAppVersion($applicationID);		
	}
	catch (Exception $e) {
		$ret = array(
			'status' => $e->getCode(),
			'error' => $e->getMessage(), 
			'ApplicationID' => 0,
			'ApplicationBlocked' => false,
			'ApplicationStatus' => false,
			'ApplicationVersion' => 0
		);
	}
	echo json_encode($ret);
}

function getAppDetail() {
	$ret = "";
	try {
		$applicationID = Flight::request()->data['applicationID'];	
		$ret = request_GetAppDetail($applicationID);
	}
	catch (Exception $e) {
		$ret = array(
			'status' => $e->getCode(),
			'error' => $e->getMessage(),
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
	}
	echo json_encode($ret);
}

function getAppContents() {
	$ret = "";
	try {
		$applicationID = Flight::request()->data['applicationID'];	
		$applicationToken = Flight::request()->data['applicationToken'];
		$deviceToken = Flight::request()->data['deviceToken'];		
		$username = Flight::request()->data['username'];	
		$password = Flight::request()->data['password'];	
		$ret = request_GetAppContents($applicationID, $applicationToken, $deviceToken, $username, $password);
	}
	catch (Exception $e) {
		$ret = array(
			'status' => $e->getCode(),
			'error' => $e->getMessage(),
			'Contents' => array()
		);
	}
	echo json_encode($ret);
}

function getContentCoverImage() {
	$ret = "";
	try {
		$contentID = Flight::request()->data['contentID'];	
		$size = Flight::request()->data['size'];
		//request_GetResponse202($cContentID);
		//request_GetResponse204($cContentID);
		$ret = request_GetContentCoverImage($contentID, $size);
	}
	catch (Exception $e) {
		$ret = array(
			'status' => $e->getCode(),
			'error' => $e->getMessage(),
			'ContentID' => 0,
			'Url' => ""
		);
	}
	echo json_encode($ret);
}

function getContentDetail() {
	$ret = "";
	try {
		$contentID = Flight::request()->data['contentID'];
		$ret = request_GetContentDetail($contentID);
	}
	catch (Exception $e) {
		$ret = array(
			'status' => $e->getCode(),
			'error' => $e->getMessage(),
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
	}
	echo json_encode($ret);
}
function getContentFile() {
	$ret = "";
	try {
		$contentID = Flight::request()->data['contentID'];
		$password = Flight::request()->data['password'];
		$ret = request_GetContentFile($contentID, $password);
	}
	catch (Exception $e) {
		$ret = array(
			'status' => $e->getCode(),
			'error' => $e->getMessage(),
			'ContentID' => 0,
			'Url' => ""
		);
	}
	echo json_encode($ret);
}

function getContentVersion() {
	$ret = "";
	try {
		$contentID = Flight::request()->data['contentID'];
		$ret = request_GetContentVersion($contentID);
	}
	catch (Exception $e) {
		$ret = array(
			'status' => $e->getCode(),
			'error' => $e->getMessage(),
			'ContentID' => 0,
			'ContentBlocked' => false,
			'ContentStatus' => false,
			'ContentVersion' => 0
		);
	}
	echo json_encode($ret);
}

function getAppCategories($applicationID) {
	$ret = "";
	try {
		$applicationID = Flight::request()->data['applicationID'];
		$ret = request_GetAppCategories($applicationID);
	}
	catch (Exception $e) {
		$ret = array(
			'status' => $e->getCode(),
			'error' => $e->getMessage(),
			'Categories' => array()
		);
	}
	echo json_encode($ret);
}

function getCategoryDetail() {
	$ret = "";
	try {
		$categoryID = Flight::request()->data['categoryID'];
		$ret = request_GetCategoryDetail($categoryID);
	}
	catch (Exception $e) {
		$ret = array(
			'status' => $e->getCode(),
			'error' => $e->getMessage(),
			'CategoryID' => 0,
			'CategoryName' => ""
		);
	}
	echo json_encode($ret);
}
function getAppContentsWithCategories() {
	$ret = "";
	try {
		$applicationID = Flight::request()->data['applicationID'];	
		$applicationToken = Flight::request()->data['applicationToken'];
		$deviceToken = Flight::request()->data['deviceToken'];		
		$username = Flight::request()->data['username'];	
		$password = Flight::request()->data['password'];	
		$categoryID = Flight::request()->data['categoryID'];	
		$ret = request_GetAppContentsWithCategories($applicationID, $applicationToken, $deviceToken, $username, $password, $categoryID);
	}
	catch (Exception $e) {
		$ret = array(
			'status' => $e->getCode(),
			'error' => $e->getMessage(),
			'Contents' => array()
		);
	}
	echo json_encode($ret);
}

function getContentDetailWithCategories() {
	$ret = "";
	try {
		$contentID = Flight::request()->data['contentID'];
		$ret = request_GetContentDetailWithCategories($contentID);
	}
	catch (Exception $e) {
		$ret = array(
			'status' => $e->getCode(),
			'error' => $e->getMessage(),
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
	}
	echo json_encode($ret);
}
function submitStatistic($id, $type, $time, $lat, $long, $deviceID, $contentID, $page, $param5, $param6, $param7) {
	$ret = "";
	try {
		$id = Flight::request()->data['id'];
		$type = Flight::request()->data['type'];
		$time = Flight::request()->data['time'];
		$lat = Flight::request()->data['lat'];
		$long = Flight::request()->data['long'];
		$deviceID = Flight::request()->data['deviceID'];
		$contentID = Flight::request()->data['contentID'];
		$page = Flight::request()->data['page'];
		$param5 = Flight::request()->data['param5'];
		$param6 = Flight::request()->data['param6'];
		$param7 = Flight::request()->data['param7'];
		
		$ret = request_SubmitStatistic($id, $type, $time, $lat, $long, $deviceID, $contentID, $page, $param5, $param6, $param7);
	}
	catch (Exception $e) {
		$ret = array(
			'status' => $e->getCode(),
			'id' => '',
			'error' => $e->getMessage()
		);
	}
	echo json_encode($ret);
}

Flight::start();
?> 
