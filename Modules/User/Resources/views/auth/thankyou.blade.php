@extends('core::layouts.app')
@section('content')
<div class="row">
    <div class="col-md-12 col-md-offset-12">
        <div class="row">
            <div class="col-md-12">
                <h2 class="text-center">Thank you for making payment.</h2>
            </div>
            @if (Request::has('receipt_url'))
            <div class="col-md-12">
                <h4 class="text-center">
                    <a href="{{ Request::get('receipt_url') }}" target="_blank">
                        Click here to download you payment receipt
                    </a>
                </h4>
            </div>
            @endif
        </div>
        <br>
    </div>
</div>
<a href="{{ route('accountsettings.index') }}" class="btn btn-primary">Back</a>
@stop