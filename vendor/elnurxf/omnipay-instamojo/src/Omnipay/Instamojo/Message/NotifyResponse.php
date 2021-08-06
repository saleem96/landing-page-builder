<?php

namespace Omnipay\Instamojo\Message;

/**
 * Class NotifyResponse
 * @package Omnipay\Instamojo\Message
 */
class NotifyResponse extends Response
{

    /**
     * @return bool
     */
    public function isSuccessful()
    {
        return !empty($this->data['status']);
    }

    /**
     * @return mixed
     */
    public function getTransactionReference()
    {
        if (isset($this->data['payment_id'])) {
            return $this->data['payment_id'];
        }

        return null;
    }

    /**
     * Was the transaction successful?
     *
     * @return string Transaction status, one of {@see STATUS_COMPLETED}, {@see #STATUS_PENDING},
     * or {@see #STATUS_FAILED}.
     */
    public function getTransactionStatus()
    {
        if (isset($this->data['status']) && 'Credit' == $this->data['status']) {
            return static::STATUS_COMPLETED;
        }

        return static::STATUS_FAILED;
    }

    /**
     * @return mixed
     */
    public function getAmount()
    {
        if (isset($this->data['amount'])) {
            return $this->data['amount'];
        }

        return null;
    }

}
