<?php
/**
 * Yandex.Kassa driver for Omnipay payment processing library
 *
 * @link      https://github.com/hiqdev/omnipay-yandex-kassa
 * @package   omnipay-yandex-kassa
 * @license   MIT
 * @copyright Copyright (c) 2019, HiQDev (http://hiqdev.com/)
 */

namespace Omnipay\YandexKassa\Tests\Message;

use Omnipay\YandexKassa\Message\CaptureRequest;
use Omnipay\YandexKassa\Message\CaptureResponse;
use Symfony\Component\HttpFoundation\Request as HttpRequest;

class CaptureRequestTest extends TestCase
{
    /** @var CaptureRequest */
    private $request;

    private $shopId               = '54401';
    private $secretKey            = 'test_Fh8hUAVVBGUGbjmlzba6TB0iyUbos_lueTHE-axOwM0';
    private $transactionReference = '2475e163-000f-5000-9000-18030530d620';
    private $transactionId        = '5ce3cdb0d1436';
    private $amount               = '187.50';
    private $currency             = 'RUB';

    public function setUp()
    {
        parent::setUp();

        $httpRequest = new HttpRequest();
        $this->request = new CaptureRequest($this->getHttpClient(), $httpRequest);
        $this->request->initialize([
            'yandexClient' => $this->buildYandexClient($this->shopId, $this->secretKey),
            'shopId' => $this->shopId,
            'secret' => $this->secretKey,
            'transactionReference' => $this->transactionReference,
            'transactionId' => $this->transactionId,
            'amount' => $this->amount,
            'currency' => $this->currency,
        ]);
    }

    public function testGetData()
    {
        $data = $this->request->getData();
        $this->assertEmpty($data);
    }

    public function testSendData()
    {
        $curlClientStub = $this->getCurlClientStub();
        $curlClientStub->method('sendRequest')->willReturn([
            [],
            $this->fixture('payment.succeeded'),
            ['http_code' => 200],
        ]);

        $this->getYandexClient($this->request)
             ->setApiClient($curlClientStub)
             ->setAuth($this->shopId, $this->secretKey);

        $response = $this->request->sendData([]);
        $this->assertInstanceOf(CaptureResponse::class, $response);
    }
}
