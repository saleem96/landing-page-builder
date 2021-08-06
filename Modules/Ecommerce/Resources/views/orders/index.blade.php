@extends('core::layouts.app')
@section('title', __('Orders'))
@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-2">
    <div>
        <h1 class="h3 mb-0 text-gray-800">@lang('Orders')</h1>
    </div>
</div>
<div class="row">
    <div class="col-md-8">
        <div class="small text-muted mb-2">
            @lang('Orders will be able to conveniently display and give status to orders processed through the payment Plaform (PayPal, Stripe...) payment system...')                       
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
                                <th>@lang('Customer Info')</th>
                                <th>@lang('Product')</th>
                                <th>@lang('Status')</th>
                                <th>@lang('GateWay')</th>
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
                                   @endif
                                </td>
                                <td>
                                    <div class="text-muted">
                                        {{$item->product_name}}
                                    </div>
                                    <div class="text-muted">
                                        <strong>{{$item->total}} {{$item->currency}}</strong>
                                    </div>
                                </td>
                                <td>
                                    <div class="btn-group">
                                          <span class="badge badge-{{getColorStatus($item->status)}} dropdown-toggle small" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">@lang($item->status) <i class="fas fa-sort-down"></i>
                                          </span>
                                          <div class="dropdown-menu dropdown-menu-top">
                                            <form method="post" action="{{ route('orders.updatestatus', ['id'=>$item->id,'status'=> 'OPEN']) }}" >
                                                    @csrf
                                                    <button type="submit" class="dropdown-item">
                                                        @lang('OPEN')
                                                    </button>
                                            </form>
                                            <form method="post" action="{{ route('orders.updatestatus', ['id'=>$item->id,'status'=> 'COMPLETED']) }}" >
                                                    @csrf
                                                    <button type="submit" class="dropdown-item">
                                                        @lang('COMPLETED')
                                                    </button>
                                            </form>
                                            <form method="post" action="{{ route('orders.updatestatus', ['id'=>$item->id,'status'=> 'CANCELED']) }}" >
                                                    @csrf
                                                    <button type="submit" class="dropdown-item">
                                                        @lang('CANCELED')
                                                    </button>
                                            </form>
                                          </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="small text-muted">
                                        {{strtoupper($item->gateway)}}
                                    </div>

                                    @if($item->is_paid)
                                        <span class="small text-success"><i class="fas fa-check-circle text-success"></i> @lang('Paid')</span>
                                    @else
                                        <span class="small text-danger"><i class="fas fa-times-circle text-danger"></i> @lang('Not paid')</span>
                                    @endif
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
                                     <div class="d-flex">
                                        
                                      
                                        <div class="p-1 ">
                                                <form method="post" action="{{ route('orders.delete', ['id'=>$item->id]) }}" onsubmit="return confirm('@lang('Confirm delete?')');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger btn-clean">
                                                        <i class="fas fa-trash"></i>
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
            <i class="fe fe-alert-triangle mr-2"></i> @lang('No Orders found')
        </div>
        @endif
    </div>
    
</div>

@stop