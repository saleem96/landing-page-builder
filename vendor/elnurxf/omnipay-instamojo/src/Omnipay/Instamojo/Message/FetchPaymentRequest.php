<?php

namespace Omnipay\Instamojo\Message;

/**
 * Class FetchPaymentRequest
 * @package Omnipay\Instamojo\Message
 */
class FetchPaymentRequest extends AbstractRequest
{
    /**
     * @return array
     */
    public function getData()
    {
        $data = parent::getData();

        $this->validate('transactionReference');

        $data['id'] = $this->getTransactionReference();

        return $data;
    }

    /**
     * @param mixed $data
     * @return Response
     */
    public function sendData($data)
    {
        $httpRequest  = $this->createRequest('GET', $this->getEndpoint() . 'payment-requests/' . $data['id'] . '/');
        $jsonResponse = $this->sendRequest($httpRequest);

        return $this->response = new Response($this, $jsonResponse);
    }

}
