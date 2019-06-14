<template>
	<div>
		<Navbar
			:settings="Navbar"
			:user="user"
		/>
		<div class="m-grid__item m-grid__item--fluid m-wrapper">
			<Search class="d-print-none" id="searchBar" v-if="display_width == true && !isMobile || display_width == true && isMobile && display.search"/>
			<!-- subheader -->
	    	<div class="m-subheader" v-show="!isMobile || isMobile && display.subheader_address">
	    		<div class="d-flex align-items-center">
	    			<div class="mr-auto">
	    				<small>
	    					Property Overview
	    				</small>
	    				<br>
	    				<h3 class="m-subheader__title">
	    					{{ property.address }}
	    				</h3>
	    			</div>
                    <PdfReport
                        :zone="zone"
                        :property="property"
                    />
	    		</div>
	    	</div>

	    	<div class="m-content page-break-after" id="row_parent">
	    		<div class="row">
	    			<General v-if="!isMobile || isMobile && display.general"
	    				:zone="zone"

	    			/>
	    			<Zoning v-if="!isMobile || isMobile && display.zoning"
	    				:zone="zone"
	    			/>
	    			<!--<Activity/>-->
	    		</div>
	    		<div class="row page-break-before">
	    			<OpenData311Complaints v-show="!isMobile || isMobile && display.too_complaints"
	    				:property="property"
	    			/>
	    		</div>
	    		<!--<div class="row page-break-before">
	    			<OpenDataComplaints v-show="!isMobile || isMobile && display.complaints"
	    				:property="property"
	    			/>
	    		</div>-->
	    		<div class="row page-break-before">
	    			<BISComplaints v-show="!isMobile || isMobile && display.complaints_bis"
	    				:property="property"
	    			/>
	    		</div>
	    		<div class="row page-break-before">
	    			<OpenDataDOBViolations v-show="!isMobile || isMobile && display.dob_violations"
	    				:property="property"
	    			/>
	    		</div>
	    		<div class="row page-break-before">
	    			<BISDOBViolations v-show="!isMobile || isMobile && display.dob_violations_bis"
	    				:property="property"
	    			/>
	    		</div>
	    		<div class="row page-break-before">
	    			<OpenDataECBViolations v-show="!isMobile || isMobile && display.ecb_violations"
	    				:property="property"
	    			/>
	    		</div>
	    		<div class="row page-break-before">
	    			<BISECBViolations v-show="!isMobile || isMobile && display.ecb_violations_bis"
	    				:property="property"
	    			/>
	    		</div>
	    		<div class="row page-break-before">
	    			<OpenDataJobApplications v-show="!isMobile || isMobile && display.job_applications"
	    				:property="property"
	    			/>
	    		</div>
	    		<div class="row page-break-before">
	    			<BISJobApplications v-show="!isMobile || isMobile && display.job_applications_bis"
	    				:property="property"
	    			/>
	    		</div>
	    		<!--<div class="row page-break-before">
	    			<OpenDataOATHCases v-show="!isMobile || isMobile && display.oath_cases"
	    				:property="property"
	    			/>
	    		</div>-->
	    		<!--<div class="row">
	    			<OpenDataACRISRPLS v-show="!isMobile || isMobile && display.acris_rpl"
	    				:property="property"
	    			/>
	    		</div>
	    		<div class="row">
	    			<OpenDataACRISPPLS v-show="!isMobile || isMobile && display.acris_ppl"
	    				:property="property"
	    			/>
	    		</div>
	    		<div class="row">
	    			<BISElevatorRecords v-show="!isMobile || isMobile && display.elevator_records"
	    				:property="property"
	    			/>
	    		</div>
	    		<div class="row">
	    			<BISElevatorInspections v-show="!isMobile || isMobile && display.elevator_inspections"
	    				:property="property"
	    			/>
	    		</div>
	    		<div class="row">
	    			<BISElevatorViolations v-show="!isMobile || isMobile && display.elevator_violations"
	    				:property="property"
	    			/>
	    		</div>
	    		<div class="row">
	    			<BISPermits
	    				:property="property"
	    			/>
	    		</div>
	    		<div class="row">
	    			<BISIlluminatedSigns v-if="!isMobile || isMobile && display.illuminated_signs"
	    				:property="property"
	    			/>
	    		</div>-->
	    	</div>
		</div>
		<BackToTop class="d-print-none"/>
	</div>
