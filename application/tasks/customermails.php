<?php

class CustomerMails_Task
{

    public function run()
    {
        try {
            /////////////////////////////////////////////////////////////3. GUN
            /**************************/
            /*************kayittan 3 gun sonra pdf yuklemis deneme musterilerine tutorial mailini gonder.*************/
            $apps = DB::table('Application AS a')
                ->left_join('Content AS c', function ($join) {
                    $join->on('c.ApplicationID', '=', 'a.ApplicationID');
                    $join->on('a.StatusID', '=', DB::raw(eStatus::Active));
                })
                ->where(function ($query) {
                    $query->where('a.Trail', '=', 1);
                    $query->where('a.StartDate', '=', DB::raw('CURDATE()-3'));
                    $query->where('c.ContentID', 'IS NOT', DB::raw('null'));
                })
                ->select(array(
                        'a.ApplicationID',
                        'a.CustomerID',
                        'c.ContentID')
                )
                ->group_by('a.ApplicationID')
                ->get();
            $this->sendMail($apps, "Tutorial", View::make('mail-templates.tutorial.index')->render(), "serdar.saygili@detaysoft.com", 3);
            /**************************/
            /*************kayittan 3 gun sonra pdf yuklemis deneme musterilerine tutorial mailini gonder.*************/

            /**************************/
            /*************kayittan 3 gun sonra pdf YUKLEMEMIS deneme musterilerine webinar mailini gonder.*************/
            $apps = DB::table('Application AS a')
                ->left_join('Content AS c', function ($join) {
                    $join->on('c.ApplicationID', '=', 'a.ApplicationID');
                    $join->on('a.StatusID', '=', DB::raw(eStatus::Active));
                })
                ->where(function ($query) {
                    $query->where('a.Trail', '=', 1);
                    $query->where('a.StartDate', '=', DB::raw('CURDATE()-3'));
                    $query->where('c.ContentID', 'IS', DB::raw('null'));
                })
                ->select(array(
                        'a.ApplicationID',
                        'a.CustomerID',
                        'c.ContentID')
                )
                ->group_by('a.ApplicationID')
                ->get();
            $this->sendMail($apps, "Webinar", View::make('mail-templates.webinar.index')->render(), "serdar.saygili@detaysoft.com", 4);
            /**************************/
            /*************kayittan 3 gun sonra pdf YUKLEMEMIS deneme musterilerine webinar mailini gonder.*************/

            /////////////////////////////////////////////////////////////5. GUN
            /**************************/
            /*************kayittan 5 gun sonra pdf yuklemis deneme musterilerine webinar mailini gonder.*************/
            $apps = DB::table('Application AS a')
                ->left_join('Content AS c', function ($join) {
                    $join->on('c.ApplicationID', '=', 'a.ApplicationID');
                    $join->on('a.StatusID', '=', DB::raw(eStatus::Active));
                })
                ->where(function ($query) {
                    $query->where('a.Trail', '=', 1);
                    $query->where('a.StartDate', '=', DB::raw('CURDATE()-5'));
                    $query->where('c.ContentID', 'IS NOT', DB::raw('null'));
                })
                ->select(array(
                        'a.ApplicationID',
                        'a.CustomerID',
                        'c.ContentID')
                )
                ->group_by('a.ApplicationID')
                ->get();
            $this->sendMail($apps, "Webinar", View::make('mail-templates.webinar.index')->render(), "serdar.saygili@detaysoft.com", 4);
            /**************************/
            /*************kayittan 5 gun sonra pdf yuklemis deneme musterilerine webinar mailini gonder.*************/

            /*************kayittan 5 gun sonra pdf YUKLEMEMIS deneme musterilerine 'Try Period Ending After 2 Days' mailini gonder.*************/
            $apps = DB::table('Application AS a')
                ->left_join('Content AS c', function ($join) {
                    $join->on('c.ApplicationID', '=', 'a.ApplicationID');
                    $join->on('a.StatusID', '=', DB::raw(eStatus::Active));
                })
                ->where(function ($query) {
                    $query->where('a.Trail', '=', 1);
                    $query->where('a.StartDate', '=', DB::raw('CURDATE()-5'));
                    $query->where('c.ContentID', 'IS', DB::raw('null'));
                })
                ->select(array(
                        'a.ApplicationID',
                        'a.CustomerID',
                        'c.ContentID')
                )
                ->group_by('a.ApplicationID')
                ->get();
            $this->sendMail($apps, "Try Period Ending After 2 Days", View::make('mail-templates.tryending2days.index')->render(), "serdar.saygili@detaysoft.com", 5);
            /**************************/
            /*************kayittan 5 gun sonra pdf YUKLEMEMIS deneme musterilerine 'Try Period Ending After 2 Days' mailini gonder.*************/

            /////////////////////////////////////////////////////////////6. GUN
            /**************************/
            /*************kayittan 6 gun sonra deneme musterilerine new features mailini gonder.*************/
            $apps = DB::table('Application')
                ->where(function ($query) {
                    $query->where('Trail', '=', 1);
                    $query->where('StartDate', '=', DB::raw('CURDATE()-6'));
                })
                ->where('StatusID', '=', 1)
                ->group_by('ApplicationID')
                ->select(array(
                    'ApplicationID',
                    'CustomerID'
                ))
                ->get();
            $this->sendMail($apps, "New Features", View::make('mail-templates.newfeature.index')->render(), "serdar.saygili@detaysoft.com", 6);
            /**************************/
            /*************kayittan 6 gun sonra deneme musterilerine new features mailini gonder.*************/

            /////////////////////////////////////////////////////////////7. GUN
            /**************************/
            /*************kayittan 7 gun sonra deneme musterilerine 'Try Period Ending Today' mailini gonder.*************/
            $apps = DB::table('Application')
                ->where(function ($query) {
                    $query->where('Trail', '=', 1);
                    $query->where('StartDate', '=', DB::raw('CURDATE()-7'));
                })
                ->where('StatusID', '=', 1)
                ->group_by('ApplicationID')
                ->select(array(
                    'ApplicationID',
                    'CustomerID'
                ))
                ->get();
            $this->sendMail($apps, "Try Ending Today", View::make('mail-templates.tryendingtoday.index')->render(), "serdar.saygili@detaysoft.com", 7);
            /**************************/
            /*************kayittan 7 gun sonra deneme musterilerine 'Try Period Ending Today' mailini gonder.*************/

            /////////////////////////////////////////////////////////////8. GUN
            /**************************/
            /*************kayittan 8 gun sonra deneme musterilerine 'Feedback' mailini gonder.*************/
            $apps = DB::table('Application')
                ->where(function ($query) {
                    $query->where('Trail', '=', 1);
                    $query->where('StartDate', '=', DB::raw('CURDATE()-8'));
                })
                ->where('StatusID', '=', 1)
                ->group_by('ApplicationID')
                ->select(array(
                    'ApplicationID',
                    'CustomerID'
                ))
                ->get();
            $this->sendMail($apps, "Feedback", View::make('mail-templates.feedback.index')->render(), "serdar.saygili@detaysoft.com", 8);
            /**************************/
            /*************kayittan 8 gun sonra deneme musterilerine 'Feedback' mailini gonder.*************/

        } catch (Exception $e) {
            // Log::info($e->getMessage());
            $msg = __('common.task_message', array(
                    'task' => '`PushWarningMail`',
                    'detail' => $e->getMessage()
                )
            );

            Common::sendErrorMail($msg);
        }
    }

    function sendMail($apps, $subjectName, $view, $userEmail, $mailID)
    {
        foreach ($apps as $app) {
            $users = DB::table('User')
                ->where('CustomerID', '=', $app->CustomerID)
                ->where('StatusID', '=', 1)
                ->get();
            foreach ($users as $user) {
                $subject = $subjectName;
                $msg = $view;
                $mailStatus = Common::sendHtmlEmail($userEmail, $user->FirstName . ' ' . $user->LastName, $subject, $msg);

                $m = new MailLog();
                $m->MailID = $mailID; //MailType
                $m->UserID = $user->UserID;
                if (!$mailStatus) {
                    $m->Arrived = 0;
                } else {
                    $m->Arrived = 1;
                }
                $m->StatusID = eStatus::Active;
                $m->save();
            }
        }
    }
}