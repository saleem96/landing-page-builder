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
          @if (session('status'))
          <div class="alert alert-success" role="alert">
            {{ session('status') }}
          </div>
          @endif
          <form class="actionLogin mb-2" action="{{ route('password.email') }}" method="post">
            @csrf
            <p class="text-muted">@lang('Enter your email address and your password will be reset and email to you.')</p>
            <div class="form-group first">
              <input class="form-control" type="text" name="email" placeholder="@lang('E-Mail Address')" required="">
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
          <button class="btn btn-block btn-primary mt-2" type="submit">@lang('Send me password reset link')</button>
        </form>
        <p class="mt-2">
          <a href="{{ route('register') }}">@lang("Don't have account yet?")</a>
        </p>
        <p>
          <a href="{{ route('login') }}">@lang('Already have account?')</a>
        </p>
    </div>
  </div>
  <div class="col-md-6 bg-auth-layout">
    
  </div>
</div>
@endsection