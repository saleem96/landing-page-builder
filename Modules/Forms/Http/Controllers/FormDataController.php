<?php

namespace Modules\Forms\Http\Controllers;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Modules\LandingPage\Entities\LandingPage;
use Modules\TemplateLandingPage\Entities\Template;
use Modules\Forms\Entities\FormData;
use Modules\LandingPage\Jobs\IntergrationLandingPage;
use Browser;
use Response;
use DB;
use Carbon\Carbon;
use Modules\User\Entities\User;

class FormDataController extends Controller
{

    public function index(Request $request)
    {

    //  $users=   User::where( 'created_at', '>', Carbon::now()->subDays(30))
    //        ->get();
    //        dd($users);

        $data = FormData::with('landingpage')->where('user_id', $request->user()->id);

        $pages = LandingPage::where('user_id', $request->user()->id)->get();

        if ($request->filled('search')) {
            $data->where('name', 'like', '%' . $request->search . '%');
        }
        $page_filter = '';
        $request_code = '';

        if ($request->filled('code')) {

            $page_filter = $pages->filter(function($item) use ($request) {
                return $item->code == $request->code;
            })->first();
            $request_code = $request->code;

            $data->where('landing_page_id', $page_filter->id);
        }

        $data->orderBy('created_at', 'DESC');
        $data = $data->paginate(10);

        return view('forms::leads.index', compact(
            'data','pages','page_filter','request_code'
        ));
    }
   
    public function edit($id)
    {
        $item = FormData::findorFail($id);

        return view('forms::leads.edit', compact(
            'item'
        ));

    }

    public function update(Request $request, $id)
    {
        $item = FormData::findorFail($id);

        $arr_temp = [];

        if ($request->new_field && $request->new_field_value && count($request->new_field) == count($request->new_field_value)) {
           
           foreach ($request->new_field as $key_field => $value) {
                $arr_temp[$value] = $request->new_field_value[$key_field];
           }

        }

        $array_except = ['new_field', 'new_field_value','_token'];

        $field_values_data = $arr_temp + $request->except($array_except);

        if(!array_filter($field_values_data)) {

            return redirect()->back()
            ->with('error', __('Not found any fields submit. Please enter some fields'));

        }

        $item->field_values = $field_values_data;

        $item->save();
        
        return redirect()->back()
            ->with('success', __('Updated successfully'));
  
    }
    
    public function exportcsv(Request $request)
    {
        $data = FormData::where('user_id', $request->user()->id);

        if ($request->filled('code')) {

            $page = LandingPage::where('code', $request->code)->first();

            $data->where('landing_page_id', $page->id);
        }
        
       
        $formdata = $data->get();

        if (count($formdata) > 0) {

            $filename = 'formdata-'.strtotime("now").'.csv';
            
            $handle = fopen($filename, 'w+');
            
            $columns = [];

            foreach($formdata as $item) {
                $columns = array_merge($columns,array_keys($item->field_values));
            }

            $columns = array_unique($columns);

            fputcsv($handle, $columns);

            foreach($formdata as $item) {
                
                $values = [];

                foreach ($columns as $key) {

                    if (isset($item->field_values[$key]) && !empty($item->field_values[$key])) {
                          array_push($values,$item->field_values[$key]);
                    }
                    else{
                        array_push($values,'');
                    }
                    
                }
                fputcsv($handle, $values);
            }
            

            fclose($handle);

            $headers = array(
                'Content-Type' => 'text/csv',
            );

            return Response::download($filename, $filename, $headers)->deleteFileAfterSend(true);

        }
        return redirect()->back()->with('error', __('Not found any data for export'));
       
           
    }
    

    public function delete($id,Request $request)
    {
       $item = FormData::findorFail($id);
       $item->delete();
       return redirect()->back()->with('success', __('Deleted successfully'));
       
    }
    public function submission($code,Request $request)
    {

        $page = LandingPage::where('code', $code)->first();

        if (!$page) {
            return response()->json(['error'=>__("Not found page id")]);
        }

        $tracking = Browser::detect();

        $fields_expect = ['_browser','_os','_lang','_timezone','_token'];

        $fields_request = array_keys($request->except($fields_expect));

        $fields_request = array_unique($fields_request);

        $field_values = array();
        
        if(count($fields_request) > 0){
            
            foreach ($fields_request as $key) {
                $field_values[$key] = $request->input($key);
            }

            if(!array_filter($field_values)) {
                return response()->json(['error'=>__("Not found any fields submit. Please enter some fields")]);
            }

            // Check email member exists on form data landing page
            if (isset($field_values['email'])) {
                $data = DB::table('form_data')
                ->where('landing_page_id',$page->id)
                ->whereJsonContains('field_values', ['email' =>$field_values['email']])
                ->get();
                
                if (count($data) > 0) {
                    return response()->json(['error'=>__("Your Email existed!")]);
                }
            }
            

            $form_data = FormData::create([
                'landing_page_id' => $page->id,
                'user_id' => $page->user_id,
                'field_values' => $field_values,
                'browser' => $tracking->browserFamily(),
                'os' => $tracking->platformFamily(),
                'device' => getDeviceTracking($tracking),
            ]);
        //     // leads in a month
        //     $leads_all=FormData::where('landing_page_id',$page->id)
        //      ->whereDate('created_at', '>', Carbon::now()->subDays(30))->get();
            
        //      //count
        //      $total =count($leads_all);
            
        //      //getting user
        //     $user= User::where('user_id',$page->user_id)->first();
         
        //      if($total<1000)
        //   {
        //      $user->wallet-1;
        //      $user->save();
        //     }
        //   else
        //   {
        //     $user->wallet-0.8;
        //     $user->save();
        //   }




            if(ruleMailChimpForAddContact($page,$form_data)){
                IntergrationLandingPage::dispatch($page,$form_data);
            }
            
                   
            return response()->json([
                'type_form_submit' => $page->type_form_submit,
                'redirect_url' => $page->redirect_url,
            ]);
        }
        else{
            return response()->json(['error'=>__("Not found any fields submit. You need config name for fields in builder")]);
        }
        
      
    }
    
    
}
