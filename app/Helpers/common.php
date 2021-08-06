<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\File;
use Nwidart\Modules\Facades\Module;
use Illuminate\Support\Facades\DB;
use Modules\Core\Library\License;
use Modules\LandingPage\Entities\LandingPage;

if (!function_exists('ruleMailChimpForAddContact')) {

    function ruleMailChimpForAddContact($landing_page,$form_data) {

        if (isset($landing_page->settings['intergration'])) {

            $intergration = $landing_page->settings['intergration'];
            
            if (isset($intergration['type']) && $intergration['type'] != "none") {
                // Check field email exits and valid.
                $field_values = $form_data->field_values;
                if (isset($field_values['email']) && !empty($field_values['email'])) {
                    if (filter_var($field_values['email'], FILTER_VALIDATE_EMAIL)) {
                        return true;
                    }
                }
            }
        }

        return false;
    }
}

if (!function_exists('getColorStatus')) {

    function getColorStatus($status = '') {

        switch ($status) {
            case 'OPEN':
                # code...
                return "primary";

                break;
            
            case 'COMPLETED':
                # code..
                return "success";

                break;
            
            case 'CANCELED':
                # code...
                return "danger";

                break;

            default:
                # code...
                return $status;
                break;
        }
    }
}
if (!function_exists('getValueIfKeyIsset')) {

    function getValueIfKeyIsset($array, $key) {

        if (isset($array[$key])) {
            
            if (is_numeric($array[$key])) {
                return intval($array[$key]);
            }
            return $array[$key];
        }
        return null;
    }
}

if (!function_exists('checkIssetAndNotEmptyKeys')) {

    function checkIssetAndNotEmptyKeys($array = [], $array_keys = []) {

        foreach ($array_keys as $key) {
            if (!isset($array[$key]) || empty($array[$key])) {
                 return false;
            }
        }
        return true;
    }
}

if (!function_exists('getLandingPageCurrentURL')) {

    function getLandingPageCurrentURL(LandingPage $page) {
        
        $url = "http://";
        
        if ($page) {
            if ($page->domain_type == 0) {
                $url .= $page->sub_domain;
            }else{
                $url .= $page->custom_domain;
            }
        }
        return $url;
    }
}

if (!function_exists('QueryJsonPage')) {

    function QueryJsonPage($json = '', $type='') {

        $q = new Jsonq($json);
        $res = $q->where('type', '=', $type)->get()->result();

        return $res;
    }
}
if (!function_exists('getAppDomain')) {

    function getAppDomain() {
        $app_url = config('app.url');
        $parse = parse_url($app_url);
        $domain_main =  $parse['host'];
        return $domain_main;
    }
}

if (!function_exists('publishLangModule')) {

    function publishLangModule($name_module = "") {

        if(!empty($name_module)) {
            
            $module = Module::find($name_module);
            
            if (!$module) {

                return false;
            }

            $path_lang_module = $module->getPath().'/Resources'.'/lang/en';

            if(File::exists($path_lang_module)) {
                
                File::copyDirectory($path_lang_module, resource_path('lang/en'));

            }
            return true;
            // call
        }else{

            // publish lang all module
            $all_modules = Module::all();
            foreach ($all_modules as $item) {

                $path_lang_module = $item->getPath().'/Resources'.'/lang/en';
                
                if(File::exists($path_lang_module)) {
                    
                    File::copyDirectory($path_lang_module, resource_path('lang/en'));

                }
            }
        }
        return true;

    }
}
if (!function_exists('getAllJSModules')) {

    function getAllAssetsModulesForApp($type = '') {
        
        // publish lang all module
        $html = "";
        $types_arr = array("css", "js");
        if (!in_array($type, $types_arr)) {
            return $html;
        }

        $all_modules = Module::all();
        foreach ($all_modules as $module) {

            $path_assets = $module->getPath().'/Resources'.'/assets/app/'.$type;
            
            if(File::exists($path_assets)) {

                $files = File::allfiles($path_assets);

                foreach ($files as $item) {

                    if (!empty($item->getContents())) {

                        if ($type == "css") {
                            $html .= "<link rel='stylesheet' href=".Module::asset($module->getLowerName().':app/css/'.$item->getFilename()).">\n";
                        }
                        elseif($type == "js"){
                            $html .= "<script src=".Module::asset($module->getLowerName().':app/js/'.$item->getFilename())." ></script>\n";
                        }
                        
                    }
                }
            }
        }
        return $html;

    }
}


