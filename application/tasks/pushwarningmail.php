<?php

class PushWarningMail_Task
{

    public function run()
    {
        try {
            $apps = DB::table('Application')
                ->where(function ($query) {
                    $query->where('ExpirationDate', '=', DB::raw('CURDATE()+15')); //son 15
                    $query->or_where('ExpirationDate', '=', DB::raw('CURDATE()+7')); //son hafta
                    $query->or_where('ExpirationDate', '=', DB::raw('CURDATE()')); //son gun
                })
                ->where('StatusID', '=', 1)
                ->get();

            foreach ($apps as $app) {
                $currentDate = date("Y-m-d");
                $date1 = new DateTime($app->ExpirationDate);
                $date2 = new DateTime($currentDate);

                $diff = $date1->diff($date2);

                $users = DB::table('User')
                    ->where('CustomerID', '=', $app->CustomerID)
                    ->where('StatusID', '=', 1)
                    ->get();
                foreach ($users as $user) {
                    //$toEmail = "info@galepress.com"; //$user->Email;
                    $toEmail = array(
                        "info@galepress.com",
                        $user->Email
                    );
                    $subject = "Uygulamanızın Geçerlilik Süresi Sonlanmak Üzere"; //__('common.task_subject');
                    //$subject = __('common.task_subject');
                    //$subject = str_replace(':pass', $diff->days, $subject);
                    if ($diff->days > 0) {
                        $msg = "Sayın " . $user->FirstName . " " . $user->LastName . ",\n" . $app->Name . " uygulamanızın geçerlilik süresinin sonlanmasına " . $diff->days . " gün kaldı.\n\nSaygılarımızla,\nGalePress";
                    } else {
                        $msg = "Sayın " . $user->FirstName . " " . $user->LastName . ",\n" . $app->Name . " uygulamanızın geçerlilik süresi bugün sonlanacaktır.\n\nSaygılarımızla,\nGalePress";
                    }

                    Bundle::start('messages');

                    Message::send(function ($m) use ($toEmail, $subject, $msg) {
                        $m->from(Config::get('custom.mail_email'), Config::get('custom.mail_displayname'));
                        $m->to($toEmail);
                        $m->subject($subject);
                        $m->body($msg);
                    });
                }
            }
        } catch (Exception $e) {
            $msg = __('common.task_message', array(
                    'task' => '`PushWarningMail`',
                    'detail' => $e->getMessage()
                )
            );

            Common::sendErrorMail($msg);

        }
    }
}