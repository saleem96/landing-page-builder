# Omnipay 3.0: Instamojo

**[Instamojo](https://www.instamojo.com/) driver for the Omnipay 3.0 PHP payment processing library**

[Omnipay](https://github.com/thephpleague/omnipay) is a framework agnostic, multi-gateway payment
processing library for PHP 5.3+.
This package implements [Instamojo Payments API v1.1](https://docs.instamojo.com/docs/payments-api).

## Installation

Omnipay is installed via [Composer](http://getcomposer.org/). To install, simply run:

```
composer require elnurxf/omnipay-instamojo
```

## Purchase

```php
use Omnipay\Omnipay;

// Setup payment gateway
$gateway = Omnipay::create('Instamojo');
$gateway->setApiKey('abc123');
$gateway->setAuthToken('abc123');

// OR
$gateway->initialize([
    'api_key'    => 'abc123',
    'auth_token' => 'abc123',
    'testMode'   => true,
]);

// Send purchase request
$response = $gateway->purchase(
    [
        'amount'     => '10.00',
        'purpose'    => 'Instamojo Payment',
        'email'      => 'elnurxf@gmail.com',
        'buyer_name' => 'Elnur Akhundov',
        'purpose'    => 'Instamojo Payment',
    ]
)->send();

// Process response
if ($response->isSuccessful() && $response->isRedirect()) {

    // Redirect to offsite payment gateway
    // print_r($response->getData());
    // echo $response->getTransactionStatus();
    $response->redirect();

} else {

    // Request failed
    echo $response->getMessage();
}
```

## Complete Purchase

```php
// Send complete purchase request
$response = $gateway->completePurchase(
    [
        'transactionReference' => $_GET['payment_id'],
    ]
)->send();

// Process response
if ($response->isSuccessful()) {

    // Request was successful
    print_r($response->getData());
    echo $response->getTransactionStatus();

} else {

    // Request failed
    echo $response->getMessage();
}
```

## Refund

```php
// Send refund request
$response = $gateway->refund(
    [
        'transactionReference' => $payment_id,
    ]
)->send();

// Process response
if ($response->isSuccessful()) {

    // Request was successful
    print_r($response->getData());
    echo $response->getTransactionStatus();

} else {

    // Request failed
    echo $response->getMessage();
}
```

## Fetch Payment Request

```php
// Send fetch payment request
$response = $gateway->fetchPaymentRequest(
    [
        'transactionReference' => $payment_request_id,
    ]
)->send();

// Process response
if ($response->isSuccessful()) {

    // Request was successful
    print_r($response->getData());
    echo $response->getTransactionStatus();

} else {

    // Request failed
    echo $response->getMessage();
}
```

## Webhook

```php
use Omnipay\Omnipay;

// Setup payment gateway
$gateway = Omnipay::create('Instamojo');
$gateway->setSalt('abc123');

// Payment notification request
$response = $gateway->acceptNotification()->send();

// Process response
if ($response->isSuccessful()) {

    // Request was successful
    print_r($response->getData());
    echo $response->getTransactionReference();
    echo $response->getTransactionStatus();

} else {

    // Request failed
    echo $response->getMessage();
}
```

## [Instamojo API v1.1 Documentation](https://docs.instamojo.com/docs/payments-api)