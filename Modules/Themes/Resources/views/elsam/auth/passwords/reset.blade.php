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
          <p class="text-muted mb-4">@lang("Enter new password!")</p>
          <form class="actionLogin mb-2" action="{{ route('password.update') }}" method="post">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            <div class="form-group first">
              <input class="form-control" type="text" name="email" value="{{ old('email') }}" placeholder="@lang('E-Mail Address')" required="">
            </div>
            <div class="form-group first">
              <input class="form-control" type="password" name="password" placeholder="@lang('Password')" required="">
            </div>
            <div class="form-group last mb-3">
              <input class="form-control" type="password" name="password_confirmation" placeholder="@lang('Confirm password')" required="">
            </div>
            @if($errors->any())
            <div class="alert alert-danger">
              <ul class="list-unstyled mb-0">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
            @endif
            <button class="btn btn-block btn-primary mt-2" type="submit">@lang('Reset Password')</button>
          </form>
          <p class="mt-2">
            <a href="{{ route('login') }}">@lang('Already have account?')</a>
          </p>
    </div>
  </div>
  <div class="col-md-6 bg-auth-layout">
    
  </div>
</div>
@endsection