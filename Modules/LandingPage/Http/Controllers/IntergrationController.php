<?php

namespace Modules\LandingPage\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\User\Entities\User;
use Modules\LandingPage\Http\Helpers\MailChimp;


class IntergrationController extends Controller
{

    public function lists(Request $request, $type)
    {

        switch ($type) {

            case 'mailchimp':
                
                $api_key = $request->input('api_key');

                if (!$api_key)
                    return response()->json(['status'=> false, 'message' => __('Please Enter a valid API key')]);
        
                $mailchimp = new MailChimp($api_key);
                $testConnect = $mailchimp->testConnect();

                if($testConnect['status'] == true) {
                    # code...
                    $getMailLists = $mailchimp->getMailLists();
                    
                    if($getMailLists['status'] == true) {
                        return response()->json(['status'=> true, 'message' => $getMailLists['message'], 'data' => $getMailLists['data']]);
                    }
                    return response()->json(['status'=> false, 'message' => $getMailLists['message']]);
                }
                return response()->json(['status'=> false, 'message' => $testConnect['message']]);
                
                break;
                
            default:
                return response()->json(['error'=>__("Unsupported type intergration")]);
                break;
        }
        
    }

    public function mergefields(Request $request, $type)
    {

        switch ($type) {

            case 'mailchimp':
                
                $api_key = $request->input('api_key');
                $list_id = $request->input('list_id');

                if (!$api_key || !$list_id)
                    return response()->json(['status'=> false, 'message' => __('Please Enter a valid API key')]);
        
                $mailchimp = new MailChimp($api_key);
                $testConnect = $mailchimp->testConnect();

                if($testConnect['status'] == true) {
                    # code...
                    $getMergeFields = $mailchimp->getListMergeFields($list_id);
                    
                    if($getMergeFields['status'] == true) {
                        
                        $data_response = implode(",",$getMergeFields['data']);

                        return response()->json(['status'=> true, 'message' => $getMergeFields['message'], 'data' => $data_response]);
                    }
                    return response()->json(['status'=> false, 'message' => $getMergeFields['message']]);
                }
                return response()->json(['status'=> false, 'message' => $testConnect['message']]);
                
                break;
                
            default:
                return response()->json(['error'=>__("Unsupported type intergration")]);
                break;
        }
        
    }

    



    
}

