<a href="{{ route('settings.index') }}" class="list-group-item list-group-item-action d-flex align-items-center ">
        @lang('General settings')
    </a>
    <a href="{{ route('settings.localization') }}" class="list-group-item list-group-item-action d-flex align-items-center">
         @lang('Localization')
    </a>
    <a href="{{ url(config('translation.ui_url')) }}" class="list-group-item list-group-item-action d-flex align-items-center">
         @lang('Languages')
    </a>
    <a href="{{ route('settings.email') }}" class="list-group-item list-group-item-action d-flex align-items-center">
       @lang('E-mail Settings')
    </a>
    <a href="{{ route('settings.integrations') }}" class="list-group-item list-group-item-action d-flex align-items-center">
       @lang('Social Integrations')
    </a>