<?php
require_once path("base") . "php-amqplib/vendor/autoload.php";

class Base_Controller extends Controller {
    public function __construct() {
	parent::__construct();
	setcookie('ticket_user_lang', Config::get("application.language"), time() + Config::get('session.lifetime') * 60, "/");
    }

	/**
	 * Catch-all method for requests that can't be matched.
	 *
	 * @param  string    $method
	 * @param  array     $parameters
	 * @return Response
	 */
	public function __call($method, $parameters)
	{
		return Response::error('404');
	}

}