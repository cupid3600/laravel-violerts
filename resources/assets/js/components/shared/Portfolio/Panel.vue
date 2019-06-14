<template>
	<div>
		<div class="m-portlet m-portlet--bordered m-portlet--unair">
			<div class="m-portlet__head">
				<div class="m-portlet__head-caption">
					<div class="m-portlet__head-title">
						<span class="m-portlet__head-icon">
							<i class="flaticon-tabs"></i>
						</span>
						<h3 class="m-portlet__head-text">
							Portfolio
						</h3>
					</div>			
				</div>
			</div>
			<div class="m-portlet__body table-responsive">
				<vuetable
					ref="vuetable"
					:api-url="`/portfolio/${user.id}`"
					:fields="fields"
			        :css="css.table"
			        :sortOrder="sortOrder"
			        :append-params="moreParams"
			        pagination-path=""
			        @vuetable:pagination-data="onPaginationData"
				>
				</vuetable>
			</div>
			<div class="m-portlet__foot">
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

	import PropertyAddress from './Columns/Address.vue'
	import PropertySettings from './Columns/Settings.vue'

	Vue.component('property-address', PropertyAddress)
	Vue.component('property-settings', PropertySettings)

	export default { 
		props: [ 
			'user'
		],
		components: { 
			Vuetable,
			VuetablePagination,
			VuetablePaginationInfo
		},
		data () { 
			return { 
				fields: [ 
					{ 
						name: '__component:property-address', 
						sortField: '', 
						title: 'Address', 
						dataClass: 'pt-15'
					},
					{ 
						name: 'property.bin', 
						sortField: '', 
						title: 'BIN', 
						dataClass: 'pt-15'
					},
					{ 
						name: 'property.block', 
						sortField: '', 
						title: 'Block', 
						dataClass: 'pt-15'
					},
					{ 
						name: 'property.lot', 
						sortField: '', 
						title: 'Lot', 
						dataClass: 'pt-15'
					},
					{ 
						name: '__component:property-settings', 
						title: ''
					}
				],
				css: {
			        table: {
			        	tableClass: 'table table-striped table-hover custom-panel',
			        	ascendingIcon: 'fa fa-angle-up',
			        	descendingIcon: 'fa fa-angle-down'
			        },
			        pagination: {
			        	wrapperClass: "pagination pull-right",
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
			        { field: 'address', sortField: 'address', direction: 'asc' },
			    ], 
			    moreParams: {}
			}
		},
		mounted() {
		    this.$events.$on('portfolio-filter-set', eventData => this.onFilterSet(eventData))
		    this.$events.$on('portfolio-filter-reset', e => this.onFilterReset())
		    this.$refs.vuetable.refresh()
		},
		methods: { 
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
	.m-portlet__body { 
		padding: 0 !important;
	}

	.m-portlet__foot { 
		padding-left: 10px !important; 
	}
</style>