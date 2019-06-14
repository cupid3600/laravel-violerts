<template>
    <div class="col" id="open_data_hearing_col">
        <table class="table table-striped d-none d-print-block">
            <thead>
                <tr class="print-table-invisible-head"/>
                <tr>
                    <th
                        class="print-table-head"
                        colspan="7">
                        <span><i class="flaticon-statistics" /></span>
                        <h3>OATH Hearing Cases <small>(Open Data)</small></h3>
                    </th>
                </tr>
                <tr>
                    <th class="align-top">Ticket #</th>
                    <th class="align-top">Issue Date/Time</th>
                    <th class="align-top">Respondent</th>
                    <th class="align-top">Hearing Date/Time</th>
                    <th class="align-top">Description</th>
                    <th class="align-top">Hearing Status</th>
                    <th class="align-top">Hearing Result</th>
                </tr>
            </thead>
            <tbody>
                <tr
                    v-for="record in panel.data"
                    :key="record.id"
                    v-if="record.hearing_result !== 'DISMISSED'">
                    <td><p class="font-weight-light">{{ record.ticket_number }}</p></td>
                    <td><p class="font-weight-light">{{ record.violation_date }}/{{ record.violation_time }}</p></td>
                    <td><p class="font-weight-light">{{ record.respondent_first_name }} {{ record.respondent_last_name }}</p></td>
                    <td><p class="font-weight-light">{{ record.hearing_date }}/{{ record.hearing_time }}</p></td>
                    <td><p class="font-weight-light">{{ record.violation_description }}</p></td>
                    <td><p class="font-weight-light">{{ record.hearing_status }}</p></td>
                    <td><p class="font-weight-light">{{ record.hearing_result }}</p></td>
                </tr>
                <tr class="print-table-footer">
                    <td colspan="7" />
                </tr>
            </tbody>
        </table>
        <div class="m-portlet d-print-none">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <span class="m-portlet__head-icon">
                            <i class="flaticon-statistics"></i>
                        </span>
                        <h3 class="m-portlet__head-text">
                            OATH Hearing Cases
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
                            <a @click="isOpen()" class="m-portlet__nav-link m-portlet__nav-link--icon" data-toggle="collapse" href="#OpenDataOATHCases" role="button" aria-expanded="false" aria-controls="OpenDataOATHCases">
                                <i class="la la-angle-down" v-if="panel.open == 0"></i>
                                <i class="la la-angle-up" v-if="panel.open == 1"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="m-portlet__body collapse table-responsive" id="OpenDataOATHCases">
                <div class="loading-state text-center" v-if="panel.loading == 1">
                    <i class="fa fa-spinner fa-spin fa-7x" style="font-size: 3em"></i>
                    <p style="margin-top: 10px;" v-if="panel.display_msg == 1" >Please wait...</p>
                </div>
                <vuetable
                        ref="vuetable"
                        v-if="panel.loading == 0 && !isMobile"
                        :api-url="`/property/open-data/oath-cases/${property.id}`"
                        :fields="fields"
                        :css="css.table"
                        :sortOrder="sortOrder"
                        :append-params="moreParams"
                        pagination-path=""
                        @vuetable:pagination-data="onPaginationData"
                >
                </vuetable>
                <div id='open_data_hearing_slider' class='swipe' v-else-if="panel.loading == 0 && isMobile">
                    <div class='swipe-wrap'>
                        <div class='swipe-card' v-for="item in panel.data">
                            <div class="row">
                                <p class="col">
                                    <strong class="m--font-boldest">
                                        Ticket #
                                    </strong>
                                    {{ item.ticket_number }}
                                </p>
                                <p class="col">
                                    <strong class="m--font-boldest">
                                        Issue Date
                                    </strong>
                                    {{ item.violation_date }}
                                </p>
                            </div>
                            <div class="row">
                                <p class="col">
                                    <strong class="m--font-boldest">
                                        Respondent
                                    </strong>
                                    {{ item.respondent_first_name + ' ' + item.respondent_last_name }}
                                </p>
                            </div>
                            <div class="row">
                                <p class="col">
                                    <strong class="m--font-boldest">
                                        Hearing Date & Time
                                    </strong>
                                    {{ item.hearing_date + ' / '+ item.hearing_time }}
                                </p>
                            </div>
                            <div class="row">
                                <p class="col">
                                    <strong class="m--font-boldest">
                                        Hearing Status
                                    </strong>
                                    {{ item.hearing_status }}
                                </p>
                                <p class="col">
                                    <strong class="m--font-boldest">
                                        Hearing Result
                                    </strong>
                                    {{ item.hearing_result }}
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

	import FilterBar from './Filter.vue'
	import OATHRespondent from './Columns/OATHRespondent.vue'
	import OATHDate from './Columns/OATHDate.vue'
    import Swipe from 'swipe-js'

	Vue.component('oath-respondent', OATHRespondent)
	Vue.component('oath-date', OATHDate)

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
						name: '__component:oath-date', 
						sortField: '', 
						title: 'Date'
					},
					{ 
						name: 'ticket_number', 
						sortField: '', 
						title: 'Ticket #'
					},
					{ 
						name: 'issuing_agency', 
						sortField: '', 
						title: 'Agency'
					},
					{ 
						name: '__component:oath-respondent', 
						sortField: '', 
						title: 'Respondent'
					},
					{ 
						name: 'balance_due', 
						sortField: '', 
						title: 'Balance'
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
			        { name: 'violation_date', sortField: 'violation_date', direction: 'asc' },
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
		    if (!this.isMobile) this.$events.$on('oath-cases-filter-set', eventData => this.onFilterSet(eventData))
		    if (!this.isMobile) this.$events.$on('oath-cases-filter-reset', e => this.onFilterReset())
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
                this.$parent.display.elevator_records = 0
                this.$parent.display.elevator_violations = 0
                this.$parent.display.general = 0
                this.$parent.display.zoning = 0
                this.$parent.display.map = 0
                this.$parent.display.illuminated_signs = 0
                this.$parent.display.job_applications = 0
                this.$parent.display.job_applications_bis = 0
                this.$parent.display.too_complaints = 0
                this.$parent.display.search = 0
                this.$parent.display.subheader_address = 0

                // manipulating CSS to make the panel full-screen
                document.getElementById('OpenDataOATHCases').style = 'min-height: calc(100vh - 186.72px);'
                document.getElementById('open_data_hearing_col').style = 'padding: 0px; position: fixed; top: 71.13px; height: 100%'
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
                this.$parent.display.elevator_records = 1
                this.$parent.display.elevator_violations = 1
                this.$parent.display.general = 1
                this.$parent.display.zoning = 1
                this.$parent.display.map = 1
                this.$parent.display.illuminated_signs = 1
                this.$parent.display.job_applications = 1
                this.$parent.display.job_applications_bis = 1
                this.$parent.display.too_complaints = 1
                this.$parent.display.search = 1
                this.$parent.display.subheader_address = 1

                // scrolling back to last position
                setTimeout(() => {window.scroll({ top: this.panel.scrollTop, left: 0, behavior: 'smooth'})}, 400)

                document.getElementById('OpenDataOATHCases').style = 'min-height: \'\';'
                document.getElementById('open_data_hearing_col').style = 'padding: 15px; position: \'\'; top: \'\'; height: \'\';'
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
			isLoading () {
				if (this.panel.loading == 1) {
					this.panel.loading = 0
				} else {
					this.panel.loading = 1
				}
			},
            applySwipe () {
                const swipeContainer = document.getElementById('open_data_hearing_slider')
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
                axios.get(`/api/property/open-data/oath-cases/swipe/${app.property.id}`)
                    .then((response) => {
                        app.panel.data = response.data
                        Vue.nextTick(() => { app.applySwipe() })
                    }).catch((error) => console.error(error))
                app.pleaseWaitMessage()
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
                axios.get(`/api/property/open-data/oath-cases/swipe/${this.property.id}`)
                    .then((response) => {
                        this.panel.data = response.data
                    }).catch((error) => console.error(error))
            },
			updateVueTable () {
                this.getMobileDataOnPageLoad()
                this.panel.open = 0
                if (!this.isMobile) this.$refs.vuetable.refresh()
				$('#OpenDataOATHCases').collapse("hide")
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

	#open_data_hearing_col {
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

	#OpenDataOATHCases {
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