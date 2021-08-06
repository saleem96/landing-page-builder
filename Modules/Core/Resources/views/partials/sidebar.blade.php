<ul class="navbar-nav sidebar bg-gradient-dark-2 accordion" id="accordionSidebar">
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ url('/') }}">
        <div class="">
          <img src="{{ Storage::url(config('app.logo_light'))}}" height="40" alt="">
        </div>
      </a>
      {!! menuSiderbar() !!}
      
      @if(Auth::user()->is_admin==0)
      <li class="nav-item"><a style="color:#ffffff; font-size:15px;" class="nav-link" href="{{ route('landingpages.trans') }}"><i class="nav fa fa-credit-card"></i>Wallet</a></li>
      @endif
      {{--  <li class="nav-item"><a style="color:#ffffff; font-size:15px;" class="nav-link" href="{{ url('payapl') }}"><i class="nav fab fa-cc-paypal"></i>Paypal</a></li>  --}}
      {{--  <li class="nav-item"><a style="color:#ffffff; font-size:15px;" class="nav-link" href="{{ url('stripe') }}"><i class="nav fab fa-cc-stripe"></i>Stripe</a></li>  --}}
      @if(Auth::user()->is_admin==1)
      <li class="nav-item"><a style="color:#ffffff; font-size:15px;" class="nav-link" href="{{ url('paymentsettings') }}"><i class="nav fa fa-credit-card"></i>Payment Settings</a></li>
      @endif

    </ul>
