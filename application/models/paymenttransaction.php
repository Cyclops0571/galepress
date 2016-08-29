<?php

/**
 * @property int $PaymentTransactionID Description
 * @property int $PaymentAccountID Description
 * @property int $CustomerID Description
 * @property int $transaction_id Description
 * @property int $transaction_token Description
 * @property int $external_id Description
 * @property int $reference_id Description
 * @property int $state Description
 * @property int $amount Description
 * @property int $currency Description
 * @property int $request Description
 * @property int $response Description
 * @property int $response3d Description
 * @property int $paid Description
 * @property int $mail_send Description
 * @property int $errorCode Description
 * @property int $errorMessage Description
 * @property int $errorGroup Description
 * @method  static PaymentTransaction find(int $id)
 */
class PaymentTransaction extends Eloquent {

	public static $table = 'PaymentTransaction';
	public static $key = 'PaymentTransactionID';
	
	/**
	 * 
	 * @return PaymentAccount
	 */
	public function PaymentAccount() {
            return $this->belongs_to('PaymentAccount', 'PaymentAccountID')->first();
	}

    /**
     * @param \Iyzipay\Model\BasicPayment|\Iyzipay\Model\BasicThreedsPayment $basicPayment
     */
	public function updateTransaction($basicPayment) {
        $this->response = $basicPayment->getRawResult();
        $this->transaction_id = $basicPayment->getPaymentTransactionId();
        $this->external_id = $basicPayment->getPaymentId();
        $this->state = $basicPayment->getStatus();
        $this->amount = $basicPayment->getPaidPrice();
        $this->currency = $basicPayment->getCurrency();
        $this->paid = (int)($basicPayment->getStatus() == "success");
        $this->errorCode = $basicPayment->getErrorCode();
        $this->errorMessage = $basicPayment->getErrorMessage();
        $this->errorGroup = $basicPayment->getErrorGroup();
        $this->save();
    }

    public function update3dTransaction(\Iyzipay\Model\BasicThreedsInitialize $basicThreedsInitialize) {
        $this->response3d = $basicThreedsInitialize->getRawResult();
        $this->state = $basicThreedsInitialize->getStatus();
        $this->errorCode = $basicThreedsInitialize->getErrorCode();
        $this->errorMessage = $basicThreedsInitialize->getErrorMessage();
        $this->errorGroup = $basicThreedsInitialize->getErrorGroup();
        $this->save();
    }
}
