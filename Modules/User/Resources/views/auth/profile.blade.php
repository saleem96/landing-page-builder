@extends('core::layouts.app')
@section('title', __('Account Settings'))
@section('content')
@if (session()->has('error'))
<div class="alert alert-danger">
<ul class="list-unstyled mb-0">
<li> <i class=""></i>{{ session()->get('error') }}</li>
</ul>
</div>
@endif
@if(session()->has('message'))
<div class="alert alert-danger">
<ul class="list-unstyled mb-0">
<li> <i class=""></i>{{ session('message') }}</li>
</ul>
</div>
@endif
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">@lang('Setting Account') &  @lang('Payment Settings')</h1>
</div>
<div class="row">
    <div class="col-md-12">
       
       @if (Auth::user()->is_admin)
        <form role="form" method="post" action="{{ route('accountsettings.update') }}" autocomplete="off">
            @csrf
            @method('PUT')
            <div class="card">
                <div class="card-header">
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a class="nav-link active" href="#tab_profile" data-toggle="tab">
                                @lang('Profile')
                            </a>
                        </li>
                        
                        @php
                            $views_render = accountSettingPayments(['user' => $user]);
                        @endphp

                                @if(!empty($views_render))
                                    <li class="nav-item">
                                        <a class="nav-link" href="#tab_payment_setting" data-toggle="tab">
                                            @lang('Payment Settings')
                                        </a>
                                    </li>
                                @endif
                         
                    </ul>
                </div>
         
                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_profile">
                            <div class="d-flex align-items-center justify-content-between">
                                <div><h4>&nbsp;</h4></div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">@lang('Name')</label>
                                        <input type="text" name="name" value="{{ $user->name }}" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" placeholder="@lang('Full name')">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">E-mail</label>
                                        <input type="email" value="{{ $user->email }}" class="form-control disabled" placeholder="E-mail" disabled>
                                        <small class="help-block">@lang("E-mail can't be changed")</small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">@lang('Password')</label>
                                        <input type="password" class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" name="password" placeholder="@lang('Password')">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">@lang('Confirm password')</label>
                                        <input type="password" class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" name="password_confirmation" placeholder="@lang('Confirm password')">
                                    </div>
                                    <div class="alert alert-info">
                                        @lang('Type new password if you would like to change current password.')
                                    </div>
                                </div>
                            </div>
                            <hr>
                        </div>
                        <div class="tab-pane" id="tab_payment_setting">
                            @if(!empty($views_render))
                                {!! $views_render !!}
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card-footer text-right">
                    <button type="submit" class="btn btn-primary btn-block">
                    <i class="fe fe-save mr-2"></i> @lang('Save settings')
                    </button>
                </div>
                </div> 
        </form>
        @else
        <form role="form" method="post" action="{{ route('accountsettings.update') }}" autocomplete="off">
            @csrf
            @method('PUT')
            <div class="card">
                <div class="card-header">
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a class="nav-link active" onclick="display3()" href="#tab_profile" data-toggle="tab">
                                @lang('Profile')
                            </a>
                        </li>
                        <li class="nav-item">
                        <div class="">
                            <button class="nav-link active" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              Select Payment Method
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                              <a class="dropdown-item" onclick="display()" >Pay With Credit Card</a>
                              <a class="dropdown-item" onclick="display2()"  >Pay With Paypal</a>
                              {{--  <a class="dropdown-item" href="#">Something else here</a>  --}}
                            </div>
                        </div>
                    </li>
                    </ul>
                </div>
         <div id="alert3">
                <div class="card-body" >
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_profile">
                            <div class="d-flex align-items-center justify-content-between">
                                <div><h4>&nbsp;</h4></div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">@lang('Name')</label>
                                        <input type="text" name="name" value="{{ $user->name }}" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" placeholder="@lang('Full name')">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">E-mail</label>
                                        <input type="email" value="{{ $user->email }}" class="form-control disabled" placeholder="E-mail" disabled>
                                        <small class="help-block">@lang("E-mail can't be changed")</small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">@lang('Password')</label>
                                        <input type="password" class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" name="password" placeholder="@lang('Password')">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">@lang('Confirm password')</label>
                                        <input type="password" class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" name="password_confirmation" placeholder="@lang('Confirm password')">
                                    </div>
                                    <div class="alert alert-info">
                                        @lang('Type new password if you would like to change current password.')
                                    </div>
                                </div>
                            </div>
                            <hr>
                        </div>
                        <div class="tab-pane" id="tab_payment_setting">
                            @if(!empty($views_render))
                                {!! $views_render !!}
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card-footer text-right">
                    <button type="submit" class="btn btn-primary btn-block">
                    <i class="fe fe-save mr-2"></i> @lang('Save settings')
                    </button>
                </div>
                </div> 
            </div>
        </form>
       <div class="card" id="alert4" style="display: none">
        <div class="card-header">
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a class="nav-link active" href="#tab_profile" data-toggle="tab">
                        @lang('Payment Settings')
                    </a>
                    
                    {{--  <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          Select Payment Method
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                          <a class="dropdown-item" onclick="display()" href="">Pay With Stripe</a>
                          <a class="dropdown-item" onclick="display2()"  href="">Pay With Paypal</a> 
                          <a class="dropdown-item" href="">Something else here</a>
                          </div>
                    </div>  --}}
                </li>
            </ul>
        </div>

       <div class="card-body" id="alert" style="display: none">
        <div class="tab-content" >
            <div class="row">
                <div class="col-md-4 col-md-offset-4">
                    <h3 class="text-left">Pay With Credit Card</h3>
                    <hr>
                    @if (session()->has('error'))
                        <div class="text-danger font-italic">{{ session()->get('error') }}</div>
                    @endif
                    <form action="{{ route('payments-new') }}"  method="post" id="payment-form">
                        @csrf
                        <div class="row form-group">
                            <div class="col-md-12">
                                <label for="name">Name</label>
                                @error('name')
                                <div class="text-danger font-italic">{{ $message }}</div>
                                @enderror
                                <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-12">
                                <label for="email">Email</label>
                                @error('email')
                                <div class="text-danger font-italic">{{ $message }}</div>
                                @enderror
                                <input type="text" name="email" id="email" class="form-control" value="{{ old('email') }}">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-12">
                                <label>Your Deposit amount in USD </label> <br>
                                {{--  <h2 class="text-muted">$1</h2>  --}}
                                <input type="number" min="1" class="form-control" name="amount">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-12">
                                <!-- Display errors returned by createToken -->
                                <label>Card Number</label>
                                <div id="paymentResponse" class="text-danger font-italic"></div>
                                <div id="card_number" class="field form-control"></div>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-4">
                                <label>Expiry Date</label>
                                <div id="card_expiry" class="field form-control"></div>
                            </div>
                            <div class="col-md-4">
                                <label>CVC Code</label>
                                <div id="card_cvc" class="field form-control"></div>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-12">
                                <div class="form-check form-check-inline custom-control custom-checkbox">
                                    <input type="checkbox" name="terms_conditions" id="terms_conditions" class="custom-control-input">
                                    <label for="terms_conditions" class="custom-control-label">
                                        I agree to terms & conditions
                                    </label>
                                </div>
                                @error('terms_conditions')
                                <div class="text-danger font-italic">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-12 small text-muted">
                                <div class="alert alert-warning">
                                    <strong>NOTE: </strong> All the payments are handled by <a target="_blank"
                                        href="https://stripe.com">STRIPE</a>. We dont store any of your data.
                                </div>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-12">
                                <div class="text-danger font-italic generic-errors"></div>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-6">
                                <input type="submit" value="Pay via Stripe" class="btn btn-primary pay-via-stripe-btn">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        </div>
        </div>
        @endif
        
         </div>
    </div>


                @if(session()->has('message'))
                    <p class="message">
                        {{ session('message') }}
                    </p>
                @endif
                <div class="card" >
            <div class="card-body" id="alert1" style="display: none">
                <div class="tab-content" >
                    <div class="row">
                        <div class="col-md-4 col-md-offset-4">
                            <h3 class="text-left">Paypal Payment </h3>
                            <hr>
                            {{--  @if (session()->has('error'))
                                <div class="text-danger font-italic">{{ session()->get('error') }}</div>
                            @endif  --}}
                            <form method="POST" action="{{ route('checkout.payment.paypal', ['order' => encrypt(mt_rand(1, 20))]) }}">
                                @csrf
                                <div class="row form-group">
                                    <div class="col-md-12">
                                        <label for="name">Name</label>
                                        @error('name')
                                        <div class="text-danger font-italic">{{ $message }}</div>
                                        @enderror
                                        <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}">
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-md-12">
                                        <label for="email">Email</label>
                                        @error('email')
                                        <div class="text-danger font-italic">{{ $message }}</div>
                                        @enderror
                                        <input type="text" name="email" id="email" class="form-control" value="{{ old('email') }}">
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-md-12">
                                        <label>Your Deposit amount in USD </label> <br>
                                        {{--  <h2 class="text-muted">$1</h2>  --}}
                                        <input type="number" min="1" class="form-control" name="amount">
                                    </div>
                                </div>
                            
                            
                                <div class="row form-group">
                                    <div class="col-md-12">
                                        <div class="text-danger font-italic generic-errors"></div>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-md-6">
                                        <input type="submit" value="Pay via Paypal" class="btn btn-primary fa fa-paypal">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row"></div>
               
                
        
            {{--  </div>  --}}
            {{--  <div class="gateway--paypal">
                <form method="POST" action="{{ route('checkout.payment.paypal', ['order' => encrypt(mt_rand(1, 20))]) }}">
                    {{ csrf_field() }}
                    <input type="text" class="form-control" name="amount">
                    <button class="btn btn-pay">
                        <i class="fa fa-paypal" aria-hidden="true"></i> Pay with PayPal
                    </button>
                </form>
            </div>  --}}
        {{--  </div>
    </div>  --}}
@stop

<script>
    function display() {
        document.getElementById("alert").style.display = "block";
        document.getElementById("alert1").style.display = "none";
        document.getElementById("alert3").style.display = "none";
        document.getElementById("alert4").style.display = "block";
    }

    function display2() {
        document.getElementById("alert1").style.display = "block";
        document.getElementById("alert4").style.display = "block";
        document.getElementById("alert").style.display = "none";
        document.getElementById("alert3").style.display = "none";
    }
    function display3() {
        document.getElementById("alert1").style.display = "none";
        document.getElementById("alert").style.display = "none";
        document.getElementById("alert3").style.display = "block";
        document.getElementById("alert4").style.display = "none";
    }
</script>
