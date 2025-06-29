@if(config('cookie-consent.enabled') && !request()->cookie(config('cookie-consent.cookie_name')))
    @include('cookie-consent::dialogContents')
@endif  
