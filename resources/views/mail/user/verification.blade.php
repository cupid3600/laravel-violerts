@component('mail::message')
# Welcome to violerts,

Click the button below to confirm your email and activate your account.

@component('mail::button', ['url' => env('APP_URL').'/user/verification/'.$verification_code ])
Activate 
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
