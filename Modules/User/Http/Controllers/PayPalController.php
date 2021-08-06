<?php

namespace Modules\User\Http\Controllers;
use Modules\User\Entities\Order;
use App\PayPal;
use Illuminate\Http\Request;
use Modules\User\Entities\Payment;
use phpDocumentor\Reflection\Types\Null_;
use Modules\User\Entities\User;
use Illuminate\Support\Facades\Auth;
/**
 * Class PayPalController
 * @package App\Http\Controllers
 */
class PayPalController extends Controller
{
    /**
     * @param Request $request
     */
    public function form(Request $request, $order_id = null)
    {
        $order_id = $order_id ?: encrypt(1);

        $order = Order::findOrFail(decrypt($order_id));

        return view('form', compact('order'));
    }

    /**
     * @param $order_id
     * @param Request $request
     */
    public function checkout($order_id, Request $request)
    {
        // dd($request->amount);
        request()->validate([
            'name' => 'required',
            'email' => 'required|email',
            'amount'=>'required|gt:0.99',
        ]);
        $order_new= new Order();
        $order_new->transaction_id='rndx';
        $order_new->payment_status=0;
        $order_new->amount=$request->amount;
        $order_new->name=$request->name;
        $order_new->email=$request->email;
        $order_new->save();
        // dd($order_new->id);
        $order = Order::findOrFail($order_new->id);

        $paypal = new PayPal;

        $response = $paypal->purchase([
            'amount' => $request->amount,
            'transactionId' => $order->id,
            'currency' => 'USD',
            'cancelUrl' => $paypal->getCancelUrl($order),
            'returnUrl' => $paypal->getReturnUrl($order),
        ]);
            // dd($response);
            

          
        if ($response->isRedirect()) {
            $response->redirect();
        }

        return redirect()->back()->with([
            'message' => $response->getMessage(),
        ]);
    }

    /**
     * @param $order_id
     * @param Request $request
     * @return mixed
     */
    public function completed($order_id, Request $request)
    {
        $order = Order::findOrFail($order_id);

        $paypal = new PayPal;
        
        $response = $paypal->complete([
            'amount' => $paypal->formatAmount($order->amount),
            'transactionId' => $order->id,
            'currency' => 'USD',
            'cancelUrl' => $paypal->getCancelUrl($order),
            'returnUrl' => $paypal->getReturnUrl($order),
            'notifyUrl' => $paypal->getNotifyUrl($order),
        ]);

        if ($response->isSuccessful()) {
            Payment::create([
                'user_id'                       =>Auth::user()->id,
                'name'                          => $order->name,
                'email'                         => $order->email,
                'amount'                        => $order->amount,
                'currency'                      => 'USD',
                'transaction_id'                => $order->id,
                'payment_status'                => 1,
                'receipt_url'                   => 'N/A',
                'transaction_complete_details'  => Null
            ]);
            $wall_user= User::where('id',Auth::user()->id)->first();
                $paymentDetails['amount']=$order->amount;
                // $fee=$paymentDetails['amount']*(0.029)+(0.3);
                   $net_amount=$paymentDetails['amount'];
                // $net_amount=$paymentDetails['amount']-$fee;

                $wall_user->wallet+=$net_amount;
                $wall_user->save();
            $order->update(['transaction_id' => $response->getTransactionReference()]);

            return redirect()->route('accountsettings.index')->with([
                'message' => 'You recent payment is sucessful with reference code ' . $response->getTransactionReference(),
            ]);
        }

        return redirect()->back()->with([
            'message' => $response->getMessage(),
        ]);
    }

    /**
     * @param $order_id
     */
    public function cancelled($order_id)
    {
        $order = Order::findOrFail($order_id);

        return redirect()->route('accountsettings.index')->with([
            'message' => 'You have cancelled your recent PayPal payment !',
        ]);
    }

    /**
     * @param $order_id
     * @param $env
     */
    public function webhook($order_id, $env)
    {
        // to do with next blog post
    }
}