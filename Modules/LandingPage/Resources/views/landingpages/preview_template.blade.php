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
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,900" rel="stylesheet">
    
    <link rel="stylesheet" href="{{ Module::asset('core:core/core.css') }}">
    <link rel="stylesheet" href="{{ Module::asset('core:app/css/customize.css') }}">

    @stack('head')
    <script type="text/javascript">
    var BASE_URL = '{{ url('/') }}';
    </script>
  </head>
  <body class="">
    <div class="container-fluid pl-0 pr-0">
      @if($errors->any())
      <div class="alert alert-danger border-radius-none">
        <ul class="list-unstyled mb-0">
          @foreach ($errors->all() as $error)
          <li> <i class="fas fa-times text-danger mr-2"></i> {{ $error }}</li>
          @endforeach
        </ul>
      </div>
      @endif
      @if (session('error'))
      <div class="alert alert-danger border-radius-none">
        <i class="fas fa-times text-danger mr-2"></i> {!! session('error') !!}
      </div>
      @endif
      <div class="row mr-0">
        <div class="col-lg-12 navbar_section pr-0">
          <div class="navbar-area-start">
            <div class="row mr-0">
              <div class="col-lg-3 col-md-12">
                <div class="navbar-page-list">
                  <div class="page_navbar">
                    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ url('dashboard') }}">
                      <div class="sidebar-brand-icon">
                        <img src="{{ Storage::url(config('app.logo_frontend'))}}" alt="" height="40">
                      </div>
                    </a>
                  </div>
                </div>
              </div>
              <div class="col-lg-3 col-md-12">
                <div class="display-view text-center">
                  <a href="#" class="active" id="labtop_device"><i class="fas fa-desktop"></i></a>
                  <a href="#" id="tablet_device" ><i class="fas fa-tablet-alt"></i></a>
                  <a href="#" id="mobile_device" class="" ><i class="fas fa-mobile-alt"></i></a>
                </div>
              </div>
              <div class="col-lg-3 col-md-12 text-center">
                <button id="btn-main-page" class="btn btn-secondary active">@lang('Main Page')</button>
                <button id="btn-thank-you-page" class="btn btn-secondary">@lang('Thank You Page')</button>
              </div>
              <div class="col-lg-3 col-md-12 text-center">
                <button class="btn btn-primary btn_builder_template" data-id="{{$item->id}}" data-toggle="modal" data-target="#createModal">@lang('Use Template')</button>
              </div>
              
            </div>
          </div>
        </div>
      </div>
      <div class="website-append">
        <iframe id="frameMainPage" src="{{ url('landingpages/frame-main-page/' . $item->id) }}" frameborder="0"></iframe>
        <iframe id="frameThankYouPage" class="d-none" src="{{ url('landingpages/frame-thank-you-page/' . $item->id) }}" frameborder="0"></iframe>
      </div>
      
    </div>
    {{-- Modal --}}
    <div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">@lang('New Landing Page')</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form id="" action="{{route('landingpages.save')}}" method="post" enctype='multipart/form-data'>
            @csrf
            <div class="modal-body">
              <div class="form-group">
                <input type="number" class="form-control" name="template_id" hidden="" required="" id="template_id_builder">
                <label for="name" class="col-form-label">@lang('Name'):</label>
                <input type="text" class="form-control" name="name" required="" id="page-name">
              </div>
              
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('Close')</button>
              <button type="submit" class="btn btn-primary" id="saveandbuilder">@lang('Save & Builder')</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    {{-- End Modal --}}
    <script src="{{ Module::asset('core:core/core.js') }}" ></script>
    <script src="{{ Module::asset('landingpage:js/app.js') }}" ></script>

  </body>
</html>