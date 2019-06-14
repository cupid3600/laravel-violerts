<template>
	<div>
		<div class="btn-group dropright">
			<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			    {{ group }}
			</button>
			<div class="dropdown-menu">
				<a class="dropdown-item" @click="changeUserGroup(rowData, 1)" v-if="rowData.user_group != 1">
			    	Member
			    </a>
			    <a class="dropdown-item" @click="changeUserGroup(rowData, 2)" v-if="rowData.user_group != 2">
			    	Admin
			    </a>
			    <a class="dropdown-item" @click="changeUserGroup(rowData, 3)" v-if="rowData.user_group != 3">
			    	Client
			    </a>
			    <a class="dropdown-item" @click="changeUserGroup(rowData, 4)" v-if="rowData.user_group != 4">
			    	Employee
			    </a>
			</div>
		</div>
	</div>
</template>
<script>
	export default { 
		props: { 

			rowData: { 
				type: Object, 
				required: true
			}, 

			rowIndex: {
				type: Number
			}

		}, 

		data () { 
			return { 
				group: ''
			}
		}, 

		methods: { 
			checkUserGroup (user) { 
				var app = this
				if(user.user_group == 1) app.group = 'Member';
				if(user.user_group == 2) app.group = 'Admin';
				if(user.user_group == 3) app.group = 'Client';
				if(user.user_group == 4) app.group = 'Employee';

			}, 

			changeUserGroup (user, user_group) { 
				var app = this
				axios.post(`/api/admin/users/change/group/${user.id}`, { 
					user_group: user_group
				})
				.then((response) => { 
					if(response.data == 1) app.group = 'Member';
					if(response.data == 2) app.group = 'Admin';
					if(response.data == 3) app.group = 'Client';
					if(response.data == 4) app.group = 'Employee';
				})
			}
		}, 

		created () { 
			this.checkUserGroup(this.rowData)
		}
	}
</script>