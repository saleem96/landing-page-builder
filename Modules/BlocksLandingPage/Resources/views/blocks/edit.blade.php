@extends('core::layouts.app')

@section('title', __('Update'))

@section('content')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">@lang('Update')</h1>
</div>
<div class="row">
        <div class="col-md-2">
                @include('core::partials.settings-sidebar')
            </div>
    <div class="col-md-10">
        <form role="form" method="post" action="{{ route('settings.blocks.update', $block->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">

                            <div class="form-group">
                                <label class="form-label">@lang('Name')</label>
                                <input type="text" name="name" value="{{$block->name}}" class="form-control" placeholder="@lang('Name')">
                            </div>
                            <div class="form-group">
                                <label class="form-label">@lang('Categories')</label>
                                 <select name="block_category_id" class="form-control">
                                    @foreach ($categories as $item)
                                        <option value="{{$item->id}}"
                                         @if ($item->id == $block->block_category_id)
                                            selected="selected"
                                        @endif
                                        >
                                        {{$item->name}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label">@lang('Thumb')</label>
                                 <input name="thumb" type="file"><br>
                                 <img src="{{ URL::to('/') }}/storage/thumb_blocks/{{ $block->thumb }}" data-value="" class="img-thumbnail" style="max-width: 100px; max-height: 100px;" />
                                <input type="hidden" name="hidden_image" value="{{ $block->thumb }}" />
                            </div>

                            <div class="form-group">
                                <p><strong>@lang('Variable available in HTML content'):</strong>  <code>##image_url##</code></p>
                                
                                <label class="form-label">@lang('HTML content')</label>

                                <textarea name="content" id="" rows="4" class="form-control">{{$block->content}}</textarea>
                            </div>
                            <div class="form-group">
                                <div class="form-label">@lang('Active')</div>
                                <label class="custom-switch">
                                    @if ($block->active)
                                        <input type="checkbox" name="active" value="1" class="custom-switch-input" checked>
                                    @else 
                                        <input type="checkbox" name="active" value="1" class="custom-switch-input" >
                                    @endif
                                    
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
                        <button class="btn btn-primary ml-auto">@lang('Save')</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    
</div>
@stop