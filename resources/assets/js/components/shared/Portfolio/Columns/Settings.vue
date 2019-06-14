<template>
	<div>
		<!--<a @click="remove(rowData.id)">
			<i class="la la-remove"></i>
		</a>-->
		<a data-toggle="modal" :data-target="'#propertySettingsModal'+rowData.id" class="btn btn-default btn-sm" @click="getAirtableKeys">
			<i class="la la-cog"></i> 
			Settings
		</a>
		<div class="modal fade" :id="'propertySettingsModal'+rowData.id" tabindex="-1" role="dialog" aria-labelledby="propertySettingsLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
		    	<div class="modal-content" style="border-radius: 0 !important;">
		      		<div class="modal-header">
		        		<h5 class="modal-title" id="exampleModalLabel">
		        			<small class="text-muted">Property settings</small>
		        			<br>
		        			{{rowData.property.address}}
		        		</h5>
		        		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          			<span aria-hidden="true">&times;</span>
		        		</button>
		      		</div>
		      		<div class="modal-body">
		        		<!--<div class="row">
		        			<div class="col-xl-10 col-lg-10 col-md-10 col-sm-10">
		        				<h5 style="margin-bottom: 0 !important; margin-top: 10px !important;">
		        					Email Notifications
		        				</h5>
		        			</div>
		        			<div class="col-xl-2 col-lg-2 col-md-2 col-sm-2" style="padding-left: 0 !important;">
		        				<label class="switch">
									<input type="checkbox" @click="enableEmailAlerts" :checked="email_notifications_enabled == true">
									<span class="slider round"></span>
								</label>
		        			</div>
		        		</div>-->
		        		<!--<div class="row">
		        			<div class="col-xl-10 col-lg-10 col-md-10 col-sm-10">
		        				<h5 style="margin-bottom: 0 !important; margin-top: 10px !important;">
		        					SMS Notifications
		        				</h5>
		        			</div>
		        			<div class="col-xl-2 col-lg-2 col-md-2 col-sm-2" style="padding-left: 0 !important;">
		        				<label class="switch">
									<input type="checkbox" @click="smsAlerts" :checked="sms_notifications_enabled == true">
									<span class="slider round"></span>
								</label>
		        			</div>
		        		</div>-->
		        		<div class="row">
		        			<div class="col-xl-10 col-lg-10 col-md-10 col-sm-10" v-if="user != null && user.user_group == 4">
		        				<h5 style="margin-bottom: 0 !important; margin-top: 10px !important;">
		        					Connect Airtable
		        				</h5>
		        			</div>
		        			<div class="col-xl-2 col-lg-2 col-md-2 col-sm-2" style="padding-left: 0 !important;" v-if="user != null && user.user_group == 4">
		        				<label class="switch">
									<input type="checkbox" @click="enableAirtable" :checked="airtable_enabled == true">
									<span class="slider round"></span>
								</label>
		        			</div>
		        			<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12" v-if="user != null && user.user_group == 4 && airtable_enabled == true">
		        				<p class="text-muted" style="font-weight: 600 !important;" v-if="airtable_base_id == null">
		        					<i class="la la-info"></i> A pre-made airtable base and linked account is required.
		        				</p>
		        				<div v-if="airtable_msg != null" class="alert alert-secondary" role="alert" style="background-color: #e0e0e0 !important; font-weight: 600 !important;">
									{{airtable_msg}}
								</div>
								<div class="input-group mb-3" v-if="airtable_accounts.length > 0 && airtable_base_id === null">
									<select class="form-control" v-model="airtable_account">
										<option value="0" selected disabled>Select Airtable account</option>
										<option :value="account.id" v-for="account in airtable_accounts">{{account.name}}</option>
									</select>
								</div>
		        				<div class="input-group mb-3" v-if="airtable_base_id == null && airtable_accounts.length > 0">
									<input type="text" class="form-control" placeholder="Base ID" aria-label="Base ID" aria-describedby="basic-addon2" v-model="airtable_base_id_input">
								  	<div class="input-group-append">
								    	<button class="btn btn-info" type="button" @click="saveAirtableBase(airtable_base_id_input)">
								    		Save
								    	</button>
								  	</div>
								  	<small class="form-text text-muted">
							    		<i class="la la-info text-muted"></i>
							    		<span @click="openAirtableBase()" class="text-info click-here">Click here</span> 
							    		for information on where to find your airtable api base id.
							    	</small>
								</div>
								<div v-if="user != null && user.user_group == 4 && airtable_base_id != null">
									<div class="card" id="baseCard">
										<div class="card-body">
								    		<div class="btn-group pull-right btn-sm" role="group" aria-label="Button group with nested dropdown">
												<button type="button" class="btn btn-default">
											  		<i class="la la-refresh"></i>
											  	</button>
											  	<div class="btn-group" role="group">
											    	<button id="btnGroupDrop1" type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
											    	</button>
											    	<div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
											      		<a class="dropdown-item" @click="removeAirtableBase">
											      			Remove
											      		</a>
											    	</div>
											  	</div>
											</div>
											<p>
												<small>Base ID</small><br>
												{{ airtable_base_id }}
											</p>
										</div>
									</div>
								</div>
		        			</div>
		        			<div class="col">
		        				<!--<hr style="margin-top: 0 !important">-->
		        				<button @click="remove(rowData.id)" class="btn btn-block btn-danger" style="font-weight: 800 !important; text-transform: uppercase; letter-spacing: 0.5px;">
		        					Remove property
		        				</button>
		        			</div>
		        		</div>
		      		</div>
		    	</div>
		  	</div>
		</div>
	</div>
