<?php

namespace Modules\Ecommerce\Http\Controllers\Payment;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Illuminate\Routing\Controller;
use Modules\Ecommerce\Entities\LandingpageOrder;
use Stripe\Checkout\Session as StripeSession;
use Stripe\Exception\SignatureVerificationException;
use Stripe\Price as StripePrice;
use Stripe\Product as StripeProduct;
use Stripe\Stripe as StripeGateway;
use Stripe\Subscription as StripeSubscription;
use Stripe\Webhook as StripeWebhook;

class Stripe
{
    public function gateway_purchase(Request $request, LandingpageOrder $payment_order)
    {
        // Set API key
        $user = $payment_order->user;

        StripeGateway::setApiKey(getValueIfKeyIsset($user->settings,'STRIPE_SECRET'));
        
        $stripe_key = getValueIfKeyIsset($user->settings,'STRIPE_KEY');

        try {

            $stripe_session = StripeSession::create([
              'payment_method_types' => ['card'],
              'line_items' => [[
                  'price_data' => [
                    'currency' => $payment_order->currency,
                    'product_data' => [
                      'name' => $payment_order->product_name,
                    ],
                    'unit_amount' => $payment_order->total_in_cents,
                  ],
                  'quantity' => 1,
              ]],
              'mode' => 'payment',
              'success_url' => route('order-submission.gateway.return', $payment_order)."?session_id={CHECKOUT_SESSION_ID}",
              'cancel_url' => route('order-submission.gateway.cancel', $payment_order),
            ]);

            
            $page = $payment_order->landingpage;
            
            $page_url = getLandingPageCurrentURL($page);

            $data_return = [
                'stripe_key' => $stripe_key,
                'page_url' => $page_url,
                'stripe_session_id' => $stripe_session->id,
            ];

            return response()->json($data_return);


        } catch (\Exception $e) {
            return response()->json(['error'=> $e->getMessage()]);
        }
    }

    public function gateway_return(Request $request, LandingpageOrder $payment_order)
    {

        if (!$request->session_id) {
            # code...
            return response()->json(['error'=> 'Not found session_id']);
        }

        // Set API key
        $user = $payment_order->user;

        StripeGateway::setApiKey(getValueIfKeyIsset($user->settings,'STRIPE_SECRET'));
        $stripe_key = getValueIfKeyIsset($user->settings,'STRIPE_KEY');

        try {

            $stripe_session = StripeSession::retrieve($request->session_id);

            // Payment was successful
            if (in_array(strtolower($stripe_session->payment_status), ['paid'])) {

                $payment_order->reference = $stripe_session->id;
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

                return response()->json(['error'=> $stripe_session->getMessage()]);
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