if(!function_exists("check_product_purchase")){

    function check_product_purchase($product_id){
        $item = DB::table('purchase_managers')->where('product_id', $product_id)->first();
        if(empty($item)){
            return false;
        }
        return $item;
    }
}

if(!function_exists("get_latest_version_product_id")){

    function get_latest_version_product_id($product_id){
        $license = new License($product_id);
        $response = $license->getLatestVersion();
        if ($response['status'] == true) {
            return $response;
        }
        
        return false;
    }
}

if(!function_exists("get_percentage")){

    function get_percentage($total, $number)
    {
      if ( $total > 0 ) {
       return number_format(($number / $total) * 100);

      } else {
        return 0;
      }
    }
}
if(!function_exists("random_color")){

    function random_color()
    {
        $items = array("primary", "success", "info", "warning", "danger" , "secondary", "dark");
        return $items[array_rand($items)];
    }
}

if(!function_exists("get_color_chart_count")){

    function get_color_chart_count($count = 0)
    {
        
        $items = ["#4353FF", "#1cc88a", "#36b9cc", "#f6c23e", "#e74a3b","#5a5c69", "#3366cc","#dc3912","#ff9900","#109618","#990099","#0099c6","#dd4477","#66aa00","#b82e2e","#316395","#3366cc","#994499","#22aa99","#aaaa11","#6633cc","#e67300","#8b0707","#651067","#329262","#5574a6","#3b3eac","#b77322","#16d620","#b91383","#f4359e","#9c5935","#a9c413","#2a778d","#668d1c","#bea413","#0c5922","#743411"];
        
        $output = array_slice($items, 0, $count);

        return $output;
        // return $items[array_rand($items)];
    }
}



if(!function_exists("getDeviceTracking")){

    function getDeviceTracking($tracking){
        
        if($tracking->isMobile()){

            return "Mobile";
        }
        elseif($tracking->isTablet()){

            return "Tablet";
        }
        elseif($tracking->isDesktop()){
            
            return "Desktop";
        }
        else{
            return "Unknown";
        }
    }
}


/*Settings*/

if(!function_exists("get_option")){

    function get_option($key, $value = ""){

        if (File::exists(storage_path('installed'))){

            $option = DB::table('settings')->where('key', $key)->first();
            if(empty($option)){
                DB::table('settings')->insert(
                    ['key' => $key, 'value' => $value]
                );
                return $value;
            }else{
                return $option->value;
            }

        }
        return $value;
        
    }
}

if(!function_exists("update_option")){

    function update_option($key, $value){

        $option = DB::table('settings')->where('key', $key)->first();
        if(empty($option)){
            DB::table('settings')->insert(
                ['key' => $key, 'value' => $value]
            );
        }else{
            DB::table('settings')
            ->where('key', $key)
            ->update(['value' => $value]);
        }
    }
}
if (!function_exists('getPaymentsvailable')) {

    function getPaymentsvailable() {
        $modules = Module::all();
        $payments = [];
        if ($modules) {

            foreach ($modules as $module) {
                $name_module = $module->getLowerName();
                $config = config($name_module.'.payment');
                if(!empty($config)){

                    if (count($config) > 0) {
                       foreach ($config as $item) {
                           $payments[] = $item;

                       }
                    }

                }
                
            }
           
        }
        return $payments;
    }
}



