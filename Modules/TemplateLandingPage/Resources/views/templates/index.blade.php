@extends('core::layouts.app')
@section('title', __('Templates'))
@section('content')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">@lang('Templates')</h1>
    <a href="{{ route('settings.templates.create') }}" class="btn btn-sm btn-success shadow-sm"><i class="fas fa-plus fa-sm text-white-50"></i> @lang('Create')</a>
</div>

<div class="row">
    <div class="col-md-2">
        @include('core::partials.settings-sidebar')
    </div>
    <div class="col-md-10">

        @if($data->count() > 0)
            <div class="card">
                <div class="table-responsive">
                    <table class="table card-table table-vcenter text-nowrap">
                        <thead class="thead-dark">
                            <tr>
                                <th>@lang('Image')</th>
                                <th>@lang('Category')</th>
                                <th>@lang('Status')</th>
                                <th>@lang('Action')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $item)
                            <tr>
                                <td><img src="{{ URL::to('/') }}/storage/thumb_templates/{{ $item->thumb }}" class="img-thumbnail" height="40" />
                                    <br>
                                    <small><a href="{{ route('settings.templates.edit', $item) }}">{{ $item->name }}</a></small>
                                    <br>
                                </td>
                                <td><small><a href="{{ route('settings.categories.edit', $item->category->id) }}">{{ $item->category->name }}</a></small></td>
                                <td>
                                    @if($item->active)
                                        <small class="badge badge-success">@lang('Active')</small>
                                    @else
                                        <small class="badge badge-warning">@lang('Not active')</small>
                                    @endif
                                    <p class="mb-2"></p>
                                    @if($item->is_premium)
                                        <small class="badge badge-danger">@lang('Premium')</small>
                                    @else
                                        <small class="badge badge-success">@lang('Free')</small>
                                    @endif
                                    
                                </td>
                                <td>
                                     <div class="d-flex">
                                        <div class="p-1">
                                              <a href="{{ route('settings.templates.edit', $item) }}"><span  class="badge badge-secondary">@lang('Edit')</span></a>
                                        </div>
                                        <div class="p-1 ">
                                              <a href="{{ route('settings.templates.builder', $item) }}"><span  class="badge badge-dark">@lang('Builder')</span></a>
                                        </div>
                                        <div class="p-1">
                                              <a target="_blank" href="{{ url('landingpages/preview-template/' . $item->id) }}"><span  class="badge badge-secondary">@lang('Preview')</span></a>
                                        </div>
                                    </div>
                                    <div class="d-flex">
                                        <div class="p-1"> 
                                            <form method="post" action="{{ route('settings.templates.clone', $item) }}" >
                                              @csrf
                                              <button type="submit" class="badge badge-secondary border-0">
                                              @lang('Clone')
                                              </button>
                                            </form>
                                        </div>
                                        <div class="p-1 ">
                                                <form method="post" action="{{ route('settings.templates.destroy', $item) }}" onsubmit="return confirm('@lang('Confirm delete?')');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="badge badge-danger border-0">
                                                        @lang('Delete')
                                                    </button>
                                                </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

        <div class="mt-4">
            {{ $data->appends( Request::all() )->links() }}
        </div>
        @if($data->count() == 0)
            <div class="alert alert-primary text-center">
                <i class="fe fe-alert-triangle mr-2"></i> @lang('No Templates found')
            </div>
        @endif

    </div>
    
</div>

@stop