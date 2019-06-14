<template>
	<router-link :to="`/property/overview/${rowData.property.address}`">
		{{rowData.property.address}}
	</router-link>
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
	a { 
		text-decoration: none !important;
		font-weight: 500;
	}
</style>