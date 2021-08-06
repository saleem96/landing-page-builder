<?php

namespace Omnipay\Instamojo\Message;

/**
 * Class CompletePurchaseResponse
 * @package Omnipay\Instamojo\Message
 */
class CompletePurchaseResponse extends Response
{

    /**
     * @return mixed
     */
    public function getTransactionReference()
    {
        if (isset($this->data['payment']['payment_id'])) {
            return $this->data['payment']['payment_id'];
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
        if (isset($this->data['payment']['status']) && 'Credit' == $this->data['payment']['status']) {
            return static::STATUS_COMPLETED;
        }

        return static::STATUS_FAILED;
    }

    /**
     * @return mixed
     */
    public function getCurrency()
    {
        if (isset($this->data['payment']['currency'])) {
            return $this->data['payment']['currency'];
        }

        return null;
    }

    /**
     * @return mixed
     */
    public function getAmount()
    {
        if (isset($this->data['payment']['amount'])) {
            return $this->data['payment']['amount'];
        }

        return null;
    }

    /**
     * @return mixed
     */
    public function getBankFees()
    {
        if (isset($this->data['payment']['fees'])) {
            return $this->data['payment']['fees'];
        }

        return null;
    }

}
