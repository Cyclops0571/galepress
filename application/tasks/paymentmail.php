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
		$paymentAccounts = PaymentAccount::where("created_at", ">=", $yesterday)
				->where("created_at", "<", $today)
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
			$accountRow[] = "Müşteri No";
			$accountRow[] = "Sirket Kodu";
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
			$accountRow[] = NULL;
			$accountRow[] = 1000 + $paymentAccount->PaymentAccountID;
			$accountRow[] = $paymentAccount->title;
			$accountRow[] = NULL; //unvan2
			$accountRow[] = $paymentAccount->address; //Sokak ve Konut Numarası
			$accountRow[] = $city->CityName;
			$accountRow[] = "Türkiye";
			$accountRow[] = "tr";
			if ($paymentAccount->kurumsal) {
				$accountRow[] = $paymentAccount->vergi_dairesi; //bireysel mi 
				$accountRow[] = $paymentAccount->vergi_no; //bireysel mi 
			} else {
				$accountRow[] = NULL; //bireysel mi 
				$accountRow[] = $paymentAccount->tckn; //bireysel mi 
			}
			$accountRow[] = $city->CityID; //bireysel mi 
			$accountExcelArray[] = $accountRow;
		}


		$paymentTransactions = PaymentTransaction::where("created_at", ">=", $yesterday)
				->where("created_at", "<", $today)
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
		
		foreach($paymentTransactions as $paymentTransaction) {
			$paymentTransaction instanceof PaymentTransaction;
			$paymentAccount = $paymentTransaction->PaymentAccount();
			$transactionRow = array();
			if($paymentAccount->kurumsal) {
				$transactionRow[] = $paymentAccount->vergi_no;
			} else {
				$transactionRow[] = $paymentAccount->tckn;
			}
			$transactionRow[] = $paymentAccount->title; //unvan
			$transactionRow[] = date("Y-m-d", strtotime($paymentAccount->created_at)); //kontrat baslangic
			$transactionRow[] = date("Y-m-d", strtotime("+12 month", $paymentAccount->created_at)); //kontrat bitis
			$transactionRow[] = 100; //Aylik Kontrat degeri
			$transactionRow[] = "YTL"; //Para Birimi
			$transactionRow[] = date("Y-m-d"); //Fatura Vade
			$transactionExcelArray[] = $transactionRow;
		}
		
		if(!empty($accountExcelArray) || !empty($transactionExcelArray)) {
			//mail gonder...
			$accountExcelFile = path("storage") . "/excel/" . date("Y_m_d") .  "account.xls";
			$transactionExcelFile = path("storage") . "/excel/" . date("Y_m_d") .  "transaction.xls";
			if(!empty($accountExcelArray)) {
				Common::toExcel($accountExcelArray, $accountExcelFile);
			}
			if(!empty($transactionExcelArray)) {
				Common::toExcel($transactionExcelArray, $transactionExcelFile);
			}
			
			
			
			
					// <editor-fold defaultstate="collapsed" desc="old_Version Mail code">
		
		$email = Config::get('custom.admin_email');
		$subject = __('common.task_success_subject');

		// file compression details ##
		$mime = 'application/gzip';
		
		// email compressed file as inline attachment ##
		$headers = "From: ".Config::get('custom.mail_email')." <".Config::get('custom.mail_displayname').">";

		// Generate a boundary string ##
		$rnd_str = md5(time()); 
		$mime_boundary = "==Multipart_Boundary_x{$rnd_str}x"; 

		// Add headers for file attachment ##
		$headers .= "\nMIME-Version: 1.0\n" . 
			"Content-Type: multipart/mixed;\n" . 
			" boundary=\"{$mime_boundary}\"";

		// Add a multipart boundary above the plain message ##
		$body = "This is a multi-part message in MIME format.\n\n" . 
			"--{$mime_boundary}\n" . 
			"Content-Type: text/plain; charset=\"iso-8859-1\"\n" . 
			"Content-Transfer-Encoding: 7bit\n\n";

		// make Base64 encoding for file data ##
		$data = chunk_split(base64_encode(file_get_contents($path.$backup)));

		// Add file attachment to the message ##
		$body .= "--{$mime_boundary}\n" . 
			"Content-Type: {$mime};\n" . 
			" name=\"{$backup}\"\n" . 
			"Content-Disposition: attachment;\n" . 
			" filename=\"{$backup}\"\n" . 
			"Content-Transfer-Encoding: base64\n\n" . 
			$data . "\n\n" . 
			"--{$mime_boundary}--\n";

		// send ##
		$res = mail( $email, $subject, $body, $headers );
		

		// check mail status ##
		if ( !$res ) {
			throw new Exception('FAILED to exel files.');
		}

		// </editor-fold>
		} 
		
	}

}
