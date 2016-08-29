<?php

class PaymentUser_Task
{

    public function run()
    {
        try {
            $this->getPayment();
        } catch (Exception $e) {
            $msg = __('common.task_message', array(
                    'task' => '`BackupDatabase`',
                    'detail' => $e->getMessage()
                )
            );
            Common::sendErrorMail($msg);
        }
    }

    public function getPayment()
    {
        $WarningMailSet = array();
        /** @var PaymentAccount[] $paymentAccounts */
        $paymentAccounts = PaymentAccount::where('StatusID', '=', eStatus::Active)->get();
        foreach ($paymentAccounts as $paymentAccount) {
            $payment = new MyPayment();
            $result = $payment->paymentWithToken($paymentAccount);
            sleep(60);
            if(!empty($result)) {
                $WarningMailSet[] = $result;
            }
        }

        // <editor-fold defaultstate="collapsed" desc="Send Warning mail">
        if (!empty($WarningMailSet)) {
            Common::sendPaymentUserReminderMail($WarningMailSet);
            $msg = "Ödeme yapmayan müşteri listesi: \r\n";
            foreach ($WarningMailSet as $WarningMail) {
                $customer = Customer::find($WarningMail["customerID"]);
                $msg .= "CustomerID: " . $customer->CustomerID . " İsim: " . $customer->CustomerName
                    . " Son Ödeme Tarihi: " . date("d-m-Y", strtotime($WarningMail["last_payment_day"]))
                    . " Uyarı Mail Seviyesi: " . $WarningMail["warning_mail_phase"]
                    . " Hata Sebebi:" . $WarningMail["error_reason"] . "\r\n";
            }
            Common::sendPaymentAdminReminderMail($msg);
        }
        // </editor-fold>

    }

}
