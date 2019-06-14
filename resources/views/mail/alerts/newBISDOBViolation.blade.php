@component('mail::message')
# {{ $property->address }}
<br>
## DOB Violation Number:
**{{ $dob_violation->number }}**
<br>

@component('mail::panel')
	@component('mail::table')
	|               |               |
	| ------------- |:-------------:|
	| ** Category **    | {{ $dob_violation->type }} |
	| ** Date issued **     | {{ $dob_violation->issue_date }} |
	@endcomponent
@endcomponent


@component('mail::button', ['url' => env('APP_URL').'property/overview/'.$property->address])
	View Property
@endcomponent

<br>
{{ config('app.name') }}
@endcomponent
