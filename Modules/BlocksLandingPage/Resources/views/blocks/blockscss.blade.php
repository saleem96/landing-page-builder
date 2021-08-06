@extends('core::layouts.app')

@section('title', __('Update'))

@section('content')
@php
//dd(config('app.blockscss'));
@endphp
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">@lang('Update style blocks css')</h1>
</div>
<div class="row">
        <div class="col-md-2">
                @include('core::partials.settings-sidebar')
            </div>
    <div class="col-md-10">
         <form role="form" method="post" action="{{ route('settings.blocks.updateblockscss') }}">
            @csrf
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <p><small>@lang('All blocks css styles are here. You can add or edit it when adding or editing a block').</small></p>
                            <div class="form-group">
                                <p><strong>@lang('Variable available in Style content'):</strong>  <code>##image_url##</code></p>
                                <label class="form-label">@lang('Blocks css')</label>
                                <textarea rows="8" name="blockscss" class="form-control">{{ config('app.blockscss') }}</textarea>
                            </div>
                        </div>
                        
                    </div>
                </div>
                <div class="card-footer">
                    <div class="d-flex">
                        <a href="{{ route('settings.blocks.index') }}" class="btn btn-secondary">@lang('Cancel')</a>
                        <button class="btn btn-success ml-auto">@lang('Save')</button>
                    </div>
                </div>
            </div>
        </form>


    </div>
    
</div>


@stop