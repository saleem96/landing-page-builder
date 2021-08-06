@extends('core::layouts.app')

@section('title', __('Update Group catetory'))

@section('content')


<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">@lang('Update Group catetory')</h1>
</div>
<div class="row">
        <div class="col-md-2">
                @include('core::partials.settings-sidebar')
            </div>
    <div class="col-md-10">

        <form role="form" method="post" action="{{ route('settings.groupcategories.update', $category->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">

                            <div class="form-group">
                                <label class="form-label">@lang('Name')</label>
                                <input type="text" name="name" value="{{$category->name}}" class="form-control" placeholder="@lang('Name')">
                            </div>
                            

                        </div>
                        
                    </div>

                </div>
                <div class="card-footer">
                    <div class="d-flex">
                        <a href="{{ route('settings.groupcategories.index') }}" class="btn btn-secondary">@lang('Cancel')</a>
                        <button class="btn btn-primary ml-auto">@lang('Save')</button>
                    </div>
                </div>
            </div>
        </form>

    </div>
    
</div>
@stop
