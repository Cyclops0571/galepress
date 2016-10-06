<?php

class CreateInteractivePDF_Task
{

    public function run()
    {
//        Common::sendEmail(Config::get('custom.admin_email_set'), 'Serdar Saygili', 'Interactive Local', 'Start');
        try {
            /** @var ContentFile[] $cf */
            $cf = DB::table('ContentFile')
                ->where('Interactivity', '=', Interactivity::ProcessQueued)
                ->where(function ($query) {
                    $query->where_null('HasCreated');
                    $query->or_where('HasCreated', '<>', 1);
                })
                ->where(function ($query) {
                    $query->where_null('ErrorCount');
                    $query->or_where('ErrorCount', '<', 2);
                })
                ->where('StatusID', '=', eStatus::Active)
                ->get();

            foreach ($cf as $f) {
                try {
                    $f->createInteractivePdf();
                } catch (Exception $e) {
                    $msg = __('common.task_message', array(
                            'task' => '`CreateInteractivePDF`',
                            'detail' => $e->getMessage()
                        )
                    );
                    Common::sendErrorMail($msg);
                }
            }
        } catch (Exception $e) {
            $msg = __('common.task_message', array(
                    'task' => '`CreateInteractivePDF`',
                    'detail' => $e->getMessage()
                )
            );
            Common::sendErrorMail($msg);
        }
    }
}
