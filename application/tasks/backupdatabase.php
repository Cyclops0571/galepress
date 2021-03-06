<?php

class BackupDatabase_Task
{

    public function run()
    {
        try {
            $this->backup();
        } catch (Exception $e) {
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
        $date = date('Y_m_d');

        // mySQL details ##
        $host = Config::get('database.connections.mysql.host');
        $username = Config::get('database.connections.mysql.username');
        $password = Config::get('database.connections.mysql.password');
        $schema = Config::get('database.connections.mysql.database');
        $path = '/home/admin/database_backup/'; // absolute and with trailing slash ##
        $opts = '--quick --lock-tables --add-drop-table'; // backup options for mysqldump ##

        // email details ##
        $email = Config::get('custom.admin_email');
        $subject = __('common.task_success_subject');

        // file compression details ##
        $zip = 'gzip';
        $mime = 'application/gzip';
        $extension = '.gz';

        // put it all together ##
        $backup = $schema . '_' . $date . '.sql' . $extension;

        // run mysqldump routine ##
        exec(sprintf('mysqldump --host=' . $host . ' --user=' . $username . ' --password=' . $password . ' ' . $schema . ' ' . $opts . ' | ' . $zip . ' > ' . $path . $backup . '', $host, $username, $password, $schema, $path . $backup));

        //secure copy database to our test server
        $scpCommand = "scp " . $path . $backup . " root@37.9.205.204:/home/admin/database_backup";
        $result = shell_exec($scpCommand);
        $result .= "Database backup islemi sorunsuz calisti.";
        Common::sendStatusMail($result);
    }
}