@extends('core::layouts.app')
@section('title', __('Leads'))
@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-2">
    <div>
        <h1 class="h3 mb-0 text-gray-800">@lang('Leads')</h1>
    </div>

</div>
<div class="d-flex flex-row align-items-center justify-content-between mb-2">
     <div class="btn-group">
        <span class="badge badge-primary dropdown-toggle small" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            @if(!empty($page_filter)) {{$page_filter->name}} @else @lang('All Landing Pages') @endif <i class="fas fa-sort-down"></i>
        </span>
        <div class="dropdown-menu dropdown-menu-top">
          <a href="{{route('leads.index')}}" class="dropdown-item">@lang('All Landing Pages')</a>
          @foreach($pages as $item)
               <a href="{{route('leads.index', ['code' => $item->code])}}" class="dropdown-item">{{ $item->name }}</a>
          @endforeach
        </div>
    </div>
    
    <a href="
        @if(!empty($request_code)) 
            {{ route('leads.exportcsv',['code' => $request_code]) }} 
        @else
            {{ route('leads.exportcsv') }} 
        @endif
        " class="btn btn-primary">@lang('Export CSV')
    </a>
</div>
<div class="row">
    <div class="col-md-12">
        @if($data->count() > 0)
            <div class="card">
                <div class="table-responsive">
                    <table class="table card-table table-vcenter text-nowrap">
                        <thead class="thead-dark">
                            <tr>
                                <th>@lang('Lead Info')</th>
                                <th>@lang('From')</th>
                                <th>@lang('Browser')</th>
                                <th>@lang('OS')</th>
                                <th>@lang('Device')</th>
                                <th>@lang('Date Info')</th>
                                <th>@lang('Action')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $item)
                            <tr>
                                <td>
                                   @if(isset($item->field_values) && is_array($item->field_values))
                                       @foreach($item->field_values as $key => $value)
                                            <div class="text-muted small">
                                                {{$key}}: {{$value}}
                                            </div>
                                       @endforeach
                                       <div></div>
                                   @endif
                                </td>
                                <td>
                                    @if(isset($item->landingpage->code))
                                        <a href="{{route('landingpages.setting', $item->landingpage->code)}}">{{$item->landingpage->name}}</a>
                                    @endif
                                </td>
                                <td>
                                    {{$item->browser}}
                                </td>
                                 <td>
                                    {{$item->os}}
                                </td>
                                 <td>
                                    {{$item->device}}
                                </td>
                                <td>
                                    <div class="small text-muted">
                                        @lang('Created'): {{$item->created_at->format('M j, Y')}}
                                    </div>
                                    <div class="small text-muted">
                                        @lang('Modified'): {{$item->updated_at->format('M j, Y')}}
                                    </div>
                                </td>
                                <td>
                                    <div class="btn-group">
                                          <span class="badge badge-primary dropdown-toggle text-white small" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="fas fa-ellipsis-h"></i>
                                          </span>

                                          <div class="dropdown-menu">
                                             <a href="{{route('leads.edit',$item->id)}}" class="dropdown-item">@lang('Edit lead')</a>

                                            <form method="post" action="{{ route('leads.delete', $item) }}" onsubmit="return confirm('@lang('Confirm delete?')');">
                                                    @csrf
                                                    @method('DELETE')
                                                     <button type="submit" class="dropdown-item">
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
            <i class="fe fe-alert-triangle mr-2"></i> @lang('No Leads found')
        </div>
        @endif
    </div>
    
</div>

@stop