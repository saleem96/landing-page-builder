@extends('themes::elsam.layout')
@section('content')
<div class="row">
  <div class="col-md-6 p-0">
    <div class="half">
          <div class="login-logo">
            <a class="" href="{{ url('/') }}">
              <img src="{{ Storage::url(config('app.logo_frontend'))}}" height="50" alt="logo">
            </a>
          </div>
          <form class="actionLogin mb-2" action="{{ route('login') }}" method="post">
            @csrf
            <div class="form-group first">
              <input class="form-control" type="text" name="email" placeholder="@lang('E-Mail Address')" required="">
            </div>
            <div class="form-group last mb-3">
              <input class="form-control" type="password" name="password" placeholder="@lang('Password')" required="">
            </div>
            
            <div class="d-flex mb-4 align-items-center">
              <label class="control control--checkbox mb-0"><span class="caption">@lang("Remember me")</span>
              <input type="checkbox" id="rememberMe" name="remember"  checked="checked"/>
              <div class="control__indicator"></div>
            </label>
            <span class="ml-auto">
              <a class="forgot-pass" href="{{ route('password.request') }}">@lang('I forgot password')</a>
            </span>
          </div>
          @if($errors->any())
          <div class="alert alert-danger">
            <ul class="list-unstyled mb-0">
              @foreach ($errors->all() as $error)
              <li> <i class="fas fa-times text-danger mr-2"></i> {{ $error }}</li>
              @endforeach
            </ul>
          </div>
          @endif
          <button class="btn btn-block btn-primary mt-2" type="submit">@lang('Sign in')</button>
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
          <a href="{{ route('register') }}">@lang("Don't have account yet?")</a>
        </p>
      </div>
  </div>
  <div class="col-md-6 bg-auth-layout">
    
  </div>
</div>

@endsection