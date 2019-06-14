@component('mail::message')
# Please create a new password

Your account password has been reset, click the link below to create a new password.

@component('mail::button', ['url' => env('APP_URL').'/recover-user/'.$user->token])
Create password
@endcomponent

<br>
{{ config('app.name') }}
@endcomponent