</template>
<script>
	import Navbar from '../components/shared/Navbar.vue'
	import General from '../components/Cards/Overview/General/Panel.vue'
	import Zoning from '../components/Cards/Overview/Zoning/Panel.vue'
	import Activity from '../components/Cards/Overview/Activity/Panel.vue'
	import OpenDataComplaints from '../components/Cards/Overview/Complaints/OpenData/Panel.vue'
	import OpenData311Complaints from '../components/Cards/Overview/Complaints/311/Panel.vue'
	import BISComplaints from '../components/Cards/Overview/Complaints/BIS/Panel.vue'
	import OpenDataDOBViolations from '../components/Cards/Overview/DOBViolations/OpenData/Panel.vue'
	import BISDOBViolations from '../components/Cards/Overview/DOBViolations/BIS/Panel.vue'
	import OpenDataECBViolations from '../components/Cards/Overview/ECBViolations/OpenData/Panel.vue'
	import BISECBViolations from '../components/Cards/Overview/ECBViolations/BIS/Panel.vue'
	import OpenDataJobApplications from '../components/Cards/Overview/JobApplications/OpenData/Panel.vue'
	import BISJobApplications from '../components/Cards/Overview/JobApplications/BIS/Panel.vue'
	import OpenDataOATHCases from '../components/Cards/Overview/OATHCases/OpenData/Panel.vue'
	import OpenDataACRISRPLS from '../components/Cards/Overview/ACRIS/OpenData/RPL/Panel.vue'
	import OpenDataACRISPPLS from '../components/Cards/Overview/ACRIS/OpenData/PPL/Panel.vue'
	import BISElevatorRecords from '../components/Cards/Overview/Elevator/BIS/Records/Panel.vue'
	import BISElevatorInspections from '../components/Cards/Overview/Elevator/BIS/Inspections/Panel.vue'
	import BISElevatorViolations from '../components/Cards/Overview/Elevator/BIS/Violations/Panel.vue'
	import BISPermits from '../components/Cards/Overview/Permits/BIS/Panel.vue'
	import BISIlluminatedSigns from '../components/Cards/Overview/IlluminatedSigns/BIS/Panel.vue'
	import Search from '../components/shared/Search.vue'
    import BackToTop from '../components/shared/BackToTop.vue'
    import PdfReport from '../components/shared/PdfReports/PdfReport.vue'

	export default { 
		props: ['address'],
		components: { 
			Navbar, 
			General,
			Zoning,
			Activity,
			OpenDataComplaints,
			OpenData311Complaints,
			BISComplaints,
			OpenDataDOBViolations,
			BISDOBViolations,
			OpenDataECBViolations,
			BISECBViolations,
			OpenDataJobApplications,
			BISJobApplications,
			OpenDataOATHCases,
			OpenDataACRISRPLS,
			OpenDataACRISPPLS,
			BISElevatorRecords,
			BISElevatorInspections,
			BISElevatorViolations,
			BISPermits,
			BISIlluminatedSigns,
			Search,
            BackToTop,
            PdfReport
		},
		data () {
			return {
				user: {},
				Navbar: {
					web: 0,
					app: 1
				},
				property: {},
				zone: {
					pluto: []
				},
				display: {
                    acris_ppl: 1,
                    acris_rpl: 1,
                    complaints: 1,
                    complaints_bis: 1,
                    dob_violations: 1,
                    dob_violations_bis: 1,
                    ecb_violations: 1,
                    ecb_violations_bis: 1,
                    elevator_inspections: 1,
                    elevator_records: 1,
                    elevator_violations: 1,
                    general: 1,
					zoning: 1,
					map: 1,
                    illuminated_signs: 1,
                    job_applications: 1,
                    job_applications_bis: 1,
                    oath_cases: 1,
                    search: 1,
                    subheader_address :1,
                    too_complaints: 1
                },
                isMobile: screen.width < 768,
				display_width: window.matchMedia("(max-width: 812px)").matches
			}
		},
		watch: { 
			'property': 'zoneQuery', 
			'address': 'getProperty'
		},
		methods: { 
			getProperty () { 
				var app = this
				axios.get(`/api/property/overview/${app.$route.params.address}`)
					 .then((response) => { 
					 	if(response.data.property != null){ 
					 		app.property = response.data.property
					 	}
					 })
			}, 
			zoneQuery () { 
				if (this.property.borough === 1 || this.property.borough === '1') { 
      				// manhattan zoning information - get request block & lot query
		      		fetch (`https://mn-zone.vio.nyc/block_lot/${this.property.block}/${this.property.lot}`, { 
		      			method: 'GET'
		      		})
		      			.then(response => response.json())
		      			.then(json => this.zone.pluto = json)
      			}
      			if (this.property.borough === 2 || this.property.borough === '2') { 
      				// bronx zoning infromation - get request block & lot query 
      				fetch (`https://bx-zone.vio.nyc/block_lot/${this.property.block}/${this.property.lot}`, { 
      					method: 'GET'
      				})
      					.then(response => response.json())
      					.then(json => this.zone.pluto = json)
      			}
      			if (this.property.borough === 3 || this.property.borough === '3') { 
      				// brooklyn zoning information - get request block & lot query
		      		fetch (`https://bk-zone.vio.nyc/block_lot/${this.property.block}/${this.property.lot}`, { 
		      			method: 'GET'
		      		})
		      			.then(response => response.json())
		      			.then(json => this.zone.pluto = json)
      			}
      			if (this.property.borough === 4 || this.property.borough === '4') { 
      				// queens zoning information - get request block & lot query 
      				fetch (`https://qn-zone.vio.nyc/block_lot/${this.property.block}/${this.property.lot}`, { 
      					method: 'GET'
      				})
      					.then(response => response.json())
      					.then(json =>this.zone.pluto = json)
      			}
      			if (this.property.borough === 5 || this.property.borough === '5') { 
      				// staten island zoning information - get request block & lot query
      				fetch (`https://si-zone.vio.nyc/block_lot/${this.property.block}/${this.property.lot}`, { 
      					method: 'GET'
      				})
      					.then(response => response.json())
      					.then(json => this.zone.pluto = json)
      			}
			}
		},
		created () { 
			var app = this
			if(app.$auth.check()){ 
				axios.get('/api/auth/user')
					 .then((response) => { 
					 	app.user = response.data.data
					 })
			}
			document.body.style.backgroundImage = 'none'
			document.body.style.backgroundColor = '#ebedf2'
			this.getProperty()
		}
	}
