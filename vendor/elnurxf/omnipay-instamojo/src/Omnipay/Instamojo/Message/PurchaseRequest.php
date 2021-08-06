<?php

namespace Omnipay\Instamojo\Message;

/**
 * Class PurchaseRequest
 * @package Omnipay\Instamojo\Message
 */
class PurchaseRequest extends AbstractRequest
{
    /**
     * @return array
     */
    public function getData()
    {
        $data = parent::getData();

        $this->validate('amount');
        $this->validate('purpose');

        $data['amount']                  = $this->getAmount();
        $data['purpose']                 = $this->getPurpose();
        $data['buyer_name']              = $this->getBuyerName();
        $data['email']                   = $this->getEmail();
        $data['phone']                   = $this->getPhone();
        $data['redirect_url']            = $this->getRedirectUrl();
        $data['webhook']                 = $this->getWebhook();
        $data['allow_repeated_payments'] = $this->getAllowRepeatedPayments();
        $data['send_email']              = $this->getSendEmail();
        $data['send_sms']                = $this->getSendSms();
        $data['expires_at']              = $this->getExpiresAt();

        return $data;
    }

    /**
     * @param mixed $data
     * @return Response
     */
    public function sendData($data)
    {
        $httpRequest  = $this->createRequest('POST', $this->getEndpoint() . 'payment-requests/', $data);
        $jsonResponse = $this->sendRequest($httpRequest);

        return $this->response = new Response($this, $jsonResponse);
    }

    /**
     * @return mixed
     */
    public function getPurpose()
    {
        return $this->getParameter('purpose');
    }

    /**
     * @param $value
     * @return \Omnipay\Common\Message\AbstractRequest
     */
    public function setPurpose($value)
    {
        return $this->setParameter('purpose', $value);
    }

    /**
     * @return mixed
     */
    public function getBuyerName()
    {
        return $this->getParameter('buyer_name');
    }

    /**
     * @param $value
     * @return \Omnipay\Common\Message\AbstractRequest
     */
    public function setBuyerName($value)
    {
        return $this->setParameter('buyer_name', $value);
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->getParameter('email');
    }

    /**
     * @param $value
     * @return \Omnipay\Common\Message\AbstractRequest
     */
    public function setEmail($value)
    {
        return $this->setParameter('email', $value);
    }

    /**
     * @return mixed
     */
    public function getPhone()
    {
        return $this->getParameter('phone');
    }

    /**
     * @param $value
     * @return \Omnipay\Common\Message\AbstractRequest
     */
    public function setPhone($value)
    {
        return $this->setParameter('phone', $value);
    }

    /**
     * @return mixed
     */
    public function getRedirectUrl()
    {
        return $this->getParameter('redirect_url');
    }

    /**
     * @param $value
     * @return \Omnipay\Common\Message\AbstractRequest
     */
    public function setRedirectUrl($value)
    {
        return $this->setParameter('redirect_url', $value);
    }

    /**
     * @return mixed
     */
    public function getWebhook()
    {
        return $this->getParameter('webhook');
    }

    /**
     * @param $value
     * @return \Omnipay\Common\Message\AbstractRequest
     */
    public function setWebhook($value)
    {
        return $this->setParameter('webhook', $value);
    }

    /**
     * @return bool
     */
    public function getAllowRepeatedPayments()
    {
        return (bool) $this->getParameter('allow_repeated_payments');
    }

    /**
     * @param $value
     * @return \Omnipay\Common\Message\AbstractRequest
     */
    public function setAllowRepeatedPayments($value)
    {
        return $this->setParameter('allow_repeated_payments', (bool) $value);
    }

    /**
     * @return bool
     */
    public function getSendEmail()
    {
        return (bool) $this->getParameter('send_email');
    }

    /**
     * @param $value
     * @return \Omnipay\Common\Message\AbstractRequest
     */
    public function setSendEmail($value)
    {
        return $this->setParameter('send_email', (bool) $value);
    }

    /**
     * @return bool
     */
    public function getSendSms()
    {
        return (bool) $this->getParameter('send_sms');
    }

    /**
     * @param $value
     * @return \Omnipay\Common\Message\AbstractRequest
     */
    public function setSendSms($value)
    {
        return $this->setParameter('send_sms', (bool) $value);
    }

    /**
     * @return mixed
     */
    public function getExpiresAt()
    {
        return $this->getParameter('expires_at');
    }

    /**
     * @param $value
     * @return \Omnipay\Common\Message\AbstractRequest
     */
    public function setExpiresAt($value)
    {
        return $this->setParameter('expires_at', $value);
    }

}
