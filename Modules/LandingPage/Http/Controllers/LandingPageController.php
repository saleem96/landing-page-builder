<?php

namespace Modules\LandingPage\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\TemplateLandingPage\Entities\Category;
use Modules\TemplateLandingPage\Entities\Template;
use Modules\LandingPage\Entities\LandingPage;
use Modules\Ecommerce\Entities\LandingpageOrder;
use Modules\BlocksLandingPage\Entities\Block;
use Modules\Forms\Entities\FormData;
use URL;
use Modules\User\Entities\User;
// use DB;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;
use Modules\LandingPage\Http\Helpers\MailChimp;
use Illuminate\Support\Facades\Auth;
use Modules\User\Entities\Payment;
class LandingPageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function dashboard(Request $request)
    {
      

        $stats_browser= DB::table('form_data')
            ->where('user_id', $request->user()->id)
            ->selectRaw('count(id) AS total, browser')
            ->groupBy('browser')
            ->get();


        $stats_os= DB::table('form_data')
            ->where('user_id', $request->user()->id)
            ->selectRaw('count(id) AS total, os')
            ->groupBy('os')
            ->get();
      

        $stats_device= DB::table('form_data')
            ->where('user_id', $request->user()->id)
            ->selectRaw('count(id) AS total, device')
            ->groupBy('device')
            ->get();


        $landingpage_count = LandingPage::where('user_id', $request->user()->id)->count();
        $landingpage_unpublish = LandingPage::where('user_id', $request->user()->id)->unpublish()->count();
        $formdata_count = FormData::where('user_id', $request->user()->id)->count();

        return view('landingpage::dashboard', 
            compact('stats_browser','stats_os', 
                'stats_device','landingpage_count','formdata_count', 'landingpage_unpublish')
    );
        
    }


    public function index(Request $request)
    {

        $plans = DB::table('plans')->first();
      
        $current_date =\Carbon\Carbon::now()->addDays(1); 
        $test= $current_date->toDateString(); 
        $firstDay = $current_date->firstOfMonth();
        $fs1= $firstDay->toDateString();  
        $lastDay=$current_date->lastOfMonth()->addDays(1); 
        $test2= $lastDay->toDateString(); 
        
        //   dd($fs1);
        // $data = LandingPage::get();
        
        // foreach($data as $d)
        // {
        //     $lead_count=count($d->formdata->whereBetween('created_at', [$fs1, $test2]));
        //     if($lead_count<1000)
        //     {
        //         if($d->user->wallet>1)
        //        {
        //         $d->user->wallet=($d->user->wallet)-($plans->charge_per_lead);
        //          $d->user->save();
        //        }
        //        else
        //        if($d->user->is_admin==0)
        //        {
        //         return redirect('/dashboard')
        //         ->withErrors('Your wallet is empty! make payment first.');
        //        }
              

        //     }
        //     else
        //     {
        //         if($lead_count>1000)
        //         {
        //             if($d->user->wallet>1)
        //             {
        //                 $d->user->wallet=($d->user->wallet)-($plans->charge_per_lead);
        //                 $d->user->save();
        //             }
        //             else
        //             if($d->user->is_admin==0)
        //             {
        //                 return redirect('/dashboard')
        //                     ->withErrors('Your wallet is empty! make payment first.');
        //             }
                   
        //         }     
        //     }
        // }
        // $leads=DB::table('form_data')
        // ->whereBetween('created_at', [$fs1, $test2])
        // ->get();
        // dd(count($leads));
    



        $data = LandingPage::where('user_id', $request->user()->id);

        if ($request->filled('search')) {
            $data->where('name', 'like', '%' . $request->search . '%');
        }

        $data->orderBy('updated_at', 'DESC');
        $data = $data->paginate(12);

        $categories = Category::get();

        $data2 = [
            'data' => $data,
            'categories' => $categories,
        ];

        return view('landingpage::landingpages.index', $data2);
    }
    public function transactions(Request $request)
    {
        $data = Payment::where('user_id', Auth::user()->id);

        if ($request->filled('search')) {
            $data->where('name', 'like', '%' . $request->search . '%');
        }

        $data->orderBy('updated_at', 'DESC');
        $data = $data->paginate(12);

        $categories = Category::get();

        $data2 = [
            'data' => $data,
            'categories' => $categories,
        ];

        return view('landingpage::landingpages.transactions', $data2);
    }
    
    

    public function clone($id,Request $request)
    {
        $page = LandingPage::findorFail($id);
        $item = $page->replicate();
        $item->name = "Copy ". $page->name;
        $item->sub_domain = generateRandomString(8).'.'.getAppDomain();
        $item->custom_domain = null;

        $item->save();
        
        return redirect()->route('landingpages.index')
            ->with('success', __('You copy the landing page :name successfully',['name'=>$page->name]));
    }

    

    public function save(Request $request)
    {
        // random subdomain
        $request->request->add(['sub_domain' => generateRandomString(8).'.'.getAppDomain()]);

        $validator = Validator::make($request->all(),
            [
            'name' => 'required|max:255',
            'template_id' => 'required',
            'sub_domain'     => 'regex:/^(?:[-A-Za-z0-9]+\.)+[A-Za-z]{2,6}$/|unique:landing_pages|min:5'
            ]
        );
        $sub_domain = $request->input('sub_domain');
        $template_id = $request->input('template_id');

        // Get template ID content and style => load builder
        $template = Template::find($template_id);

        if (!$template) {
            return redirect()->route('alltemplates')
            ->with('error', __('Template id not found'));
        }

        $template = replaceVarContentStyle($template);

        $item = "";

        if ($validator->fails()) {
            return redirect()->back()->with('error',$validator->errors()->first());
        }   
        else{

            $item = LandingPage::create([
                'user_id'  => $request->user()->id,
                'name' => $request->input('name'),
                'html' => $template->content,
                'css' => $template->style,
                'thank_you_page_html' => $template->thank_you_page,
                'thank_you_page_css' => $template->thank_you_style,
                'template_id' => $template_id,
                'sub_domain' => $sub_domain,
                'settings' => [
                    "intergration" => [
                        "type" => "none",
                        "settings" => [],
                    ]
                ]
            ]);

        }
        return redirect()->route('landingpages.builder', ['code'=>$item->code]);
    }
   

    

    public function updateBuilder($code, $type = 'main-page', Request $request)
    {
        $type_arr = array('main-page','thank-you-page');
        
        if (!in_array($type, $type_arr)) {
            return response()->json(['error'=>__("Not Found Type")]);
        }

        if ($code) {
            
            $item = LandingPage::where('code', $code)->first();
            if ($item) {

                if ($type == 'thank-you-page') {
                    $item->thank_you_page_components = $request->input('gjs-components');
                    $item->thank_you_page_styles = $request->input('gjs-styles');
                    $item->thank_you_page_html = $request->input('gjs-html');
                    $item->thank_you_page_css = $request->input('gjs-css');
                }
                else{

                    $item->components = $request->input('gjs-components');
                    $item->styles = $request->input('gjs-styles');
                    $item->html = $request->input('gjs-html');
                    $item->css = $request->input('gjs-css');
                    $item->main_page_script = $request->input('main_page_script');
                    
                }
                
                
                if($item->save()){
                    return response()->json(['success'=>__("Updated successfully")]);
                }
            }
            
        }
        return response()->json(['error'=>__("Updated failed")]);
    }
   
    public function loadBuilder($code, $type = 'main-page', Request $request){
        
        $type_arr = array('main-page','thank-you-page');
        
        if (!in_array($type, $type_arr)) {
            return response()->json(['error'=>__("Not Found Type")]);
        }

        if ($code) {

            $page = LandingPage::where('user_id', $request->user()->id);
            $page = $page->where('code', $code)->first();
            if($page){
                
                if ($type == 'thank-you-page') {
                    return response()->json([
                        'gjs-components'=>$page->thank_you_page_components, 
                        'gjs-styles' => $page->thank_you_page_styles,
                        'gjs-html'=>$page->thank_you_page_html, 
                        'gjs-css' => $page->thank_you_page_css
                    ]);
                }
                return response()->json([
                    'gjs-components'=>$page->components, 
                    'gjs-styles' => $page->styles,
                    'gjs-html'=>$page->html, 
                    'gjs-css' => $page->css
                ]);
               
            }
            
        }
        abort(404);
    }
    

    public function builder($code, $type = 'main-page' ,Request $request){
        
        $type_arr = array('main-page','thank-you-page');
        if (!in_array($type, $type_arr)) {
            abort(404);
        }
       
        if ($code || !in_array($type,['main_page','thank-you-page'])) {

            $page = LandingPage::where('user_id', $request->user()->id);
            $page = $page->where('code', $code)->first();

            if($page){

                $blocks = Block::with('category')->where('active', true)->orderBy('name')->get();
                $blockscss = replaceVarContentStyle(config('app.blockscss'));
                $images_url = getAllImagesUser($request->user()->id);
                $all_icons = config('app.all_icons');

                return view('landingpage::landingpages.builder', compact('page','blocks','blockscss','images_url','all_icons'));
            }
            
        }
        abort(404);
    }

    public function setting($code,Request $request)
    {
        if ($code) {
            
            $data = LandingPage::where('user_id', $request->user()->id);
            
            $item = $data->where('code', $code)->first();
            

            $item_intergration = $item->settings['intergration'];


            if ($item) {
                $intergrations_data = config('intergrations.data');
                return view('landingpage::landingpages.settings', compact('item','intergrations_data','item_intergration'));
            }
            
        }
        abort(404);
    }
    public function settingUpdate($id,Request $request)
    {
        // add validate intergration
        $intergration_type = $request->intergration_type;

        $validate_intergration = [];

        if ($intergration_type == "mailchimp") {

            $validate_intergration = [
                'mailchimp.api_key'    => 'required',
                'mailchimp.contact_subscription_status'    => 'required',
                'mailchimp.mailing_list'    => 'required',
            ];
            
        }

        $validate = [
            'name'    => 'required',
            'domain_type'   => 'required|integer',
            'sub_domain'           => 'regex:/^(?:[-A-Za-z0-9]+\.)+[A-Za-z]{2,6}$/|unique:landing_pages,sub_domain,' . $id,
            'custom_domain'     => 'regex:/^(?:[-A-Za-z0-9]+\.)+[A-Za-z]{2,6}$/|unique:landing_pages,custom_domain,' . $id
        ];
        $validate = array_merge($validate, $validate_intergration);


        $request->validate($validate);


        if ($request->type_form_submit == 'url') {

            if (filter_var($request->redirect_url, FILTER_VALIDATE_URL) === FALSE) {
                return back()->with('error', __('Redirect URL Not a valid URL'));
            }
        }

        if ($request->type_payment_submit == 'url') {

            if (filter_var($request->redirect_url_payment, FILTER_VALIDATE_URL) === FALSE) {
                return back()->with('error', __('Redirect URL Not a valid URL'));
            }
        }

        $domain_main = '.'.getAppDomain();
        if (isset($request->sub_domain)) {
            # code...
            if (strpos($domain_main, $request->sub_domain)) {
                return back()->with('error', __('Subdomain must have ').$domain_main);
            }
        }
        

        $page  = LandingPage::findOrFail($id);

        $dataRequest = $request->all();
        
        if (!$request->filled('is_publish')) {
            $dataRequest['is_publish'] = false;
        } else {
            $dataRequest['is_publish'] = true;
        }
        
        // intergrations
        
        $intergration_setting = [
            "type" => "none",
            "settings" => [],
        ];

        switch ($intergration_type) {

            case 'mailchimp':

                $intergration_setting = [
                    "type" => $intergration_type,
                    "settings" => [
                        'api_key'    => $request->mailchimp['api_key'],
                        'contact_subscription_status'    => $request->mailchimp['contact_subscription_status'],
                        'mailing_list'    => $request->mailchimp['mailing_list'],
                        'merge_fields'  => $request->mailchimp['merge_fields'],
                    ]
                ];
                break;
            
            default:
                break;
        }

        $dataRequest['settings'] = [
            "intergration" => $intergration_setting
        ];

        $favicon = $request->file('favicon');

        if ($favicon) {
            $new_name = 'favicon' . '.' . $favicon->getClientOriginalExtension();
            $favicon->move(public_path('storage/pages/'.$id.'/'), $new_name);
            $dataRequest['favicon'] = $new_name;
        }

        $social_image = $request->file('social_image');
        if ($social_image) {
            $new_name = 'social_image' . '.' . $social_image->getClientOriginalExtension();
            $social_image->move(public_path('storage/pages/'.$id.'/'), $new_name);
            $dataRequest['social_image'] = $new_name;
        }
        
        $page->update($dataRequest);

        return back()->with('success', __('Updated successfully'));
    }
    

    public function previewTemplate($id){
        
        if ($id) {

            $template = Template::find($id);

            if (!$template) {
                return redirect()->route('alltemplates')
                ->with('error', __('Template id not found'));
            }
            $template = replaceVarContentStyle($template);

            $item = $template;

            return view('landingpage::landingpages.preview_template', compact('item'));
            
        }
        abort(404);
    }
    public function getTemplateJson($id,Request $request)
    {
        $template = Template::find($id);
        if (!$template) {
            return response()->json([
                'error' => __('Template id not found')
            ]);
        }
        $template = replaceVarContentStyle($template);
        $blockscss = replaceVarContentStyle(config('app.blockscss'));

        return response()->json([
            'blockscss'=>$blockscss, 
            'style' => $template->style,
            'content'=>$template->content, 
            'thank_you_page' => $template->thank_you_page,
            'thank_you_style' => $template->thank_you_style,
        ]);
    }

    public function frameMainPage($id){
        
        if ($id) {

            $template = Template::find($id);
            if (!$template) {
                return redirect()->route('alltemplates')
                ->with('error', __('Template id not found'));
            }
            return view('landingpage::landingpages.frame_main_page', compact('template'));
            
        }
        abort(404);
    }
    public function frameThankYouPage($id){
        
        if ($id) {

            $template = Template::find($id);
            if (!$template) {
                return redirect()->route('alltemplates')
                ->with('error', __('Template id not found'));
            }
            return view('landingpage::landingpages.frame_thank_you_page', compact('template'));
            
        }
        abort(404);
    }

    public function delete($code,Request $request)
    {
        if ($code) {
            
            $data = LandingPage::where('user_id', $request->user()->id);

            $item = $data->where('code', $code)->first();

            if($item){
                $item->delete();
                return redirect()->route('landingpages.index')->with('success', __('Deleted successfully'));
            }
        }
        abort(404);
    }

    public function searchIcon(Request $request){
        
        $response = "";
        if ($request->keyword) {

            $input = preg_quote($request->keyword, '~'); 
            $data = config('app.all_icons');
            $result = preg_grep('~' . $input . '~', $data);
            
            foreach ($result as $key => $value) {
                # code...
                $response.= '<i class="'.$value.'"></i>';
            }
            return response()->json(['result'=> $response]);
        }
        else{

            $data = config('app.all_icons');
            foreach ($data as $key => $value) {
                # code...
                $response.= '<i class="'.$value.'"></i>';
            }
            return response()->json(['result'=> $response]);
        }


    }
    public function uploadImage(Request $request)
    {
        $validator = Validator::make($request->all(), [
                'files' => 'required|mimes:jpg,jpeg,png,svg|max:20000',
        ]);
        if ($validator->fails()) {    
            return response()->json(['error' => __('The file must be an jpg,jpeg,png,svg')]);
        }
        $images=array();
        $imagesURL=array(); 

        if($request->hasfile('files'))
        {
            $file = $request->file('files');

            $name=$file->getClientOriginalName();
            $new_name = $name;
            $file->move(public_path('storage/user_storage/'.$request->user()->id), $new_name);
            $imagesURL[] = URL::to('/storage/user_storage/'.$request->user()->id."/".$new_name);
            $images[]=$new_name;

        }
        return response()->json($imagesURL);
    }

    public function deleteImage(Request $request)
    {
        $input=$request->all();
        $link_array = explode('/',$input['image_src']);
        $image_name = end($link_array);
        $path = public_path('storage/user_storage/'.$request->user()->id."/".$image_name);

        if(File::exists($path)) {
            File::delete($path);
        }
        return response()->json($image_name);
    }

    
}

