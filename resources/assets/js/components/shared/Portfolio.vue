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
			<div class="m-portlet__body">
				<vuetable
					ref="vuetable"
					:api-url="`/portfolio/${user.id}`"
					:fields="fields"
			        :css="css.table"
			        :sortOrder="sortOrder"
				>
				</vuetable>
			</div>
		</div>
	</div>
</template>
<script>
	import Vuetable from 'vuetable-2/src/components/Vuetable.vue'
	export default { 
		props: [ 
			'user'
		],
		components: { 
			Vuetable
		},
		data () { 
			return { 
				fields: [ 
					{ 
						name: 'address', 
						sortField: '', 
						title: 'Address'
					},
					{ 
						name: 'bin', 
						sortField: '', 
						title: 'BIN'
					},
					{ 
						name: 'block', 
						sortField: '', 
						title: 'Block'
					},
					{ 
						name: 'lot', 
						sortField: '', 
						title: 'Lot'
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
		}
	}
</script>
<style scoped>
	
</style>