

<div class="d-flex align-items-center justify-content-between">
    <div>
        <h4>@lang('PayPal')</h4>
        <p>@lang('Customers can pay using their PayPal account or any major credit or debit card.')</p>
    </div>
    <div><img src="{{ asset('img/paypal.svg') }}" height="100" alt="PayPal"></div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label class="form-label">@lang('Environment')</label>
            <select name="settings[PAYPAL_SANDBOX]" class="form-control">
                <option value="1" {{ getValueIfKeyIsset($data['user']->settings,'PAYPAL_SANDBOX') === 1 ? 'selected' : '' }}>@lang('Sandbox')</option>
                <option value="0"  {{ getValueIfKeyIsset($data['user']->settings,'PAYPAL_SANDBOX') === 0 ? 'selected' : '' }}>@lang('Live')</option>
            </select>
        </div>
        <div class="form-group">
            <label class="form-label">@lang('Client ID')</label>
            <input type="text" name="settings[PAYPAL_CLIENT_ID]" value="{{ getValueIfKeyIsset($data['user']->settings,'PAYPAL_CLIENT_ID') }}" class="form-control">
        </div>
        <div class="form-group">
            <label class="form-label">@lang('Secret')</label>
            <input type="text" name="settings[PAYPAL_SECRET]" value="{{ getValueIfKeyIsset($data['user']->settings,'PAYPAL_SECRET') }}" class="form-control">
        </div>
    </div>
    <div class="col-md-6">
    </div>
</div>
<hr>
<div class="d-flex align-items-center justify-content-between">
    <div>
        <h4>@lang('Stripe')</h4>
        <p>@lang('Customers can pay using any major credit or debit card.')</p>
    </div>
    <div><img src="{{ asset('img/stripe.svg') }}" height="100" alt="=Stripe"></div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label class="form-label">@lang('Publishable key')</label>
            <input type="text" name="settings[STRIPE_KEY]" value="{{ getValueIfKeyIsset($data['user']->settings,'STRIPE_KEY') }}" class="form-control" placeholder="pk_XXX">
        </div>
        <div class="form-group">
            <label class="form-label">@lang('Secret key')</label>
            <input type="text" name="settings[STRIPE_SECRET]" value="{{ getValueIfKeyIsset($data['user']->settings,'STRIPE_SECRET') }}" class="form-control">
        </div>
    </div>
    <div class="col-md-6">
        
    </div>
</div>

