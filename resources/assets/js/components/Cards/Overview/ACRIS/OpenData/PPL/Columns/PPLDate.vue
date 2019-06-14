<template>
	<div>
		<p>
			{{formatDate(rowData.good_through_date)}}
		</p>
	</div>
</template>
<script>
	import moment from 'moment'
	export default { 
		name: 'ppl-date', 
		methods: { 
			formatDate (value) { 
				return moment(String(value)).format('MM/DD/YYYY')
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