<!doctype html>
<html lang="{{ app()->getLocale() }}" dir="ltr">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
        <title>{{$page->seo_title}}</title>
        <meta name="description" content="{{$page->seo_description}}">
        <meta name="keywords" content="{{$page->keywords}}">
        <!-- Apple Stuff -->
        <link rel="apple-touch-icon" href="{{ URL::to('/') }}/storage/pages/{{ $page->id }}/{{ $page->favicon }}">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="black">
        <meta name="apple-mobile-web-app-title" content="Title">
        <!-- Google / Search Engine Tags -->
        <meta itemprop="name" content="{{$page->seo_title}}">
        <meta itemprop="description" content="{{$page->seo_description}}">
        <meta itemprop="image" content="@if($page->social_image){{ URL::to('/') }}/storage/pages/{{ $page->id }}/{{ $page->social_image }}@endif">

        <!-- Facebook Meta Tags -->
        <meta property="og:type" content="website">
        <meta property="og:title" content="{{$page->social_title}}">
        <meta property="og:description" content="{{$page->social_description}}">
        <meta property="og:image" content="@if($page->social_image){{ URL::to('/') }}/storage/pages/{{ $page->id }}/{{ $page->social_image }}@endif">
        <meta property="og:url" content="{{ getLandingPageCurrentURL($page) }}">
        
        <!-- Twitter Meta Tags -->
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" content="{{$page->social_title}}">
        <meta name="twitter:description" content="{{$page->social_description}}">
        <meta name="twitter:image" content="@if($page->social_image){{ URL::to('/') }}/storage/pages/{{ $page->id }}/{{ $page->social_image }}@endif">
        @if($page->favicon)
        <link rel="icon" href="{{ URL::to('/') }}/storage/pages/{{ $page->id }}/{{ $page->favicon }}" type="image/png">
        @else
        <link rel="icon" href="{{ Storage::url(config('app.logo_favicon'))}}" type="image/png">
        @endif
        <!-- MS Tile - for Microsoft apps-->
        <meta name="msapplication-TileImage" content="{{ URL::to('/') }}/storage/pages/{{ $page->id }}/{{ $page->favicon }}">

        <link rel="stylesheet" href="{{ Module::asset('landingpage:css/template.css') }}">
        <link rel="stylesheet" href="{{ Module::asset('landingpage:css/custom-publish.css') }}">
        @if (Module::find('Ecommerce'))
            <script src="https://js.stripe.com/v3/"></script>
        @endif
    </head>

    <body class="">
        <div id="loadingMessage">
          <div class="lds-ring"><div></div><div></div><div></div><div></div></div>
        </div>

        @if($check_remove_brand == false)
            <div class="action_footer">
                <a href="{{ URL::to('/') }}" class="cd-top">
                    {{ config('app.name') }}
                </a>
            </div>
        @endif
        <script>
            window._formLink = "{{ url('/')."/form-submission/".$page->code }}";
            window._loadPageLink = "{{ url('/')."/get-page-json/".$page->code }}";
            window._orderLink = "{{ url('/')."/order-submission/".$page->code }}";

            window._thankYouURL = "{{ getLandingPageCurrentURL($page)."/thank-you" }}";

            window._token = "{{ csrf_token() }}";
        </script>
        
        <script src="{{ Module::asset('landingpage:js/publish.js') }}"></script>
        <script src="{{ Module::asset('landingpage:js/main-page.js') }}"></script>

    </body>
</html>