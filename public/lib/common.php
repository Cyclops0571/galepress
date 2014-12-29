<?php
	@ini_set("default_charset","UTF-8");
	header('Content-Type: text/html; charset=utf-8');
	
	include($_SERVER["DOCUMENT_ROOT"]."/lib/config.php");
	include($_SERVER["DOCUMENT_ROOT"]."/lib/core.php");
	include($_SERVER["DOCUMENT_ROOT"]."/lib/core.request.php");
	
	$conn = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD);
	if (!$conn) {
		die(mysql_error());
	}
	if (!mysql_select_db(DB_NAME, $conn)) {
		die(mysql_error());
	}
	mysql_query("SET NAMES '".DB_CHARSET."'", $conn);
	mysql_query("SET CHARACTER SET ".DB_CHARSET, $conn);
	mysql_query("SET COLLATION_CONNECTION = '".DB_COLLATE."'", $conn);
?>