<?php

class PaymentUser_Task {

    public function run()
    {
		try
		{
			$this->getPayment();
		}
		catch (Exception $e)
		{
			$msg = __('common.task_message', array(
					'task' => '`BackupDatabase`',
					'detail' => $e->getMessage()
					)
				);
			Common::sendErrorMail($msg);
		}
    }

	
	public function getPayment() {
		$paymentAccounts = PaymentAccount::all();
		foreach($paymentAccounts as $paymentAccount) {
			$paymentAccount instanceof PaymentAccount;
			if($paymentAccount->payment_count < 12) {
				//tam olarak gununde mailler gitmeli ve bu program calismali...
				if(date("Y-m-d") == date('Y-m-d', strtotime("+1 mounth", $paymentAccount->last_payment_day))) {
					//todo kredi karti ise cekmeyi dene
					//cekemedin ise mail at hatirlatma yap...
				}
				
				
			}
		}
		
		
		
	}
	
}