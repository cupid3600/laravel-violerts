<template>
	<div>
		<p v-if="rowData.plumbing !== null">Plumbing</p>
		<p v-if="rowData.mechanical !== null">Mechanical</p>
		<p v-if="rowData.boiler !== null">Boiler</p>
		<p v-if="rowData.fuel_burning !== null">Fuel Burning</p>
		<p v-if="rowData.fuel_storage !== null">Fuel Storage</p>
		<p v-if="rowData.standpipe !== null">Standpipe</p>
		<p v-if="rowData.sprinkler !== null">Sprinkler</p>
		<p v-if="rowData.fire_alarm !== null">Fire Alarm</p>
		<p v-if="rowData.equipment !== null">Equipment</p>
		<p v-if="rowData.fire_suppression !== null">Fire Supression</p>
		<p v-if="rowData.curb_cut !== null">Curb Cut</p>
		<p v-if="rowData.other !== null">Other - {{rowData.other_description}}</p>
	</div>
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
	p { 
		display: inline-block !important;  
	}
</style>