</script>
<style>
    @page {
        size: landscape;
        margin: 0;
    }
    @media print {
        .page-break-after {
            page-break-after: always;
        }
        * {
            width: 100%;
            color: #575962;
            -webkit-print-color-adjust: exact !important;
            float: none;
        }
        .page-break-before {
            page-break-before: always;
        }
        nav {
            position: absolute;
            top: 0;
        }
        svg {
            max-width: 11rem;
        }
        .m-subheader {
            position: relative;
            left: 1rem;
        }
        .m-subheader small {
            font-weight: 400;
            color: rgb(44,46,50);
            font-size: 1.4rem !important;
        }
        .m-subheader__title {
            font-weight: 500;
            font-size: 1.8rem;
        }
        .m-portlet__head-text {
            font-size: 1.4rem !important;
        }
        .print-header {
            font-size: 1.3rem !important;
            font-weight: 500;
            font-family: Roboto;
        }
        .m-grid__item {
            background-color: rgb(235, 236, 242);
            margin: 0 !important;
        }
        .col-print-6 {
            min-width: 100% !important;
            max-width: 100% !important;
            width: 100%;
        }
        .m-portlet {
            box-shadow: 0px 1px 15px 1px rgba(113, 106, 202, 0.08) !important;
            page-break-after: always !important;
        }
        .table thead th {
            vertical-align: middle !important;
        }
        .table {
            display: table !important;
            table-layout: fixed !important;

        }
        .table td {
            background-color: transparent !important;
        }
        tr:nth-child(even) {
            background: white;
        }
        .print-table-head {
            height: 5.1rem;
            padding: 0 2.2rem !important;
            font-size: 1.1rem;
            font-family: Roboto;
            vertical-align: middle;
            border-bottom: 1px solid rgb(235, 236, 242) !important;
        }
        .print-table-invisible-head {
            background-color: rgb(235,235,241);
            height: 35px;
        }
        .print-table-head h3 {
            top: 1.7rem;
            font-size: 1.3rem;
            font-weight: 500;
            display: inline;
        }
        .print-table-head small {
            color: #afb2c1;
            font-weight: 300;
            padding-left: 5px;
            font-size: 1rem;
        }
        [class^="flaticon-"]:before, [class*=" flaticon-"]:before, [class^="flaticon-"]:after, [class*=" flaticon-"]:after {
            color: #b2b1c5;
            font-size: 1.5rem;
            padding: 0 13px 0 0;
            line-height: inherit;
        }
        .print-table-footer {
            height: 52px !important;
            border-top: 1px solid rgb(235, 236, 242) !important;
            margin-top: 1px !important;
            background-color: white !important;
        }
    }
    .navbar-dark {
        background-color: #2c2e3e !important;
    }

	.m-grid__item { 
		margin-top: 80px;
	}

	.m-subheader { 
		padding-bottom: 20px; 
	}

	.m-subheader small { 
		font-size: 18px !important;

	}

	.m-content { 
		padding-left: 30px; 
		padding-right: 30px;
	}

	#searchBar { 
		display: none !important;
		margin-bottom: 0px !important;
	}

	#searchBar button { 
		padding-top: 0 !important;
		padding-bottom: 0 !important;
	}

	/* iphone 4/4s - portrait */
	@media only screen 
  	and (min-device-width: 320px) 
  	and (max-device-width: 480px)
  	and (-webkit-min-device-pixel-ratio: 2)
  	and (orientation: portrait) {
		.navbar-brand svg { 
			width: 50%;
		}

		.nav-item:nth-child(2) { 
			padding-left: 0 !important;
		}

		#searchBar { 
			display: inherit !important;
			margin-bottom: 10px !important;
			padding-top: 20px !important;
			padding-left: 30px !important;
			padding-right: 30px !important;
		}

		.m-subheader { 
			padding-left: 30px !important;
			padding-right: 30px !important;
		}

		.m-subheader small { 
			font-size: 12px !important;
		}

		.m-subheader__title { 
			font-size: 14px !important;
		}
	}

	/* iphone 5/5s/5c - portrait */
	@media only screen 
	and (min-device-width: 320px) 
	and (max-device-width: 568px)
	and (-webkit-min-device-pixel-ratio: 2)
	and (orientation: portrait) {
		.nav-item:nth-child(2) { 
			padding-left: 0 !important;
		}

		#searchBar { 
			display: inherit !important;
			margin-bottom: 10px !important;
			padding-top: 20px !important;
			padding-left: 30px !important;
			padding-right: 30px !important;
		}

		.m-subheader { 
			padding-left: 31px !important;
			padding-right: 31px !important;
		}

		.m-subheader small { 
			font-size: 12px !important;
		}

		.m-subheader__title { 
			font-size: 14px !important;
		}

	}

	/* iphone 6/7 - portrait */
	@media only screen 
	and (min-device-width: 375px) 
	and (max-device-width: 667px) 
	and (-webkit-min-device-pixel-ratio: 2) { 
		.nav-item:nth-child(2) { 
			padding-left: 0 !important;
		}

		#searchBar { 
			display: inherit !important;
			margin-bottom: 10px !important;
			padding-top: 20px !important;
			padding-left: 30px !important;
			padding-right: 30px !important;
		}

		.m-subheader { 
			padding-left: 30px !important;
			padding-right: 30px !important;
		}

		.m-subheader small { 
			font-size: 12px !important;
		}

		.m-subheader__title { 
			font-size: 14px !important;
		}

	}

	/* iphone 6+/7+/8+ - portrait */
	@media only screen 
	and (min-device-width: 414px) 
	and (max-device-width: 736px) 
	and (-webkit-min-device-pixel-ratio: 3)
	and (orientation: portrait) { 
		.nav-item:nth-child(2) { 
			padding-left: 0 !important;
		}

		#searchBar { 
			display: inherit !important;
			margin-bottom: 10px !important;
			padding-top: 20px !important;
			padding-left: 30px !important;
			padding-right: 30px !important;
		}

		.m-subheader { 
			padding-left: 30px !important;
			padding-right: 30px !important;
		}

		.m-subheader small { 
			font-size: 12px !important;
		}

		.m-subheader__title { 
			font-size: 14px !important;
		}

	}

	/* iphone x - portrait */
	@media only screen 
	and (min-device-width: 375px) 
	and (max-device-width: 812px) 
	and (-webkit-min-device-pixel-ratio: 3)
	and (orientation: portrait) { 
		.nav-item:nth-child(2) { 
			padding-left: 0 !important;
		}

		#searchBar { 
			display: inherit !important;
			margin-bottom: 10px !important;
			padding-top: 20px !important;
			padding-left: 30px !important;
			padding-right: 30px !important;
		}

		.m-subheader { 
			padding-left: 30px !important;
			padding-right: 30px !important;
		}

		.m-subheader small { 
			font-size: 12px !important;
		}

		.m-subheader__title { 
			font-size: 14px !important;
		}

	}
</style>