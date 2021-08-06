<!doctype html>
<html lang="{{ app()->getLocale() }}" dir="ltr">
  <head>
    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Language" content="{{ app()->getLocale() }}" />
    <meta name="msapplication-TileColor" content="#2d89ef">
    <meta name="theme-color" content="#4188c9">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" />
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="HandheldFriendly" content="True">
    <meta name="MobileOptimized" content="320">
    <link rel="icon" href="{{ Storage::url(config('app.logo_favicon'))}}" type="image/png">
    <title>@yield('title', config('app.name'))</title>
    <meta name="description" content="{{ config('app.SITE_DESCRIPTION') }}">
    <meta name="keywords" content="{{ config('app.SITE_KEYWORDS')}}">
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,900" rel="stylesheet">
    <link rel="stylesheet" href="{{ Module::asset('core:core/core.css') }}">
    <link rel="stylesheet" href="{{ Module::asset('core:app/css/customize.css') }}">
    @includeWhen(config('app.GOOGLE_ANALYTICS'), 'core::partials.google-analytics')
    
    @stack('head')
    <script type="text/javascript">
      var BASE_URL = '{{ url('/') }}';
    </script>
  </head>
  <body id="page-top" class="sidebar-toggled">
    <!-- Page Wrapper -->
    <div id="wrapper">
      <!-- Sidebar -->
      @include('core::partials.sidebar')
      <!-- End of Sidebar -->
      <!-- Content Wrapper -->
      <div id="content-wrapper" class="d-flex flex-column">
        <!-- Main Content -->
        <div id="content">
          <!-- Topbar -->
          @include('core::partials.header-top')
          <!-- End of Topbar -->
          <!-- Begin Page Content -->
          <div class="container-fluid">
            @if($errors->any())
            <div class="alert alert-danger">
              <ul class="list-unstyled mb-0">
                @foreach ($errors->all() as $error)
                <li> <i class="fas fa-times text-danger mr-2"></i> {{ $error }}</li>
                @endforeach
              </ul>
            </div>
            @endif
            @if (session('success'))
                  <div class="alert alert-success">
                      <i class="fas fa-check-circle text-success mr-2"></i> {!! session('success') !!}
                  </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger">
                    <i class="fas fa-times text-danger mr-2"></i> {!! session('error') !!}
                </div>
            @endif
            <!-- Page Heading -->
            @yield('content')
            
          </div>
          <!-- /.container-fluid -->
        </div>
        <!-- End of Main Content -->
 
        <!-- Footer -->
        <footer class="sticky-footer">
          <div class="container my-auto">
            <div class="copyright text-center my-auto">
              <span>@lang('Copyright') © {{ now()->year }} @lang('Desing by') <a href="{{ url('/') }}">{{ config('app.name') }}</a></span>
            </div>
          </div>
        </footer>
        <!-- End of Footer -->
      </div>
      <!-- End of Content Wrapper -->
    </div>
        <div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">@lang('New Landing Page')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
              </div>
               <form id="" action="{{route('landingpages.save')}}" method="post" enctype='multipart/form-data'>
                  @csrf
              <div class="modal-body">
                  <div class="form-group">
                    <input type="number" class="form-control" name="template_id" hidden="" required="" id="template_id_builder">
                    <label for="name" class="col-form-label">@lang('Name'):</label>
                    <input type="text" class="form-control" name="name" required="" id="page-name">
                  </div>
                
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('Close')</button>
                <button type="submit" class="btn btn-primary" id="saveandbuilder">@lang('Save & Builder')</button>
              </div>
              </form>
            </div>
          </div>
        </div>
    
    <a class="scroll-to-top rounded" href="#page-top">
      <i class="fas fa-angle-up"></i>
    </a>

   
    <script src="{{ Module::asset('core:core/core.js') }}" ></script>
    <script src="{{ Module::asset('core:vendor/tinymce/js/tinymce/tinymce.min.js') }}" ></script>
    <script src="{{ Module::asset('core:app/js/app.js') }}" ></script>
    


    
<script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
<script src="https://js.stripe.com/v3/"></script>
<script>
    // Create an instance of the Stripe object
    // Set your publishable API key
    var stripe = Stripe('{{ env("STRIPE_PUBLISH_KEY") }}');

    // Create an instance of elements
    var elements = stripe.elements();

    var style = {
        base: {
            fontWeight: 400,
            fontFamily: '"DM Sans", Roboto, Open Sans, Segoe UI, sans-serif',
            fontSize: '16px',
            lineHeight: '1.4',
            color: '#1b1642',
            padding: '.75rem 1.25rem',
            '::placeholder': {
                color: '#ccc',
            },
        },
        invalid: {
            color: '#dc3545',
        }
    };

    var cardElement = elements.create('cardNumber', {
        style: style
    });
    cardElement.mount('#card_number');

    var exp = elements.create('cardExpiry', {
        'style': style
    });
    exp.mount('#card_expiry');

    var cvc = elements.create('cardCvc', {
        'style': style
    });
    cvc.mount('#card_cvc');

    // Validate input of the card elements
    var resultContainer = document.getElementById('paymentResponse');
    cardElement.addEventListener('change', function (event) {
        if (event.error) {
            resultContainer.innerHTML = '<p>' + event.error.message + '</p>';
        } else {
            resultContainer.innerHTML = '';
        }
    });

    // Get payment form element
    var form = document.getElementById('payment-form');

    // Create a token when the form is submitted.
    form.addEventListener('submit', function (e) {
        e.preventDefault();
        createToken();
    });

    // Create single-use token to charge the user
    function createToken() {
        stripe.createToken(cardElement).then(function (result) {
            if (result.error) {
                // Inform the user if there was an error
                resultContainer.innerHTML = '<p>' + result.error.message + '</p>';
            } else {
                // Send the token to your server
                stripeTokenHandler(result.token);
            }
        });
    }

    // Callback to handle the response from stripe
    function stripeTokenHandler(token) {
        // Insert the token ID into the form so it gets submitted to the server
        var hiddenInput = document.createElement('input');
        hiddenInput.setAttribute('type', 'hidden');
        hiddenInput.setAttribute('name', 'stripeToken');
        hiddenInput.setAttribute('value', token.id);
        form.appendChild(hiddenInput);

        // Submit the form
        form.submit();
    }

    $('.pay-via-stripe-btn').on('click', function () {
        var payButton   = $(this);
        var name        = $('#name').val();
        var email       = $('#email').val();

        if (name == '' || name == 'undefined') {
            $('.generic-errors').html('Name field required.');
            return false;
        }
        if (email == '' || email == 'undefined') {
            $('.generic-errors').html('Email field required.');
            return false;
        }

        if(!$('#terms_conditions').prop('checked')){
            $('.generic-errors').html('The terms conditions must be accepted.');
            return false;
        }
    });

</script>

    @stack('scripts')
  </body>
</html>