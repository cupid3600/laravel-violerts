<template>
	<table class="table table-striped d-none d-print-block">
        <thead>
            <tr class="print-table-invisible-head"/>
            <tr>
                <th
                    class="print-table-head"
                    colspan="7">
                    <span><i class="flaticon-statistics" /></span>
                    <h3>DOB Violations <small>(BIS)</small></h3>
                </th>
            </tr>
            <tr>
                <th class="align-top">Issue Date</th>
                <th class="align-top">DOB Violation #</th>
                <th class="align-top">Type</th>
                <th class="align-top">Description</th>
                <th class="align-top">Comments</th>
                <th class="align-top">Device #</th>
                <th class="align-top">Violation Category</th>
            </tr>
        </thead>
        <tbody>
            <tr
                v-for="record in panel.data"
                :key="record.id"
                v-if="record.type !== 'DOB VIOLATION - CLOSED' && record.type !== 'DOB VIOLATION - DISMISSED' && record.type !== 'DOB VIOLATION - RESOLVED'">
                <td><p class="font-weight-light">{{ record.dob_violation_number }}</p></td>
                <td><p class="font-weight-light">{{ record.file_date }}</p></td>
                <td><p class="font-weight-light">{{ record.type }}</p></td>
                <td><p class="font-weight-light">{{ record.description }}</p></td>
                <td><p class="font-weight-light">{{ record.comments }}</p></td>
                <td><p class="font-weight-light">{{ record.device_number }}</p></td>
                <td><p class="font-weight-light">{{ record.violation_category }}</p></td>
            </tr>
            <tr class="print-table-footer">
                <td colspan="7" />
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
		}, 
		methods: { 

		}
	}
</script>
<style>
	
</style>