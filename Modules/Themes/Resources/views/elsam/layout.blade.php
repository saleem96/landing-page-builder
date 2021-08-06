<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        @includeWhen(config('app.GOOGLE_ANALYTICS'), 'core::partials.google-analytics')
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>{{ __(config('app.name')) }} &mdash; {{ config('app.SITE_SLOGAN') }}</title>
        <meta name="description" content="{{ config('app.SITE_DESCRIPTION') }}">
        <meta name="keywords" content="{{ config('app.SITE_KEYWORDS') }}">
        
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito+Sans:400,600,700&display=swap">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" type="text/css" href="{{ Module::asset('themes:elsam/css/bootstrap.min.css') }}"  />
        <link rel="stylesheet" type="text/css" href="{{ Module::asset('themes:elsam/css/materialdesignicons.min.css') }}"  />
        <link rel="stylesheet" type="text/css" href="{{ Module::asset('themes:elsam/css/pe-icon-7-stroke.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ Module::asset('themes:elsam/fonts/icomoon/style.css') }}" />
        <link rel="stylesheet" type="text/css" href="{{ Module::asset('themes:elsam/css/owl.carousel.css') }}" />
        <link rel="stylesheet" type="text/css" href="{{ Module::asset('themes:elsam/css/owl.theme.css') }}" />
        <link rel="stylesheet" type="text/css" href="{{ Module::asset('themes:elsam/css/owl.transitions.css') }}" />
        <link rel="stylesheet" type="text/css" href="{{ Module::asset('themes:elsam/css/style.css') }}"  />
        @stack('head')
    </head>
    <body data-spy="scroll" data-target="#navbarCollapse">
        @if (session('success'))
        <div class="alert alert-success border-radius-none">
            <i class="fas fa-check-circle text-success mr-2"></i> {!! session('success') !!}
        </div>
        @endif
        @if (session('error'))
        <div class="alert alert-danger border-radius-none">
            <i class="fas fa-times text-danger mr-2"></i> {!! session('error') !!}
        </div>
        @endif
        @yield('content')
        <!-- START FOOTER -->
        <section class="py-4 footer_bottom">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6 col-md-5 col-sm-6">
                        <p class="mb-0 f_400">@lang('Copyright') © {{ now()->year }} @lang('Desing by') <a href="{{ url('/') }}">{{ __(config('app.name')) }}</a></p>
                    </div>
                    
                    <div class="col-lg-6 col-md-4 col-sm-12">
                        <ul class="list-unstyled f_menu text-right">
                            {!! menuBottomSkins(['pagewebsites' => $pagewebsites]) !!}
                        </ul>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- END FOOTER -->
        <script src="{{ Module::asset('themes:elsam/js/jquery.min.js') }}"></script>
        <script src="{{ Module::asset('themes:elsam/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ Module::asset('themes:elsam/js/jquery.easing.min.js') }}"></script>
        <script src="{{ Module::asset('themes:elsam/js/jquery.mb.YTPlayer.js') }}"></script>
        <script src="{{ Module::asset('themes:elsam/js/contact.init.js') }}"></script>
        <script src="{{ Module::asset('themes:elsam/js/counter.init.js') }}"></script>
        <script src="{{ Module::asset('themes:elsam/js/owl.carousel.min.js') }}"></script>
        <script src="{{ Module::asset('themes:elsam/js/app.js') }}"></script>
        @stack('scripts')
    </body>
</html>