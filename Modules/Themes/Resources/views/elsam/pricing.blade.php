@extends('themes::elsam.layout')
@section('content')
@include('themes::elsam.nav')
    <section class="section-sm" id="pricing">
        <div class="container">

            <div class="row">
                <div class="col-lg-12">
                    <div class="title-box text-center">
                        <h6 class="title-sub-title mb-0 text-primary f-17">@lang('Pricing')</h6>
                        <h3 class="title-heading mt-4">@lang('Find out which plan is right for you')</h3>
                    </div>
                </div>
            </div>

            <div class="row mt-5 pt-4">
                <div class="col-lg-{{ 12 / (count($packages) + 1)}}">
                    <div class="pricing-box mt-4 rounded">
                        <div class="pricing-content">
                            <h4 class="text-uppercase">@lang("Package Free")</h4>
                            <p class="text-muted mb-4 pb-1">@lang("Package Free")
                            </p>
                            <hr>
                            <div class="pricing-plan mt-4 text-primary text-center">
                                <h1>@lang("FREE")</h1>
                            </div>
                            <hr>

                            <div class="pricing-features pt-3">
                                @if(config('saas.number_landing_page') == -1) 
                                            <p class="text-muted"><strong>@lang('Unlimited Landing Page')</strong></p>
                                        @else
                                            <p class="text-muted">@lang(':number Landing Page',['number' => config('saas.number_landing_page')])</p>
                                @endif
                                @if(config('saas.number_leads') == -1) 
                                            <p class="text-muted"><strong>@lang('Unlimited leads')</strong></p>
                                        @else
                                            <p class="text-muted">@lang(':number leads',['number' => config('saas.number_leads')])</p>
                                        @endif
                                @if(config('saas.number_orders') == -1) 
                                            <p class="text-muted"><strong>@lang('Unlimited orders')</strong></p>
                                        @else
                                            <p class="text-muted">@lang(':number orders',['number' => config('saas.number_orders')])</p>
                                        @endif
                                
                                        <p class="text-muted @if(config('saas.unlimited_premium_template') && config('saas.unlimited_premium_template') == true)@else text-line-through @endif">@lang("Unlimited premium template")</p>
                                        <p class="text-muted @if(config('saas.form_data_export') && config('saas.form_data_export') == true)@else text-line-through @endif">@lang("Form data export csv")</p>
                                        <p class="text-muted @if(config('saas.remove_branding') && config('saas.remove_branding') == true)@else text-line-through @endif">@lang("Remove branding")</p>
                                        <p class="text-muted @if(config('saas.custom_code') && config('saas.custom_code') == true)@else text-line-through @endif">@lang("Custom code header and footer")</p>
                                        <p class="text-muted @if(config('saas.custom_domain') && config('saas.custom_domain') == true)@else text-line-through @endif">@lang("Custom domain for landing page")</p>
                            </div>
                            <div class="pricing-border mt-3"></div>
                            <div class="mt-4 pt-2 text-center">
                                <a href="{{ route('login') }}" class="btn btn-secondary btn-round">@lang('Login Now')</a>
                            </div>
                        </div>
                    </div>
                </div>
                @foreach($packages as $package)
                <div class="col-lg-{{ 12 / (count($packages) + 1)}}">
                    <div class="pricing-box @if($package->is_featured == 1) border border-primary @endif mt-4 rounded">
                        <div class="pricing-content">
                            @if($package->is_featured == 1)<div class="pricing-lable">@lang('Popular')</div>@endif
                            <h4 class="text-uppercase">{{ $package->title }}</h4>
                            <p class="text-muted mb-4 pb-1">{{ $package->description }}
                            </p>
                            <hr>
                            {{-- <div class="price f_700 f_size_40 t_color2">@if($package->price > 0){{ $currency_symbol }}{{ $package->price }}<sub class="f_size_16 f_400">/@lang($package->interval)</sub> @else @lang("FREE") @endif</div> --}}

                            <div class="pricing-plan mt-4 text-primary text-center">
                                <h1><sup class="text-muted">{{ $currency_symbol }} </sup>{{ $package->price }} <small class="f-16 text-muted">/@lang($package->interval)</small></h1>
                            </div>
                            <hr>

                            <div class="pricing-features pt-3">
                                @if($package->settings['number_landing_page'] == -1) 
                                            <p class="text-muted"><strong>@lang('Unlimited Landing Page')</strong></p>
                                @else
                                            <p class="text-muted">@lang(':number Landing Page',['number' => $package->settings['number_landing_page']])</p>
                                @endif
                                @if($package->settings['number_leads'] == -1) 
                                            <p class="text-muted"><strong>@lang('Unlimited leads')</strong></p>
                                        @else
                                            <p class="text-muted">@lang(':number leads',['number' => $package->settings['number_leads']])</p>
                                        @endif
                                @if($package->settings['number_orders'] == -1) 
                                            <p class="text-muted"><strong>@lang('Unlimited orders')</strong></p>
                                        @else
                                            <p class="text-muted">@lang(':number orders',['number' => $package->settings['number_orders']])</p>
                                        @endif

                                        <p class="text-muted @if($package->hasPermissionTo('unlimited_premium_template') && $package->settings['unlimited_premium_template'] == true) @else text-line-through @endif">@lang("Unlimited premium template")</p>
                                        <p class="text-muted @if($package->hasPermissionTo('form_data_export') && $package->settings['form_data_export'] == true) @else text-line-through @endif">@lang("Form data export csv")</p>
                                        <p class="text-muted @if($package->hasPermissionTo('remove_branding') && $package->settings['remove_branding'] == true) @else text-line-through @endif">@lang("Remove branding")</p>
                                        <p class="text-muted @if($package->hasPermissionTo('custom_code') && $package->settings['custom_code'] == true) @else text-line-through @endif">@lang("Custom code header and footer")</p>
                                        <p class="text-muted @if($package->hasPermissionTo('custom_domain') && $package->settings['custom_domain'] == true) @else text-line-through @endif">@lang("Custom domain for landing page")</p>

                            </div>
                            <div class="pricing-border mt-3"></div>
                            <div class="mt-4 pt-2 text-center">
                                <a href="{{ route('billing.package', $package) }}" class="btn btn-primary btn-round">@lang('Buy Now')</a>
                            </div>
                        </div>
                    </div>
                </div>
                          
                @endforeach


            </div>

        </div>
    </section>


@stop