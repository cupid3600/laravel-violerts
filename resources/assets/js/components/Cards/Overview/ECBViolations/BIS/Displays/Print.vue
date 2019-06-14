<template>
	<table class="table table-striped d-none d-print-block">
        <thead>
            <tr class="print-table-invisible-head"/>
            <tr>
                <th
                    class="print-table-head"
                    colspan="6">
                    <span><i class="flaticon-statistics" /></span>
                    <h3>ECB Violations <small>(BIS)</small></h3>
                </th>
            </tr>
            <tr>
            	<th class="align-top">ECB Violation #</th>
                <th class="align-top">Issue Date</th>
                <th class="align-top">Hearing Date/Time</th>
                <th class="align-top">Hearing Status</th>
                <th class="align-top">Certification Status</th>
                <th class="align-top">Description</th>
                <th class="align-top">Specific Conditions</th>
                <th class="align-top">DOB Violation Status</th>
            </tr>
        </thead>
        <tbody>
            <tr
                v-for="record in panel.data"
                :key="record.id">
                <td><p class="font-weight-light">{{ record.ecb_violation_number }}</p></td>
                <td><p class="font-weight-light">{{ record.violation_date }}</p></td>
                <td><p class="font-weight-light">{{ record.scheduled_hearing_date }}</p></td>
                <td><p class="font-weight-light">{{ record.ecb_hearing_status }}</p></td>
                <td><p class="font-weight-light">{{ record.certification_status }}</p></td>
                <td><p class="font-weight-light">{{ record.standard_description }}</p></td>
                <td><p class="font-weight-light">{{ record.specific_violation_conditions }}</p></td>
                <td><p class="font-weight-light">{{ record.building_violation_status+' '+record.building_violation_status_msg }}</p></td>
            </tr>
            <tr class="print-table-footer">
                <td colspan="6" />
            </tr>
        </tbody>
    </table>
</template>
<script>
	export default { 
		props: ['panel'], 
		data () { 
			return { 

			}
		}
	}
</script>
<style>
	
</style>