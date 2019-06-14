<template>
	<div>
		<button 
			@click="suspendUser(rowData.id)"
			class="btn btn-warning btn-sm" 
			v-if="rowData.isSuspended == false && rowData.id != user.id"
		>
			<i class="la la-user-times"></i> 
			Suspend
		</button>
		<button 
			@click="restoreUser(rowData.id)"
			class="btn btn-success btn-sm" 
			v-if="rowData.isSuspended == true && rowData.id != user.id"
		>
			<i class="la la-unlock-alt"></i> 
			Restore
		</button>
	</div>
</template>
<script>
	export default { 
		data () {
			return { 
				user: {}
			}
		}, 

		methods: { 
			getUser () { 
				var app = this
				axios.get(`/api/auth/user`)
				 .then((response) => { 
				 	app.user = response.data.data
				 })
			},

			suspendUser (id) { 
				var app = this
				axios.get(`/api/admin/users/suspend/${id}`)
					 .then((response) => { 
					 	console.log(response.data)
					 	app.$parent.refresh()
					 })
			}, 

			restoreUser (id) { 
				var app = this
				axios.get(`/api/admin/users/restore/${id}`)
					 .then((response) => { 
					 	console.log(response.data)
					 	app.$parent.refresh()
					 })
			}
		},

		props: { 
			
			rowData: { 
				type: Object,
				required: true
			},  

			rowIndex: { 
				type: Number
			}
		}, 

		mounted () { 
			this.getUser();
		}
	}
</script>