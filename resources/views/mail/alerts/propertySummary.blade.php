<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<style>

	#itemCount { 

	}
	
	#itemCount div:nth-child(1) h1, #itemCount div:nth-child(1) p { 
		color: #34bfa3 !important;
	} 

	#itemCount div:nth-child(2) h1, #itemCount div:nth-child(2) p { 
		color: #5867dd !important;
	} 

	#itemCount div:nth-child(3) h1, #itemCount div:nth-child(3) p { 
		color: #f4516c !important;
	}

	#itemCount div:nth-child(4) h1, #itemCount div:nth-child(4) p { 
		color: #00c5dc !important;
	}
		
	#itemCount div h1, #itemCount div p { 
		text-align: center !important;
	}

	#itemCount div h1 { 
		margin-top: 0 !important;
		font-size: 28px !important;
	}

	#itemCount div p { 
		font-size: 12px !important; 
		font-weight: 500 !important;
		margin-bottom: 0 !important;
	}

	h1 small { 
		font-size: 12px !important;
	}

</style>
@component('mail::message')
### Property summary
# {{ $property->address }}
<hr>
<div class="row" id="itemCount">
	<div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-xs-12">
		<h1>{{ count($complaints) }}</h1>
		<p>Complaints</p>
	</div>
	<div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-xs-12">
		<h1>{{ count($dob_violations) }}</h1>
		<p>DOB Violations</p>
	</div>
	<div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-xs-12">
		<h1>{{ count($ecb_violations) }}</h1>
		<p>ECB Violations</p>
	</div>
	<div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-xs-12">
		<h1>{{ count($job_applications) }}</h1>
		<p>Job Applications</p>
	</div>
</div>
<hr>
<br>
@if (count($complaints) > 0)
<div class="row" id="complaintsList">
	<h1 class="text-muted col-xl-12 col-lg-12 col-md-12 col-sm-12">
		<!--<small class="pull-right">EXPAND</small>-->
		Open Complaints
	</h1>
	@foreach ($complaints as $complaint)
	<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="card">
			<div class="card-body">
		    	<h5 class="card-title">
		    		<a href="">
		    			{{ $complaint->complaint_number }}
		    		</a>
		    	</h5>
		    	<h6 class="card-subtitle mb-2 text-muted">
		    		Date issued: <strong>{{ $complaint->date_entered }}</strong>
		    	</h6>
		    	<p class="card-text">
		    		{{ $complaint->description }}
		    	</p>
		    	<a href="{{ $complaint->uri }}" class="card-link">View Complaint</a>
		  	</div>
		</div>
	</div>
	@endforeach
</div>
<hr>
@endif

@if(count($dob_violations) > 0)
<div class="row" id="dobViolationList">
	<h1 class="text-muted col-xl-12 col-lg-12 col-md-12 col-sm-12">
		<!--<small class="pull-right">EXPAND</small>-->
		Open DOB Violations
	</h1>
	@foreach ($dob_violations as $dob_violation)
	<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="card">
			<div class="card-body">
		    	<h5 class="card-title">
		    		<a href="">
		    			{{ $dob_violation->number }}
		    		</a>
		    	</h5>
		    	<h6 class="card-subtitle mb-2 text-muted">
		    		Date issued: 
		    		<strong>{{ $dob_violation->issue_date }}</strong> 
		    		| Category: 
		    		<strong>{{ $dob_violation->type }}</strong>
		    	</h6>
		    	<a href="http://a810-bisweb.nyc.gov/bisweb/{{ $dob_violation->uri }}" class="card-link">View DOB Violation</a>
		  	</div>
		</div>
	</div>
	@endforeach
</div>
<hr>
@endif

@if (count($ecb_violations) > 0)
<div class="row" id="ecbViolationList">
	<h1 class="text-muted col-xl-12 col-lg-12 col-md-12 col-sm-12">
		<!--<small class="pull-right">EXPAND</small>-->
		Open ECB Violations
	</h1>
	@foreach ($ecb_violations as $ecb_violation)
	<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="card">
			<div class="card-body">
		    	<h5 class="card-title">
		    		<p class="pull-right">
		    			Respondent: 
		    			<strong>{{ $ecb_violation->respondent }}</strong>
		    		</p>
		    		<a href="http://a810-bisweb.nyc.gov/bisweb/{{ $ecb_violation->uri }}">
		    			{{ $ecb_violation->ecb_number }}
		    		</a>
		    	</h5>
		    	<h6 class="card-subtitle mb-2 text-muted">
		    		Date issued: <strong>{{ $ecb_violation->viol_date }}</strong> | Infraction codes: {{ $ecb_violation->infraction_codes }} | Status: <strong>{{ $ecb_violation->bvs_status }}</strong>
		    	</h6>
		    	<a href="http://a810-bisweb.nyc.gov/bisweb/{{ $ecb_violation->uri }}" class="card-link">View ECB Violation</a>
		  	</div>
		</div>
	</div>
	@endforeach
</div>
@endif

@if (count($job_applications) > 0)
<div class="row" id="ecbViolationList">
	<h1 class="text-muted col-xl-12 col-lg-12 col-md-12 col-sm-12">
		<!--<small class="pull-right">EXPAND</small>-->
		Open Job Applications
	</h1>
	@foreach ($job_applications as $job_application)
	<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="card">
			<div class="card-body">
		    	<h5 class="card-title">
		    		<a href="">
		    			{{ $job_application->job_number }}
		    		</a>
		    	</h5>
		    	<h6 class="card-subtitle mb-2 text-muted">
		    		File date: <strong>{{ $job_application->file_date }}</strong> | Document #: {{ $job_application->doc_number }} | Status: <strong>{{ $job_application->job_status }}</strong>
		    	</h6>
		    	<a href="http://a810-bisweb.nyc.gov/bisweb/{{ $job_application->uri }}" class="card-link">View Job Application</a>
		  	</div>
		</div>
	</div>
	@endforeach
</div>
@endif

@component('mail::button', ['url' => env('APP_URL').'/property/overview/'.$property->address])
View Overview 
@endcomponent

@endcomponent
<script
  src="https://code.jquery.com/jquery-3.3.1.min.js"
  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
  crossorigin="anonymous"></script>
