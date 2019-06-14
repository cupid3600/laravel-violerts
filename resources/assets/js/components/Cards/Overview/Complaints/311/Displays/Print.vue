<template>
    <table class="table table-striped d-none d-print-block">
        <thead>
            <tr class="print-table-invisible-head"/>
            <tr>
                <th
                    class="print-table-head"
                    colspan="4">
                    <span><i class="flaticon-statistics" /></span>
                    <h3>311 Complaints <small>(Open Data)</small></h3>
                </th>
            </tr>
            <tr>
                <th class="align-top">Agency</th>
                <th class="align-top">Status</th>
                <th class="align-top">Issue Date</th>
                <th class="align-top">Description</th>
            </tr>
        </thead>
        <tbody>
            <tr
                v-for="record in panel.data"
                :key="record.id"
                v-if="record.status !== 'Closed'">
                <td><p class="font-weight-light" v-if="record.agency_name">{{ record.agency_name }}</p></td>
                <td><p class="font-weight-light text-muted" v-if="!record.agency_name"><i class="la la-warning"></i> Currently Unavailable</p></td>
                <td><p class="font-weight-light">{{ record.status }}</p></td>
                <td><p class="font-weight-light text-muted" v-if="!record.status"><i class="la la-warning"></i> Currently Unavailable</p></td>
                <td><p class="font-weight-light">{{ formatDate(record.created_at) }}</p></td>
                <td><p class="font-weight-light text-muted" v-if="!record.created_at"><i class="la la-warning"></i> Currently Unavailable</p></td>
                <td><p class="font-weight-light">{{ record.resolution_description }}</p></td>
                <td><p class="font-weight-light text-muted" v-if="!record.resolution_description"><i class="la la-warning"></i> Currently Unavailable</p></td>
            </tr>
            <tr class="print-table-footer">
                <td colspan="4" />
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
            },
        }
    }
</script>
<style scoped>
    
</style>