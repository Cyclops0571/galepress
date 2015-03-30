<?php
////////////////////////////////////////////////////////////////////////////////////////////////
// Request
////////////////////////////////////////////////////////////////////////////////////////////////
function request($url, $default, $post = false, $postData = array()) {
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, WS_URL.$url);
	curl_setopt($ch, CURLOPT_HEADER, false);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_TIMEOUT, 20);
	if($post) {
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));	
	}
	$data = curl_exec($ch);
	curl_close($ch);
	$json = json_decode($data);
	if((int)$json->status !== 0) {
		throw new Exception($json->error, $json->status);
	}
	$ret = json_decode($data, true);

	//Add item to array if doesnt exist
	foreach ($default as $k => $v) {
		if(!array_key_exists($k, $ret)) {
			$ret[$k] = $v;
		}
	}
	//Remove item if doesnt exist in default values
	foreach ($ret as $k => $v) {
		if(!array_key_exists($k, $default)) {
			unset($ret[$k]);
		}
	}
	return $ret;
}

function getApplicationID($categoryID) {
	$result = "";
	$rc = 0;
	$applicationID = 0;
	$sql = "SELECT `ApplicationID` FROM `Category` WHERE `CategoryID`=".mysql_real_escape_string((int)$categoryID);
	execute_mysql_query($sql, $result, $rc);
	if($rc > 0) {
		$row = mysql_fetch_array($result);
		
		$applicationID = (int)$row["ApplicationID"];
	}
	return $applicationID;
}
