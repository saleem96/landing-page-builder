<?php

namespace Omnipay\Instamojo\Message;

/**
 * Class RefundResponse
 * @package Omnipay\Instamojo\Message
 */
class RefundResponse extends Response
{

    const STATUS_REFUNDED = 'refunded';

    /**
     * @return mixed
     */
    public function getTransactionReference()
    {
        if (isset($this->data['refund']['payment_id'])) {
            return $this->data['refund']['payment_id'];
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
        if (isset($this->data['refund']['status'])) {
            switch ($this->data['refund']['status']) {
                case 'Refunded':
                    return static::STATUS_REFUNDED;
                case 'Pending':
                    return static::STATUS_PENDING;
            }
        }

        return static::STATUS_FAILED;
    }

    /**
     * @return mixed
     */
    public function getAmount()
    {
        if (isset($this->data['refund']['refund_amount'])) {
            return $this->data['refund']['refund_amount'];
        }

        return null;
    }

}
