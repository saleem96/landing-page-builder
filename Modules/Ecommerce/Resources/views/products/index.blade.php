@extends('core::layouts.app')
@section('title', __('Products'))
@section('content')

<div class="row">
    <div></div>
</div>
<div class="d-sm-flex align-items-center justify-content-between mb-2">
    <div>
        <h1 class="h3 mb-0 text-gray-800">@lang('Products')</h1>
    </div>
    <a href="{{ route('products.create') }}" class="btn btn-sm btn-success shadow-sm"><i class="fas fa-plus fa-sm text-white-50"></i> @lang('Create product')</a>
</div>
<div class="row">
    <div class="col-md-8">
        <div class="small text-muted mb-2">
            @lang('You can add products or services that you can sell directly from your landing pages using the integration with your PayPal or Stripe...')                       
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        @if($data->count() > 0)
            <div class="card">
                <div class="table-responsive">
                    <table class="table card-table table-vcenter text-nowrap">
                        <thead class="thead-dark">
                            <tr>
                                <th>@lang('Name')</th>
                                <th>@lang('Price')</th>
                                <th>@lang('Currency')</th>
                                <th>@lang('Description')</th>
                                <th>@lang('Date')</th>
                                <th>@lang('Action')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $item)
                            <tr>
                                <td>
                                    <a href="{{ route('products.edit', $item) }}">{{ $item->name }}</a>
                                </td>
                                <td>{{$item->price}}</td>
                                <td>{{$item->currency}}</td>
                               <td style="width: 100px;">
                                    <div class="small text-muted">
                                        {{$item->description}}
                                    </div>
                                </td>
                               <td>
                                <div class="small text-muted">
                                    @lang('Date Created'): {{$item->created_at->format('M j, Y')}}
                                </div>
                                <div class="small text-muted">
                                    @lang('Date Modified'): {{$item->updated_at->format('M j, Y')}}
                                </div>
                                </td>
                                
                                <td>
                                     <div class="d-flex">
                                        <div class="p-1 ">
                                             <a href="{{ route('products.edit', $item) }}" class="btn btn-sm btn-primary">@lang('Edit')</a>
                                        </div>
                                        <div class="p-1 ">
                                                <form method="post" action="{{ route('products.destroy', $item) }}" onsubmit="return confirm('@lang('Confirm delete?')');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger btn-clean">
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
            <i class="fe fe-alert-triangle mr-2"></i> @lang('No products found')
        </div>
        @endif
    </div>
    
</div>

@stop