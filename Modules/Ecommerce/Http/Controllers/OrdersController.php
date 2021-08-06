<?php

namespace Modules\Ecommerce\Http\Controllers;
use Modules\Ecommerce\Http\Controllers\Payment\PayPal;
use Modules\Ecommerce\Http\Controllers\Payment\Stripe;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\LandingPage\Entities\LandingPage;
use Modules\Ecommerce\Entities\LandingpageProduct;
use Modules\Ecommerce\Entities\LandingpageOrder;

use Browser;


class OrdersController extends Controller
{

    public function orderSubmission($code,Request $request)
    {
        // form checkout with payment method
        
        $paymentmethod = "";

        if($request->has('paymentmethod')) {
            
            $type = ['paypal','banktransfer','stripe'];
            if (!in_array($request->paymentmethod, $type)) {
                return response()->json(['error'=>__("Not found type payment")]);
            }

            $paymentmethod = $request->paymentmethod;

        }
        // button checkout
        elseif($request->has('_type')){

            $type = ['paypal','stripe'];
            if (!in_array($request->_type, $type)) {
                return response()->json(['error'=>__("Not found type payment")]);
            }
            $paymentmethod = $request->_type;
        }
        else{
            return response()->json(['error'=>__("Not found payment method or type")]);
        }

        $product = LandingpageProduct::find($request->_productid);

        if (!$product) {
            return response()->json(['error'=>__("Not found products")]);
        }

        $page = LandingPage::where('code', $code)->first();
        if (!$page) {
            return response()->json(['error'=>__("Not found LandingPage")]);
        }

        $user = $page->user;

        // check exits key Payment
        if ($paymentmethod == 'paypal') {

            $paypal_keys = ['PAYPAL_SANDBOX', 'PAYPAL_CLIENT_ID','PAYPAL_SECRET'];
            $check_key_payment = checkIssetAndNotEmptyKeys($user->settings,$paypal_keys);
            if (!$check_key_payment) {
                return response()->json(['error'=>__("You need config setting payment PayPal in account setting")]);
            }
        }

        if ($paymentmethod == 'stripe') {

            $stripe_keys = ['STRIPE_KEY', 'STRIPE_SECRET'];
            $check_key_payment = checkIssetAndNotEmptyKeys($user->settings,$stripe_keys);
            if (!$check_key_payment) {
                return response()->json(['error'=>__("You need config setting payment STRIPE in account setting")]);
            }
        }
        
        
        // get field if exits form
        $fields_request = array_keys($request->all());
        
        $fields_expect = ['_type','_productid','_token','paymentmethod'];
        foreach ($fields_expect as $item) {
            if (($item = array_search($item,$fields_request)) !== false) {
                unset($fields_request[$item]);
            }
        }
        $fields_request = array_unique($fields_request);
        $field_values = array();
        
        if(count($fields_request) > 0){
            foreach ($fields_request as $key) {
                $field_values[$key] = $request->input($key);
            }
        }

        $tracking = Browser::detect();

        $payment_order = LandingpageOrder::create([
            'user_id'    => $page->user_id,
            'landing_page_id' => $page->id,
            'product_name' => $product->name,
            'gateway'    => $paymentmethod,
            'total'      => $product->price,
            'field_values' => $field_values,
            'is_paid'    => false,
            'browser' => $tracking->browserFamily(),
            'os' => $tracking->platformFamily(),
            'device' => getDeviceTracking($tracking),
            'currency'   => $product->currency,
        ]);


        switch ($paymentmethod) {

            case 'stripe':

                return (new Stripe)->gateway_purchase($request, $payment_order);

                break;

            case 'paypal':

                return (new PayPal)->gateway_purchase($request, $payment_order);

                break;

            case 'banktransfer':

                $page_url = getLandingPageCurrentURL($page);
                
                $redirect_url_success = '';

                if ($page->type_payment_submit == 'url') {
                    $redirect_url_success = $page->redirect_url_payment; 
                } else{
                    $redirect_url_success = $page_url."/thank-you"; 
                }
                
                $data_return = [
                    'redirect_url_success' => $redirect_url_success,
                ];
                return response()->json($data_return);
                break;
                
            default:
                return response()->json(['error'=>__("Unsupported payment gateway")]);
                break;
        }
      
    }

    public function gateway_return(Request $request, LandingpageOrder $payment_order)
    {
        
        switch ($payment_order->gateway) {

            case 'stripe':

                return (new Stripe)->gateway_return($request, $payment_order);

                break;

            case 'paypal':

                return (new PayPal)->gateway_return($request, $payment_order);

                break;
            default:
                return response()->json(['error'=>__("Unsupported payment gateway")]);
                break;
        }
        
    }

    public function gateway_cancel(Request $request, LandingpageOrder $payment_order)
    {
        if ($payment_order->landingpage) {

            $page = $payment_order->landingpage;
            
            $return_url = getLandingPageCurrentURL($page);

            return redirect()->to($return_url);
        }
        abort(404);
    }

    public function gateway_notify(Request $request, $gateway)
    {
        switch ($gateway) {

            case 'stripe':

                return (new Stripe)->gateway_notify($request);

                break;

            case 'paypal':

                return (new PayPal)->gateway_notify($request);

                break;

            default:

                return response()->json(['error'=>__("Unsupported payment gateway")]);
                
                break;
        }
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    
    public function index(Request $request)
    {
        $data = LandingpageOrder::where('user_id', $request->user()->id);

        if ($request->filled('search')) {
            $data->where('name', 'like', '%' . $request->search . '%');
        }

        $data->orderBy('created_at', 'DESC');
        $data = $data->paginate(10);

        return view('ecommerce::orders.index', compact(
            'data'
        ));
    }
  
    public function updateStatus(Request $request, $id, $status)
    {
        $status_arr = ['OPEN', 'COMPLETED', 'CANCELED'];
        
        if (!in_array($status, $status_arr)) {
            abort(404);
        }
        $item = LandingpageOrder::findorFail($id);

        $item->status = $status;
        $item->save();

        return back()->with('success', __('Updated successfully'));
        //
    }

  
    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function delete(Request $request,$id)
    {
        $item = LandingpageOrder::findorFail($id);

        $item->delete();

        return back()->with('success', __('Deleted successfully'));

    }
}
