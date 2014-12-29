<?php
////////////////////////////////////////////////////////////////////////////////////////////////
// Common functions
////////////////////////////////////////////////////////////////////////////////////////////////
function execute_mysql_query($sql, &$result, &$rc) {
	global $conn;
	$result = mysql_query($sql, $conn);
	if(!$result) {
		//throw new Exception('Invalid query: '.mysql_error());
		echo 'Invalid query: '.mysql_error();
		exit();
	}
	$rc = mysql_num_rows($result);
}

function xmlEscape($string) {
    return str_replace(array('&', '<', '>', '\'', '"'), array('&amp;', '&lt;', '&gt;', '&apos;', '&quot;'), $string);
}

function loggy($t) {
	$file = $_SERVER["DOCUMENT_ROOT"]."/files/log.txt";
	file_put_contents($file, $t."\n", FILE_APPEND);
}
?>