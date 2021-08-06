<!doctype html>
<html lang="{{ app()->getLocale() }}" dir="ltr">

<head>
    @includeWhen(config('app.GOOGLE_ANALYTICS'), 'core::partials.google-analytics')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Language" content="{{ app()->getLocale() }}" />
    <meta name="msapplication-TileColor" content="#2d89ef">
    <meta name="theme-color" content="#4188c9">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" />
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="HandheldFriendly" content="True">
    <meta name="MobileOptimized" content="320">
    <link rel="shortcut icon" type="image/x-icon" href="{{ Storage::url(config('app.logo_favicon'))}}" />
    <title>@yield('title', config('app.name'))</title>
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,900" rel="stylesheet">
    <link rel="stylesheet" href="{{ Module::asset('landingpage:css/builder.css') }}">
    <link rel="stylesheet" href="{{ Module::asset('landingpage:css/customize.css') }}">
    <script src="{{ Module::asset('landingpage:js/builder.js') }}"></script>
   
    <script type="text/javascript">
      var config = {
        enable_edit_code: false,
        enable_slider: true,
        enable_countdown: true,
        enable_custom_code_block: true,
        url_get_products:  "{{ URL::to('ecommerce/products/getproducts') }}",
        all_icons: @json($all_icons)
      };
    </script>
    <script src="{{ Module::asset('landingpage:js/grapeweb.js') }}"></script>

</head>

 <body>
    <div id="mobileAlert">
      <div class="message">
        <h3>@lang('Builder not work on mobile')</h3>
        <a href ="{{ route('landingpages.index') }}">@lang('Back')</a>
      </div>
    </div>
   
    <input type="text" name="code" value="{{$page->code}}" hidden class="form-control">
    
    <div id="loadingMessage">
      <div class="lds-ring"><div></div><div></div><div></div><div></div></div>
    </div>
    <div class="btn-page-group">
        <a href="{{ URL::to('landingpages/builder/'.$page->code)}}" class="btn btn-light @if(request()->route('type') != 'thank-you-page') active @endif" id="btn-main-page">@lang('Main Page')</a>
        <a href="{{ URL::to('landingpages/builder/'.$page->code.'/thank-you-page') }}" class="btn btn-light @if(request()->route('type') == 'thank-you-page') active @endif" id="btn-thank-you-page">@lang('Thank You Page')</a>
    </div>
    <div id="gjs">
    </div>

    @php
      $arr_blocks = [];
      foreach ($blocks as $item) {
           $arr_temp = [];
           $arr_temp['id'] = $item->id;
           $arr_temp['thumb'] = URL::to('/').'/storage/thumb_blocks/'.$item->thumb;
           $arr_temp['name'] = $item->name;
           $arr_temp['category'] = $item->category->name;
           $arr_temp['content'] = $item->getReplaceVarBlockContent();
           array_push($arr_blocks, $arr_temp);
      }
    @endphp

    <script type="text/javascript">
      const type_page ='{{request()->route('type')}}';
      var urlStore = '{{ URL::to('landingpages/update-builder/'.$page->code.'/'.request()->route('type')) }}';
      var urlLoad = '{{ URL::to('landingpages/load-builder/'.$page->code.'/'.request()->route('type')) }}';
      var upload_Image = '{{ URL::to('uploadimage') }}';
      var url_default_css_template = '{{Module::asset('landingpage:css/template.css')}}';
      var back_button_url = "{{ URL::to('landingpages') }}";
      var publish_button_url = '{{ URL::to('landingpages/setting/'.$page->code) }}';
      var url_delete_image = '{{ URL::to('/deleteimage') }}';
      var url_search_icon = '{{ URL::to('/searchIcon') }}';

      var _token = '{{ csrf_token() }}';
      var images_url = @json($images_url);
      var blockscss = @json($blockscss);
      var blocks = @json($arr_blocks);
      
    </script>
    <script src="{{ Module::asset('landingpage:js/customize-builder.js') }}" ></script>

    
  </body>


</html>