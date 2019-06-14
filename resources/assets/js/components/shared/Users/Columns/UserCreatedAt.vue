<template>
	<p> 
		{{ formatDate(rowData.created_at) }}
	</p>
</template>
<script>
	import moment from 'moment'

	export default { 
		data () { 
			return { 

			}
		}, 

		methods: { 
			formatDate (value) { 
				if (value) { 
					return moment(String(value)).format('MM/DD/YYYY')
				}
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
	p { 
		margin-bottom: 0 !important;
	}
</style>