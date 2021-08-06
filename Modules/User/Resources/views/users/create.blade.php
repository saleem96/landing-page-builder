@extends('core::layouts.app')

@section('title', __('Create new user'))

@section('content')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">@lang('Create')</h1>
</div>
<div class="row">
        <div class="col-md-2">
                @include('core::partials.settings-sidebar')
            </div>
    <div class="col-md-10">

        <form role="form" method="post" action="{{ route('settings.users.store') }}">
            @csrf
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">

                            <div class="form-group">
                                <label class="form-label">@lang('Name')</label>
                                <input type="text" name="name" value="{{ old('name') }}" class="form-control" placeholder="@lang('Name')">
                            </div>

                            <div class="form-group">
                                <label class="form-label">@lang('E-mail')</label>
                                <input type="email" name="email" value="{{ old('email') }}" class="form-control" placeholder="@lang('E-mail')">
                            </div>
                            <div class="form-group">
                                <label class="form-label">@lang('Package')</label>
                                <select name="package_id" class="form-control">
                                    <option value=""></option>
                                    @foreach($packages as $package)
                                    <option value="{{ $package->id }}" {{ $package->id == old('package_id') ? 'selected' : '' }}>{{ $package->title }}</option>
                                    @endforeach
                                </select>
                            </div>



                            <div class="form-group">
                                <div class="form-label">@lang('Administrator')</div>
                                <label class="custom-switch">
                                    <input type="checkbox" name="is_admin" class="custom-switch-input">
                                    <span class="custom-switch-indicator"></span>
                                    <span class="custom-switch-description">@lang('Allow access to settings')</span>
                                </label>
                            </div>

                        </div>
                        <div class="col-md-6">

                            <div class="form-group">
                                <label class="form-label">@lang('Password')</label>
                                <input type="password" name="password" value="" class="form-control" placeholder="@lang('Password')">
                            </div>

                            <div class="form-group">
                                <label class="form-label">@lang('Confirm password')</label>
                                <input type="password" name="password_confirmation" value="" class="form-control" placeholder="@lang('Password')">
                            </div>
                            <div class="form-group">
                                <label class="form-label">@lang('Package ends at')</label>
                                <div class="input-group date" id="datetimepicker1" data-target-input="nearest">
                                    <input type="text" class="form-control datetimepicker-input" name="package_ends_at" value="{{ old('package_ends_at') }}" placeholder="@lang('Package ends at')" data-target="#datetimepicker1"/>
                                    <div class="input-group-append" data-target="#datetimepicker1" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
                <div class="card-footer">
                    <div class="d-flex">
                        <a href="{{ route('settings.users.index') }}" class="btn btn-secondary">@lang('Cancel')</a>
                        <button class="btn btn-success ml-auto">@lang('Add user')</button>
                    </div>
                </div>
            </div>
        </form>

    </div>
    
</div>


@stop