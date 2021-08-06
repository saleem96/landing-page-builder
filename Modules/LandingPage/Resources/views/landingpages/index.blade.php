@extends('core::layouts.app')
@section('title', __('My Landing Pages'))
@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
  <h1 class="h3 mb-0 text-gray-800">@lang('My Landing Pages')</h1>
  <form method="get" action="{{ route('landingpages.index') }}" class="my-3 my-lg-0 navbar-search">
    <div class="input-group">
      <input type="text" name="search" value="{{ Request::get('search') }}" class="form-control bg-light border-0 small" placeholder="@lang('Search landing pages')" aria-label="Search" aria-describedby="basic-addon2">
      <div class="input-group-append">
        <button class="btn btn-primary" type="submit">
        <i class="fas fa-search fa-sm"></i>
        </button>
      </div>
    </div>
  </form>
</div>
<div class="row">
  <div class="col-sm-12">
    @if($data->count() > 0)
    <div class="card">
      <div class="table-responsive min-h-200">
        <table class="table">
          <thead class="thead-dark">
            <tr>
              <th>@lang('Name')</th>
              <th>@lang('Type')</th>
              <th>@lang('Publish')</th>
              <th>@lang('Domain')</th>
              <th>@lang('Leads')</th>
              <th>@lang('Settings')</th>
              <th>@lang('Action')</th>
            </tr>
          </thead>
          <tbody>
            @foreach($data as $item)
            <tr>
              <td>
                <a href="{{ route('landingpages.builder', $item->code) }}">{{ $item->name }}</a>
              </td>
              <td>
                @if(isset($item->template->name))
                  {{$item->template->name}}
                @else
                  @lang('None')
                @endif
              </td>
              <td>
                @if($item->is_publish)
                <span class="badge badge-success">@lang('Published')</span>
                @else
                <span class="badge badge-danger">@lang('Not publish')</span>
                @endif
                
              </td>
              <td>
                @if($item->domain_type == 0)
                <a href="http://{{$item->sub_domain}}" target="_blank">{{$item->sub_domain}}</a>
                @elseif($item->domain_type == 1)
                <a href="http://{{$item->custom_domain}}">{{$item->custom_domain}}</a>
                @endif
              </td>
              <td>
                {{--  {{ dd($item->formdata) }}  --}}
                <a href="{{route('leads.index', ['code' => $item->code])}}" class="badge badge-primary badge-pill">{{$item->formdata->count()}} @lang('leads')</a>
              </td>
              <td>
                <a href="{{route('landingpages.setting', $item->code)}}" class="badge badge-primary"><i class="fas fa-cog"></i> @lang('Setting')</a>
              </td>
              <td>
                <div class="btn-group">
                  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="fas fa-ellipsis-h"></i>
                  </button>
                  <div class="dropdown-menu dropdown-menu-top">
                    <a href="{{ route('landingpages.builder', $item->code) }}" class="dropdown-item">@lang('Builder')</a>
                    <a href="{{route('leads.index', ['code' => $item->code])}}" class="dropdown-item">@lang('Leads')</a>
                    <form method="post" action="{{ route('landingpages.clone', $item) }}" >
                      @csrf
                      <button type="submit" class="dropdown-item">
                      @lang('Clone')
                      </button>
                    </form>
                    <form method="post" action="{{ route('landingpages.delete', $item->code) }}" onsubmit="return confirm('@lang('Confirm delete?')');">
                      @csrf
                      <button class="dropdown-item">@lang('Delete')</button>
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
  </div>
  
  
</div>
<div class="row">
  <div class="col-lg-12">
    @if($data->count() == 0)
    <div class="text-center">
      <div class="error mx-auto mb-3"><i class="far fa-file-alt"></i></div>
      <p class="lead text-gray-800">@lang('No Landing Page Found')</p>
      <p class="text-gray-500">@lang("You don't have any Landing Page").</p>
      <a href="{{ route('alltemplates') }}" class="btn btn-primary">
        <span class="text">@lang('New Landing Page')</span>
      </a>
    </div>
    @endif
  </div>
</div>
@stop