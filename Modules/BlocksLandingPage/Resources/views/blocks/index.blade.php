@extends('core::layouts.app')
@section('title', __('Blocks'))
@section('content')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">@lang('Blocks')</h1>
    <div class="d-flex">
        <form method="get" action="{{ route('settings.blocks.index') }}" class="mr-2 mt-1 navbar-search">
         <div class="input-group">
           <input type="text" name="search" value="{{ Request::get('search') }}" class="form-control bg-light border-0 small" placeholder="@lang('Search name')" aria-label="Search" aria-describedby="basic-addon2">
           <div class="input-group-append">
             <button class="btn btn-primary" type="submit">
               <i class="fas fa-search fa-sm"></i>
             </button>
           </div>
         </div>
       </form>
        <a href="{{ route('settings.blocks.blockscss') }}" class="btn btn-sm btn-primary shadow-sm m-2"><i class="fas fa-pencil-alt"></i> @lang('Blocks css')</a>
        <a href="{{ route('settings.blocks.create') }}" class="btn btn-sm btn-success shadow-sm m-2"><i class="fas fa-plus fa-sm text-white-50"></i> @lang('Create')</a>
        
    </div>
    
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
                                <th>@lang('Name')</th>
                                <th>@lang('Category')</th>
                                <th>@lang('Active')</th>
                                <th>@lang('Action')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $item)
                            <tr>
                                <td><img src="{{ URL::to('/') }}/storage/thumb_blocks/{{ $item->thumb }}" class="img-thumbnail" style="max-width: 100px; max-height: 100px;" /></td>
                                <td>

                                    <a href="{{ route('settings.blocks.edit', $item) }}">{{ $item->name }}</a>
                                </td>
                                <td><a href="{{ route('settings.blockscategories.edit', $item->category->id) }}">{{ $item->category->name }}</a></td>

                                <td>
                                    @if($item->active)
                                        <span class="badge badge-success">Active</span>
                                    @else
                                        <span class="badge badge-warning">Not Active</span>
                                    @endif
                                    
                                </td>
                                
                                <td>
                                     <div class="d-flex">
                                        <div class="p-1 ">
                                             <a href="{{ route('settings.blocks.edit', $item) }}" class="btn btn-sm btn-primary">@lang('Edit')</a>
                                        </div>
                                        <div class="p-1 ">
                                                <form method="post" action="{{ route('settings.blocks.copyedit', $item) }}" >
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-secondary btn-clean">
                                                        @lang('Clone')
                                                    </button>
                                                </form>
                                        </div>
                                        <div class="p-1 ">
                                                <form method="post" action="{{ route('settings.blocks.destroy', $item) }}" onsubmit="return confirm('@lang('Confirm delete?')');">
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
                <i class="fe fe-alert-triangle mr-2"></i> @lang('No Blocks found')
            </div>
        @endif

    </div>
    
</div>

@stop