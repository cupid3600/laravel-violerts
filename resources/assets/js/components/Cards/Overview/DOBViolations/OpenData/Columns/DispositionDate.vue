<template>
	<p>
		{{formatDate(rowData.disposition_date)}}
	</p>
</template>
<script>
	import moment from 'moment'
	export default { 
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
		}, 
	}
</script>
<style type="text/css" scoped>
	
</style>