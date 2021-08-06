@extends('core::layouts.app')
@section('title', __('Templates'))
@section('content')
<div class="row">
  <div class="col-12 text-center">
      <h1 class="h3">@lang('Choose a Customizable Template for Your Landing Page')</h1>
  </div>
</div>
<div class="row mt-4">
  <div class="col-sm-8">
      <a href="{{ url('alltemplates')}}" class="btn btn-light">@lang("All Templates")</a>
      @foreach($groupCategories as $groupCategory)
          <div class="btn-group" role="group">
            <button id="btnGroupDrop{{$groupCategory->id}}" type="button" class="btn btn-light dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              {{$groupCategory->name}}
            </button>
            <div class="dropdown-menu" aria-labelledby="btnGroupDrop{{$groupCategory->id}}">
              @foreach ($groupCategory->categories()->get() as $item)
                    <a class="dropdown-item" href="{{ url('alltemplates/'). '/' .$item->id}}">{{$item->name}}</a>
              @endforeach
            </div>
          </div>
      @endforeach
  </div>
  <div class="col-sm-4">
      <form method="get" action="{{ url('alltemplates') }}" class="my-3 my-lg-0 navbar-search">
        <div class="input-group">
          <input type="text" name="search" value="{{ Request::get('search') }}" class="form-control bg-light border-0 small" placeholder="@lang('Search all templates')" aria-label="Search" aria-describedby="basic-addon2">
          <div class="input-group-append">
            <button class="btn btn-primary" type="submit">
            <i class="fas fa-search fa-sm"></i>
            </button>
          </div>
        </div>
      </form>
  </div>
</div>
@if($data->count() > 0)

<div class="row row_blog_responsive pt-4 clearfix">
    @foreach($data as $item)
      <div class="col-xl-4 col-lg-6 col-md-4 col-sm-6 col-12 itembb">
          <div class="clearfix blog-bottom blog blogitemlarge">
              <a href="#" title="{{$item->name}}" class="image-blog date clearfix">
                  <img src="{{ URL::to('/') }}/storage/thumb_templates/{{ $item->thumb }}" alt="{{$item->name}}" data-was-processed="true" class="" />
                  @if($item->is_premium)
                        <span class="post-date badge badge-danger"><i class="fas fa-star"></i> @lang("Premium")</span>
                  @else
                        <span class="post-date badge badge-success"><i class="fas fa-star"></i> @lang("Free")</span>
                  @endif
                  
              </a>
              <div class="content_blog clearfixflex flex-column flex-lg-row">
                  <div class="p-1">
                    {{ $item->name }}
                  </div>
                  <div class="d-flex pt-1">
                      <a href="#" class="btn btn-primary mr-2 btn_builder_template" data-id="{{$item->id}}" data-toggle="modal" data-target="#createModal">@lang("Builder")</a>
                      <a href="{{ url('landingpages/preview-template/' . $item->id) }}" class="btn btn-primary ">@lang("Preview")</a>
                  </div>
              </div>
          </div>
      </div>
    @endforeach
</div>
<div class="row mt-2 ml-1">
    {{ $data->appends( Request::all() )->links() }}
</div>

@else
<div class="row mt-4">
  <div class="col-lg-12">
        <div class="text-center">
              <div class="error mx-auto mb-3"><i class="far fa-window-maximize"></i></div>
              <p class="lead text-gray-800">@lang('No Template found')</p>
            </div>
  </div>
</div>
@endif


@stop

