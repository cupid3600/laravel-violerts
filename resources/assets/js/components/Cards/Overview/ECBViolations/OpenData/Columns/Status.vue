<template>
	<div style="padding-right: 5px;">
		<span class="label label-success" v-if="rowData.ecb_violation_status === 'RESOLVE'">
			resolved
		</span>
		<span class="label label-success" v-if="rowData.ecb_violation_status === 'DISMISSED'">
			dismissed
		</span>
		<span class="label label-danger" v-if="rowData.ecb_violation_status === 'ACTIVE'">
			active
		</span>
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
		}, 
	}
</script>
<style type="text/css">
	.label { 
		text-transform: uppercase;
		letter-spacing: 0.5px;
		padding-left: 5px;
		padding-right: 5px;
		font-size: 10px;
		font-weight: 500;
	}

	.label-danger { 
		border: 1.2px solid #f4516c;
		background-color: #f4516c;
		color: #fff;
	}

	.label-success { 
		border: 1.2px solid #34bfa3;
		background-color: #34bfa3;
		color: #fff;
	}
</style>