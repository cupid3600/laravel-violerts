<template>
	<p>
		{{ rowData.applicant_s_first_name+' '+rowData.applicant_s_last_name }}
	</p>
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
		}
	}
</script>
<style scoped>
	

</style>