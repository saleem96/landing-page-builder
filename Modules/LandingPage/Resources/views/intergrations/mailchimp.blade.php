    

<div class="form-intergration d-none" id="form_mailchimp">
    
    <h4>@lang('Mailchimp')</h4>
    <div class="alert alert-warning" role="alert">
        @lang('The form will subscribe a new contact or lead to the chosen mailing system. Make sure there is an <strong>email</strong> field in the form!')
    </div>
    
    @if($item_intergration['type'] != "mailchimp")
        <input type="text" hidden="" name="mailchimp[merge_fields]" id="mailchimp_merge_fields" value="" class="form-control">
        <div class="form-group">
            <label class="form-label">@lang('API Key')<span class="text-danger">*</span></label>
            <input type="text" id="mailchimp_api_key" name="mailchimp[api_key]" value="" placeholder="@lang('Your Mailchimp API key')" class="form-control">
        </div>
        <div class="form-group">
            <label class="form-label">@lang('Contact subscription status')<span class="text-danger">*</span></label>
            <select name="mailchimp[contact_subscription_status]" class="form-control">
                <option value="subscribed">@lang("Active")
                </option>
                <option value="pending">@lang("Awaiting user confirmation")</option>
            </select>
        </div>
        <div class="form-group">
            <label class="form-label">@lang("Mailing list")<span class="text-danger">*</span></label>
            <select id="mailchimp_mailing_list" name="mailchimp[mailing_list]" class="form-control">
            </select>
        </div>
        <div class="alert alert-info" role="alert">
             @lang('Valid fields from your list'): <strong id="merge_fields_span"></strong>
        </div>
        <div class="alert alert-primary" role="alert">
            @lang('Change name your form fields with fields in your chosen integration, so that the data is saved correctly').<br>
            @lang('We suggest using Text type fields in MailChimp lists')
        </div>
        
    @else
        <input type="text" hidden="" name="mailchimp[merge_fields]" id="mailchimp_merge_fields" value="{{$item_intergration['settings']['merge_fields']}}" class="form-control">

        <div class="form-group">
            <label class="form-label">@lang('API Key')<span class="text-danger">*</span></label>
            <input type="text" id="mailchimp_api_key" name="mailchimp[api_key]" value="{{$item_intergration['settings']['api_key']}}" placeholder="@lang('Your Mailchimp API key')" class="form-control">
        </div>
        <div class="form-group">
            <label class="form-label">@lang('Contact subscription status')<span class="text-danger">*</span></label>
            <select name="mailchimp[contact_subscription_status]" class="form-control">
                <option value="subscribed" 
                    {{ $item_intergration['settings']['contact_subscription_status'] ==  'subscribed' ? 'selected' : ''}}>
                    @lang("Active")
                </option>
                <option value="pending" {{ $item_intergration['settings']['contact_subscription_status'] ==  'pending' ? 'selected' : ''}}>
                @lang("Awaiting user confirmation")</option>
            </select>
        </div>
        <div class="form-group">
            <label class="form-label">@lang("Mailing list")<span class="text-danger">*</span></label>
            <select id="mailchimp_mailing_list" name="mailchimp[mailing_list]" class="form-control" required="">
            </select>
        </div>
        <div class="alert alert-info" role="alert">
             @lang('Valid fields from your list'): <strong id="merge_fields_span"></strong>
        </div>
        <div class="alert alert-primary" role="alert">
            @lang('Change name your form fields with fields in your chosen integration, so that the data is saved correctly').<br>
            @lang('We suggest using Text type fields in MailChimp lists')
        </div>
    @endif
</div>

