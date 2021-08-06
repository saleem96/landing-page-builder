<li class="nav-item {{ (request()->is('dashboard')) ? 'active' : '' }}">
	<a class="nav-link" href="{{ route('dashboard') }}">
		<i class="fas fa-tachometer-alt"></i>
		<span>@lang('Dashboard')</span></a>
</li>
<li class="nav-item {{ (request()->is('landingpages')) ? 'active' : '' }}">
	<a class="nav-link" href="{{ route('landingpages.index') }}">
		<i class="fas fa-paper-plane"></i>
		<span>@lang('Landing Pages')</span></a>
</li>
<li class="nav-item {{ (request()->is('alltemplates*')) ? 'active' : '' }}">
	<a class="nav-link" href="{{ route('alltemplates') }}">
		<i class="far fa-window-maximize"></i>
		<span>@lang('Templates')</span></a>
</li>
<hr class="sidebar-divider">
<li class="nav-item {{ (request()->is('leads*')) ? 'active' : '' }}">
	<a class="nav-link" href="{{ route('leads.index') }}">
		<i class="fas fa-user-friends"></i>
		<span>@lang('Leads')</span></a>
</li>
