<?php
require($_SERVER["DOCUMENT_ROOT"]."/lib/common.php");
require($_SERVER["DOCUMENT_ROOT"]."/lib/ws.php");
require 'flight/Flight.php';

@ini_set("default_charset","UTF-8");
header('Content-Type: text/html; charset=utf-8');
header('Content-type: text/json');
header('Content-type: application/json');
ini_set('display_errors', 1);
error_reporting(E_ALL);

function getParam($key) {

	$param = "";
	try {
		$param = Flight::request()->data[$key];
			
		if($param === NULL) {
			
			$param = Flight::request()->query[$key];
			
			if($param === NULL) {

				$json = json_decode(Flight::request()->body, true);

				if(isset($json[$key])) {
					$param = $json[$key];
				}
			}
		}
	}
	catch (Exception $e) { }
	return $param;
};

Flight::route('POST|GET /getAppVersion', function () {	
	$applicationID = getParam('applicationID');
	$ret = getAppVersion($applicationID);
	echo json_encode($ret);
});

Flight::route('POST|GET /getAppDetail', function () {
	$applicationID = getParam('applicationID');
	$ret = getAppDetail($applicationID);
	echo json_encode($ret);
});

Flight::route('POST|GET /getAppCategories', function () {
	$applicationID = getParam('applicationID');
	$ret = getAppCategories($applicationID);
	echo json_encode($ret);
});

Flight::route('POST|GET /getCategoryDetail', function () {
	$categoryID = getParam('categoryID');
	$ret = getCategoryDetail($categoryID);
	echo json_encode($ret);
});

Flight::route('POST|GET /getAppContents', function () {
	$applicationID = getParam('applicationID');
	$applicationToken = getParam('applicationToken');
	$deviceToken = getParam('deviceToken');
	$username = getParam('username');
	$password = getParam('password');
	$ret = getAppContents($applicationID, $applicationToken, $deviceToken, $username, $password);
	echo json_encode($ret);
});

Flight::route('POST|GET /getAppContentsWithCategories', function () {
	$applicationID = getParam('applicationID');
	$applicationToken = getParam('applicationToken');
	$deviceToken = getParam('deviceToken');
	$username = getParam('username');
	$password = getParam('password');
	$categoryID = getParam('categoryID');
	$ret = getAppContentsWithCategories($applicationID, $applicationToken, $deviceToken, $username, $password, $categoryID);
	echo json_encode($ret);
});

Flight::route('POST|GET /getContentVersion', function () {
	$contentID = getParam('contentID');
	$ret = getContentVersion($contentID);
	echo json_encode($ret);
});

Flight::route('POST|GET /getContentDetail', function () {
	$contentID = getParam('contentID');
	$ret = getContentDetail($contentID);
	echo json_encode($ret);
});

Flight::route('POST|GET /getContentDetailWithCategories', function () {
	$contentID = getParam('contentID');
	$ret = getContentDetailWithCategories($contentID);
	echo json_encode($ret);
});

Flight::route('POST|GET /getContentCoverImage', function () {
	$contentID = getParam('contentID');
	$size = getParam('size');
	$ret = getContentCoverImage($contentID, $size);
	echo json_encode($ret);
});

Flight::route('POST|GET /getContentFile', function () {
	$contentID = getParam('contentID');
	$password = getParam('password');
	$ret = getContentFile($contentID, $password);
	echo json_encode($ret);
});

Flight::route('POST|GET /submitStatistic', function () {
	$id = getParam('id');
	$type = getParam('type');
	$time = getParam('time');
	$lat = getParam('lat');
	$long = getParam('long');
	$deviceID = getParam('deviceID');
	$contentID = getParam('contentID');
	$page = getParam('page');
	$param5 = getParam('param5');
	$param6 = getParam('param6');
	$param7 = getParam('param7');
	$ret = submitStatistic($id, $type, $time, $lat, $long, $deviceID, $contentID, $page, $param5, $param6, $param7);
	echo json_encode($ret);
});

Flight::route('POST|GET /submitStatisticWithApplicationID', function () {
	$id = getParam('id');
	$type = getParam('type');
	$time = getParam('time');
	$lat = getParam('lat');
	$long = getParam('long');
	$deviceID = getParam('deviceID');
	$applicationID = getParam('applicationID');
	$contentID = getParam('contentID');
	$page = getParam('page');
	$param5 = getParam('param5');
	$param6 = getParam('param6');
	$param7 = getParam('param7');
	$ret = submitStatisticWithApplicationID($id, $type, $time, $lat, $long, $deviceID, $applicationID, $contentID, $page, $param5, $param6, $param7);
	echo json_encode($ret);
});

Flight::map('notFound', function(){
    echo "Not Found";
});

Flight::start();

require($_SERVER["DOCUMENT_ROOT"]."/lib/common.end.php");
?> 
