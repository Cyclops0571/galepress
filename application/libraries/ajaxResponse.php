<?php

class ajaxResponse {
    private function __construct() {
	;
    }
    
    public static function error($errorMsg) {
	$tmpArray = array (
	    "errmsg" => $errorMsg,
	    "success" => false,
	);
	return json_encode($tmpArray);
    }
    
    public static function success() {
	return json_encode(array("success" => true));
    }
}
