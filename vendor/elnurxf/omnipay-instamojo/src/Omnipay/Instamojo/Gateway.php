<?php

namespace Omnipay\Instamojo;

use Omnipay\Common\AbstractGateway;

/**
 * Class Gateway
 * @package Omnipay\Instamojo
 * @link https://docs.instamojo.com/docs/payments-api
 */
class Gateway extends AbstractGateway
{
    /**
     * @return string
     */
    public function getName()
    {
        return 'Instamojo';
    }

    /**
     * @return array
     */
    public function getDefaultParameters()
    {
        return array(
            'api_key'    => '',
            'auth_token' => '',
            'salt'       => '',
        );
    }

    /**
     * @return mixed
     */
    public function getSalt()
    {
        return $this->getParameter('salt');
    }

    /**
     * @param $value
     * @return $this
     */
    public function setSalt($value)
    {
        return $this->setParameter('salt', $value);
    }

    /**
     * @return mixed
     */
    public function getApiKey()
    {
        return $this->getParameter('api_key');
    }

    /**
     * @param $value
     * @return $this
     */
    public function setApiKey($value)
    {
        return $this->setParameter('api_key', $value);
    }

    /**
     * @return mixed
     */
    public function getAuthToken()
    {
        return $this->getParameter('auth_token');
    }

    /**
     * @param $value
     * @return $this
     */
    public function setAuthToken($value)
    {
        return $this->setParameter('auth_token', $value);
    }

    /**
     * @param array $parameters
     * @return \Omnipay\Common\Message\AbstractRequest
     */
    public function purchase(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Instamojo\Message\PurchaseRequest', $parameters);
    }

    /**
     * @param array $parameters
     * @return \Omnipay\Common\Message\AbstractRequest
     */
    public function completePurchase(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Instamojo\Message\CompletePurchaseRequest', $parameters);
    }

    /**
     * @param array $parameters
     * @return \Omnipay\Common\Message\AbstractRequest
     */
    public function refund(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Instamojo\Message\RefundRequest', $parameters);
    }

    /**
     * @param array $parameters
     * @return \Omnipay\Common\Message\AbstractRequest
     */
    public function fetchPaymentRequest(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Instamojo\Message\FetchPaymentRequest', $parameters);
    }

    /**
     * Handle notification callback.
     *
     * @param array $parameters
     * @return \Omnipay\Common\Message\AbstractRequest
     */
    public function acceptNotification(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Instamojo\Message\NotifyRequest', $parameters);
    }
}
