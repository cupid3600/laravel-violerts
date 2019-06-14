<template>
	<table class="table table-striped d-none d-print-block">
        <thead>
            <tr class="print-table-invisible-head"/>
            <tr>
                <th
                    class="print-table-head"
                    colspan="8">
                    <span><i class="flaticon-statistics" /></span>
                    <h3>DOB Violations <small>(Open Data)</small></h3>
                </th>
            </tr>
            <tr>
            	<th class="align-top">DOB Violation #</th>
                <th class="align-top">Issue Date</th>
                <th class="align-top">Disposition Date</th>
                <th class="align-top">Disposition Comments</th>
                <th class="align-top">Device #</th>
                <th class="align-top">Description</th>
                <th class="align-top">Status</th>
            </tr>
        </thead>
        <tbody>
            <tr
                v-for="record in panel.data"
                :key="record.id"
                v-if="record.violation_category !== 'V*-DOB VIOLATION - Resolved' && record.violation_category !== 'V*-DOB VIOLATION - DISMISSED'">
                <td><p class="font-weight-light">{{ record.violation_number }}</p></td>
                <td><p class="font-weight-light">{{ formatDate(record.issue_date) }}</p></td>
                <td><p class="font-weight-light">{{ formatDate(record.disposition_date) }}</p></td>
                <td><p class="font-weight-light">{{ record.disposition_comments }}</p></td>
                <td><p class="font-weight-light">{{ record.device_number }}</p></td>
                <td><p class="font-weight-light">{{ record.description }}</p></td>
                <td><p class="font-weight-light">{{ record.violation_category }}</p></td>
            </tr>
            <tr class="print-table-footer">
                <td colspan="7" />
            </tr>
        </tbody>
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
			}
		}
	}
</script>
<style>
	
</style>