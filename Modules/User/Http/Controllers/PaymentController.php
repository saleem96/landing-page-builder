<?php

namespace Modules\User\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Routing\Controller;
use Modules\Saas\Entities\Package;
use Modules\User\Entities\User;
use Nwidart\Modules\Facades\Module;

use Exception;
use Stripe\Charge;
use Stripe\Stripe;
use Stripe\Customer;
use Modules\User\Entities\Payment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
class PaymentController extends Controller
{
    public function create()
    {
        return view('payments.create');
    }

    public function store()
    {
        // dd(request()->all());
        request()->validate([
            'name' => 'required',
            'email' => 'required|email',
            'terms_conditions' => 'accepted',
            'amount'=>'required|gt:0.99',
        ]);
        // dd(request()->all());
        /** I have hard coded amount. You may fetch the amount based on customers order or anything */
        $amount     = request('amount');
        $currency   = 'usd';

        if (empty(request()->get('stripeToken'))) {
            session()->flash('error', 'Some error while making the payment. Please try again');
            return back()->withInput();
        }
        Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
        try {
            /** Add customer to stripe, Stripe customer */
            $customer = Customer::create([
                'email'     => request('email'),
                'source'    => request('stripeToken')
            ]);
        } catch (Exception $e) {
            $apiError = $e->getMessage();
        }

        if (empty($apiError) && $customer) {
            /** Charge a credit or a debit card */
            try {
                /** Stripe charge class */
                $charge = Charge::create(array(
                    'customer'      => $customer->id,
                    'amount'        => $amount*100,
                    'currency'      => $currency,
                    'description'   => 'Some testing description'
                ));
            } catch (Exception $e) {
                $apiError = $e->getMessage();
            }

            if (empty($apiError) && $charge) {
                // Retrieve charge details 
                $paymentDetails = $charge->jsonSerialize();
                if ($paymentDetails['amount_refunded'] == 0 && empty($paymentDetails['failure_code']) && $paymentDetails['paid'] == 1 && $paymentDetails['captured'] == 1) {
                //   dd('ssss');
                $wall_user= User::where('id',Auth::user()->id)->first();
                $paymentDetails['amount']=$paymentDetails['amount']/100;
                // $fee=$paymentDetails['amount']*(0.029)+(0.3);
                   $net_amount=$paymentDetails['amount'];
                // $net_amount=$paymentDetails['amount']-$fee;

                $wall_user->wallet+=$net_amount;
                $wall_user->save();


                    Payment::create([
                        'user_id'                       =>Auth::user()->id,
                        'name'                          => request('name'),
                        'email'                         => request('email'),
                        'amount'                        => $net_amount,
                        'currency'                      => $paymentDetails['currency'],
                        'transaction_id'                => 0,
                        'payment_status'                => 1,
                        'receipt_url'                   => $paymentDetails['receipt_url'],
                        'transaction_complete_details'  => json_encode($paymentDetails)
                    ]);
                    // dd(json_encode($paymentDetails));
                 
                    return redirect('/thankyou/?receipt_url=' . $paymentDetails['receipt_url']);
                    // return redirect('/thankyou');
                } else {
                    session()->flash('error', 'Transaction failed');
                    return back()->withInput();
                }
            } else {
                session()->flash('error', 'Error in capturing amount: ' . $apiError);
                return back()->withInput();
            }
        } else {
            session()->flash('error', 'Invalid card details: ' . $apiError);
            return back()->withInput();
        }
    }

    public function thankyou()
    {
        
        return view('user::auth.thankyou');
    }
}