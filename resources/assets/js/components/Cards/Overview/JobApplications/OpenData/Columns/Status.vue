<template>
	<div style="padding-right: 5px;">
		<span class="label label-default" v-if="rowData.job_status_descrp === 'PRE FILED'">
			pre-filed
		</span>
		<span class="label label-pending" v-if="rowData.job_status_descrp === 'A/P UNPAID'">
			a/p unpaid
		</span>
		<span class="label label-pending" v-if="rowData.job_status_descrp === 'A/P TO D.E.A.R'">
			a/p d.e.a.r
		</span>
		<span class="label label-success" v-if="rowData.job_status_descrp === 'A/P ENTIRE'">
			a/p entire
		</span>
		<span class="label label-success" v-if="rowData.job_status_descrp === 'AP NPE'">
			ap-npe
		</span>
		<span class="label label-warning" v-if="rowData.job_status_descrp === 'ASSIGNED TO P/E'">
			assigned to p/e
		</span>
		<span class="label label-pending" v-if="rowData.job_status_descrp === 'PAA FEE DUE'">
			paa fee due
		</span>
		<span class="label label-warning" v-if="rowData.job_status_descrp === 'P/E IN PROCESS'">
			p/e in process
		</span>
		<span class="label label-success" v-if="rowData.job_status_descrp === 'SIGN OFF'">
			sign-off
		</span>
		<span class="label label-danger" v-if="rowData.job_status_descrp === 'P/E DISAPPROVED'">
			p/e disapproved
		</span>
		<span class="label label-pending" v-if="rowData.job_status_descrp === 'P/E PARTIAL APRV'">
			p/e partial aprv
		</span>
		<span class="label label-warning" v-if="rowData.job_status_descrp === 'P/E PAA $ PENDING'">
			p/e paa $ pending
		</span>
		<span class="label label-success" v-if="rowData.job_status_descrp === 'P/E PAA $ RESOLVD'">
			p/e paa $ resolved
		</span>
		<span class="label label-success" v-if="rowData.job_status_descrp === 'APPROVED'">
			approved
		</span>
		<span class="label label-pending" v-if="rowData.job_status_descrp === 'PERMIT PARTIAL'">
			permit-partial
		</span>
		<span class="label label-pending" v-if="rowData.job_status_descrp === 'PERMIT ISSUED - ENTIRE JOB/WORK'">
			permit-issued
		</span>
		<span class="label label-success" v-if="rowData.job_status_descrp === 'PERMIT ENTIRE'">
			permit-entire
		</span>
		<span class="label label-success" v-if="rowData.job_status_descrp === 'COMPLETED'">
			completed
		</span>
		<span class="label label-success" v-if="rowData.job_status_descrp === 'SIGNED OFF'">
			signed-off
		</span>
		<span class="label label-danger" v-if="rowData.job_status_descrp === 'SUSPENDED'">
			suspended
		</span>
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
		}, 
	}
</script>
<style type="text/css">
	.label { 
		text-transform: uppercase;
		letter-spacing: 0.5px;
		padding-left: 5px;
		padding-right: 5px;
		font-size: 10px;
		font-weight: 500;
	}

	.label-warning { /* yellow */
		background-color: #f1e124;
		border: 1.2px solid #f1e124;
		color: #fff; 
	}

	.label-pending { /* orange */
		background-color: #ffb100;
		border: 1.2px solid #ffb100;
		color: #fff;
	}

	.label-default { 
		border: 1.2px solid #e3e3e3;
		background-color: #e3e3e3;
		color: #fff;
	}

	.label-danger { 
		border: 1.2px solid #f4516c;
		background-color: #f4516c;
		color: #fff;
	}

	.label-success { 
		border: 1.2px solid #34bfa3;
		background-color: #34bfa3;
		color: #fff;
	}
</style>