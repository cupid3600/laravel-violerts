<template>
    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-print-6">
        <div class="d-none d-print-block">
            <div class="m-portlet m-portlet--bordered">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text">
                                Zoning
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="m-portlet__body">
                    <div class="row">
                        <div class="col-sm">
                            <strong class="m--font-boldest">Zoning District 1</strong>
                            <p>{{ zone.pluto.ZoneDist1 }}</p>
                        </div>
                        <div class="col-sm">
                            <strong class="m--font-boldest">Commercial Overlay 1</strong>
                            <p>{{ zone.pluto.Overlay1 }}</p>
                        </div>
                        <div class="col-sm">
                            <strong class="m--font-boldest">Historical Zoning Map</strong>
                            <p>{{ this.zone.pluto.ZoneMap }}</p>
                        </div>
                        <div class="col-sm">
                            <strong class="m--font-boldest">Built FAR</strong>
                            <p>{{ zone.pluto.BuiltFAR }}</p>
                        </div>
                        <div class="col-sm">
                            <strong class="m--font-boldest">Residential FAR</strong>
                            <p>{{ zone.pluto.ResidFAR }}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm">
                            <strong class="m--font-boldest">Zoning District 2</strong>
                            <p>{{ zone.pluto.ZoneDist2 }}</p>
                        </div>
                        <div class="col-sm">
                            <strong class="m--font-boldest">Commercial Overlay 2</strong>
                            <p>{{ zone.pluto.Overlay2 }}</p>
                        </div>
                        <div class="col-sm">
                            <strong class="m--font-boldest">Land Use</strong>
                            <p>{{ zone.pluto.LandUse }}</p>
                        </div>
                        <div class="col-sm">
                            <strong class="m--font-boldest">Commercial FAR</strong>
                            <p>{{ zone.pluto.CommFAR }}</p>
                        </div>
                        <div class="col-sm">
                            <strong class="m--font-boldest">Facility FAR</strong>
                            <p>{{ zone.pluto.FacilFAR }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="m-portlet m-portlet--bordered d-print-none" id="zoningPortlet">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <h3 class="m-portlet__head-text">
                            Zoning
                        </h3>
                    </div>
                </div>
                <div class="m-portlet__head-tools">
                    <ul class="m-portlet__nav">
                        <li class="m-portlet__nav-item">
                            <a @click="isOpen" class="m-portlet__nav-link m-portlet__nav-link--icon" data-toggle="collapse" href="#zoningPanel" role="button" aria-expanded="false" aria-controls="zoningPanel">
                                <i class="la la-angle-down" v-if="panel.open == 0"></i>
                                <i class="la la-angle-up" v-if="panel.open == 1"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="m-portlet__body collapse" id="zoningPanel">
                <div class="row">
                    <div class="col-xl-6">
                        <strong class="m--font-boldest">
                            Zoning District 1
                        </strong>
                        <p >
                            {{ zone.pluto.ZoneDist1 }}
                        </p>
                    </div>
                    <div class="col-xl-6">
                        <strong class="m--font-boldest">
                            Zoning District 2
                        </strong>
                        <p >
                            {{ zone.pluto.ZoneDist2 }}
                        </p>
                    </div>
                    <div class="col-xl-6">
                        <strong class="m--font-boldest">
                            Commercial Overlay 1
                        </strong>
                        <p v-if="zone.pluto.Overlay1 !== null">
                            {{ zone.pluto.Overlay1 }}
                        </p>
                        <p v-if="zone.pluto.Overlay1 == null">
                            Null
                        </p>
                    </div>
                    <div class="col-xl-6">
                        <strong class="m--font-boldest">
                            Commercial Overlay 2
                        </strong>
                        <p v-if="zone.pluto.Overlay2 !== null">
                            {{ zone.pluto.Overlay2 }}
                        </p>
                        <p v-if="zone.pluto.Overlay2 == null">
                            Null
                        </p>
                    </div>
                    <div class="col-xl-6">
                        <strong class="m--font-boldest">
                            Historical Zoning Map
                        </strong>
                        <p>
                            <a class="link-class" @click="viewMap">
                                view
                            </a>
                        </p>
                    </div>
                    <div class="col-xl-6">
                        <strong class="m--font-boldest">
                            Land Use
                        </strong>
                        <p>
                            {{ zone.pluto.LandUse }}
                        </p>
                    </div>
                    <div class="col-xl-6">
                        <strong class="m--font-boldest">
                            Built FAR
                        </strong>
                        <p>
                            {{ zone.pluto.BuiltFAR }}
                        </p>
                    </div>
                    <div class="col-xl-6">
                        <strong class="m--font-boldest">
                            Commercial FAR
                        </strong>
                        <p>
                            {{ zone.pluto.CommFAR }}
                        </p>
                    </div>
                    <div class="col-xl-6">
                        <strong class="m--font-boldest">
                            Residential FAR
                        </strong>
                        <p>
                            {{ zone.pluto.ResidFAR }}
                        </p>
                    </div>
                    <div class="col-xl-6">
                        <strong class="m--font-boldest">
                            Facility FAR
                        </strong>
                        <p>
                            {{ zone.pluto.FacilFAR }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>
</div>
</div>
</template>
<script>
	export default { 
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
			viewMap () { 
				window.open(`https://s3.amazonaws.com/vio-assets/${this.zone.pluto.ZoneMap}.pdf`);
			}, 
			isOpen () { 
				if (this.panel.open == 1) { 
					this.panel.open = 0
				} else { 
					this.panel.open = 1
				}
			},
		}, 
		mounted () { 
			$('#zoningPanel').collapse("show")
			this.isOpen()
		}
	}
</script>
<style scoped>
	.link-class {
		color: #5867dd !important;
	}

	.link-class:hover { 
		text-decoration: underline !important; 
	}

	#zoningPanel { 
		padding: 30.8px !important;
	}

	#zoningPanel .row { 
		margin-left: 0 !important;
		margin-right: 0 !important;
	}
</style>