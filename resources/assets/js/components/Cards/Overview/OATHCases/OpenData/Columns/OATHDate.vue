<template>
	<div>
		<p>
			{{formatDate(rowData.violation_date)}}
		</p>
	</div>
</template>
<script>
	import moment from 'moment'
	
	export default { 
		name: 'oath-date',
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