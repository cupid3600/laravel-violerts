<template>
	<table class="table table-striped d-none d-print-block">
        <thead>
            <tr class="print-table-invisible-head"/>
            <tr>
                <th
                    class="print-table-head"
                    colspan="6">
                    <span><i class="flaticon-statistics" /></span>
                    <h3>Job Applications <small>(Open Data)</small></h3>
                </th>
            </tr>
            <tr>
                <th class="align-top">Job #</th>
                <th class="align-top">Type</th>
                <th class="align-top">Latest Action Date</th>
                <th class="align-top">Status</th>
                <th class="align-top">Applicant</th>
            </tr>
        </thead>
        <tbody>
            <tr
                v-for="record in panel.data"
                :key="record.id">
                <td><p class="font-weight-light">{{ record.job__ }}</p></td>
                <td><p class="font-weight-light">{{ record.latest_action_date }}</p></td>
                <td><p class="font-weight-light">{{ record.job_type }}</p></td>
                <td><p class="font-weight-light">{{ record.job_status }}</p></td>
                <td><p class="font-weight-light">{{ record.applicant_s_first_name }} {{ record.applicant_s_last_name }}</p></td>
            </tr>
            <tr class="print-table-footer">
                <td colspan="5" />
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
<style scoped>
	
</style>