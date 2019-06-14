@component('mail::message')
# {{ $property->address }} - Has a new job application.
<br>
### Job Application Number:
**{{ $job_application->job_number }}**
<br>

@component('mail::button', ['url' => env('APP_URL').'/property/overview/'.$property->address])
	View Overview
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
