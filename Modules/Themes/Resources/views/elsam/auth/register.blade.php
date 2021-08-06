@extends('themes::elsam.layout')
@section('content')
@if(config('recaptcha.api_site_key') && config('recaptcha.api_secret_key'))
@push('head')
{!! htmlScriptTagJsApi() !!}
@endpush
@endif

<div class="row">
  <div class="col-md-6 p-0">
    <div class="half">
      <div class="login-logo">
        <a class="" href="{{ url('/') }}">
          <img src="{{ Storage::url(config('app.logo_frontend'))}}" height="50" alt="logo">
        </a>
      </div>
      <form class="actionLogin mb-2" action="{{ route('register') }}" method="post">
        @csrf
        <div class="form-group first">
          <input class="form-control" type="text" name="name"  value="{{ old('name') }}" placeholder="@lang('Enter name')" required="">
        </div>
        <div class="form-group first">
          <input class="form-control" type="text" name="email" value="{{ old('email') }}" placeholder="@lang('E-Mail Address')" required="">
        </div>
        <div class="form-group first">
          <input class="form-control" type="password" name="password" placeholder="@lang('Password')" required="">
        </div>
        <div class="form-group last mb-3">
          <input class="form-control" type="password" name="password_confirmation" placeholder="@lang('Confirm password')" required="">
        </div>
        @if(config('recaptcha.api_site_key') && config('recaptcha.api_secret_key'))
        <div class="form-group">
          {!! htmlFormSnippet() !!}
          @if ($errors->has('g-recaptcha-response'))
          <div class="text-red mt-1">
            <small><strong>{{ $errors->first('g-recaptcha-response') }}</strong></small>
          </div>
          @endif
        </div>
        @endif
        @if($errors->any())
        <div class="alert alert-danger">
          <ul class="list-unstyled mb-0">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
        @endif
        <button class="btn btn-block btn-primary mt-2" type="submit">@lang('Register')</button>
      </form>
      <div class="social-login">
        @if(config('services.facebook.client_id') && config('services.facebook.client_secret'))
        <a href="{{ route('login.social', 'facebook') }}" class="facebook btn d-flex justify-content-center align-items-center">
          <span class="icon-facebook mr-3"></span> @lang('Login with Facebook')
        </a>
        @endif
        @if(config('services.google.client_id') && config('services.google.client_secret'))
        <a href="{{ route('login.social', 'google') }}" class="google btn d-flex justify-content-center align-items-center">
          <span class="icon-google mr-3"></span> @lang('Login with Google')
        </a>
        @endif
      </div>
      <p class="mt-2">
        <a href="{{ route('login') }}">@lang('Already have account?')</a>
      </p>
    </div>
  </div>
  <div class="col-md-6 bg-auth-layout">
    
  </div>
</div>

@endsection