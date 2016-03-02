<?php

class UpdateSize_Task
{

    public function run()
    {
        try {
            $arr = array();

            $cs = DB::table('Customer')
                ->where('StatusID', '=', eStatus::Active)
                ->get();
            foreach ($cs as $c) {
                $as = DB::table('Application')
                    ->where('CustomerID', '=', $c->CustomerID)
                    ->where('StatusID', '=', eStatus::Active)
                    ->get();
                foreach ($as as $a) {
                    $cts = DB::table('Content')
                        ->where('ApplicationID', '=', $a->ApplicationID)
                        ->where('StatusID', '=', eStatus::Active)
                        ->get();
                    foreach ($cts as $ct) {
                        $cfs = DB::table('ContentFile')
                            ->where('ContentID', '=', $ct->ContentID)
                            ->where('StatusID', '=', eStatus::Active)
                            ->get();
                        foreach ($cfs as $cf) {
                            //each contentfile
                            $size = 0;
                            $path = path('public') . 'files/customer_' . $c->CustomerID . '/application_' . $a->ApplicationID . '/content_' . $ct->ContentID . '/file_' . $cf->ContentFileID;
                            if (File::exists($path)) {
                                $size = Common::dirsize($path);
                            }
                            array_push($arr, array('contentfile', $cf->ContentFileID, $size));
                        }
                        //each content
                        $size = 0;
                        $path = path('public') . 'files/customer_' . $c->CustomerID . '/application_' . $a->ApplicationID . '/content_' . $ct->ContentID;
                        if (File::exists($path)) {
                            $size = Common::dirsize($path);
                        }
                        array_push($arr, array('content', $ct->ContentID, $size));
                    }
                    //each application;
                    $size = 0;
                    $path = path('public') . 'files/customer_' . $c->CustomerID . '/application_' . $a->ApplicationID;
                    if (File::exists($path)) {
                        $size = Common::dirsize($path);
                    }
                    array_push($arr, array('application', $a->ApplicationID, $size));
                }
                //each customer;
                $size = 0;
                $path = path('public') . 'files/customer_' . $c->CustomerID;
                if (File::exists($path)) {
                    $size = Common::dirsize($path);
                }
                array_push($arr, array('customer', $c->CustomerID, $size));
            }

            //update tables
            DB::transaction(function () use ($arr) {
                foreach ($arr as $a) {
                    if ($a[0] == 'customer') {
                        $c = Customer::find((int)$a[1]);
                        $c->TotalFileSize = (int)$a[2];
                        $c->save();
                    } elseif ($a[0] == 'application') {
                        $c = Application::find((int)$a[1]);
                        $c->TotalFileSize = (int)$a[2];
                        $c->save();
                    } elseif ($a[0] == 'content') {
                        $c = Content::find((int)$a[1]);
                        $c->TotalFileSize = (int)$a[2];
                        $c->save();
                    } elseif ($a[0] == 'contentfile') {
                        $c = ContentFile::find((int)$a[1]);
                        $c->TotalFileSize = (int)$a[2];
                        $c->save();
                    }
                }
            });
        } catch (Exception $e) {
            $msg = __('common.task_message', array(
                    'task' => '`UpdateSize`',
                    'detail' => $e->getMessage()
                )
            );

            Common::sendErrorMail($msg);
        }
    }
}