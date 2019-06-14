<template>
    <div class="col" id="open_data_dob_violations_col">
    	<!-- print markup -->
        <PrintDisplay :panel="panel" /> 
        <!--/print markup -->
        <!-- web markup -->
        <div class="m-portlet d-print-none">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <span class="m-portlet__head-icon">
                            <i class="flaticon-statistics"></i>
                        </span>
                        <h3 class="m-portlet__head-text">
                            DOB Violations
                            <small>
                                (Open Data)
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
                            <a @click="isOpen()" class="m-portlet__nav-link m-portlet__nav-link--icon" data-toggle="collapse" href="#OpenDataDOBViolations" role="button" aria-expanded="false" aria-controls="OpenDataDOBViolations">
                                <i class="la la-angle-down" v-if="panel.open == 0"></i>
                                <i class="la la-angle-up" v-if="panel.open == 1"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="m-portlet__body collapse table-responsive" id="OpenDataDOBViolations">
                <div class="loading-state text-center" v-if="panel.loading == 1">
                    <i class="fa fa-spinner fa-spin fa-7x" style="font-size: 3em"></i>
                    <p style="margin-top: 10px;" v-if="panel.display_msg == 1" >Please wait...</p>
                </div>
                <!-- desktop markup -->
				<vuetable
						ref="vuetable"
						v-if="panel.loading == 0 && !isMobile"
						:api-url="`/property/open-data/dob-violations/${property.id}`"
						:fields="fields"
						:css="css.table"
						:sortOrder="sortOrder"
						:append-params="moreParams"
						pagination-path=""
						@vuetable:pagination-data="onPaginationData"
				>
				</vuetable>
				<!--/desktop markup -->
				<!-- mobile (swipe) markup -->
				<div id='open_data_dob_violations_slider' class='swipe' v-else-if="panel.loading == 0 && isMobile">
					<div class='swipe-wrap'>
						<div class='swipe-card' v-for="item in panel.data">
							<div class="row">
								<p class="col">
									<strong class="m--font-boldest">
										Violation #
									</strong>
									{{ item.violation_number }}
								</p>
								<p class="col">
									<strong class="m--font-boldest">
										Issue Date
									</strong>
									{{ item.issue_date }}
								</p>
							</div>
							<div class="row">
								<p class="col">
									<strong class="m--font-boldest">
										Type
									</strong>
									{{ item.violation_type }}
								</p>
								<p class="col">
									<strong class="m--font-boldest">
										Disposition Date
									</strong>
									{{ item.disposition_date }}
								</p>
							</div>
							<div class="row">
								<p class="col">
									<strong class="m--font-boldest">
										Disposition Comments
									</strong>
									{{ item.disposition_comments }}
								</p>
							</div>
							<div class="row">
								<p class="col">
									<strong class="m--font-boldest">
										Status
									</strong>
									{{ item.violation_category }}
								</p>
							</div>
							<div class="row">
								<p class="col">
									<strong class="m--font-boldest">
										Description
									</strong>
									{{ item.description }}
								</p>
							</div>
							<div class="row">
								<p class="col">
									<strong class="m--font-boldest">
										Device #
									</strong>
									{{ item.device_number }}
								</p>
							</div>
							<div class="row">
								<div class="col">
									<button class="btn btn-info btn-block">
										View More
									</button>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!--/mobile (swipe) markup -->
			</div>
			<!-- mobile (swipe) footer markup -->
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
			<!--/mobile (swipe) footer markup -->
		</div>
		<!--/web markup --> 
	</div>
