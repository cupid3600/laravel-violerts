<template>
	<div class="col">
		<div class="m-portlet">
			<div class="m-portlet__head">
				<div class="m-portlet__head-caption">
					<div class="m-portlet__head-title">
						<span class="m-portlet__head-icon">
							<i class="flaticon-statistics"></i>
						</span>
						<h3 class="m-portlet__head-text">
							Permits 
							<small>
								(BIS)
							</small>
							<!--<small>
								<strong v-if="property.complaints_open != ''">
									{{property.complaints_open}} 
								</strong>
								<strong v-if="property.complaints_open == null">
									0 
								</strong>
								Open / 
							</small>
							<small>
								<strong v-if="property.complaints_total != ''">
									{{property.complaints_total}} 
								</strong>
								<strong v-if="property.complaints_total == null">
									0 
								</strong>
								Total
							</small>-->
						</h3>
					</div>
				</div>
				<div class="m-portlet__head-tools">
					<ul class="m-portlet__nav">
						<li class="m-portlet__nav-item">
							<FilterBar />
						</li>
						<li class="m-portlet__nav-item">
							<a @click="isOpen()" class="m-portlet__nav-link m-portlet__nav-link--icon" data-toggle="collapse" href="#BISPermits" role="button" aria-expanded="false" aria-controls="BISPermits">
							    <i class="la la-chevron-circle-down" v-if="panel.open == 0" style="font-size: 24px !important;"></i>
							    <i class="la la-chevron-circle-up" v-if="panel.open == 1" style="font-size: 24px !important;"></i>
							</a>
						</li>
					</ul>
				</div>
			</div>
			<div class="m-portlet__body collapse table-responsive" id="BISPermits">
				<div class="loadng-state text-center" v-if="panel.loading == 1">
					<i class="fa fa-spinner fa-spin fa-7x" style="font-size: 3em"></i>
				</div>
				<vuetable
					ref="vuetable"
					v-if="panel.loading == 0"
					:api-url="`/property/bis/permits/${property.id}`"
					:fields="fields"
			        :css="css.table"
			        :sortOrder="sortOrder"
			        :append-params="moreParams"
			        pagination-path=""
			        @vuetable:pagination-data="onPaginationData"
				>
				</vuetable>
			</div>
			<div class="m-portlet__foot" v-if="panel.loading == 0">
				<div class="row align-items-center">
					<div class="col-lg-6 m--valign-middle">
						<vuetable-pagination-info ref="paginationInfo" class="pull-left"></vuetable-pagination-info>
					</div>
					<div class="col-lg-6 m--align-right">
						<vuetable-pagination ref="pagination" @vuetable-pagination:change-page="onChangePage" :css="css.pagination"></vuetable-pagination>
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
						name: 'permit_number', 
						sortField: '', 
						title: 'Permit #'
					},
					{ 
						name: 'job_number', 
						sortField: '', 
						title: 'Job #'
					},
					{ 
						name: 'fee', 
						sortField: '', 
						title: 'Fee'
					},
					{ 
						name: 'first_issue_date', 
						sortField: '', 
						title: 'First Issue Date'
					},
					{ 
						name: 'last_issue_date', 
						sortField: '', 
						title: 'Last Issue Date'
					},
					{ 
						name: 'issued_date', 
						sortField: '', 
						title: 'Issued Date'
					},
					{ 
						name: 'expires_date', 
						sortField: '', 
						title: 'Expires Date'
					},
					{ 
						name: 'seq_no', 
						sortField: '', 
						title: 'Seq #'
					},
					{ 
						name: 'filing_date', 
						sortField: '', 
						title: 'Filing Date'
					},
					{ 
						name: 'status', 
						sortField: '', 
						title: 'Status'
					},
					{ 
						name: 'work_description', 
						sortField: '', 
						title: 'Work Description'
					},
					{ 
						name: 'proposed_job_start_date', 
						sortField: '', 
						title: 'Proposed Job Start Date'
					},
					{ 
						name: 'work_approved_date', 
						sortField: '', 
						title: 'Work Approved Date'
					},
					{ 
						name: 'use', 
						sortField: '', 
						title: 'Use'
					},
					{ 
						name: 'landmark', 
						sortField: '', 
						title: 'Landmark'
					},
					{ 
						name: 'stories', 
						sortField: '', 
						title: 'Stories'
					},
					{ 
						name: 'site_fill', 
						sortField: '', 
						title: 'Site Fill'
					},
					{ 
						name: 'review_is_requested_under_building_code', 
						sortField: '', 
						title: 'Review Under Building Code'
					},
					{ 
						name: 'adding_more_than_3_stories', 
						sortField: '', 
						title: 'Adding More Than 3 Stories'
					},
					{ 
						name: 'removing_one_or_more_stories', 
						sortField: '', 
						title: 'Remove One Or More Stories'
					},
					{ 
						name: 'performing_work_in_50_percent_or_more_of_building_area', 
						sortField: '', 
						title: 'Performing Work in 50% Or More Of Building Area'
					},
					{ 
						name: 'demolishing_50_percent_or_more_of_building_area', 
						sortField: '', 
						title: 'Demolishing 50% Or More Of Building Area'
					},
					{ 
						name: 'performing_vertical_horizontal_enlargement', 
						sortField: '', 
						title: 'Performing Vertical Horizontal Enlargement'
					},
					{ 
						name: 'mechanical_equipment_to_be_used_for_demolition', 
						sortField: '', 
						title: 'Mechanical Equipment To Be Used For Demo.'
					},
					{ 
						name: 'mech_equipment_other_than_handheld', 
						sortField: '', 
						title: 'Mechanical Equipment Other Than Handheld'
					},
					{ 
						name: 'concrete_work_completed', 
						sortField: '', 
						title: 'Concrete Work Completed'
					},
					{ 
						name: 'requesting_concrete_exclusion', 
						sortField: '', 
						title: 'Requesting Concrete Exclusion'
					},
					{ 
						name: 'work_includes_2000_cubic_yds_or_more_of_concrete', 
						sortField: '', 
						title: 'Work Includes 2000 Yrds Or More Of Concreate'
					},
					{ 
						name: 'issued_to', 
						sortField: '', 
						title: 'Issued To'
					},
					{ 
						name: 'gc_safety_registration', 
						sortField: '', 
						title: 'GC Safety Registration'
					},
					{ 
						name: 'business', 
						sortField: '', 
						title: 'Business'
					},
					{ 
						name: 'phone', 
						sortField: '', 
						title: 'Phone'
					}
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
			        { name: 'inspection_date', sortField: 'inspection_date', direction: 'asc' },
			    ],
			    moreParams: {},

				panel: { 
					open: 0,
					loading: 0,
				}
			}
		},
		mounted() {
		    this.$events.$on('bis-permits-filter-set', eventData => this.onFilterSet(eventData))
		    this.$events.$on('bis-permits-filter-reset', e => this.onFilterReset())
		},
		methods: { 
			isOpen () { 
				if (this.panel.open == 1) { 
					this.panel.open = 0
				} else { 
					this.panel.open = 1
					this.getData()
				}
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
				app.isLoading()
				axios.get(`/api/property/bis/job-applications/index/${app.property.id}`)
					 .then((response) => { 
					 	app.getJobApplicationsRecords()
					 }) 
			},
			getJobApplicationsRecords () { 
				var app = this 
				axios.get(`/api/property/bis/job-applications/records/${app.property.id}`)
					 .then((response) => { 
					 	app.getPermitsIndex()
					 }) 
			},
			getPermitsIndex () { 
				var app = this
				axios.get(`/api/property/bis/permits/index/${app.property.id}`)
					 .then((response) => { 
					 	app.getPermitsRecords()
					 })	
			},
			getPermitsRecords () { 
				var app = this 
				axios.get(`/api/property/bis/permits/records/${app.property.id}`)
					 .then((response) => { 
					 	app.isLoading()
					 })	
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
		
</style>