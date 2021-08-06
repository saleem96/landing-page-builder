@extends('themes::elsam.layout')


@section('content')
@include('themes::elsam.nav')

 <!-- END HOME -->
    <section class="bg-home" id="home">
        <div class="home-center">
            <div class="home-desc-center">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-lg-6">
                            <div class="home-content">
                                <h1 class="home-title">@lang('#1 Landing page builder')</h1>
                                <p class="text-muted mt-3 f-20"> @lang("Get your leads and sell your product with landing page. Customize template inside the Drag & Drop Builder, and launch a professional-looking landing page that's designed to convert").</p>
                                <div class="mt-5">
                                    <a href="{{ route('login') }}" class="btn btn-primary">@lang('Login Now') <span class="text-white-50"></span></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="home-img mt-2">
                                <video class="img-fluid" autoplay loop muted>
                                  <source src="{{ Module::asset('themes:elsam/images/demo_banner.mp4') }}" type="video/mp4" />
                                </video>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- END HOME -->

    <!-- START CLIENT-IMG -->
    <section class="section pt-0">
        <div class="container">
            <div class="row mt-5">
                <div class="col-lg-3">
                    <div class="client-images mt-4">
                        <img src="{{ Module::asset('themes:elsam/images/clients/logo_01.png') }}" alt="logo-img" class="mx-auto img-fluid d-block">
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="client-images mt-4">
                        <img src="{{ Module::asset('themes:elsam/images/clients/logo_07.png') }}" alt="logo-img" class="mx-auto img-fluid d-block">
                    </div>
                </div>
                <div class="col-lg-3 ">
                    <div class="client-images mt-4">
                        <img src="{{ Module::asset('themes:elsam/images/clients/logo_06.png') }}" alt="logo-img" class="mx-auto img-fluid d-block">
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="client-images mt-4">
                        <img src="{{ Module::asset('themes:elsam/images/clients/logo_02.png') }}" alt="logo-img" class="mx-auto img-fluid d-block">
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- END CLIENT IMG -->

    <!-- START HOW IT WORK -->
    <section class="section pt-5  bg-light" id="how-it-work">
        <div class="container">

            <div class="row">
                <div class="col-lg-12">
                    <div class="title-box text-center">
                        <h6 class="title-sub-title mb-0 text-primary f-17">@lang('How It Work')</h6>
                        <h3 class="title-heading mt-4">@lang('Convert More Leads')
                            </h3>
                    </div>
                </div>
            </div>

            <div class="row mt-5">
                <div class="col-lg-4">
                    <div class="work-box text-center p-3">
                        <div class="arrow">
                            <img src="{{ Module::asset('themes:elsam/images/arrow-1.png') }}" alt="">
                        </div>
                        <div class="work-count">
                            <p class="mb-0">1</p>
                        </div>
                        <div class="work-icon">
                            <i class="pe-7s-file"></i>
                        </div>
                        <h5 class="mt-4">@lang('Select emplates')</h5>
                        <p class="text-muted mt-3">
                            @lang('Save time and choose from over 100 prebuilt sections that you can easily drag and drop onto any website or landing page').
                        </p>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="work-box text-center p-3">
                        <div class="arrow">
                            <img src="{{ Module::asset('themes:elsam/images/arrow-2.png') }}" alt="">
                        </div>
                        <div class="work-count">
                            <p class="mb-0">2</p>
                        </div>
                        <div class="work-icon">
                            <i class="pe-7s-pen"></i>
                        </div>
                        <h5 class="mt-4">@lang('Edit Landing Page')</h5>
                        <p class="text-muted mt-3">
                            @lang('Just drag, drop, click, and type to customize your website, landing page, and opt-in forms. No coding or high-tech skills required').
                        </p>

                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="work-box text-center p-3">
                        <div class="work-count">
                            <p class="mb-0">3</p>
                        </div>
                        <div class="work-icon">
                            <i class="pe-7s-user"></i>
                        </div>
                        <h5 class="mt-4">@lang('Collect customers')</h5>
                        <p class="text-muted mt-3">
                            @lang('Collect leads and orders with live submission. You can always easily download a .CSV file of your collected leads').
                        </p>
                    </div>
                </div>

            </div>

        </div>
    </section>
    <!-- END HOE IT WORK -->

    <!-- START SERVICES -->
    <section class="section" id="services">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="title-box text-center">
                        <h6 class="title-sub-title mb-0 text-primary f-17">{{ __(config('app.name')) }}</h6>
                        <h3 class="title-heading mt-4">@lang('Grow Your Business')</h3>
                    </div>
                </div>
            </div>


            <div class="row align-items-center mt-5">

                <div class="col-lg-6">
                    <div class="nav flex-column nav-pills mt-4">
                        <a class="nav-link">
                            <div class="p-3">
                                <div class="media">
                                    <div class="services-title">
                                        <i class="mdi mdi-search-web"></i>
                                    </div>
                                    <div class="media-body pl-4">
                                        <h5 class="mb-2 services-title mt-2">
                                            @lang('SEO-friendly pages')</h5>
                                        <p class="mb-0">@lang('Set your meta tags (title, description, and keywords)').</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <a class="nav-link">
                            <div class="p-3">
                                <div class="media">
                                    <div class="services-title">
                                        <i class="mdi mdi-server"></i>
                                    </div>
                                    <div class="media-body pl-4">
                                        <h5 class="mb-2 services-title mt-2">@lang('Free hosting')</h5>
                                        <p class="mb-0">@lang('Securely host your landing pages on a free domain').</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <a class="nav-link">
                            <div class="p-3">
                                <div class="media">
                                    <div class="services-title">
                                        <i class="mdi mdi-monitor-cellphone"></i>
                                    </div>
                                    <div class="media-body pl-4">
                                        <h5 class="mb-2 f-18 services-title mt-2">@lang('Multi device')</h5>
                                        <p class="mb-0">@lang('You can easily optimize how your content displays on desktop, tablet, and mobile').</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="nav flex-column nav-pills mt-4">
                        <a class="nav-link">
                            <div class="p-3">
                                <div class="media">
                                    <div class="services-title">
                                        <i class="mdi mdi-speedometer"></i>
                                    </div>
                                    <div class="media-body pl-4">
                                        <h5 class="mb-2 services-title mt-2">
                                            @lang('Top speed')</h5>
                                        <p class="mb-0">@lang('Increase conversions with landing page load speeds and 99.9% uptime').</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <a class="nav-link">
                            <div class="p-3">
                                <div class="media">
                                    <div class="services-title">
                                        <i class="mdi mdi-human-male-female"></i>
                                    </div>
                                    <div class="media-body pl-4">
                                        <h5 class="mb-2 services-title mt-2">@lang('Great for lead generation')</h5>
                                        <p class="mb-0">@lang('Collect quality leads and easy with export CSV').</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <a class="nav-link">
                            <div class="p-3">
                                <div class="media">
                                    <div class="services-title">
                                        <i class="mdi mdi-web"></i>
                                    </div>
                                    <div class="media-body pl-4">
                                        <h5 class="mb-2 f-18 services-title mt-2">@lang('Sell your products')</h5>
                                        <p class="mb-0">@lang('Sell more – faster and easier. Implementing PayPal, Stripe... payments directly to your landing page').</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </section>
    <!-- END SERVICES -->

    <!-- START COUNTER -->
    <section class="section bg-light pt-5">
        <div class="container">
            <div class="row" id="counter">
                <div class="col-lg-5">
                    <div class="counter-info mt-4">
                        <h3>@lang('Trusted by 40,000+ small business owners')</h3>
                        <p class="text-muted mt-4">@lang('Discover why more than 40,000 small business owners choose') {{ __(config('app.name')) }}.</p>
                        <div class="mt-4">
                            <a href="{{ route('login') }}" class="btn btn-primary">@lang('Login Now')  <i class="mdi mdi-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="counter-box mt-4">
                                <div class="media box-shadow bg-white p-4 rounded">
                                    <div class="counter-icon mr-3">
                                        <i class="mdi mdi-emoticon-outline text-primary h2"></i>
                                    </div>
                                    <div class="media-body pl-2">
                                        <h3 class="counter-count"> <span class="counter-value" data-count="40000">0</span>
                                            +</h3>
                                        <h5 class="mt-2 mb-0 f-17">@lang('Happy Clients')</h5>
                                      
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="counter-box mt-4">
                                <div class="media box-shadow bg-white p-4 rounded">
                                    <div class="counter-icon mr-3">
                                        <i class="mdi mdi-flag text-primary h2"></i>
                                    </div>
                                    <div class="media-body pl-2">
                                        <h3 class="counter-count"> <span class="counter-value" data-count="24">0</span>
                                        </h3>
                                        <h5 class="mt-2 mb-0 f-17">@lang('Languages')</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-1">
                        <div class="col-lg-6">
                            <div class="counter-box mt-4">
                                <div class="media box-shadow bg-white p-4 rounded">
                                    <div class="counter-icon mr-3">
                                        <i class="mdi mdi-earth text-primary h2"></i>
                                    </div>
                                    <div class="media-body pl-2">
                                        <h3 class="counter-count"> <span class="counter-value"
                                                data-count="160">0</span> +
                                        </h3>
                                        <h5 class="mt-2 mb-0 f-17">@lang('Countries')</h5>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="counter-box mt-4">
                                <div class="media box-shadow bg-white p-4 rounded">
                                    <div class="counter-icon mr-3">
                                        <i class="mdi mdi-timer text-primary h2"></i>
                                    </div>
                                    <div class="media-body pl-2">
                                        <h3 class="counter-count"> <span class="counter-value" data-count="5">0</span> +
                                        </h3>
                                        <h5 class="mt-2 mb-0 f-17">@lang('Years of expe'). </h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- END COUNTER -->

    

    <!-- START TESTIMONIAL -->
    <section class="section" id="testimonial">
        <div class="container">

            <div class="row">
                <div class="col-lg-12">
                    <div class="title-box text-center">
                        <h6 class="title-sub-title mb-0 text-primary f-17">@lang('Testimonial')</h6>
                        <h3 class="title-heading mt-4">@lang('What they say about us')</h3>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center mt-5">
                <div class="col-lg-10">
                    <div class="testi-carousel">

                        <div class="testimonial-box text-center p-4">
                            <div class="testi-img-user">
                                <img src="{{ Module::asset('themes:elsam/images/testimonials-1.jpg') }}" alt="" class="rounded-circle testi-user mx-auto d-block">
                            </div>
                            <h4 class="font-italic mt-4 pt-2">@lang('Support team is the best. Thanks for all the personal care that you guys give your customers').</h4>
                            <div class="testi-border mt-4"></div>
                            <p class="text-uppercase text-muted mb-0 mt-4 f-14">John Frusciante</p>
                        </div>

                        <div class="testimonial-box text-center p-4">
                            <div class="testi-img-user">
                                <img src="{{ Module::asset('themes:elsam/images/testimonials-2.jpg') }}" alt="" class="rounded-circle testi-user mx-auto d-block">
                            </div>

                            <h4 class="font-italic mt-4 pt-2">@lang('The software is super easy to understand, and gives lots of leeway for design and customization')</h4>

                            <div class="testi-border mt-4"></div>
                            <p class="text-uppercase text-muted mb-0 mt-4 f-14">Martin James</p>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- END TESTIMONIAL -->

    <!-- START VIDEO -->
    <section class="section bg-light">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="text-center">
                        <h6 class="text-uppercase desc-white f-14">@lang("We'll lead the way")</h6>
                        <h2 class="line-height_1_4 mt-4">@lang("Join millions of users and grow")<br> @lang("your business")</h2>
                        <div class="mt-4 pt-2">
                            <a href="{{ route('login') }}" class="btn btn-primary">@lang('Start a free trial') <span class="text-white-50"></span></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- END VIDEO -->
@stop