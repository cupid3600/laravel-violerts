<template>
	<div class="col" id="bis_elevator_records_col">
		<div class="m-portlet">
			<div class="m-portlet__head">
				<div class="m-portlet__head-caption">
					<div class="m-portlet__head-title">
						<span class="m-portlet__head-icon">
							<i class="flaticon-statistics"></i>
						</span>
						<h3 class="m-portlet__head-text">
							Elevator Records 
							<small>
								(BIS)
							</small>
						</h3>
					</div>
				</div>
				<div class="m-portlet__head-tools">
					<ul class="m-portlet__nav">
						<li class="m-portlet__nav-item">
							<FilterBar />
						</li>
						<li class="m-portlet__nav-item">
							<a @click="isOpen()" class="m-portlet__nav-link m-portlet__nav-link--icon" data-toggle="collapse" href="#BISElevatorRecords" role="button" aria-expanded="false" aria-controls="BISElevatorRecords">
							    <i class="la la-angle-down" v-if="panel.open == 0"></i>
							    <i class="la la-angle-up" v-if="panel.open == 1"></i>
							</a>
						</li>
					</ul>
				</div>
			</div>
			<div class="m-portlet__body collapse table-responsive" id="BISElevatorRecords">
				<div class="loading-state text-center" v-if="panel.loading == 1">
					<i class="fa fa-spinner fa-spin fa-7x" style="font-size: 3em"></i>
					<p style="margin-top: 10px;" v-if="panel.display_msg == 1" >Please wait...</p>
				</div>
				<vuetable
					ref="vuetable"
					v-if="panel.loading == 0 && !isMobile"
					:api-url="`/property/bis/elevators/${property.id}`"
					:fields="fields"
			        :css="css.table"
			        :sortOrder="sortOrder"
			        :append-params="moreParams"
			        pagination-path=""
			        @vuetable:pagination-data="onPaginationData"
				>
				</vuetable>
				<div id='bis_elevator_records_slider' class='swipe' v-else-if="panel.loading == 0 && isMobile">
					<div class='swipe-wrap'>
						<div class='swipe-card' v-for="item in panel.data">
							{{ item }}
						</div>
					</div>
				</div>
			</div>
			<div class="m-portlet__foot" v-if="panel.loading == 0">
				<div class="row align-items-center">
					<div class="col-lg-6 m--valign-middle">
						<div v-if="panel.show_page_count"><p>Slide {{ panel.current_slide }} of {{ panel.data.length }}</p></div>
						<div v-if="isMobile && panel.data && !panel.open">{{ panel.data.length }} items</div>
						<vuetable-pagination-info ref="paginationInfo" class="pull-left" v-if="!isMobile"></vuetable-pagination-info>
					</div>
					<div class="col-lg-6 m--align-right">
						<vuetable-pagination ref="pagination" @vuetable-pagination:change-page="onChangePage" :css="css.pagination" v-if="!isMobile"></vuetable-pagination>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>