</template>
<script>
	export default { 
		props: { 
			rowData: { 
				required: true, 
				type: Object
			}, 
			rowIndex: { 
				type: Number
			}
		},
		data () { 
			return { 
				user: null,
				email_notifications_enabled: false, 
				sms_notifications_enabled: false, 
				airtable_accounts: [],
				airtable_enabled: false,
				airtable_account: 0,
				airtable_base_id: null,
				airtable_base_id_input: null,
				airtable_msg: null,
			}
		}, 
		methods: { 

			checkSettings (Id) { 
				var app = this
				axios.get(`/api/portfolio/settings/${Id}`)
					 .then((response) => { 
					 	console.log(response.data)
					 	app.airtable_base_id = response.data.airtable_base_id
					 	app.airtable_enabled = response.data.airtable_enabled
					 })
			},

			remove (property) { 
				console.log(property)
				var app = this
				axios.get(`/api/portfolio/remove/property/${property}`)
					 .then((response) => { 
					 	app.$parent.refresh()
					 	console.log(response.data)
					 	$('#propertySettingsModal').modal('hide')
						$('.modal-backdrop').remove();
					 })
			}, 

			enableEmailAlerts () { 
				
			},

			smsAlerts () { 
				console.log('clicky')
			},

			enableAirtable () { 
				var app = this
				if (this.airtable_enabled) { 
					axios.get(`/api/portfolio/airtable/disable/${app.rowData.id}`)
						 .then((response) => { 
						 	this.airtable_enabled = false
						 })
				} else { 
					app.airtable_enabled = true
				}
			}, 

			saveAirtableBase (base_id) { 
				var app = this
				console.log(app.rowData.id);
				if (base_id != null && app.airtable_enabled == true && app.airtable_account > 0) { 
					axios.post(`/api/portfolio/airtable/enable/${app.rowData.id}`, { 
						airtable_base_id: app.airtable_base_id_input,
						airtable_key_id: app.airtable_account
					})
					.then((response) => { 
						console.log(response)
						app.airtable_msg = null
						app.airtable_account = 0
						app.airtable_base_id = response.data.airtable_base_id
						app.airtable_base_id_input = null
					})
				} else if (app.airtable_account === 0 || app.airtable_account == null) { 
					app.airtable_msg = 'Please select an Airtable account'
				} else if (base_id == null) { 
					app.airtable_msg = 'The Airtable base id is required.'
				}
			}, 

			openAirtableBase () { 
				window.open('https://airtable.com/api');
			},

			removeAirtableBase () { 
				var app = this
				axios.get(`/api/portfolio/airtable/remove/${app.rowData.id}`)
					 .then((response) => { 
					 	app.airtable_enabled = response.data.airtable_enabled
					 	app.airtable_base_id = response.data.airtable_base_id
					 })
			}, 
			getUser () { 
				var app = this
				axios.get('/api/auth/user')
					 .then((response) => { 
					 	app.user = response.data.data
					 })
			}, 
			getAirtableKeys () { 
				var app = this 
				axios.get(`/api/user/settings/read/airtable-key/index/${app.user.id}`)
					 .then((response) => { 
					 	console.log(response)
					 	app.airtable_accounts = response.data
					 })
			}
		}, 
		created () {
			var app = this
			app.getUser()
			app.checkSettings(app.rowData.id)
		}, 
		watch: {
			'user': 'getAirtableKeys'
		}
	}
</script>
<style scoped>
	#baseCard { 
		margin-bottom: 10px !important;
	}

	#baseCard p { 
		margin-bottom: 0 !important;
	}

	#baseCard small { 
		font-weight: 600 !important;
	}

	#baseCard .btn-sm { 
		padding-right: 0 !important;
	}

	.click-here { 
		cursor: pointer !important;
	}

	.switch {
	  position: relative;
	  display: inline-block;
	  width: 60px;
	  height: 34px;
	}

	.switch input {display:none;}

	.slider {
	  position: absolute;
	  cursor: pointer;
	  top: 0;
	  left: 0;
	  right: 0;
	  bottom: 0;
	  background-color: #ccc;
	  -webkit-transition: .4s;
	  transition: .4s;
	}

	.slider:before {
	  position: absolute;
	  content: "";
	  height: 26px;
	  width: 26px;
	  left: 4px;
	  bottom: 4px;
	  background-color: white;
	  -webkit-transition: .4s;
	  transition: .4s;
	}

	input:checked + .slider {
	  background-color: #2196F3;
	}

	input:focus + .slider {
	  box-shadow: 0 0 1px #2196F3;
	}

	input:checked + .slider:before {
	  -webkit-transform: translateX(26px);
	  -ms-transform: translateX(26px);
	  transform: translateX(26px);
	}

	/* Rounded sliders */
	.slider.round {
	  border-radius: 34px;
	}

	.slider.round:before {
	  border-radius: 50%;
}
</style>