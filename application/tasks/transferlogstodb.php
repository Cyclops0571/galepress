<?php

class TransferLogsToDB_Task
{

    public function run()
    {
        try {
            //var_dump($param);
            //return;

            $arr = array();
            $badRows = 0;

            $date = new DateTime();
            $date->sub(new DateInterval('P1D'));
            $logFile = '/var/log/httpd/domains/galepress.com-' . $date->format('Ymd') . '.log.1';

            //$logFile = '/var/log/httpd/domains/galepress.com-201312'.$param[0].'.log.1';
            //$logFile = '/var/log/httpd/domains/galepress.com-20131021.log.1';
            //$logFile = '/var/zpanel/logs/domains/zadmin/galepress.com-access-20130603.log';

            /*
              //Dosyayi bulamadigindan iptal ettik
              if(!File::exists($logFile))
              {
              throw new Exception('Log file not found!');
              }
             */

            $contents = File::get($logFile);

            $lines = explode("\n", $contents);

            for ($i = 0; $i < count($lines); $i++) {
                $line = $lines[$i];

                if (preg_match("/^(\S+) (\S+) (\S+) \[([^:]+):(\d+:\d+:\d+) ([^\]]+)\] \"(\S+) (.*?) (\S+)\" (\S+) (\S+) (\".*?\") (\".*?\")$/", $line, $m)) {
                    //$dump = var_export($m, true);
                    //throw new Exception('regex-on:'.$dump);
                    /*
                      regex-on:array (
                      0 => '78.171.184.247 - - [25/May/2013:00:08:11 +0300] "POST /soap.php HTTP/1.1" 200 898 "-" "zen/1.0 CFNetwork/609.1.4 Darwin/13.0.0"',
                      1 => '78.171.184.247',
                      2 => '-',
                      3 => '-',
                      4 => '25/May/2013',
                      5 => '00:08:11',
                      6 => '+0300',
                      7 => 'POST',
                      8 => '/soap.php',
                      9 => 'HTTP/1.1',
                      10 => '200',
                      11 => '898',
                      12 => '"-"',
                      13 => '"zen/1.0 CFNetwork/609.1.4 Darwin/13.0.0"',
                      )
                     */

                    $ip = $m[1];
                    $date = $m[4];
                    $time = $m[5];
                    $method = $m[7];
                    $url = $m[8];
                    $statusCode = (int)$m[10];
                    $size = (int)$m[11];
                    $userAgent = $m[13];

                    if ($method == 'GET' && $statusCode == 200) {
                        $customerID = 0;
                        $applicationID = 0;
                        $contentID = 0;
                        $contentFileID = 0;

                        //files/customer_2/application_1/content_12/file_13
                        if (preg_match("/^\/files\/customer_(\d+)\/application_(\d+)\/content_(\d+)\/file_(\d+)/", $url, $m)) {
                            $customerID = (int)$m[1];
                            $applicationID = (int)$m[2];
                            $contentID = (int)$m[3];
                            $contentFileID = (int)$m[4];
                        } //files/customer_2/application_1/content_12
                        elseif (preg_match("/^\/files\/customer_(\d+)\/application_(\d+)\/content_(\d+)/", $url, $m)) {
                            $customerID = (int)$m[1];
                            $applicationID = (int)$m[2];
                            $contentID = (int)$m[3];
                        } //files/customer_2/application_1
                        elseif (preg_match("/^\/files\/customer_(\d+)\/application_(\d+)/", $url, $m)) {
                            $customerID = (int)$m[1];
                            $applicationID = (int)$m[2];
                        } //files/customer_2
                        elseif (preg_match("/^\/files\/customer_(\d+)/", $url, $m)) {
                            $customerID = (int)$m[1];
                        } //tr/icerikler/talep?RequestTypeID=1101&ContentID=123
                        elseif (preg_match("/^\/tr\/icerikler\/talep\?RequestTypeID=(\d+)&ContentID=(\d+)/", $url, $m)) {
                            $contentID = (int)$m[2];
                            $content = Content::find($contentID);
                            if ($content) {
                                $applicationID = (int)$content->ApplicationID;
                            }
                            $application = Application::find($applicationID);
                            if ($application) {
                                $customerID = (int)$application->CustomerID;
                            }
                        }

                        if ($customerID > 0 || $applicationID > 0 || $contentID > 0 || $contentFileID > 0) {
                            $row = array(
                                'dummy',
                                $customerID,
                                $applicationID,
                                $contentID,
                                $contentFileID,
                                $size,
                                $url,
                                date_create_from_format('d/M/Y H:i:s', $date . ' ' . $time),
                                $ip,
                                $userAgent
                            );
                            array_push($arr, $row);
                        }
                    }
                } else {
                    $badRows++;
                }
            }

            DB::transaction(function () use ($arr) {
                foreach ($arr as $a) {
                    $c = new Logg();
                    $c->CustomerID = $a[1];
                    $c->ApplicationID = $a[2];
                    $c->ContentID = $a[3];
                    $c->ContentFileID = $a[4];
                    $c->Size = $a[5];
                    $c->Url = $a[6];
                    $c->Date = $a[7];
                    $c->IP = $a[8];
                    $c->UserAgent = $a[9];
                    $c->save();
                }
            });

            $toEmail = Config::get('custom.admin_email');
            $subject = __('common.task_success_subject');
            $msg = __('common.task_success_message', array(
                    'task' => '`TransferLogsToDB`',
                    'detail' => 'İşlenmeyen satır sayısı:' . $badRows . "\r\n" . 'Dosya:' . $logFile
                )
            );

            Bundle::start('messages');

            Message::send(function ($m) use ($toEmail, $subject, $msg) {
                $m->from((string)__('maillang.contanct_email'), Config::get('custom.mail_displayname'));
                $m->to($toEmail);
                $m->subject($subject);
                $m->body($msg);
            });
        } catch (Exception $e) {

            $msg = __('common.task_message', array(
                    'task' => '`TransferLogsToDB`',
                    'detail' => $e->getMessage()
                )
            );

            Common::sendErrorMail($msg);
        }
    }

}
