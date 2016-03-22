<?php

class PushWarningMail_Task
{

    public function run()
    {
        try {
            /** @var Application[] $apps */
            $apps = Application::where(function ($query) {
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
                    $toEmail = array(
                        "info@galepress.com",
                        $user->Email
                    );
                    $subject = __('maillang.subscription_expire_notice_subject', array(), $app->ApplicationLanguage);
                    $replacements = array(
                        'FIRSTNAME' => $user->FirstName,
                        'LASTNAME' => $user->LastName,
                        'APPLICATIONNAME' => $app->Name,
                        'REMAINIGDAYS' => $diff->days
                    );
                    if ($diff->days > 0) {
                        $msg = __('maillang.subscription_expire_notice_15days_body', $replacements, $app->ApplicationLanguage);
                    } else {
                        $msg = __('maillang.subscription_expire_notice_0days_body', $replacements, $app->ApplicationLanguage);
                    }

                    Bundle::start('messages');

                    Message::send(function ($m) use ($toEmail, $subject, $msg) {
                        $m->from((string)__('maillang.contanct_email'), Config::get('custom.mail_displayname'));
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