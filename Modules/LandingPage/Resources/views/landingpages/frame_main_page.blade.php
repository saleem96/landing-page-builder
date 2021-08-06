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
    <link rel="icon" href="{{ Storage::url(config('app.logo_favicon'))}}" type="image/png">
    <link rel="shortcut icon" type="image/x-icon" href="{{ Storage::url(config('app.logo_favicon'))}}" />
    <title>@yield('title', config('app.name'))</title>
    <link rel="stylesheet" href="{{ Module::asset('landingpage:css/template.css') }}">
    
</head>
 <body>

    <script>
            window._loadTemplateLink = "{{ url('/landingpages')."/get-template-json/".$template->id }}";
            window._token = "{{ csrf_token() }}";
    </script>
    <script src="{{ Module::asset('landingpage:js/publish.js') }}"></script>
    <script src="{{ Module::asset('landingpage:js/frame-main.js') }}"></script>
</body>

</html>