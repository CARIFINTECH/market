@component('mail::message')# Thank you for creating an account with {{env('APP_NAME')}}. Please click the button below to verify the account
@component('mail::button', ['url' => $url])Verify Account
@endcomponent
Thanks,<br>
{{ config('app.name') }}
@endcomponent