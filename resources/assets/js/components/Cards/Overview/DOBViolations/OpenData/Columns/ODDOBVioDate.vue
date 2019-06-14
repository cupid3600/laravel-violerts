<template>
	<div>
		{{formatDate(rowData.issue_date)}}
	</div>
</template>
<script>
	import moment from 'moment'

	export default { 
		name: 'dob-date',
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