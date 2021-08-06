<?php

namespace Omnipay\Instamojo\Message;

use Omnipay\Common\Exception\InvalidRequestException;

/**
 * Class NotifyRequest
 * @package Omnipay\Instamojo\Message
 */
class NotifyRequest extends AbstractRequest
{
    /**
     * @return array
     * @throws InvalidRequestException
     */
    public function getData()
    {
        if (!isset($this->data)) {
            $data = $this->httpRequest->request->all();

            if (!isset($data['mac'])) {
                throw new InvalidRequestException("The mac parameter is required");
            }

            $mac_provided = $data['mac']; // Get the MAC from the POST data
            unset($data['mac']); // Remove the MAC key from the data.
            ksort($data, SORT_STRING | SORT_FLAG_CASE);

            $mac_calculated = hash_hmac('sha1', implode('|', $data), $this->getSalt());
            if ($mac_provided == $mac_calculated) {
                $this->data = $data;
            } else {
                throw new InvalidRequestException("MAC mismatch");
            }
        }

        return $this->data;
    }

    /**
     * @param mixed $data
     * @return NotifyResponse
     */
    public function sendData($data)
    {
        return $this->response = new NotifyResponse($this, $data);
    }
}