<script>
	import Vue from 'vue'
	import Vuetable from 'vuetable-2/src/components/Vuetable.vue'
	import VuetablePagination from 'vuetable-2/src/components/VuetablePagination'
	import VuetablePaginationInfo from 'vuetable-2/src/components/VuetablePaginationInfo'
    import Swipe from 'swipe-js'

	import FilterBar from './Filter.vue'
	
	export default { 
		props: [ 
			'property'
		], 
		components: { 
			Vuetable,
			VuetablePagination,
			VuetablePaginationInfo, 
			FilterBar
		},
		data () { 
			return { 
				fields: [ 
					{ 
						name: 'elevator_record_number', 
						sortField: '', 
						title: 'Record #'
					},
					{ 
						name: 'device_number', 
						sortField: '', 
						title: 'Device #'
					},
					{ 
						name: 'device_type', 
						sortField: '', 
						title: 'Device Type'
					},
					{ 
						name: 'record', 
						sortField: '', 
						title: 'Record'
					},
					{ 
						name: 'device_status', 
						sortField: '', 
						title: 'Device Status'
					},
					{ 
						name: 'status_date', 
						sortField: '', 
						title: 'Status Date'
					},
					{ 
						name: 'stat_comm', 
						sortField: '', 
						title: 'Stat Comm.'
					},
					{ 
						name: 'approval_date', 
						sortField: '', 
						title: 'Approval Date'
					},
					{ 
						name: 'alteration', 
						sortField: '', 
						title: 'Alteration'
					},
					{ 
						name: 'floor_from', 
						sortField: '', 
						title: 'From Floor'
					},
					{ 
						name: 'floor_to', 
						sortField: '', 
						title: 'To Floor'
					},
					{ 
						name: 'travel_distance', 
						sortField: '', 
						title: 'Travel Distance'
					},
					{ 
						name: 'speed_fpm', 
						sortField: '', 
						title: 'Speed FPM'
					},
					{ 
						name: 'car_entrances', 
						sortField: '', 
						title: 'Car Entrances'
					},
					{ 
						name: 'capacity_lbs', 
						sortField: '', 
						title: 'Capacity (lbs)'
					},
					{ 
						name: 'hoist_ropes_quantity', 
						sortField: '', 
						title: 'Hoist Ropes Quantity'
					},
					{ 
						name: 'hoist_ropes_size', 
						sortField: '', 
						title: 'Hoist Ropes Size'
					},
					{ 
						name: 'hoist_ropes_kind', 
						sortField: '', 
						title: 'Hoist Ropes Kind'
					},
					{ 
						name: 'governor_ropes_quantity', 
						sortField: '', 
						title: 'Governor Ropes Quantity'
					},
					{ 
						name: 'governor_ropes_size', 
						sortField: '', 
						title: 'Governor Ropes Size'
					},
					{ 
						name: 'governor_ropes_kind', 
						sortField: '', 
						title: 'Governor Ropes Kind'
					},
					{ 
						name: 'governor_type', 
						sortField: '', 
						title: 'Governor Type'
					},
					{ 
						name: 'safety_type', 
						sortField: '', 
						title: 'Safety Type'
					},
					{ 
						name: 'machine_type', 
						sortField: '', 
						title: 'Machine Type'
					},
					{ 
						name: 'mode_operation', 
						sortField: '', 
						title: 'Mode Operation'
					},
					{ 
						name: 'car_buffer_type', 
						sortField: '', 
						title: 'Car Buffer Type'
					},
					{ 
						name: 'firemans_service', 
						sortField: '', 
						title: 'Firemans Service'
					},
					{ 
						name: 'working_pressure', 
						sortField: '', 
						title: 'Working Pressure'
					},
					{ 
						name: 'manufacturer', 
						sortField: '', 
						title: 'Manufacturer'
					},
					{ 
						name: 'status', 
						sortField: '', 
						title: 'Status'
					},
				],
				css: {
			        table: {
			        	tableClass: 'table table-striped table-hover custom-panel',
			        	ascendingIcon: 'fa fa-angle-up',
			        	descendingIcon: 'fa fa-angle-down'
			        },
			        pagination: {
			        	wrapperClass: "pagination pull-right flex-wrap",
					    activeClass: "active",
					    disabledClass: "disabled",
					    pageClass: "page-link",
					    linkClass: "page-link",
			        	icons: {
				            first: '',
				            prev: '',
				            next: '',
				            last: ''
			          	}
			        }
			    },
			    sortOrder: [
			        { name: 'device_number', sortField: 'device_number', direction: 'asc' },
			    ],
			    moreParams: {},

				panel: { 
					open: 0,
					loading: 0,
                    display_msg: false,
                    data: null,
                    scrollTop: 0,
                    swipe: null,
                    current_slide: 1,
                    show_page_count: false
                },
                isMobile: null
            }
        },
        created() {
            this.$nextTick(() => {this.getMobile()})
        },
		mounted() {
		    if (!this.isMobile) this.$events.$on('bis-elevator-records-filter-set', eventData => this.onFilterSet(eventData))
		    if (!this.isMobile) this.$events.$on('bis-elevator-records-filter-reset', e => this.onFilterReset())
		},
		watch: { 
			'property': 'updateVueTable'
		},
		methods: {
            getMobile () {
                this.isMobile = this.$parent.isMobile
            },
            openMobilePanel () {
                // getting position of scrollbar (y-axis) before the panel "opens"
                this.panel.scrollTop = (window.pageYOffset !== undefined) ? window.pageYOffset :
                    (document.documentElement || document.body.parentNode || document.body).scrollTop;

                this.$parent.display.acris_rpl = 0
                this.$parent.display.acris_ppl = 0
                this.$parent.display.complaints = 0
                this.$parent.display.complaints_bis = 0
                this.$parent.display.dob_violations = 0
                this.$parent.display.dob_violations_bis = 0
                this.$parent.display.ecb_violations = 0
                this.$parent.display.ecb_violations_bis = 0
                this.$parent.display.elevator_inspections = 0
                this.$parent.display.too_complaints = 0
                this.$parent.display.elevator_violations = 0
                this.$parent.display.general = 0
                this.$parent.display.zoning = 0
                this.$parent.display.map = 0
                this.$parent.display.illuminated_signs = 0
                this.$parent.display.job_applications = 0
                this.$parent.display.job_applications_bis = 0
                this.$parent.display.oath_cases = 0
                this.$parent.display.search = 0
                this.$parent.display.subheader_address = 0

                // manipulating CSS to make the panel full-screen
                document.getElementById('BISElevatorRecords').style = 'min-height: calc(100vh - 186.72px);'
                document.getElementById('bis_elevator_records_col').style = 'padding: 0px; position: fixed; top: 71.13px; height: 100%'
                document.getElementById('row_parent').style = 'padding: 0px 15px;'
            },
            closeMobilePanel () {
                this.panel.show_page_count = 0
                if (this.panel.swipe) this.panel.swipe.stop()
                this.panel.current_slide = 1

                this.$parent.display.acris_rpl = 1
                this.$parent.display.acris_ppl = 1
                this.$parent.display.complaints = 1
                this.$parent.display.complaints_bis = 1
                this.$parent.display.dob_violations = 1
                this.$parent.display.dob_violations_bis = 1
                this.$parent.display.ecb_violations = 1
                this.$parent.display.ecb_violations_bis = 1
                this.$parent.display.elevator_inspections = 1
                this.$parent.display.too_complaints = 1
                this.$parent.display.elevator_violations = 1
                this.$parent.display.general = 1
                this.$parent.display.zoning = 1
                this.$parent.display.map = 1
                this.$parent.display.illuminated_signs = 1
                this.$parent.display.job_applications = 1
                this.$parent.display.job_applications_bis = 1
                this.$parent.display.oath_cases = 1
                this.$parent.display.search = 1
                this.$parent.display.subheader_address = 1

                // scrolling back to last position
                setTimeout(() => {window.scroll({ top: this.panel.scrollTop, left: 0, behavior: 'smooth'})}, 400)

                document.getElementById('BISElevatorRecords').style = 'min-height: \'\';'
                document.getElementById('bis_elevator_records_col').style = 'padding: 15px; position: \'\'; top: \'\'; height: \'\';'
                document.getElementById('row_parent').style = 'padding: 0px 30px;'
            },
            getMobileDataOnPageLoad () {
                axios.get(`/api/property/bis/elevator/records/swipe/${this.property.id}`)
                    .then((response) => {
                        this.panel.data = response.data
                    }).catch((error) => console.error(error))
            },
            pleaseWaitMessage () {
            	var app = this;
                setTimeout(() => {
                    if (app.panel.loading == true){
                        app.panel.display_msg = true
                    } else {
                        app.panel.display_msg = false
                    }
                }, 30000);
            },
            applySwipe () {
                const swipeContainer = document.getElementById('bis_elevator_records_slider')
                window.TOOSwipe = new Swipe(swipeContainer, {
                    speed: 400,
                    disableScroll: true,
                    callback: (index, el) => {
                        this.panel.current_slide = index + 1
                    }
                })
                this.panel.swipe = window.TOOSwipe
                this.panel.show_page_count = this.isMobile && this.panel.open && this.panel.swipe
            },
            getMobileData () {
                const app = this
                app.isLoading()
                axios.get(`/api/property/bis/elevator/records/swipe/${app.property.id}`)
                    .then((response) => {
                        this.panel.data = response.data
                        app.isLoading()
                        Vue.nextTick(() => { app.applySwipe() })
                    }).catch((error) => console.error(error))
                this.pleaseWaitMessage()
            },
			isOpen () {
                if (this.panel.open == 1) {
                    this.panel.open = 0
                    if (this.isMobile) this.closeMobilePanel()
                } else {
                    this.panel.open = 1
                    if (this.panel.loading == false) {
                        if (this.isMobile) {
                            this.getMobileData()
                            this.openMobilePanel()
                        }
                        else this.getData()
                    }
                }
			},
			isLoading () { 
				if (this.panel.loading == 1) { 
					this.panel.loading = 0
				} else { 
					this.panel.loading = 1
					if (this.panel.loading == false) { 
						this.getData()
					}
				}
			}, 
			getData () { 
				var app = this
				app.isLoading()
				axios.get(`/api/property/bis/elevators/index/${app.property.id}`)
					 .then((response) => { 
					 	app.getInspectionData()
					 })	 
			},
			updateVueTable () {
                if (this.isMobile) this.getMobileDataOnPageLoad()
                this.panel.open = 0
                if (!this.isMobile) this.$refs.vuetable.refresh()
				$('#BISElevatorRecords').collapse("hide")
			},
			getInspectionData () { 
				var app = this
				axios.get(`/api/property/bis/elevators/inspections/${app.property.id}`)
					 .then((response) => { 
					 	app.getViolationData()
					 })	
			},
			getViolationData () { 
				var app = this
				axios.get(`/api/property/bis/elevators/violations/${app.property.id}`)
					 .then((response) => { 
					 	app.isLoading()
					 })	
				// please wait message function.
				setTimeout(() => {
					if(app.panel.loading == true){ 
						app.panel.display_msg = true
					} else { 
						app.panel.display_msg = false
					}
				}, 30000);
			},
			onPaginationData (paginationData) {
		    	this.$refs.pagination.setPaginationData(paginationData)
		    	this.$refs.paginationInfo.setPaginationData(paginationData) 
		    },
		    onChangePage (page) {
		    	this.$refs.vuetable.changePage(page)
		    },
		    onFilterSet (filterText) {
		        this.moreParams = {
		            'filter': filterText
		        }
		        Vue.nextTick( () => this.$refs.vuetable.refresh())
		    },
		    onFilterReset () {
		        this.moreParams = {}
		        Vue.nextTick( () => this.$refs.vuetable.refresh())
		    }
		}
	}

