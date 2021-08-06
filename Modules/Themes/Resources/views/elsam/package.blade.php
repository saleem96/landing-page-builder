@extends('themes::elsam.layout')
@section('title', $package->title)
@section('content')
@include('themes::elsam.nav')

<!-- START PRICING -->
    <section class="section-sm">
        <div class="container">

            <div class="row">
                <div class="col-lg-12">
                    <div class="title-box text-center">
                        <h3 class="title-heading mt-4">@lang('Upgrade to :title',['title'=> $package->title])</h3>
                    </div>
                </div>
            </div>

            <div class="row mt-5 pt-4 justify-content-center">
                <div class="price_content">
                    <!-- END Title -->
                    <div class="row justify-content-center">
                        <div class="card card_billing">
                            <div class="card-header">
                                <h5 class="card-title">@lang('Total') {{ $currency_symbol }}{{ $package->price }} / @lang($package->interval)</h5>
                            </div>
                            <div class="card-body">
                                {!! paymentSkins(['package' => $package]) !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

@stop