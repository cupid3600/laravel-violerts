<template>
	<div>
		<a :href="'https://a836-acris.nyc.gov/DS/DocumentSearch/DocumentImageView?doc_id='+rowData.document_id">
			{{rowData.document_id}}
		</a>
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