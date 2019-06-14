<template>
	<table class="table table-striped d-none d-print-block">
	    <thead>
	        <tr class="print-table-invisible-head"/>
	        <tr>
	            <th
	                class="print-table-head"
	                colspan="7">
	                <span><i class="flaticon-statistics" /></span>
	                <h3>Complaints <small>(BIS)</small></h3>
	            </th>
	        </tr>
	        <tr>
	            <th class="align-top">Complaint #</th>
	            <th class="align-top">Issue Date</th>
	            <th class="align-top">Category</th>
	            <th class="align-top">Disposition</th>
	            <th class="align-top">Description</th>
	            <th class="align-top">Comments</th>
	            <th class="align-top">Status</th>
	        </tr>
	    </thead>
	    <tbody>
	        <tr
	            :key="record.id"
	            v-for="record in panel.data"
	            v-if="record.status !== 'RES' && record.status !== 'CLS'"
	        >
	            <td><p class="font-weight-light">{{ record.complaint_number }}</p></td>
	            <td><p class="font-weight-light">{{ formatDate(record.date_entered) }}</p></td>
	            <td><p class="font-weight-light">{{ record.category_code+' '+record.category_code_description }}</p></td>
	            <td><p class="font-weight-light">{{ record.disposition_description }}</p></td>
	            <td><p class="font-weight-light">{{ record.description }}</p></td>
	            <td><p class="font-weight-light">{{ record.comments }}</p></td>
	            <td><p class="font-weight-light">{{ record.status }}</p></td>
	        </tr>
	        <tr class="print-table-footer">
	            <td colspan="7" />
	        </tr>
	    </tbody>
	    <div class="m-portlet__foot" />
	</table>
</template>
<script>
	import moment from 'moment'

	export default { 
		props: ['panel'], 
		data () { 
			return { 

			}
		}, 
		methods: { 
			formatDate (value) { 
                if (value) { 
                    return moment(String(value)).format('MM/DD/YYYY')
                }
            },
		}
	}
</script>
<style>
	
</style>