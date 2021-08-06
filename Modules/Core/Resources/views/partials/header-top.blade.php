<nav class="navbar navbar-expand topbar mb-4 static-top">
  <button id="sidebarToggleTop" class="btn d-md-none rounded-circle mr-3">
  <i class="fa fa-bars"></i>
  </button>
  <!-- Topbar Navbar -->
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" href="{{ route('alltemplates') }}" >
        <i class="fas fa-plus fa-lg"></i>
        <span class="d-none d-sm-inline-block ml-2">@lang('New Landing Page')</span>
      </a>
    </li>
    
  </ul>
  <ul class="navbar-nav ml-auto">
    
    {!! menuHeaderTop() !!}

    <li class="nav-item dropdown no-arrow">
      <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <span class="mr-2 d-none d-lg-inline text-gray-600 small">
          @if($active_language)
            {{ $active_language }}
          @endif
        </span>
        <i class="fas fa-language fa-lg"></i>
      </a>
      <!-- Dropdown - User Information -->
      <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
        @foreach($languages as $item)
        <a href="{{ route('localize', $item) }}" rel="alternate" hreflang="{{ $item }}" class="dropdown-item">
          {{ $item }}
        </a>
        @endforeach
      </div>
    </li>
    @php
       $payments= DB::table('payments')->where('user_id',Auth::user()->id)->orderBy('created_at', 'DESC')->get();
       $user_wallet=DB::table('users')->where('id',Auth::user()->id)->first();
    @endphp
    @if(Auth::user()->is_admin==0)
    <li class="nav-item dropdown no-arrow">
      <a class="nav-link dropdown-toggle" href=" {{ route('landingpages.trans') }}" aria-haspopup="true" aria-expanded="false">
        <span class="mr-2 d-none d-lg-inline text-gray-600 small">Wallet</span>
        <i class="fas fa-wallet"></i>
      </a>
      <!-- Dropdown - User Information -->
      <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown1">
       <span>&nbsp; Total Balance </span> {{$user_wallet->wallet? round($user_wallet->wallet,2):0 }} $
       <hr>
        @foreach ($payments as $item)
        <span> &nbsp; {{round($item->amount,2)}} {{ $item->currency}} deposited by &nbsp;{{ $item->name }} </span>
       <span style="font-size: x-small"> {{ \Carbon\Carbon::parse($item->created_at)->diffForHumans() }}</span> 
        <hr>
        @endforeach

      </div>
    </li>
    @endif

    <li class="nav-item dropdown no-arrow">
      <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ Auth::user()->name }}</span>
        <i class="fas fa-laugh-wink"></i>
      </a>
      <!-- Dropdown - User Information -->
      <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
        <a class="dropdown-item" href="{{ route('accountsettings.index') }}">
          <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
          @lang('Account Settings')
        </a>
        
        <div class="dropdown-divider"></div>
        <a class="dropdown-item" href="{{ route('logout') }}">
          <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
          @lang('Logout')
        </a>
      </div>
    </li>
  
  </ul>
</nav>