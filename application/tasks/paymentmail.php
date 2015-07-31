<?php

class PaymentMail_Task {

    public function run() {
        try {
            $this->sendPaymentReportMail();
        } catch (Exception $e) {
            $msg = __('common.task_message', array(
                'task' => '`BackupDatabase`',
                'detail' => $e->getMessage()
                    )
            );
            Common::sendErrorMail($msg);
        }
    }

    public function sendPaymentReportMail() {
        //yeni cekilmis bir ucret var ise onu verecek
        //yeni acilmis bir account var ise onu verecek
        $yesterday = date("Y-m-d", strtotime("-1 day"));
        $today = date("Y-m-d");

        $paymentAccounts = PaymentAccount::where("created_at", "<", $today)
//			->where("created_at", ">=", $yesterday)
                ->order_by("PaymentAccountID", "DESC")
                ->get();
        $accountExcelArray = array();





//		Uygulama Adı	İçerik Adı	Toplam Dosya Boyutu (Byte)	Toplam Trafik (Byte)	
//		Online Türkce Manga	serdar test 2	62766602	NULL
//		Online Türkce Manga	serdar test 3	4164464	NULL
//		Online Türkce Manga	bilgi islem test cover image	58394	NULL
//		Online Türkce Manga	bilgi islem test cover image	0	NULL
//		Online Türkce Manga	bilgi islem test 2	45019	NULL
//		Online Türkce Manga	pdf resim crop test	44172872	NULL

        if (!empty($paymentAccounts)) {
            $accountRow = array();
            $accountRow[] = "Sirket Kodu";
            $accountRow[] = "Müşteri No";
            $accountRow[] = "Ünvan1";
            $accountRow[] = "Ünvan2";
            $accountRow[] = "Sokak ve Konut Numarası";
            $accountRow[] = "Şehir";
            $accountRow[] = "Ülke";
            $accountRow[] = "Dil";
            $accountRow[] = "Vergi Daire";
            $accountRow[] = "Vergi No";
            $accountRow[] = "Hesap";
            $accountRow[] = "Bölge"; //plaka kodu
            $accountExcelArray[] = $accountRow;
        }

        foreach ($paymentAccounts as $paymentAccount) {
            $paymentAccount instanceof PaymentAccount;
            $city = $paymentAccount->city();

            $accountRow = array();
            $accountRow[] = 1000 + $paymentAccount->PaymentAccountID; //Sirket Kodu
            $accountRow[] = ""; //Müşteri No
            $accountRow[] = $paymentAccount->title; //unvan1
            $accountRow[] = ""; //unvan2
            $accountRow[] = $paymentAccount->address; //Sokak ve Konut Numarası
            $accountRow[] = $city->CityName; //sehir
            $accountRow[] = "Türkiye"; //ulke
            $accountRow[] = "tr"; //dil
            if ($paymentAccount->kurumsal) {
                $accountRow[] = $paymentAccount->vergi_dairesi; //bireysel mi 
                $accountRow[] = $paymentAccount->vergi_no; //bireysel mi 
                $accountRow[] = ""; //bireysel mi 
            } else {
                $accountRow[] = ""; //bireysel mi 
                $accountRow[] = ""; //bireysel mi 
                $accountRow[] = $paymentAccount->tckn; //bireysel mi 
            }
            $accountRow[] = $city->CityID; //bireysel mi 
            $accountExcelArray[] = $accountRow;
        }
        $paymentTransactions = PaymentTransaction::where("created_at", "<", $today)
                ->where('state', '=', 'paid')
                ->where('amount', '>', 0)
                ->order_by("PaymentAccountID")
                ->get();

        $transactionExcelArray = array();
        if (!empty($paymentTransactions)) {
            $transactionRow = array();
            $transactionRow[] = "Vergi Numarası - TCKN";
            $transactionRow[] = "Müşteri Ünvanı";
            $transactionRow[] = "Kontrat başlangıç tarihi";
            $transactionRow[] = "Kontrat bitiş tarihi";
            $transactionRow[] = "Aylık kontrat değeri";
            $transactionRow[] = "Para birimi";
            $transactionRow[] = "Fatura Vade";
            $transactionExcelArray[] = $transactionRow;
        }

        foreach ($paymentTransactions as $paymentTransaction) {
            $paymentTransaction instanceof PaymentTransaction;
            $paymentAccount = $paymentTransaction->PaymentAccount();
            $transactionRow = array();
            if ($paymentAccount->kurumsal) {
                $transactionRow[] = $paymentAccount->vergi_no;
            } else {
                $transactionRow[] = $paymentAccount->tckn;
            }
            $transactionRow[] = $paymentAccount->title; //unvan
            $transactionRow[] = date("Y-m-d", strtotime($paymentAccount->created_at)); //kontrat baslangic
            $transactionRow[] = date("Y-m-d", strtotime("+12 month " . $paymentAccount->created_at)); //kontrat bitis
            $transactionRow[] = $paymentTransaction->amount; //Aylik Kontrat degeri
            $transactionRow[] = "YTL"; //Para Birimi
            $transactionRow[] = date("Y-m-d"); //Fatura Vade
            $transactionExcelArray[] = $transactionRow;
        }

        if (!empty($accountExcelArray) || !empty($transactionExcelArray)) {
            //mail gonder...
            $accountExcelFile = "";
            $transactionExcelFile = "";
            if (!empty($accountExcelArray)) {
                $accountExcelFileName = date("Y_m_d") . "account.xls";
                $accountExcelFile = path("storage") . "/excel/" . $accountExcelFileName;
                Common::toExcel($accountExcelArray, $accountExcelFile);
            }
            if (!empty($transactionExcelArray)) {
                $transactionExcelFileName = date("Y_m_d") . "transaction.xls";
                $transactionExcelFile = path("storage") . "/excel/" . $transactionExcelFileName;
                Common::toExcel($transactionExcelArray, $transactionExcelFile);
            }

            // <editor-fold defaultstate="collapsed" desc="old_Version Mail code">
            if(!empty($accountExcelFile) || !empty($transactionExcelFile)) {
                $subject = __('common.task_success_subject');
                $msg = "Excel Filelari listededir";
                try{
                    Bundle::start('messages');
                    Message::send(function($m) use($subject, $msg, $accountExcelFile, $transactionExcelFile) {
                        $m->from(Config::get('custom.admin_email'), Config::get('custom.mail_displayname'));
                        $m->to(Config::get('custom.admin_email'));
                        $m->subject($subject);
                        $m->body($msg);
    //                    if(!empty($accountExcelFile)) {
    //                        $m->attach($accountExcelFile);
    //                    }
    //                    if(!empty($transactionExcelFile)) {
    //                        $m->attach($transactionExcelFile);
    //                    }
                    });
                    
                } catch (Exception $ex) {
                    echo $ex->getMessage();
                }
                
            }
            // </editor-fold>
        }
    }

}
