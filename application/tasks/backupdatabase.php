<?php

class BackupDatabase_Task {

    public function run()
    {
		try
		{
			$this->backup();
		}
		catch (Exception $e)
		{
			$msg = __('common.task_message', array(
					'task' => '`BackupDatabase`',
					'detail' => $e->getMessage()
					)
				);
			Common::sendErrorMail($msg);
		}
    }
	
	public function backup()
	{
		//http://studio.quintalinda.com/help/downloads/mysql-backup/
		/*
		this script will backup, compress and email a single mySQL schema, and borrows code from several sources, including:
		http://oscarm.org/news/detail/543-how_to_backup_mysql_database_email_results_using_bash
		http://www.dagondesign.com/articles/automatic-mysql-backup-script/

		there is no error checking - please feel free to add some.

		please note this script leaves a copy of your backup on the server, if you make your backup path on a publicly
		available address, this could be a security issue - either make it above your public_html or add something to 
		secure or delete the file.

		script by www.greenmedia.es - feel free to change and add, no warantee, guarantee, nada.. good luck.
		*/

		// errors ##
		ini_set('error_reporting', E_ALL);

		// date format, you can change this, for example date('Y_m_d_h_i_s') ##
		$date =  date('Y_m_d');

		// mySQL details ##
		$host = Config::get('database.connections.mysql.host');
		$username = Config::get('database.connections.mysql.username');
		$password = Config::get('database.connections.mysql.password');
		$schema = Config::get('database.connections.mysql.database');
		$path = '/home/admin/domains/galepress.com/public_html/backup/'; // absolute and with trailing slash ##
		$opts = '--quick --lock-tables --add-drop-table'; // backup options for mysqldump ##

		// email details ##
		$email = Config::get('custom.admin_email');
		$subject = __('common.task_success_subject');

		// file compression details ##
		$zip = 'gzip';
		$mime = 'application/gzip';
		$extension = '.gz';

		// put it all together ##
		$backup = $schema.'_'.$date.'.sql'.$extension;

		// run mysqldump routine ##
		exec(sprintf('mysqldump --host='.$host.' --user='.$username.' --password='.$password.' '.$schema.' '.$opts.' | '.$zip.' > '.$path.$backup.'', $host, $username, $password, $schema, $path.$backup));

		// email compressed file as inline attachment ##
		$headers = "From: ".Config::get('custom.mail_email')." <".Config::get('custom.mail_displayname').">";

		// Generate a boundary string ##
		$rnd_str = md5(time()); 
		$mime_boundary = "==Multipart_Boundary_x{$rnd_str}x"; 

		// Add headers for file attachment ##
		$headers .= "\nMIME-Version: 1.0\n" . 
			"Content-Type: multipart/mixed;\n" . 
			" boundary=\"{$mime_boundary}\"";

		// Add a multipart boundary above the plain message ##
		$body = "This is a multi-part message in MIME format.\n\n" . 
			"--{$mime_boundary}\n" . 
			"Content-Type: text/plain; charset=\"iso-8859-1\"\n" . 
			"Content-Transfer-Encoding: 7bit\n\n";

		// make Base64 encoding for file data ##
		$data = chunk_split(base64_encode(file_get_contents($path.$backup)));

		// Add file attachment to the message ##
		$body .= "--{$mime_boundary}\n" . 
			"Content-Type: {$mime};\n" . 
			" name=\"{$backup}\"\n" . 
			"Content-Disposition: attachment;\n" . 
			" filename=\"{$backup}\"\n" . 
			"Content-Transfer-Encoding: base64\n\n" . 
			$data . "\n\n" . 
			"--{$mime_boundary}--\n";

		// send ##
		$res = mail( $email, $subject, $body, $headers );

		// check mail status ##
		if ( !$res ) {
			throw new Exception('FAILED to email mysqldump.');
		}
	}
}