if (!function_exists('accountSettingPayments')) {

    function accountSettingPayments($data = []) {
        $modules = Module::all();
        $html = "";
        $config_module = [];
        $modules_sort = [];
        if ($modules) {
            foreach ($modules as $module) {
                $name_module = $module->getLowerName();
                $menu_config = config($name_module.'.menu');
                
                if(view()->exists($name_module.'::moduletemplates.module-account-payment') && !empty($menu_config['account_payment_position'])){
                    $tmp['name'] = $name_module;
                    $tmp['account_payment_position'] = $menu_config['account_payment_position'];
                    $modules_sort[] =  $tmp;
                }
                
            }
            // sort
            usort($modules_sort, function ($item1, $item2) {
                return $item1['account_payment_position'] <=> $item2['account_payment_position'];
            });

            // get view Template
            foreach ($modules_sort as $item) {
                $html .= view($item['name'].'::moduletemplates.module-account-payment',compact('data'))->render(); 
            }
                
        }
        return $html;
    }
}

if (!function_exists('settingPayments')) {

    function settingPayments($data = []) {
        $modules = Module::all();
        $html = "";
        $config_module = [];
        $modules_sort = [];
        if ($modules) {
            foreach ($modules as $module) {
                $name_module = $module->getLowerName();
                $menu_config = config($name_module.'.menu');
                
                if(view()->exists($name_module.'::moduletemplates.module-setting-payment') && !empty($menu_config['setting_payment_position'])){
                    $tmp['name'] = $name_module;
                    $tmp['setting_payment_position'] = $menu_config['setting_payment_position'];
                    $modules_sort[] =  $tmp;
                }
                
            }
            // sort
            usort($modules_sort, function ($item1, $item2) {
                return $item1['setting_payment_position'] <=> $item2['setting_payment_position'];
            });

            // get view Template
            foreach ($modules_sort as $item) {
                $html .= view($item['name'].'::moduletemplates.module-setting-payment')->render(); 
            }
                
        }
        return $html;
    }
}
if (!function_exists('paymentSkins')) {

    function paymentSkins($data = []) {
        $modules = Module::all();
        $html = "";
        $config_module = [];
        $modules_sort = [];
        if ($modules) {
            foreach ($modules as $module) {
                $name_module = $module->getLowerName();
                $menu_config = config($name_module.'.menu');
                
                if(view()->exists($name_module.'::moduletemplates.module-payment-skins') && !empty($menu_config['payment_skins_position'])){
                    $tmp['name'] = $name_module;
                    $tmp['payment_skins_position'] = $menu_config['payment_skins_position'];
                    $modules_sort[] =  $tmp;
                }
                
            }
            // sort
            usort($modules_sort, function ($item1, $item2) {
                return $item1['payment_skins_position'] <=> $item2['payment_skins_position'];
            });

            // get view Template
            foreach ($modules_sort as $item) {
                $html .= view($item['name'].'::moduletemplates.module-payment-skins',compact('data'))->render(); 
            }
                
        }
        return $html;
    }
}
if (!function_exists('menuHeaderSkins')) {

    function menuHeaderSkins($data = []) {
        $modules = Module::all();
        $html = "";
        $config_module = [];
        $modules_sort = [];
        if ($modules) {
            foreach ($modules as $module) {
                $name_module = $module->getLowerName();
                $menu_config = config($name_module.'.menu');
                
                if(view()->exists($name_module.'::moduletemplates.module-header-skins') && !empty($menu_config['header_skins_position'])){
                    $tmp['name'] = $name_module;
                    $tmp['header_skins_position'] = $menu_config['header_skins_position'];
                    $modules_sort[] =  $tmp;
                }
                
            }
            // sort
            usort($modules_sort, function ($item1, $item2) {
                return $item1['header_skins_position'] <=> $item2['header_skins_position'];
            });

            // get view Template
            foreach ($modules_sort as $item) {
                $html .= view($item['name'].'::moduletemplates.module-header-skins')->render(); 
            }
                
        }
        return $html;
    }
}

