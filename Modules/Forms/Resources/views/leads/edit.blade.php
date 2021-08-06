@extends('core::layouts.app')

@section('title', __('Edit lead'))

@section('content')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">@lang('Edit lead')</h1>
</div>
<div class="row">
    <div class="col-md-8">

        <form role="form" method="post" action="{{ route('leads.update', $item->id) }}" enctype="multipart/form-data">
            @csrf
            <div class="card">
                <div class="card-body" id="card-body-leads">
                    @if(isset($item->field_values) && is_array($item->field_values))
                    @foreach($item->field_values as $key => $value)
                        @php
                            $id_temp = generateRandomString(8);
                        @endphp
                        <div class="row" id="row-{{$id_temp}}">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label">{{$key}}</label>
                                    <div class="row">
                                        <div class="col-md-10">
                                            <input type="text" name="{{ $key }}" value="{{ $value }}" required class="form-control" placeholder="{{$key}}">
                                        </div>
                                        <div class="col-md-2">
                                            <button type="button" class="btn btn-danger btn-lead-delete" id="{{$id_temp}}">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    @endforeach
                    @endif
                    <div class="row" id="row-button-add-field">
                        <div class="col-md-12">
                            <button type="button" class="btn btn-success" id="btn-add-field-lead">
                                <i class="fas fa-plus"></i> @lang('Add field')
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="d-flex">
                        <a href="{{ route('leads.index') }}" class="btn btn-secondary">@lang('Cancel')</a>
                        <button class="btn btn-primary ml-auto">@lang('Save')</button>
                    </div>
                </div>
            </div>
        </form>

    </div>
    
    @push('scripts')
      <script src="{{ Module::asset('forms:js/lead.js') }}" ></script>
    @endpush
    
</div>


@stop