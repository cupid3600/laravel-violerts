<template>
	<div v-if="user.user_group === '2' && user.is_verified == 1 && user.isSuspended == 0">
		<div class="m-portlet m-portlet--bordered m-portlet--unair">
			<div class="m-portlet__head">
				<div class="m-portlet__head-caption">
					<div class="m-portlet__head-title">
						<span class="m-portlet__head-icon">
							<i class="flaticon-users"></i>
						</span>
						<h3 class="m-portlet__head-text">
							User Management
						</h3>
					</div>			
				</div>
			</div>
			<div class="m-portlet__body table-responsive">
				<vuetable
					ref="vuetable"
					:api-url="`/admin/users`"
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

	import UserName from './Columns/UserName.vue'
	import UserGroup from './Columns/UserGroup.vue'
	import UserCreatedAt from './Columns/UserCreatedAt.vue'
	import UserSuspend from './Columns/UserSuspend.vue'

	Vue.component('user-name', UserName)
	Vue.component('user-group', UserGroup)
	Vue.component('user-join-date', UserCreatedAt)
	Vue.component('user-suspend', UserSuspend)


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
						name: '__component:user-name', 
						sortField: '', 
						title: 'Name',
						dataClass: 'pt-15'
					},
					{
						name: '__component:user-group', 
						sortField: '', 
						title: 'Type',
						dataClass: 'pt-15'
					},
					{
						name: 'email', 
						sortField: '', 
						title: 'Email',
						dataClass: 'pt-15'
					},
					{
						name: '__component:user-join-date', 
						sortField: '', 
						dataClass: 'pt-15',
						title: 'Joined on'
					},
					{
						name: '__component:user-suspend', 
						sortField: '', 
						title: ''
					},
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
		    this.$events.$on('user-management-filter-set', eventData => this.onFilterSet(eventData))
		    this.$events.$on('user-management-filter-reset', e => this.onFilterReset())
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
<style>
	.m-portlet__body { 
		padding: 0 !important;
	}

	.m-portlet__foot { 
		padding-left: 10px !important; 
	}

	.pt-15 { 
		padding-top: 15px !important;
	}
</style>