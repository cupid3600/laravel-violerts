@component('mail::message')
# {{ $property->address }}
### {{ $complaint->description }}


**Date Entered: ** {{ $complaint->date_entered }} 


** Status: ** {{ $complaint->status }}

@component('mail::button', ['url' => env('APP_URL').'/property/overview/'.$property->address])
	View Property
@endcomponent

<br>
{{ config('app.name') }}
@endcomponent