if (!function_exists('menuBottomSkins')) {

    function menuBottomSkins($data = []) {

        $modules = Module::all();
        $html = "";
        $config_module = [];
        $modules_sort = [];
        if ($modules) {
            foreach ($modules as $module) {
                $name_module = $module->getLowerName();
                $menu_config = config($name_module.'.menu');
                
                if(view()->exists($name_module.'::moduletemplates.module-bottom-skins') && !empty($menu_config['bottom_skins_position'])){
                    $tmp['name'] = $name_module;
                    $tmp['bottom_skins_position'] = $menu_config['bottom_skins_position'];
                    $modules_sort[] =  $tmp;
                }

            }
            // sort
            usort($modules_sort, function ($item1, $item2) {
                return $item1['bottom_skins_position'] <=> $item2['bottom_skins_position'];
            });

            // get view Template
            foreach ($modules_sort as $item) {
                $html .= view($item['name'].'::moduletemplates.module-bottom-skins',compact('data'))->render(); 
            }
                
        }
        return $html;
    }
}


if (!function_exists('menuSiderbar')) {

    function menuSiderbar($data = []) {
        $modules = Module::all();
        $html = "";
        $config_module = [];
        $modules_sort = [];
        if ($modules) {
            
            foreach ($modules as $module) {
                $name_module = $module->getLowerName();
                $menu_config = config($name_module.'.menu');
                
                if(view()->exists($name_module.'::moduletemplates.module-sidebar') && !empty($menu_config['siderbar_position'])){
                    $tmp['name'] = $name_module;
                    $tmp['siderbar_position'] = $menu_config['siderbar_position'];
                    $modules_sort[] =  $tmp;
                }
                
            }
            // sort
            usort($modules_sort, function ($item1, $item2) {
                return $item1['siderbar_position'] <=> $item2['siderbar_position'];
            });

            // get view Template
            foreach ($modules_sort as $item) {
                $html .= view($item['name'].'::moduletemplates.module-sidebar')->render(); 
            }
                
        }
        return $html;
    }
}

if (!function_exists('menuAdminSettingSiderbar')) {

    function menuAdminSettingSiderbar($data = []) {
        $modules = Module::all();
        $html = "";
        $config_module = [];
        $modules_sort = [];
        if ($modules) {
            // sort module with siderbar position
            foreach ($modules as $module) {
                $name_module = $module->getLowerName();
                $menu_config = config($name_module.'.menu');
                
                if(view()->exists($name_module.'::moduletemplates.module-setting-sidebar') && !empty($menu_config['siderbar_setting_position'])){
                    $tmp['name'] = $name_module;
                    $tmp['siderbar_setting_position'] = $menu_config['siderbar_setting_position'];
                    $modules_sort[] =  $tmp;
                }
                
            }
            // sort
            usort($modules_sort, function ($item1, $item2) {
                return $item1['siderbar_setting_position'] <=> $item2['siderbar_setting_position'];
            });

            // get view template
            foreach ($modules_sort as $item) {
                $html .= view($item['name'].'::moduletemplates.module-setting-sidebar')->render(); 
            }
                
        }
        return $html;
    }
}
if (!function_exists('menuHeaderTop')) {

    function menuHeaderTop($data = []) {
        $modules = Module::all();
        $html = "";
        $config_module = [];
        $modules_sort = [];
        if ($modules) {
            // sort module with siderbar position
            foreach ($modules as $module) {
                $name_module = $module->getLowerName();
                $menu_config = config($name_module.'.menu');
                
                if(view()->exists($name_module.'::moduletemplates.module-header-top') && !empty($menu_config['header_top'])){
                    $tmp['name'] = $name_module;
                    $tmp['header_top'] = $menu_config['header_top'];
                    $modules_sort[] =  $tmp;
                }
                
            }
            // sort
            usort($modules_sort, function ($item1, $item2) {
                return $item1['header_top'] <=> $item2['header_top'];
            });

            // get view template
            foreach ($modules_sort as $item) {
                $html .= view($item['name'].'::moduletemplates.module-header-top')->render(); 
            }
                
        }
        return $html;
    }
}

