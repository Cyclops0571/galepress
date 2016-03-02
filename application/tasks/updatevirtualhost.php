<?php

class UpdateVirtualHost_Task
{

    public function run()
    {
        try {
            $vHost = '';

            $apps = DB::table('Customer AS c')
                ->join('Application AS a', function ($join) {
                    $join->on('a.CustomerID', '=', 'c.CustomerID');
                    $join->on('a.StatusID', '=', DB::raw(eStatus::Active));
                })
                ->join('Package AS p', function ($join) {
                    $join->on('p.PackageID', '=', 'a.PackageID');
                })
                ->where('p.BandWidth', '>', 0)
                ->where('c.StatusID', '=', eStatus::Active)
                ->order_by('a.ApplicationID', 'DESC')
                ->get(array('c.CustomerID', 'a.ApplicationID', 'p.MonthlyQuote', 'p.BandWidth', DB::raw("getApplicationTraffic(a.ApplicationID, DATE_FORMAT(NOW(), '%Y-%m-01'), LAST_DAY(NOW())) AS Traffic")));

            foreach ($apps as $app) {
                $monthlyQuote = 1024 * 1024 * (float)$app->MonthlyQuote;
                $traffic = (float)$app->Traffic;

                if ($monthlyQuote < $traffic) {

                    $byte = (float)$app->BandWidth;

                    $vHost .= "\t\t<Directory \"" . path('public') . "files/customer_" . $app->CustomerID . "/application_" . $app->ApplicationID . "\">\n";
                    $vHost .= "\t\t\tBandWidth all " . $byte . "\n";
                    $vHost .= "\t\t</Directory>\n";
                }
            }

            $v = '';

            if (Str::length($vHost) > 0) {
                $v = "<IfModule mod_bw.c>\n";
                $v .= "\t\tBandWidthModule On\n";
                $v .= "\t\tForceBandWidthModule On\n";
                //Bandwidth all 1048576
                //MaxConnection all 20
                $v .= $vHost;
                $v .= "\t</IfModule>";
            }

            $file = path('public') . 'files/httpd.conf';
            //$file = path('public').'files/httpd.local.conf';
            $content = File::get($file);
            $content = str_replace("{BANDWIDTH}", $v, $content);
            //File::put($file.'.generated.conf', $content);

            //Local
            //File::copy('/etc/apache2/sites-available/default2', '/etc/apache2/sites-available/default2.backup');
            //File::put('/etc/apache2/sites-available/default2', $content);

            //Server
            File::copy('/usr/local/directadmin/data/users/admin/httpd.conf', '/usr/local/directadmin/data/users/admin/httpd.conf.backup');
            File::put('/usr/local/directadmin/data/users/admin/httpd.conf', $content);
        } catch (Exception $e) {
            $msg = __('common.task_message', array(
                    'task' => '`UpdateVirtualHost`',
                    'detail' => $e->getMessage()
                )
            );
            Common::sendErrorMail($msg);
        }
    }
}