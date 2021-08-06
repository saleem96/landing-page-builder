@extends('core::layouts.app')
@section('title', __('My Landing Pages'))
@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
  <h1 class="h3 mb-0 text-gray-800">Transactions</h1>
  @php
  $user_wallet=DB::table('users')->where('id',Auth::user()->id)->first();
  @endphp
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
<h1 class="h4 mb-0 text-gray-800"> Total Balance  {{$user_wallet->wallet? round($user_wallet->wallet,2):0 }} $ </h1>
<br>
<div class="row">
  <div class="col-sm-12">
    @if($data->count() > 0)
    <div class="card">
      <div class="table-responsive min-h-200">
        <table class="table">
          <thead class="thead-dark">
            <tr>
              <th>Name</th>
              <th>Email</th>
              <th>Amount</th>
              <th>Currency</th>
              <th>Reciept link</th>
              <th>Created at</th>
              {{--  <th>@lang('Settings')</th>  --}}
              {{--  <th>@lang('Action')</th>  --}}
            </tr>
          </thead>
          <tbody>
            @foreach($data as $item)
            <tr>
              <td>
               {{ $item->name }}
              </td>
              <td>
                {{ $item->email }}
              </td>
              <td>
                {{ round($item->amount,2)}}      
              </td>
              <td>
                {{ $item->currency}}   
              </td>
              <td>
              <a href="{{ $item->receipt_url}} ">{{ $item->receipt_url}}   </a>  
              </td>
              <td>
                {{$item->created_at}}
              </td>
              <td>
                {{--  <div class="btn-group">
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
                </div>  --}}
                
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
      <p class="lead text-gray-800">@lang('No Transaction Found')</p>
      <p class="text-gray-500">@lang("You don't have any Transaction").</p>
      <a href="{{ route('accountsettings.index') }}" class="btn btn-primary">
        <span class="text">Make a deposit</span>
      </a>
    </div>
    @endif
  </div>
</div>
@stop