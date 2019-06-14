<template>
	<div class="modal fade" id="userSettingsModal" tabindex="-1" role="dialog" aria-labelledby="userSettingsModalLabel" aria-hidden="true">
	  	<div class="modal-dialog" role="document">
	    	<div class="modal-content">
	      		<div class="modal-header">
	        		<h5 class="modal-title" id="userSettingsModalLabel">
	        			<i class="la la-user text-muted"></i>
	        			User Settings
	        		</h5>
	        		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
	        		  	<span aria-hidden="true">&times;</span>
	        		</button>
	      		</div>
	      		<div class="modal-body">
        			<form>
        				<h6 style="color: #000;">Plan details</h6>
					  	<div class="card" id="subscriptionPlanCard">
							<div class="card-body">
						    	<button class="btn btn-sm btn-info pull-right" disabled>
					    			Change plan 
					    		</button>
					    		<p v-if="user != null && user.user_group == 1">
					    			You're on the Member plan. 
					    		</p> 
					    		<p v-if="user != null && user.user_group == 2">
					    			You're on the Admin plan. 
					    		</p> 
					    		<p v-if="user != null && user.user_group == 3">
					    			You're on the Client plan. 
					    		</p> 
					    		<p v-if="user != null && user.user_group == 4">
					    			You're on the Employee plan. 
					    		</p> 
							</div>
						</div>
        				<hr v-if="user != null && user.user_group == 4">
        				<h6 v-if="user != null && user.user_group == 4" style="color: #000;">Connect Airtable account</h6>
        				<div v-if="user != null && user.user_group == 4" class="form-group">
					    	<label style="color: #000;">API Key</label>
					    	<input type="text" class="form-control" placeholder="Enter api key" v-model="airtable.key">
					    	<small class="form-text text-muted">
					    		<i class="la la-info text-muted"></i>
					    		<span @click="openAirtableAccount()" class="text-info click-here">Click here</span> 
					    		for information on where to find your airtable api key.
					    	</small>
					  	</div>
					  	<br v-if="user != null && user.user_group == 4">
					  	<div v-if="user != null && user.user_group == 4" class="form-group">
					    	<label style="color: #000;">Name</label>
					    	<input type="text" class="form-control" placeholder="Company name, email, project" v-model="airtable.name">
					  	</div>
					  	<hr v-if="user != null && user.user_group == 4 && linked_accounts.length > 0" >
					  	<div v-if="user != null && user.user_group == 4 && linked_accounts.length > 0">
					  		<h6 style="color: #000;">Linked accounts</h6>
					  		<div class="card" v-for="account in linked_accounts">
							  <div class="card-body">
							    <p class="card-title" style="color: #636363;">Airtable account</p>
							    <h6 class="card-subtitle mb-2 text-muted">{{account.name}}</h6>
							    <a class="card-link">
							    	<strong class="text-muted">Key: </strong>   
							    	<span style="color:#000;"> 
							    		{{`***${account.key.slice(3, 11)}`}}
							    	</span>
							    </a>
							    <a @click="removeAirtableKey(account.id)" class="card-link text-danger">
							    	Remove account
							    </a>
							  </div>
							</div>
					  	</div>
					  	<hr>

					  	<button type="button" class="btn btn-success" @click="addAirtableKey" :disabled="user && user.user_group != 4">Save changes</button>
					  	<button type="button" class="btn btn-default" style="color: #000 !important;" data-dismiss="modal" aria-label="Close">Close</button>
					</form>
	      		</div>
	    	</div>
	  	</div>
	</div>
</template>
<script>
	export default { 
		props: [ 
			'user'
		],
		data () { 
			return { 
				airtable: { 
					name: null, 
					key: null
				},
				linked_accounts: []
			}
		}, 
		methods: { 
			openAirtableAccount () { 
				window.open('https://airtable.com/account');
			},
			addAirtableKey () { 
				var app = this
				axios.post(`/api/user/settings/create/airtable-key/${app.user.id}`, { 
					name: app.airtable.name, 
					key: app.airtable.key
				})
				.then((response) => { 
					app.airtable.name = null
					app.airtable.key = null
					console.log(response)
					app.getAirtableKeys()
				})
			}, 
			getAirtableKeys () { 
				var app = this 
				axios.get(`/api/user/settings/read/airtable-key/index/${app.user.id}`)
					 .then((response) => { 
					 	console.log(response)
					 	app.linked_accounts = response.data
					 })
			}, 
			removeAirtableKey(account_id) { 
				var app = this 
				axios.get(`/api/user/settings/delete/airtable-key/${account_id}`)
					 .then((response) => { 
					 	console.log(response)
					 	app.getAirtableKeys()
					 })
			}
		}, 
		watch: { 
			'user': 'getAirtableKeys'
		}
	}
</script>
<style type="text/css" scoped>
	.click-here { 
		cursor: pointer !important;
	}

	.card-link:hover { 
		cursor: pointer;
	}

	#subscriptionPlanCard .card-body { 
		padding-top: 5px !important;
		padding-bottom: 5px !important;
	}

	#subscriptionPlanCard p { 
		color: #5b5b5b;
		font-weight: 600;
		padding-top: 11.5px;
		font-size: 14px;
	}

	#subscriptionPlanCard button { 
		margin-top: 7px !important;
	}
</style>