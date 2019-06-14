<template>
	<div>
		{{formatDate(rowData.latest_action_date)}}
	</div>
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
		}
	}
</script>