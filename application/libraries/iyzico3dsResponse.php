<?php

/**
 * Created by PhpStorm.
 * User: p1027
 * Date: 29.08.2016
 * Time: 16:33
 */
class iyzico3dsResponse
{
    public $status;
    public $paymentId;
    public $conversationData;
    public $conversationId;
    public $mdStatus;
    public function __construct($result)
    {
        $this->status = $result['status'];
        $this->paymentId = (int)$result['paymentId'];
        $this->conversationData = $result['conversationData'];
        $this->conversationId = (int)$result['conversationId'];
        $this->mdStatus = $result['mdStatus'];
    }

}