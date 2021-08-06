<?php

namespace Modules\LandingPage\Http\Helpers;
use MailchimpMarketing;

class MailChimp
{
    protected $client;            

    public function __construct($apiKey)
    {
        $client = new MailchimpMarketing\ApiClient();
        $apiKey = $apiKey;
        $dataCenter = substr($apiKey,strpos($apiKey,'-')+1);

        $client->setConfig([
            'apiKey' => $apiKey,
            'server' => $dataCenter,
        ]);
        $this->client = $client;
        
    }
    public function testConnect(){
        
        try {
            
            $this->client->ping->get();
            return ['status'=> true, 'message' => __('Connected success')];
        
        } catch (\Exception $e) {
            
            return ['status'=> false, 'message' => __('Please Enter a valid API key')];
        }  
    }
    public function getMailLists(){

        try {

            $lists = [];
            $response = $this->client->lists->getAllLists();
            foreach ($response->lists as $item) {
                array_push($lists, ["id" => $item->id, "name" => $item->name]);
            }

            return ['status'=> true, 'message' => __('Connected success'), 'data' => $lists];
        
        } catch (\Exception $e) {
            
            return ['status'=> false, 'message' => $e->getMessage()];
        }
    }
    public function getListMergeFields($list_id){

        try {

            $merge_fields = [];
            $response = $this->client->lists->getListMergeFields($list_id);
            foreach ($response->merge_fields as $item) {
                // only for type = "text"
                if ($item->type == 'text') {
                    array_push($merge_fields, $item->tag);
                }
                
            }
            return ['status'=> true, 'message' => __('Connected success'), 'data' => $merge_fields];
        
        } catch (\Exception $e) {
            
            return ['status'=> false, 'message' => $e->getMessage()];
        }
    }

  

    public function addContact($mailChimpSettings, $field_values, $tags = []){
        
        try {
            
            $merge_fields = [];
            if(isset($mailChimpSettings['merge_fields'])){
                $merge_fields_setting = explode(",", $mailChimpSettings['merge_fields']);
                foreach ($merge_fields_setting as $item) {

                    if (isset($field_values[$item]) &&  !empty($field_values[$item])) {
                        $merge_fields[$item] = $field_values[$item];
                    }
                }
            }

            $data_post = [
                "email_address" => $field_values['email'],
                "status" => $mailChimpSettings['contact_subscription_status'],
                "tags" => $tags
            ];
            if (!empty($merge_fields)) {
                $data_post['merge_fields'] = $merge_fields;
            }

            $response = $this->client->lists->addListMember($mailChimpSettings['mailing_list'], $data_post);

            return ['status'=> true, 'message' => __('MailChimp add contact success')];
        
        } catch (\Exception $e) {
            return ['status'=> false, 'message' => $e->getMessage()];
        }

    }

}
