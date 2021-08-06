<?php

namespace Omnipay\Instamojo\Message;

use Guzzle\Http\Message\RequestInterface;

/**
 * Class AbstractRequest
 * @package Omnipay\Instamojo\Message
 */
abstract class AbstractRequest extends \Omnipay\Common\Message\AbstractRequest
{
    /**
     * @var string
     */
    protected $liveEndpoint = 'https://www.instamojo.com/api/1.1/';
    /**
     * @var string
     */
    protected $testEndpoint = 'https://test.instamojo.com/api/1.1/';

    /**
     * @param $method
     * @param $endpoint
     * @param $data
     * @return RequestInterface
     */
    public function createRequest($method, $endpoint, $data = null)
    {
        return $this->httpClient->request($method, $endpoint, [
            'Accept'       => 'application/json',
            'Content-type' => 'application/json',
            'X-Api-key'    => $this->getApiKey(),
            'X-Auth-Token' => $this->getAuthToken(),
        ], json_encode($data));
    }

    /**
     * @param RequestInterface $httpRequest
     * @return array|bool|float|int|string
     */
    public function sendRequest($response)
    {
        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * @return string
     */
    protected function getEndpoint()
    {
        return $this->getTestMode() ? $this->testEndpoint : $this->liveEndpoint;
    }

    /**
     * @return array
     */
    public function getData()
    {
        return [];
    }

    /**
     * @return string
     */
    public function getSalt()
    {
        return $this->getParameter('salt');
    }

    /**
     * @param $value
     * @return \Omnipay\Common\Message\AbstractRequest
     */
    public function setSalt($value)
    {
        return $this->setParameter('salt', $value);
    }

    /**
     * @return string
     */
    public function getApiKey()
    {
        return $this->getParameter('api_key');
    }

    /**
     * @param $value
     * @return \Omnipay\Common\Message\AbstractRequest
     */
    public function setApiKey($value)
    {
        return $this->setParameter('api_key', $value);
    }

    /**
     * @return string
     */
    public function getAuthToken()
    {
        return $this->getParameter('auth_token');
    }

    /**
     * @param $value
     * @return \Omnipay\Common\Message\AbstractRequest
     */
    public function setAuthToken($value)
    {
        return $this->setParameter('auth_token', $value);
    }

}
