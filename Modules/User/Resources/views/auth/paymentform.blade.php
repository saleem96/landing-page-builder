@extends('core::layouts.app')
@section('title', __('Account Settings'))
@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Payment Charges Setting</h1>
</div>
<div class="row">
    <div class="col-md-12">
        <form role="form" method="post" action="{{ route('paymentSettings.update') }}" autocomplete="off">
            @csrf
            @method('PUT')
            <div class="card">
                <div class="card-header">
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a class="nav-link active" href="#tab_profile" data-toggle="tab">
                               Payment comission/charges
                            </a>
                        </li>
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
                                        <label class="form-label">Charges Per lead</label>
                                        <input type="number" name="charge_pl" value="{{ $plan->charge_per_lead }}" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" placeholder="">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">charges after 1000 leads/month</label>
                                        <input type="number" name="charge_al" value="{{ $plan->charge_after }}" class="form-control disabled" placeholder="" >
                                        {{--  <small class="help-block">@lang("E-mail can't be changed")</small>  --}}
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
    </div>
</div>
@stop