</template>
<script>
	import Vue from 'vue'
	import Vuetable from 'vuetable-2/src/components/Vuetable.vue'
	import VuetablePagination from 'vuetable-2/src/components/VuetablePagination'
	import VuetablePaginationInfo from 'vuetable-2/src/components/VuetablePaginationInfo'
    import Swipe from 'swipe-js'

	import FilterBar from './Filter.vue'

	import DOBVioDate from './Columns/ODDOBVioDate.vue'
	import ViewMore from './Columns/ViewMore.vue'
	import Status from './Columns/Status'
	import DispositionDate from './Columns/DispositionDate'

	import PrintDisplay from './Displays/Print.vue'

	Vue.component('od-dob-vio-date', DOBVioDate)
	Vue.component('open_data_dob_view_more', ViewMore)
	Vue.component('open_data_dob_status', Status)
	Vue.component('open_data_dob_disposition_date', DispositionDate)

	export default { 
		props: [ 
			'property'
		], 
		components: { 
			Vuetable,
			VuetablePagination,
			VuetablePaginationInfo, 
			FilterBar, 
			PrintDisplay
		},
		data () { 
			return { 
				fields: [ 
					{ 
						name: '__component:open_data_dob_view_more', 
						sortField: '', 
						title: 'View'
					},
					{ 
						name: '__component:od-dob-vio-date', 
						sortField: '', 
						title: 'Date'
					},
					{ 
						name: 'number', 
						sortField: '', 
						title: 'Violation #'
					},
					{ 
						name: 'ecb_number', 
						sortField: '', 
						headerClass: 'ECBNumberHeader', 
						dataClass: 'ECBNumberData',
						title: 'ECB #'
					},
					{ 
						name: 'description', 
						sortField: '', 
						title: 'Description'
					},
					{ 
						name: 'disposition_comments', 
						sortField: '', 
						headerClass: 'dispositionCommentsHeader', 
						dataClass: 'dispositionCommentsData',
						title: 'Disposition Comments'
					},
					{ 
						name: '__component:open_data_dob_disposition_date', 
						sortField: '', 
						headerClass: 'dispositionDateHeader', 
						dataClass: 'dispositionDateData',
						title: 'Disposition Date'
					},
					{ 
						name: '__component:open_data_dob_status', 
						sortField: '', 
						title: 'Status'
					},
				],
				css: {
			        table: {
			        	tableClass: 'table table-striped table-hover custom-panel open-data-dob-violations',
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
			        { name: 'issue_date', sortField: 'issue_date', direction: 'asc' },
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
		created () {
		    this.$nextTick(() => {this.getMobile()})
		},
		mounted() {
		    if (!this.isMobile) this.$events.$on('dob-vio-filter-set', eventData => this.onFilterSet(eventData))
		    if (!this.isMobile) this.$events.$on('dob-vio-filter-reset', e => this.onFilterReset())
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
                this.$parent.display.too_complaints = 0
                this.$parent.display.dob_violations_bis = 0
                this.$parent.display.ecb_violations = 0
                this.$parent.display.ecb_violations_bis = 0
                this.$parent.display.elevator_inspections = 0
                this.$parent.display.elevator_records = 0
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
                document.getElementById('OpenDataDOBViolations').style = 'min-height: calc(100vh - 186.72px);'
                document.getElementById('open_data_dob_violations_col').style = 'padding: 0px; position: fixed; top: 71.13px; height: 100%'
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
                this.$parent.display.too_complaints = 1
                this.$parent.display.dob_violations_bis = 1
                this.$parent.display.ecb_violations = 1
                this.$parent.display.ecb_violations_bis = 1
                this.$parent.display.elevator_inspections = 1
                this.$parent.display.elevator_records = 1
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

                document.getElementById('OpenDataDOBViolations').style = 'min-height: \'\';'
                document.getElementById('open_data_dob_violations_col').style = 'padding: 15px; position: \'\'; top: \'\'; height: \'\';'
                document.getElementById('row_parent').style = 'padding: 0px 30px;'
            },
			isOpen () {
                if (this.panel.open == 1) {
                    this.panel.open = 0
                    if (this.isMobile) this.closeMobilePanel()
                } else {
                    this.panel.open = 1
                    if (this.panel.loading == false) {
                    	this.getData()
                        if (this.isMobile) {
                            this.openMobilePanel()
                        }
                    }
                }
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
                const swipeContainer = document.getElementById('open_data_dob_violations_slider')
                window.mySwipe = new Swipe(swipeContainer, {
                    speed: 400,
                    disableScroll: true,
                    callback: (index, el) => {
                        this.panel.current_slide = index + 1
                    }
                })
                this.panel.swipe = window.mySwipe
                this.panel.show_page_count = this.isMobile && this.panel.open && this.panel.swipe
            },
			isLoading () {
				if (this.panel.loading == 1) {
					this.panel.loading = 0
				} else {
					this.panel.loading = 1
				}
			},
			getData () {
				var app = this
				app.getMobileData()
				// please wait message function.
				setTimeout(() => {
					if(app.panel.loading == true){
						app.panel.display_msg = true
					} else {
						app.panel.display_msg = false
					}
				}, 30000);
			},
            getMobileDataOnPageLoad () {
                axios.get(`/api/property/open-data/dob-violations/swipe/${this.property.id}`)
                    .then((response) => {
                        this.panel.data = response.data
                    }).catch((error) => console.error(error))
            },
            getMobileData () {
                const app = this
                axios.get(`/api/property/open-data/dob-violations/swipe/${app.property.id}`)
                    .then((response) => {
                        app.panel.data = response.data
                        Vue.nextTick(() => { app.applySwipe() })
                    }).catch((error) => console.error(error))
                app.pleaseWaitMessage()
            },
			updateVueTable () {
                this.getMobileDataOnPageLoad()
                this.panel.open = 0
                if (!this.isMobile) this.$refs.vuetable.refresh()
				$('#OpenDataDOBViolations').collapse("hide")
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
<style>
	.open-data-dob-violations .dispositionCommentsHeader, .open-data-dob-violations .dispositionCommentsData { 
		width: 200px !important;
	}

	.open-data-dob-violations .dispositionDateHeader, .open-data-dob-violations .dispositionDateData { 
		width: 150px !important;
	}

	.open-data-dob-violation .ECBNumberHeader, .open-data-dob-violation .ECBNumberData { 
		min-width: 95px !important;
	}

	p {
		margin: 0;
	}

	#open_data_dob_violations_col {
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

	.swipe-card strong, .swipe-card p {
		display: block;
	}

	.swipe-card p {
		margin-bottom: 5px !important;
	}

	.swipe-card .btn {
		margin-top: 5px !important;
	}

	#OpenDataDOBViolations {
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