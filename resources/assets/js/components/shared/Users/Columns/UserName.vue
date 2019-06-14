<template>
	<a :href="`/admin/user/profile/${rowData.profile_id}`">
		{{ rowData.name }}
	</a>
</template>
<script>
	export default { 
		data () { 
			return { 

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

		}
	}
</script>
<style scoped>
	a { 
		font-weight: 500;
		text-decoration: none !important;
	}
</style>