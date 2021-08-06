<?php

namespace Omnipay\Instamojo\Message;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\NotificationInterface;
use Omnipay\Common\Message\RedirectResponseInterface;

/**
 * Class Response
 * @package Omnipay\Instamojo\Message
 */
class Response extends AbstractResponse implements RedirectResponseInterface, NotificationInterface
{

    /**
     * @return bool
     */
    public function isSuccessful()
    {
        return !empty($this->data['success']);
    }

    /**
     * @return bool
     */
    public function isRedirect()
    {
        return !empty($this->data['payment_request']['longurl']);
    }

    /**
     * @return null
     */
    public function getRedirectUrl()
    {
        return $this->redirectUrl = $this->isRedirect() ? $this->data['payment_request']['longurl'] : null;
    }

    /**
     * Gateway Reference
     *
     * @return null|string A reference provided by the gateway to represent this transaction
     */
    public function getTransactionReference()
    {
        return !empty($this->data['payment_request']['id']) ? $this->data['payment_request']['id'] : null;
    }

    /**
     * Was the transaction successful?
     *
     * @return string Transaction status, one of {@see STATUS_COMPLETED}, {@see #STATUS_PENDING},
     * or {@see #STATUS_FAILED}.
     */
    public function getTransactionStatus()
    {
        return static::STATUS_PENDING;
    }

    /**
     * Response Message
     *
     * @return null|string A response message from the payment gateway
     */
    public function getMessage()
    {
        return json_encode($this->data['message']);
    }

    /**
     * @return string
     */
    public function getRedirectMethod()
    {
        return 'GET';
    }

    /**
     * @return mixed
     */
    public function getRedirectData()
    {
        return $this->getData();
    }
}
