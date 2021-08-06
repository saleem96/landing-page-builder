<?php

namespace Modules\Ecommerce\Http\Controllers\Payment;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Illuminate\Routing\Controller;
use Modules\Ecommerce\Entities\LandingpageOrder;
use Omnipay\Omnipay;

class PayPal
{
    public function gateway_purchase(Request $request, LandingpageOrder $payment_order)
    {

        $paypal = Omnipay::create('PayPal_Rest');
        
        $user = $payment_order->user;

        $paypal->initialize([
            'clientId'  => getValueIfKeyIsset($user->settings,'PAYPAL_CLIENT_ID'),
            'secret'    => getValueIfKeyIsset($user->settings,'PAYPAL_SECRET'),
            'testMode'  => getValueIfKeyIsset($user->settings,'PAYPAL_SANDBOX'),
            'brandName' => $user->name,
        ]);
        

        try {

            // Send purchase request
            $response = $paypal->purchase([
                'transactionId' => $payment_order->id,
                'amount'        => $payment_order->total,
                'currency'      => $payment_order->currency,
                'description'   => $payment_order->product_name,
                'cancelUrl'     => route('order-submission.gateway.cancel', $payment_order),
                'returnUrl'     => route('order-submission.gateway.return', $payment_order),
                'notifyUrl'     => route('order-submission.gateway.notify', $payment_order),
            ])->send();

            // Process response
            if ($response->isRedirect()) {
                // Redirect to offsite payment gateway
                return response()->json(['redirect_url'=> $response->getRedirectUrl()]);

            }elseif ($response->isSuccessful()) {

                // Payment was successful
                $payment_order->reference = $response->getTransactionReference();
                $payment_order->is_paid   = true;
                $payment_order->save();

                $page = $payment_order->landingpage;

                if ($page) {

                    $redirect_url_success = '';

                    $page_url = getLandingPageCurrentURL($page);

                    if ($page->type_payment_submit == 'url') {
                        $redirect_url_success = $page->redirect_url_payment; 
                    } else {
                        $redirect_url_success = $page_url."/thank-you"; 
                    }

                    return redirect()->to($redirect_url_success);
                }
                return response()->json(['success'=> __('Thank you for your payment!')]);

                

            } else {
                // Payment failed
                return response()->json(['error'=> $response->getMessage()]);
            }

        } catch (\Exception $e) {
            return response()->json(['error'=> $e->getMessage()]);
        }
    }

    public function gateway_return(Request $request, LandingpageOrder $payment_order)
    {
        
        if (!$request->paymentId || !$request->PayerID) {
            # code...
            return response()->json(['error'=> 'Not found paymentId or Payer ID']);
        }

        $paypal = Omnipay::create('PayPal_Rest');

        $paypal->initialize([
            'clientId'  => getValueIfKeyIsset($user->settings,'PAYPAL_CLIENT_ID'),
            'secret'    => getValueIfKeyIsset($user->settings,'PAYPAL_SECRET'),
            'testMode'  => getValueIfKeyIsset($user->settings,'PAYPAL_SANDBOX'),
            'brandName' => $user->name,
        ]);
        

        try {

            // Complete purchase
            $response = $paypal->completePurchase([
                'transactionId'        => $payment_order->id,
                'payer_id'             => $request->PayerID,
                'transactionReference' => $request->paymentId,
                'amount'               => $payment_order->total,
                'currency'             => $payment_order->currency,
                'description'          => $payment_order->product_name,
                'cancelUrl'     => route('order-submission.gateway.cancel', $payment_order),
                'returnUrl'     => route('order-submission.gateway.return', $payment_order),
                'notifyUrl'     => route('order-submission.gateway.notify', $payment_order),
            ])->send();

            // Process response
            if ($response->isSuccessful()) {

                // Payment was successful
                $payment_order->reference = $response->getTransactionReference();
                $payment_order->is_paid   = true;
                $payment_order->save();

                $page = $payment_order->landingpage;
                
                if ($page) {

                    $redirect_url_success = '';

                    $page_url = getLandingPageCurrentURL($page);

                    if ($page->type_payment_submit == 'url') {
                        $redirect_url_success = $page->redirect_url_payment; 
                    } else {
                        $redirect_url_success = $page_url."/thank-you"; 
                    }

                    return redirect()->to($redirect_url_success);
                }

                return response()->json(['success'=> __('Thank you for your payment!')]);


            } else {
                return response()->json(['error'=> $response->getMessage()]);
          
            }
            

        } catch (\Exception $e) {
            return response()->json(['error'=> $e->getMessage()]);
        }
    }

    public function gateway_notify(Request $request)
    {

    }

    public function gateway_cancel(Request $request, LandingpageOrder $payment_order)
    {

    }

}