</script>
<style scoped>
	p {
		margin: 0;
	}

	#bis_elevator_records_col {
		transition: all .1s ease-out;
	}

	.swipe {
		overflow: hidden;
		/*visibility: hidden;*/
		position: relative;
	}

	.swipe-wrap {
		position: relative;
	}

	.swipe-wrap > div {
		float:left;
		width:100%;
		position: relative;
	}

	.swipe-card {
		overflow-y: scroll;
		width: 100%;
		padding: 5px 10px;
		height: calc(100vh - 186.72px);
		background-color: white !important;
	}

	#BISElevatorRecords {
		padding: 0 !important;
	}

	.loading-state { 
		padding-top: 25px !important;
		padding-bottom: 25px !important;
	}

	.vuetable { 
		margin-bottom: 0 !important;
	}

	/* iphone 4/4s - portrait */
	@media only screen 
  	and (min-device-width: 320px) 
  	and (max-device-width: 480px)
  	and (-webkit-min-device-pixel-ratio: 2)
  	and (orientation: portrait) {
  		.item-count-btn { 
  			display: none !important;
  		}
	}

	/* iphone 5/5s/5c - portrait */
	@media only screen 
	and (min-device-width: 320px) 
	and (max-device-width: 568px)
	and (-webkit-min-device-pixel-ratio: 2)
	and (orientation: portrait) {
		.item-count-btn { 
			display: none !important;
		}
	}

	/* iphone 6/7 - portrait */
	@media only screen 
	and (min-device-width: 375px) 
	and (max-device-width: 667px) 
	and (-webkit-min-device-pixel-ratio: 2) { 
		.item-count-btn { 
			display: none !important;
		}
	}

	/* iphone 6+/7+/8+ - portrait */
	@media only screen 
	and (min-device-width: 414px) 
	and (max-device-width: 736px) 
	and (-webkit-min-device-pixel-ratio: 3)
	and (orientation: portrait) { 
		.item-count-btn { 
			display: none !important;
		}

	}

	/* iphone x - portrait */
	@media only screen 
	and (min-device-width: 375px) 
	and (max-device-width: 812px) 
	and (-webkit-min-device-pixel-ratio: 3)
	and (orientation: portrait) { 

		.item-count-btn { 
			display: none !important;
		}
	}	
</style>