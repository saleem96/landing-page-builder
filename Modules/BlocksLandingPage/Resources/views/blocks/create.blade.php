@extends('core::layouts.app')

@section('title', __('Create new block'))

@section('content')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">@lang('Create')</h1>
</div>
<div class="row">
        <div class="col-md-2">
                @include('core::partials.settings-sidebar')
            </div>
    <div class="col-md-10">
         <form role="form" method="post" action="{{ route('settings.blocks.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">

                            <div class="form-group">
                                <label class="form-label">@lang('Name')</label>
                                <input type="text" name="name" value="{{ old('name') }}" class="form-control" placeholder="@lang('Name')">
                            </div>
                            <div class="form-group">
                                <label class="form-label">@lang('Categories')</label>
                                 <select name="block_category_id" class="form-control">
                                    @foreach ($categories as $item)
                                        <option value="{{$item->id}}">{{$item->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label">@lang('Thumb')</label>
                                <input name="thumb" type="file"><br>
                            </div>

                            <div class="form-group">
                                <p><strong>@lang('Variable available in HTML content'):</strong>  <code>##image_url##</code></p>
                                
                                <label class="form-label">@lang('HTML content')</label>
                                <textarea rows="4" name="content" class="form-control"></textarea>
                            </div>
                            
                            <div class="form-group">
                                <div class="form-label">@lang('Active')</div>
                                <label class="custom-switch">
                                    <input type="checkbox" name="active" class="custom-switch-input">
                                    <span class="custom-switch-indicator"></span>
                                    <span class="custom-switch-description">@lang('Allow active block')</span>
                                </label>
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