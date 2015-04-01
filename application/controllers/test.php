<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of test
 *
 * @author Detay
 */
class Test_Controller extends Base_Controller{
	public $restful = true;
	
	public function __construct() {
		parent::__construct();
	}

	public function get_index() {
		$path_info = pathinfo('/foo/bar/baz.bill');
		var_dump($path_info);
		exit;
		$token = Token::where('ApplicationID', '=', '96')
						->where('UDID', '=', '1bb7a359cc0b62d5')
//						->where('UDID', '=', $UDID)
						->first();
		var_dump(DB::last_query());
		var_dump($token);
	}

}
