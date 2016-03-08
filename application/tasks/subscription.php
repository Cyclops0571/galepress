<?php

class Subscription_Task
{
    public function run()
    {
        try {
            //android ve iphone kullanicilarinin receiptlerine bakip
            //subscriptioni cancel olmus olan var mi ona bakacagim...
            /** @var Client[] $clientSet */
            $clientSet = Client::where('SubscriptionChecked', '=', 0)
                ->where('PaidUntil', '>', date('Y-m-d H:i:s', strtotime('-3 day')))
                ->where('PaidUntil', '<', date('Y-m-d H:i:s', strtotime('+1 day')))
                ->where('SubscriptionChecked', '<', 4)
                ->get();

            foreach ($clientSet as $client) {
                $client->CheckReceiptCLI();
            }
        } catch (Exception $e) {
            $msg = __('common.task_message', array(
                    'task' => '`SubscriptionTask`',
                    'detail' => $e->getMessage()
                )
            );
            Common::sendErrorMail($msg);
        }
    }
}