if (!function_exists('generateRandomString')) {

    function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}

if (!function_exists('getAllImagesContentMedia')) {

    function getAllImagesContentMedia(){
        $path = public_path('storage/content_media');
        if(!File::exists($path)) {
            File::makeDirectory($path, $mode = 0755, true, true);
        }
        $images_url = [];
        $files = File::files($path);
        foreach ($files as $item) {
            # code...
            $images_url[] = URL::to('/storage/content_media')."/".$item->getFilename();
        }
        return $images_url;
        
    }
}

if (!function_exists('getAllImagesUser')) {

    function getAllImagesUser($user_id){
        $path = public_path('storage/user_storage/'.$user_id);
        if(!File::exists($path)) {
            File::makeDirectory($path, $mode = 0755, true, true);
        }
        $images_url = [];
        $files = File::files($path);
        foreach ($files as $item) {
            # code...
            $images_url[] = URL::to('/storage/user_storage/'.$user_id)."/".$item->getFilename();
        }
        return $images_url;
        
    }
}
if (!function_exists('getAllContentTemplate')) {

    function getAllContentTemplate(){
        $path = public_path('storage/content_media');
        $images_url = [];
        $files = File::files($path);
        foreach ($files as $item) {
            # code...
            $images_url[] = URL::to('/storage/content_media')."/".$item->getFilename();
        }
        return $images_url;
        
    }
}
if (!function_exists('replaceVarContentStyle')) {

    function replaceVarContentStyle($item=""){
        // Image URL: ##image_url##
        $results = array();
        $image_url = URL::to('/storage/content_media')."/";

        $temp = $item;
        if (is_object($item)) {
            if (isset($item->content)) {
                $temp->content = str_replace('##image_url##', $image_url, $item->content);
            }
            if (isset($item->style)) {
                $temp->style = str_replace('##image_url##', $image_url, $item->style);
            }
            if (isset($item->thank_you_page)) {
                $temp->thank_you_page = str_replace('##image_url##', $image_url, $item->thank_you_page);
            }
            if (isset($item->thank_you_style)) {
                $temp->thank_you_style = str_replace('##image_url##', $image_url, $item->thank_you_style);
            }
            
            
        }
        else{
            if (isset($item)) {
                $temp = str_replace('##image_url##', $image_url, $item);
            }
        }
        return $temp;
    }
}
if (!function_exists('saveImgBase64')) {

     function saveImgBase64($param, $folder)
    {
        list($extension, $content) = explode(';', $param);
        $tmpExtension = explode('/', $extension);
        preg_match('/.([0-9]+) /', microtime(), $m);
        $fileName = sprintf('img%s%s.%s', date('YmdHis'), $m[1], $tmpExtension[1]);
        $content = explode(',', $content)[1];
        $storage = Storage::disk('public');

        $checkDirectory = $storage->exists($folder);

        if (!$checkDirectory) {
            $storage->makeDirectory($folder);
        }

        $storage->put($folder . '/' . $fileName, base64_decode($content), 'public');

        return $fileName;
    }
}

