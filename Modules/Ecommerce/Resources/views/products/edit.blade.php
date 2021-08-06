@extends('core::layouts.app')

@section('title', __('Edit product'))

@section('content')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">@lang('Edit product')</h1>
</div>
<div class="row">
    <div class="col-md-8">

        <form role="form" method="post" action="{{ route('products.update', $item->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label">@lang('Name')</label>
                                <input type="text" name="name" value="{{ $item->name }}" required class="form-control" placeholder="@lang('Name')">
                            </div>
                        </div>
                       
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="form-label">@lang('Gross Price')</label>
                                <input type="number" required min="0" step="0.01" name="price" value="{{ $item->price }}" class="form-control" placeholder="@lang('Price')">
                            </div>
                            
                        </div>
                        <div class="col-md-9">
                            <div class="form-group">
                                <label class="form-label">@lang('Currency')</label>
                                <select name="currency" class="form-control">
                                    @foreach($currencies as $code => $title)
                                        <option value="{{ $code }}" {{ $item->currency === $code ? 'selected' : '' }}> {{ $title }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label">@lang('Description')</label>
                                <textarea class="form-control" name="description" rows="3">{{ $item->description }}</textarea>
                            </div>
                            
                        </div>
                        
                    </div>

                </div>
                <div class="card-footer">
                    <div class="d-flex">
                        <a href="{{ route('products.index') }}" class="btn btn-secondary">@lang('Cancel')</a>
                        <button class="btn btn-primary ml-auto">@lang('Save')</button>
                    </div>
                </div>
            </div>
        </form>

    </div>
    
</div>


@stop