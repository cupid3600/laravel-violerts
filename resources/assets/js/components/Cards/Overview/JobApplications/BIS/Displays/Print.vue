<template>
	<table class="table table-striped d-none d-print-block">
        <thead>
            <tr class="print-table-invisible-head"/>
            <tr>
                <th
                    class="print-table-head"
                    colspan="7">
                    <span><i class="flaticon-statistics" /></span>
                    <h3>Job Applications <small>(BIS)</small></h3>
                </th>
            </tr>
            <tr>
                <th class="align-top">Job #</th>
                <th class="align-top">Latest Action Date</th>
                <th class="align-top">Status</th>
                <th class="align-top">Type </th>
                <th class="align-top">Description</th>
                <th class="align-top">Applicant</th>
            </tr>
        </thead>
        <tbody>
            <tr
                v-for="record in panel.data"
                :key="record.id">
                <td><p class="font-weight-light">{{ record.job_number }}</p></td>
                <td><p class="font-weight-light">{{ record.status_date }}</p></td>
                <td><p class="font-weight-light">{{ record.job_status }}</p></td>
                <td><p class="font-weight-light">{{ record.job_type }}</p></td>
                <td><p class="font-weight-light">{{ record.job_description }}</p></td>
                <td><p class="font-weight-light" v-if="record.applicant">{{ record.applicant.name }}</p></td>
                <td><p class="font-weight-light" v-if="!record.applicant"><i class="la la-warning"></i> Currently Unavailable</p></td>

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
			formatDate (value) { 
				if (value) { 
					return moment(String(value)).format('MM/DD/YYYY')
				}
			}
		}
	}
</script>