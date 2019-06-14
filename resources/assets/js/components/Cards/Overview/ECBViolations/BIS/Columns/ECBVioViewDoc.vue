<template>
	<div>
		<a @click="viewDocument(rowData.ecb_number)">
			View
		</a>
	</div>
</template>
<script>
	export default { 
		data () { 
			return { 

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
		}, 
		methods: { 
			viewDocument (ecb_number) { 
				window.open(`http://a820-ecbticketfinder.nyc.gov/GetViolationImage?violationNumber=${ecb_number}`)
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