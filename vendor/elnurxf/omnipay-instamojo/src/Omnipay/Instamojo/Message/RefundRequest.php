<?php

namespace Omnipay\Instamojo\Message;

/**
 * Class RefundRequest
 * @package Omnipay\Instamojo\Message
 */
class RefundRequest extends AbstractRequest
{
    /**
     * @return array
     */
    public function getData()
    {
        $data = parent::getData();
        $this->validate('transactionReference');
        $data['payment_id'] = $this->getTransactionReference();
        $data['type']       = $this->getType();
        $data['body']       = $this->getBody();
        if ($this->getAmount()) {
            $data['refund_amount'] = $this->getAmount();
        }

        return $data;
    }

    /**
     * @param mixed $data
     * @return RefundResponse
     */
    public function sendData($data)
    {
        $httpRequest  = $this->createRequest('POST', $this->getEndpoint() . 'refunds/', $data);
        $jsonResponse = $this->sendRequest($httpRequest);

        return $this->response = new RefundResponse($this, $jsonResponse);
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->getParameter('type') ?: 'QFL';
    }

    /**
     * @param $value
     * @return \Omnipay\Common\Message\AbstractRequest
     */
    public function setType($value)
    {
        return $this->setParameter('type', $value);
    }

    /**
     * @return string
     */
    public function getBody()
    {
        return $this->getParameter('body') ?: $this->getType();
    }

    /**
     * @param $value
     * @return \Omnipay\Common\Message\AbstractRequest
     */
    public function setBody($value)
    {
        return $this->setParameter('body', $value);
    }

}
