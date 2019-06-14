<template>
    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-print-6">
        <div class="d-none d-print-block">
            <div class="m-portlet m-portlet--bordered">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text">
                                General
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="m-portlet__body">
                    <div class="row">
                        <div class="col-sm">
                            <strong class="m--font-boldest">Owner</strong>
                            <p>{{ zone.pluto.OwnerName }}</p>
                        </div>
                        <div class="col-sm">
                            <strong class="m--font-boldest">Year Built</strong>
                            <p>{{ zone.pluto.YearBuilt }}</p>
                        </div>
                        <div class="col-sm">
                            <strong class="m--font-boldest">Number of Buildings</strong>
                            <p>{{ zone.pluto.NumBldgs }}</p>
                        </div>
                        <div class="col-sm">
                            <strong class="m--font-boldest">Number of Units</strong>
                            <p>{{ zone.pluto.UnitsTotal }}</p>
                        </div>
                        <div class="col-sm">
                            <strong class="m--font-boldest">Gross Floor Area</strong>
                            <p>{{ zone.pluto.BldgArea }}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm">
                            <strong class="m--font-boldest">Tax Block</strong>
                            <p>{{ zone.pluto.Block }}</p>
                        </div>
                        <div class="col-sm">
                            <strong class="m--font-boldest">Tax Lot</strong>
                            <p>{{ zone.pluto.Lot }}</p>
                        </div>
                        <div class="col-sm">
                            <strong class="m--font-boldest">Number of Floors</strong>
                            <p>{{ zone.pluto.NumFloors }}</p>
                        </div>
                        <div class="col-sm">
                            <strong class="m--font-boldest">Lot Area</strong>
                            <p>{{ zone.pluto.LotArea }}</p>
                        </div>
                        <div class="col-sm">
                            <strong class="m--font-boldest">Landmark</strong>
                            <p>{{ zone.pluto.Landmark }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="m-portlet m-portlet--bordered d-print-none" id="generalPortlet">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <h3 class="m-portlet__head-text">
                            General
                        </h3>
                    </div>
                </div>
                <div class="m-portlet__head-tools">
                    <ul class="m-portlet__nav">
                        <!--<myCloud  style="padding-top: 20px !important;"/>-->
                        <li class="m-portlet__nav-item">
                            <a @click="isOpen" class="m-portlet__nav-link m-portlet__nav-link--icon" data-toggle="collapse" href="#generalPanel" role="button" aria-expanded="false" aria-controls="generalPanel">
                                <i class="la la-angle-down" v-if="panel.open == 0"></i>
                                <i class="la la-angle-up" v-if="panel.open == 1"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="m-portlet__body collapse" id="generalPanel">
                <div class="row">
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-6">
                        <strong class="m--font-boldest">
                            Owner
                        </strong>
                        <p v-if="zone.pluto.OwnerName != null">
                            {{ zone.pluto.OwnerName }}
                        </p>
                        <p v-if="zone.pluto.OwnerName == null" class="text-muted">
                            Not Available
                        </p>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-6">
                        <strong class="m--font-boldest">
                            Year Built
                        </strong>
                        <p>
                            {{ zone.pluto.YearBuilt }}
                        </p>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-6">
                        <strong class="m--font-boldest">
                            Tax Block
                        </strong>
                        <p>
                            {{ zone.pluto.Block }}
                        </p>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-6">
                        <strong class="m--font-boldest">
                            Tax Lot
                        </strong>
                        <p>
                            {{ zone.pluto.Lot }}
                        </p>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-6">
                        <strong class="m--font-boldest">
                            Number Of Buildings
                        </strong>
                        <p>
                            {{ zone.pluto.NumBldgs }}
                        </p>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-6">
                        <strong class="m--font-boldest">
                            Number Of Floors
                        </strong>
                        <p>
                            {{ zone.pluto.NumFloors }}
                        </p>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-6">
                        <strong class="m--font-boldest">
                            Number Of Units
                        </strong>
                        <p>
                            {{ zone.pluto.UnitsTotal }}
                        </p>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-6">
                        <strong class="m--font-boldest">
                            Lot Area
                        </strong>
                        <p>
                            {{ zone.pluto.LotArea }}
                        </p>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-6">
                        <strong class="m--font-boldest">
                            Gross Floor Area
                        </strong>
                        <p>
                            {{ zone.pluto.BldgArea }}
                        </p>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-6">
                        <strong class="m--font-boldest">
                            Landmark
                        </strong>
                        <p v-if="zone.pluto.Landmark == null">
                            Null
                        </p>
                        <p v-if="zone.pluto.Landmark != null">
                            {{ zone.pluto.Landmark }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
	import myCloud from '../../../shared/MyCloud/MyCloud.vue'
	export default { 
		components: { 
			myCloud
		},
		props: [ 
			'zone'
		],
		data () { 
			return { 
				panel: { 
					open: 0,
					loading: 0,
				}
			}
		}, 
		methods: { 
			isOpen () { 
				if (this.panel.open == 1) { 
					this.panel.open = 0
				} else { 
					this.panel.open = 1
				}
			},
		}, 
		mounted () { 
			$('#generalPanel').collapse("show")
			this.isOpen()
		}
	}
</script>
<style scoped>
	#generalPanel { 
		padding: 30.8px !important;
	}

	#generalPanel .row { 
		margin-left: 0 !important;
		margin-right: 0 !important;
	}
</style>