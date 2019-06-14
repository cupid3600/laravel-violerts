<template>
    <div class="col" id="open_data_complaints_col">
        <!-- print markup -->
        <table class="table table-striped d-none d-print-block">
            <thead>
                <tr class="print-table-invisible-head"/>
                <tr>
                    <th
                        class="print-table-head"
                        colspan="8">
                        <span><i class="flaticon-statistics" /></span>
                        <h3>Complaints <small>(Open Data)</small></h3>
                    </th>
                </tr>
                <tr>
                    <th class="align-top">Complaint #</th>
                    <th class="align-top">Status</th>
                    <th class="align-top">Disposition Date</th>
                    <th class="align-top">Inspection Date</th>
                </tr>
            </thead>
            <tbody>
                <tr
                    :key="record.id"
                    v-for="record in panel.data"
                    v-if="record.status !== 'CLOSED'"
                >
                    <td><p class="font-weight-light">{{ record.complaint_number }}</p></td>
                    <td><p class="font-weight-light">{{ record.status }}</p></td>
                    <td><p class="font-weight-light">{{ record.disposition_date }}</p></td>
                    <td><p class="font-weight-light">{{ record.inspection_date }}</p></td>
                </tr>
                <tr class="print-table-footer">
                    <td colspan="4" />
                </tr>
            </tbody>
            <div class="m-portlet__foot" />
        </table>
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
                            Complaints
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
                            <a @click="isOpen()" class="m-portlet__nav-link m-portlet__nav-link--icon" data-toggle="collapse" href="#OpenDataComplaints" role="button" aria-expanded="false" aria-controls="OpenDataComplaints">
                                <i class="la la-angle-down" v-if="panel.open == 0"></i>
                                <i class="la la-angle-up" v-if="panel.open == 1"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="m-portlet__body collapse table-responsive" id="OpenDataComplaints">
                <div class="loading-state text-center" v-if="panel.loading == 1">
                    <i class="fa fa-spinner fa-spin fa-7x" style="font-size: 3em"></i>
                    <p style="margin-top: 10px;" v-if="panel.display_msg == 1" >Please wait...</p>
                </div>
                <!-- desktop markup -->
                <vuetable
                        ref="vuetable"
                        v-if="panel.loading == 0 && !isMobile"
                        :api-url="`/property/open-data/complaints/${property.id}`"
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
                <div id='open_data_complaints_slider' class='swipe' v-else-if="panel.loading == 0 && isMobile && panel.data">
                    <div class='swipe-wrap'>
                        <div class='swipe-card' v-for="item in panel.data">
                            <div class="row">
                                <p class="col">
                                    <strong class="m--font-boldest">
                                        Complaint #
                                    </strong>
                                    {{item.complaint_number}}
                                </p>
                                <p class="col">
                                    <strong class="m--font-boldest">
                                        Status
                                    </strong>
                                    {{item.status}}
                                </p>
                            </div>
                            <div class="row">
                                <p class="col">
                                    <strong class="m--font-boldest">
                                        Community Board
                                    </strong>
                                    {{item.community_board}}
                                </p>
                                <p class="col">
                                    <strong class="m--font-boldest">
                                        Category
                                    </strong>
                                    {{item.complaint_category}}
                                </p>
                            </div>
                            <div class="row">
                                <p class="col">
                                    <strong class="m--font-boldest">
                                        Disposition Date
                                    </strong>
                                    {{item.disposition_date}}
                                </p>
                                <p class="col">
                                    <strong class="m--font-boldest">
                                        Disposition Code
                                    </strong>
                                    {{item.disposition_code}}
                                </p>
                            </div>
                            <div class="row">
                                <p class="col">
                                    <strong class="m--font-boldest">
                                        Unit
                                    </strong>
                                    {{item.unit}}
                                </p>
                                <p class="col">
                                    <strong class="m--font-boldest">
                                        Inspection Date
                                    </strong>
                                    {{item.inspection_date}}
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
                <div v-else-if="panel.loading == 0 && isMobile && !panel.data">No relevant data.</div>
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
                        <vuetable-pagination v-if="!isMobile" ref="pagination" @vuetable-pagination:change-page="onChangePage" :css="css.pagination"></vuetable-pagination>
                    </div>
                </div>
            </div>
            <!--/mobile (swipe) footer markup -->
        </div>
        <!--/web markup-->
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
						name: 'date_entered', 
						sortField: '', 
						title: 'Date Entered'
					},
					{ 
						name: 'complaint_number', 
						sortField: '', 
						title: 'Complaint #'
					},
					{ 
						name: 'community_board', 
						sortField: '', 
						title: 'Community board'
					},
					{ 
						name: 'special_district', 
						sortField: '', 
						title: 'Special District'
					},
					{ 
						name: 'disposition_code', 
						sortField: '', 
						title: 'Disposition Code'
					},
					{ 
						name: 'disposition_date', 
						sortField: '', 
						title: 'Disposition Date'
					},
					{ 
						name: 'inspection_date', 
						sortField: '', 
						title: 'Inspection Date'
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
			        { name: 'date_entered', sortField: 'date_entered', direction: 'asc' },
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
            if (!this.isMobile) this.$events.$on('comp-filter-set', eventData => this.onFilterSet(eventData))
            if (!this.isMobile) this.$events.$on('comp-filter-reset', e => this.onFilterReset())
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
                this.$parent.display.oath_cases = 0
                this.$parent.display.search = 0
                this.$parent.display.subheader_address = 0
				this.$parent.display.too_complaints = 0

                // manipulating CSS to make the panel full-screen
                document.getElementById('OpenDataComplaints').style = 'min-height: calc(100vh - 186.72px);'
                document.getElementById('open_data_complaints_col').style = 'padding: 0px; position: fixed; top: 71.13px; height: 100%'
                document.getElementById('row_parent').style = 'padding: 0px 15px;'
            },
            pleaseWaitMessage() {
                setTimeout(() => {
                	var app = this;
                    if (app.panel.loading == true){
                        app.panel.display_msg = true
                    } else {
                        app.panel.display_msg = false
                    }
                }, 30000);
            },
            closeMobilePanel () {
                this.panel.show_page_count = 0
                if (this.panel.swipe) this.panel.swipe.stop()
                this.panel.current_slide = 1

                this.$parent.display.acris_rpl = 1
                this.$parent.display.acris_ppl = 1
                this.$parent.display.too_complaints = 1
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
                this.$parent.display.oath_cases = 1
                this.$parent.display.search = 1
                this.$parent.display.subheader_address = 1

                // scrolling back to last position
                setTimeout(() => {window.scroll({ top: this.panel.scrollTop, left: 0, behavior: 'smooth'})}, 400)

                document.getElementById('OpenDataComplaints').style = 'min-height: \'\';'
                document.getElementById('open_data_complaints_col').style = 'padding: 15px; position: \'\'; top: \'\'; height: \'\';'
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
			updateVueTable () {
                this.getMobileDataOnPageLoad()
				this.panel.open = 0
                if (!this.isMobile) this.$refs.vuetable.refresh()
				$('#OpenDataComplaints').collapse("hide")
			},
            applySwipe () {
                const swipeContainer = document.getElementById('open_data_complaints_slider')
                window.openDataSwipe = new Swipe(swipeContainer, {
                    speed: 400,
                    disableScroll: true,
                    callback: (index, el) => {
                        this.panel.current_slide = index + 1
                    }
                })
                this.panel.swipe = window.openDataSwipe
                this.panel.show_page_count = this.isMobile && this.panel.open && this.panel.swipe
            },
            getMobileDataOnPageLoad () {
                axios.get(`/api/property/open-data/complaints/swipe/${this.property.id}`)
                    .then((response) => {
                        this.panel.data = response.data
                    }).catch((error) => console.error(error))
            },
            getMobileData () {
                const app = this
                axios.get(`/api/property/open-data/complaints/swipe/${app.property.id}`)
                    .then((response) => {
                        app.panel.data = response.data
                        Vue.nextTick(() => { app.applySwipe() })
                    }).catch((error) => console.error(error))
                this.pleaseWaitMessage()
            },
			getData () {
				var app = this
				app.getMobileData()
				// please wait message function.
				app.pleaseWaitMessage()
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

	#open_data_complaints_col {
		transition: all .1s ease-out;
	}

	.swipe {
		overflow: hidden;
		visibility: hidden;
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

	#OpenDataComplaints {
		padding: 0 !important;
	}

	.vuetable { 
		margin-bottom: 0 !important;
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