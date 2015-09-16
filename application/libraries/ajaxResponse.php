<?php

class ajaxResponse {
    private function __construct() {
	;
    }
    
    public static function error($errorMsg) {
	$tmpArray = array (
	    "errmsg" => (string)$errorMsg,
	    "success" => false,
	);
	return json_encode($tmpArray);
    }
    
    public static function success($msg = "") {
	$responseArray = array("success" => true);
	if(!empty($msg)) {
	    $responseArray["succesMsg"] = (string)$msg;
	}
	return json_encode($responseArray);
    }
}
