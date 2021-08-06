<?php

namespace Modules\Themes\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\LandingPage\Entities\LandingPage;
use Modules\User\Entities\User;
use Illuminate\Support\Facades\App;
use JoeDixon\Translation\Drivers\Translation;
use Module;

class ThemesController extends Controller
{
    public function __construct(Translation $translation)
    {
        $this->translation = $translation;
    }
    
    public function getLandingPage(Request $request)
    {
        if ($request->domain == getAppDomain()) {

            $skin            = config('app.SITE_LANDING');
            $currency_symbol         = config('app.CURRENCY_SYMBOL');
            $currency_code   = config('app.CURRENCY_CODE');
            $user            = $request->user();
            return view('themes::' . $skin . '.home', compact(
                'user','currency_symbol','currency_code'
            ));
        }
        else{

            $page = $request->page;

            $blockscss = replaceVarContentStyle(config('app.blockscss'));
            $user = User::find($page->user_id);
            $check_remove_brand = 1;

            if (Module::find('Saas')) {
                $check_remove_brand = $user->checkRemoveBrand();
            }

            return view('landingpage::landingpages.publish_page', compact(
                'page','blockscss','check_remove_brand'
            ));

        }

    }
    public function getPageJson(Request $request)
    {
        $page = $request->page;
        $blockscss = replaceVarContentStyle(config('app.blockscss'));
        return response()->json([
            'blockscss'=>$blockscss, 
            'css' => $page->css,
            'html'=>$page->html, 
            'custom_header' => $page->custom_header,
            'custom_footer' => $page->custom_footer,
            'thank_you_page_css' => $page->thank_you_page_css,
            'thank_you_page_html' => $page->thank_you_page_html,
            'main_page_script' => $page->main_page_script,
        ]);

    }
    public function thankYouPage(Request $request){
        
        if ($request->domain == getAppDomain()) {
            abort(404);
        }
        else{

            $page = $request->page;
            $blockscss = replaceVarContentStyle(config('app.blockscss'));
            $user = User::find($page->user_id);
            $check_remove_brand = 1;

            if (Module::find('Saas')) {
                $check_remove_brand = $user->checkRemoveBrand();
            }

            return view('landingpage::landingpages.publish_thank_page', compact(
                'page','blockscss','check_remove_brand'
            ));

        }
    }

    public function localize($locale)
    {
        
        $languages = $this->translation->allLanguages();
        $locale = $languages->has($locale) ? $locale : config('app.fallback_locale');

        App::setLocale($locale);

        session()->put('locale', $locale);

        return redirect()->back();
    }



    
   


}