if (!function_exists('cleanImages')) {

    function cleanImages(){

        $path = public_path('storage/thumb_templates');
        $images_url = [];
        $files = File::files($path);
        foreach ($files as $item) {
            # code...
            //$block = Template::where('thumb',$item->getFilename())->first();
            if (!$block) {
                $path_delete = $path."/".$item->getFilename();

                if(File::exists($path_delete)) {
                    File::delete($path_delete);
                }
            }
        }
        die("done");
    }
}
if (!function_exists('deleteImageWithPath')) {
    
    function deleteImageWithPath($path_delete){

        if(File::exists($path_delete)) {
            File::delete($path_delete);
        }
    }
}
if (!function_exists('setEnv')) {
    
    function setEnv($data)
    {
        if (empty($data) || !is_array($data) || !is_file(base_path('.env'))) {
            return false;
        }

        $env = file_get_contents(base_path('.env'));

        $env = explode("\n", $env);

        foreach ($data as $data_key => $data_value) {

            $updated = false;

            foreach ($env as $env_key => $env_value) {

                $entry = explode('=', $env_value, 2);

                // Check if new or old key
                if ($entry[0] == $data_key) {
                    $env[$env_key] = $data_key . '=' . $data_value;
                    $updated       = true;
                } else {
                    $env[$env_key] = $env_value;
                }
            }

            // Lets create if not available
            if (!$updated) {
                $env[] = $data_key . '=' . $data_value;
            }
        }

        $env = implode("\n", $env);

        file_put_contents(base_path('.env'), $env);

        return true;
    }
}

if (!function_exists('format_time')) {
    /**
     * @param Carbon $timestamp
     * @param string $format
     * @return string
     */
    function format_time(Carbon $timestamp, $format = 'j M Y H:i')
    {
        $first = Carbon::create(0000, 0, 0, 00, 00, 00);
        if ($timestamp->lte($first)) {
            return '';
        }

        return $timestamp->format($format);
    }
}

if (!function_exists('date_from_database')) {
    /**
     * @param string $time
     * @param string $format
     * @return string
     */
    function date_from_database($time, $format = 'Y-m-d')
    {
        if (empty($time)) {
            return $time;
        }

        return format_time(Carbon::parse($time), $format);
    }
}

if (!function_exists('human_file_size')) {
    /**
     * @param int $bytes
     * @param int $precision
     * @return string
     */
    function human_file_size($bytes, $precision = 2): string
    {
        $units = ['B', 'kB', 'MB', 'GB', 'TB'];

        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);

        $bytes /= pow(1024, $pow);

        return number_format($bytes, $precision, ',', '.') . ' ' . $units[$pow];
    }
}

if (!function_exists('get_file_data')) {
    /**
     * @param string $file
     * @param bool $toArray
     * @return bool|mixed
     */
    function get_file_data($file, $toArray = true)
    {
        $file = File::get($file);
        if (!empty($file)) {
            if ($toArray) {
                return json_decode($file, true);
            }
            return $file;
        }
        if (!$toArray) {
            return null;
        }
        return [];
    }
}

if (!function_exists('change_file_json')) {
    /**
     * @param string $file
     * @param bool $toArray
     * @return bool|mixed
     */
    function change_file_json($file, $key_change, $value_change)
    {
        $jsonString = file_get_contents($file);
        
        $data = json_decode($jsonString, true);
        $data[$key_change] = $value_change;
        
        $newJsonString = json_encode($data);

        file_put_contents($file, $newJsonString);
    }
}

if (!function_exists('json_encode_prettify')) {
    /**
     * @param array $data
     * @return string
     */
    function json_encode_prettify($data)
    {
        return json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    }
}

if (!function_exists('save_file_data')) {
    /**
     * @param string $path
     * @param array|string $data
     * @param bool $json
     * @return bool|mixed
     */
    function save_file_data($path, $data, $json = true)
    {
        try {
            if ($json) {
                $data = json_encode_prettify($data);
            }
            if (!File::isDirectory(File::dirname($path))) {
                File::makeDirectory(File::dirname($path), 493, true);
            }
            File::put($path, $data);

            return true;
        } catch (Exception $exception) {
            info($exception->getMessage());
            return false;
        }
    }
}

if (!function_exists('scan_folder')) {
    /**
     * @param string $path
     * @param array $ignoreFiles
     * @return array
     */
    function scan_folder($path, $ignoreFiles = [])
    {
        try {
            if (File::isDirectory($path)) {
                $data = array_diff(scandir($path), array_merge(['.', '..', '.DS_Store'], $ignoreFiles));
                natsort($data);
                return $data;
            }
            return [];
        } catch (Exception $exception) {
            return [];
        }
    }
}
