@can('admin')
<li class="nav-item  {{ (request()->is('settings*')) ? 'active' : '' }}">
	<a class="nav-link" href="{{ route('settings.index') }}">
		<i class="fas fa-user-secret"></i>
		<span>@lang('Administrator')</span></a>
	</li>
	@endcan