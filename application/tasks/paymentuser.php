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
            $errorReason = "";
            //eger accounttan 1 son bir ay icinde odeme alinmis ise odeme alma.
            $lastPaymentFlag = $paymentAccount->last_payment_day < date("Y-m-d", strtotime("-1 month +1 day"));
            $installmentFlag = $paymentAccount->payment_count < $paymentAccount->Application->Installment;
            if ($paymentAccount->payment_count > 0 && $paymentAccount->ValidUntil <= date("Y-m-d") && $lastPaymentFlag && $installmentFlag) {
                //InstallmentCount buraya gelecekkkk....
                //sleep before getting blocked ...
                sleep(60);
                $paymentResult = FALSE;
                // <editor-fold defaultstate="collapsed" desc="first bin check">
                $binCheckData = array();
                $binCheckData['api_id'] = Config::get("custom.iyzico_api_id");
                $binCheckData['secret'] = Config::get("custom.iyzico_secret");
                $binCheckData['bin'] = $paymentAccount->bin;
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, Config::get("custom.iyzico_bin_check_url"));
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
                curl_setopt($ch, CURLOPT_POSTFIELDS, Common::getPostDataString($binCheckData));
                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
                //curl_setopt($ch, CURLOPT_FAILONERROR, true);
                $bincheckResponse = curl_exec($ch);
                curl_close($ch);
                // </editor-fold>

                $responseJson = json_decode($bincheckResponse, TRUE);
                if ($responseJson["status"] == "SUCCESS" && $responseJson["details"]["CARD_TYPE"] == "CREDIT CARD") {
                    $paymentUserName = "";
                    $paymentUserSurname = "";

                    $paymentUserNameSurnameSet = explode(" ", $paymentAccount->holder);
                    if (count($paymentUserNameSurnameSet) >= 2) {
                        for ($i = 0; $i < count($paymentUserNameSurnameSet) - 1; $i++) {
                            $paymentUserName = empty($paymentUserName) ? $paymentUserNameSurnameSet[$i] : $paymentUserName . " " . $paymentUserNameSurnameSet[$i];
                        }
                        $paymentUserSurname = $paymentUserNameSurnameSet[count($paymentUserNameSurnameSet) - 1];
                    }
                    $paymentTransaction = new PaymentTransaction();
                    $paymentTransaction->PaymentAccountID = $paymentAccount->PaymentAccountID;
                    $paymentTransaction->CustomerID = $paymentAccount->CustomerID;
                    $paymentTransaction->save();

                    $postData['api_id'] = Config::get("custom.iyzico_api_id");
                    $postData['secret'] = Config::get("custom.iyzico_secret");
                    $postData['response_mode'] = "SYNC";
                    $postData['mode'] = Config::get("custom.payment_environment");
                    $postData['external_id'] = $paymentTransaction->PaymentTransactionID;
                    $postData['customer_first_name'] = $paymentUserName;
                    $postData['customer_last_name'] = $paymentUserSurname;
                    $postData['customer_company_name'] = "iyzico";
                    $postData['customer_contact_email'] = $paymentAccount->email;
                    $postData['customer_contact_mobile'] = str_replace(array(" ", "-", "(", ")"), "", $paymentAccount->phone);
                    $postData['customer_language'] = 'tr';
                    $postData['customer_presentation_usage'] = 'GalepressAylikOdeme_' . date('YmdHisu');
                    $postData['descriptor'] = 'GalepressAylikOdeme_' . date('YmdHisu');
                    $postData['type'] = "DB";

                    $application = $paymentAccount->Application;
                    $paymentAmount = $application->Price * 1.18;
                    $postData['amount'] = (int)($paymentAmount * 100);
                    $postData['card_token'] = $paymentAccount->card_token;
                    $postData['card_expiry_year'] = $paymentAccount->expiry_year;
                    $postData['card_expiry_month'] = $paymentAccount->expiry_month;
                    $postData['card_verification'] = $paymentAccount->card_verification;
                    $postData['installment_count'] = NULL;
                    $postData['currency'] = "TRY";
                    $postData['descriptor'] = 'GalepressAylikOdeme_' . date('YmdHisu');
                    $postData['card_register'] = 1;
                    $postData['card_brand'] = $paymentAccount->brand;
                    $postData['card_holder_name'] = $paymentAccount->holder;
                    $postData['connector_type'] = "Garanti";
                    $postData['customer_contact_ip'] = "127.0.0.1";

                    $paymentTransaction->request = json_encode($postData);
                    $paymentTransaction->save();

                    //do the request then
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, Config::get('custom.iyzico_url'));
                    curl_setopt($ch, CURLOPT_POST, 1);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, Common::getPostDataString($postData));
                    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
                    $paymentResponse = curl_exec($ch);
                    curl_close($ch);
                    $transaction = json_decode($paymentResponse, TRUE);

                    $paymentTransaction->response = $paymentResponse;
                    if (isset($transaction['transaction']['state']) && strpos($transaction['transaction']['state'], "paid") !== FALSE) {
                        //paid
                        //increment the payment count
                        //update the last payment date
                        //success
                        $paymentResult = TRUE;
                        $paymentAccount->payment_count = $paymentAccount->payment_count + 1;
                        $paymentAccount->last_payment_day = date("Y-m-d");
                        $paymentAccount->WarningMailPhase = 0;
                        $paymentAccount->save();

                        $paymentTransaction->transaction_id = $transaction['transaction']['transaction_id'];
                        $paymentTransaction->external_id = $transaction['transaction']['external_id'];
                        $paymentTransaction->reference_id = $transaction['transaction']['reference_id'];
                        $paymentTransaction->state = $transaction['transaction']['state'];
                        $paymentTransaction->amount = $transaction['transaction']['amount'];
                        $paymentTransaction->currency = $transaction['transaction']['currency'];
                        $paymentTransaction->paid = 1;
                        $paymentTransaction->save();
                        Common::sendPaymentUserSuccesMail($paymentAccount->holder, $paymentAccount->email, $paymentAmount);
                    } else {
                        //not paid
                        $paymentTransaction->PaymentAccountID = $paymentAccount->PaymentAccountID;
                        $paymentTransaction->CustomerID = $paymentAccount->CustomerID;
                        if (isset($transaction['transaction'])) {
                            $paymentTransaction->transaction_id = $transaction['transaction']['transaction_id'];
                            $paymentTransaction->external_id = $transaction['transaction']['external_id'];
                            $paymentTransaction->reference_id = $transaction['transaction']['reference_id'];
                            $paymentTransaction->state = $transaction['transaction']['state'];
                        }
                        $paymentTransaction->save();
                        $errorReason = !empty($transaction["response"]["error_message_tr"]) ? $transaction["response"]["error_message_tr"] : $transaction["response"]["error_message"];
                    }
                }

                // <editor-fold defaultstate="collapsed" desc="prepare warning mail list">
                if (!$paymentResult) {
                    //mail it to user,
                    $paymentAccount->WarningMailPhase++;
                    if ($paymentAccount->WarningMailPhase < 3) {
                        $paymentAccount->save();
                    }

                    $userInfoSet = array();
                    $userInfoSet["customerID"] = $paymentAccount->CustomerID;
                    $userInfoSet["error_reason"] = $errorReason;
                    $userInfoSet["email"] = $paymentAccount->email;
                    $userInfoSet["name_surname"] = $paymentAccount->holder;
                    $userInfoSet["last_payment_day"] = $paymentAccount->last_payment_day;
                    $userInfoSet["warning_mail_phase"] = $paymentAccount->warning_mail_phase;
                    $WarningMailSet[] = $userInfoSet;
                }
                // </editor-fold>
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
