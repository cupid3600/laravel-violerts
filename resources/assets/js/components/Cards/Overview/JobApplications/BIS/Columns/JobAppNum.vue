<template>
	<div>
		<a href="#" @click="openBISRecord" v-if="rowData.uri != ''">
			{{rowData.job_number}}
		</a>
		<p v-if="rowData.uri === ''">
			{{rowData.job_number}}
		</p>
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
		methods: { 
			openBISRecord () { 
				window.open(`http://a810-bisweb.nyc.gov/bisweb/${this.rowData.uri}`);
			}
		}
	}
</script>
<style scoped>
	a {
		color: #5867dd !important;
	}

	a:hover { 
		text-decoration: underline !important; 
	}
</style>