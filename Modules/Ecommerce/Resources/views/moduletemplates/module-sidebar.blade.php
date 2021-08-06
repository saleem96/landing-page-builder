<hr class="sidebar-divider">
<li class="nav-item {{ (request()->is('ecommerce/products*')) ? 'active' : '' }}">
	<a class="nav-link" href="{{ route('products.index') }}">
		<i class="fab fa-product-hunt"></i>
		<span>@lang('Products')</span></a>
</li>
<li class="nav-item {{ (request()->is('ecommerce/orders*')) ? 'active' : '' }}">
	<a class="nav-link" href="{{ route('orders.index') }}">
		<i class="fas fa-id-card"></i>
		<span>@lang('Orders')</span></a>
</li>