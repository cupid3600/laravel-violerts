@component('mail::message')
# {{ $property->address }}
<br>
## ECB Violation Number:
**{{ $ecb_violation->ecb_number }}**
<br>
@component('mail::panel')
	@component('mail::table')
		|               |               |
		| ------------- |:-------------:|
		| ** Violation Date **    | {{ $ecb_violation->violation_date }} |
		| ** Compliance Status **     | {{ $ecb_violation->buildings_violation_status }} |
		| ** Respondent ** | {{ $ecb_violation->respondent }} |
	@endcomponent
@endcomponent


@component('mail::button', ['url' => env('APP_URL').'/property/overview/'.$property->address])
	View Property
@endcomponent

<br>
{{ config('app.name') }}
@endcomponent