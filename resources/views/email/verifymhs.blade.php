@component('mail::message')
# Email Verification

Thank you for signing up. 

@component('mail::button', ['url' => $verifymhs])
Set Password
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent