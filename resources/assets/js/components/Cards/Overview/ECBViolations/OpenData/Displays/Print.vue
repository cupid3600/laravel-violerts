<template>
	<table class="table table-striped d-none d-print-block">
        <thead>
            <tr class="print-table-invisible-head"/>
            <tr>
                <th
                    class="print-table-head"
                    colspan="8">
                    <span><i class="flaticon-statistics" /></span>
                    <h3>ECB Violations <small>(Open Data)</small></h3>
                </th>
            </tr>
            <tr>
            	<th class="align-top">ECB Violation #</th>
                <th class="align-top">Issue Date</th>
                <th class="align-top">Respondent</th>
                <th class="align-top">Hearing Date/Time</th>
                <th class="align-top">Hearing Status</th>
                <th class="align-top">Certification Status</th>
                <th class="align-top">Description</th>
                <th class="align-top">Status</th>
            </tr>
        </thead>
        <tbody>
            <tr
                v-for="record in panel.data"
                :key="record.id">
                <td><p class="font-weight-light">{{ record.ecb_violation_number }}</p></td>
                <td><p class="font-weight-light">{{ formatDate(record.issue_date) }}</p></td>
                <td><p class="font-weight-light">{{ record.respondent_name }}</p></td>
                <td><p class="font-weight-light">{{ formatDate(record.hearing_date) }} / {{ record.hearing_time }}</p></td>
                <td><p class="font-weight-light">{{ record.hearing_status }}</p></td>
                <td><p class="font-weight-light">{{ record.certification_status }}</p></td>
                <td><p class="font-weight-light">{{ record.violation_description }}</p></td>
                <td><p class="font-weight-light">{{ record.ecb_violation_status }}</p></td>
            </tr>
            <tr class="print-table-footer">
                <td colspan="8" />
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