<template>
	<div>
		<p>
			{{rowData.respondent_first_name}} {{rowData.respondent_last_name}}
		</p>
	</div>
</template>
<script>
	export default { 
		name: 'oath-respondent',
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