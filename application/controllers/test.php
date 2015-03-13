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
		echo \Laravel\Request::env();
		$toEmail = Config::get('custom.admin_email');
		$subject = __('common.task_subject');
		$fromEmail = Config::get('custom.mail_email');
		$msg = __('common.task_message', array(
				'task' => '`BackupDatabase`',
				'detail' => "bilgi islem test"
				)
		);
		Bundle::start('messages');
		Message::send(function($m) use($fromEmail, $toEmail, $subject, $msg) {
			$m->from($fromEmail, Config::get('custom.mail_displayname'));
			$m->to($toEmail);
			$m->subject($subject);
			$m->body($msg);
		});
	}

}
