@extends('themes::elsam.layout')
@section('content')
@include('themes::elsam.nav')

<!-- START PRICING -->
    <section class="section-sm">
        <div class="container">

            <div class="row">
                <div class="col-lg-12">
                    <div class="title-box text-center">
                        <h3 class="title-heading mt-4">{{$page->title}}</h3>
                    </div>
                </div>
            </div>

            <div class="row mt-5 pt-4">
                {!!$page->description!!}
            </div>

        </div>
    </section>

@stop