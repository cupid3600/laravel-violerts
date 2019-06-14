<template>
	<div>
		<li class="m-portlet__nav-item" id="myCloud-btn" data-toggle="modal" data-target="#myCloudModal">
			<a>
				<p class="pull-right">My Cloud</p>
				<i class="la la-cloud"></i> 
			</a>
		</li>
		<div class="modal fade" id="myCloudModal" tabindex="-1" role="dialog" aria-labelledby="myCloudModal" aria-hidden="true">
			<div class="modal-dialog modal-lg" role="document">
		    	<div class="modal-content">
		      		<div class="modal-header">
		        		<h5 class="modal-title" id="myCloudModalLabel">
		        			<i class="la la-cloud"></i> 
		        			My Cloud
		        		</h5>
		        			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          				<span aria-hidden="true">&times;</span>
		        			</button>
		      		</div>
		      		<div class="modal-body">
		      			<div class="col section">
		      				<h4 class="text-left">
		      					<button class="btn btn-sm pull-right expand-section-btn" type="button" data-toggle="collapse" data-target="#drawingsCollapse" aria-expanded="false" aria-controls="drawingsCollapse">
				      				<i class="la la-chevron-circle-down"></i> 
				      			</button>
			      				Drawings
			      			</h4>
			      			<hr>
			      			<div class="collapse" id="drawingsCollapse">
								<div class="row">
									
								</div>
			      			</div>
		      			</div>
		      			<div class="col section">
		      				<h4 class="text-left">
		      					<button class="btn btn-sm pull-right expand-section-btn">
				      				<i class="la la-chevron-circle-down"></i> 
				      			</button>
			      				Documents
			      			</h4>
			      			<hr>
		      			</div>
		      			<div class="col section">
		      				<h4 class="text-left">
		      					<button class="btn btn-sm pull-right expand-section-btn">
				      				<i class="la la-chevron-circle-down"></i> 
				      			</button>
			      				Photos
			      			</h4>
			      			<hr>
		      			</div>
		      		</div>
		    	</div>
		  	</div>
		</div>
	</div>
</template>
<script>
	export default { 
		data () { 
			return { 
			
			}	
		}, 
		methods: { 

		}
	}
</script>
<style type="text/css" scoped>
	#myCloud-btn { 
		padding-top: 5px !important;
		padding-right: 10px !important;
		color: #737487 !important;
		font-weight: 500 !important;
		cursor: pointer !important;
	}

	#myCloud-btn:hover, #myCloud-btn:focused { 
		color: #716aca !important;
	}

	#myCloud-btn a { 
		
	}

	#myCloud-btn i { 
		width: 24px !important;
		height: 24px !important;
	}

	#myCloud-btn p { 
		height: 24px !important;
		margin-bottom: 0 !important;
	}

	#myCloud-btn i, #myCloud-btn p { 
		display: inline-block !important;
	}

	.section h4 { 
		font-family: 'Roboto' !important;
		text-transform: uppercase !important;
		font-weight: 400 !important;
		letter-spacing: 0.5px !important;
		margin-bottom: 0 !important;
		color: #737487 !important;
	}

	.section h4 button { 
		margin-top: -5px !important;
	}

	.section hr { 
		margin-top: 8px !important;
	}

	.expand-section-btn { 
		padding-top: 1px !important;
	}

	.expand-section-btn i { 
		font-size: 24px !important;
		color: #737487 !important;
	}
</style>