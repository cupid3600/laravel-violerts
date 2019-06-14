<template>
	<div style="padding-right: 5px;">
		<span class="label label-default" v-if="rowData.job_status === 'A PRE FILED'">
			pre-filed
		</span>
		<span class="label label-pending" v-if="rowData.job_status === 'B A/P UNPAID'">
			a/p unpaid
		</span>
		<span class="label label-pending" v-if="rowData.job_status === 'C A/P TO D.E.A.R'">
			a/p d.e.a.r
		</span>
		<span class="label label-success" v-if="rowData.job_status === 'D A/P ENTIRE'">
			a/p entire
		</span>
		<span class="label label-success" v-if="rowData.job_status === 'E AP NPE'">
			ap-npe
		</span>
		<span class="label label-warning" v-if="rowData.job_status === 'F ASSIGNED TO P/E'">
			assigned to p/e
		</span>
		<span class="label label-pending" v-if="rowData.job_status === 'G PAA FEE DUE'">
			paa fee due
		</span>
		<span class="label label-warning" v-if="rowData.job_status === 'H P/E IN PROCESS'">
			p/e in process
		</span>
		<span class="label label-success" v-if="rowData.job_status === 'I SIGN OFF'">
			sign-off
		</span>
		<span class="label label-danger" v-if="rowData.job_status === 'J P/E DISAPPROVED'">
			p/e disapproved
		</span>
		<span class="label label-pending" v-if="rowData.job_status === 'K P/E PARTIAL APRV'">
			p/e partial aprv
		</span>
		<span class="label label-warning" v-if="rowData.job_status === 'L P/E PAA $ PENDING'">
			p/e paa $ pending
		</span>
		<span class="label label-success" v-if="rowData.job_status === 'M P/E PAA $ RESOLVD'">
			p/e paa $ resolved
		</span>
		<span class="label label-success" v-if="rowData.job_status === 'P APPROVED'">
			approved
		</span>
		<span class="label label-pending" v-if="rowData.job_status === 'Q PERMIT PARTIAL' || rowData.job_status === 'Q PERMIT-PARTIAL'">
			permit-partial
		</span>
		<span class="label label-success" v-if="rowData.job_status === 'R PERMIT-ENTIRE' || rowData.job_status === 'R PERMIT-ENTIRE'">
			permit-entire
		</span>
		<span class="label label-success" v-if="rowData.job_status === 'U COMPLETED'">
			completed
		</span>
		<span class="label label-success" v-if="rowData.job_status === 'X SIGNED OFF'">
			signed-off
		</span>
		<span class="label label-danger" v-if="rowData.job_status === '3 SUSPENDED'">
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