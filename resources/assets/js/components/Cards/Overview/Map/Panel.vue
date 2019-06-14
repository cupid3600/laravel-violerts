<template>
	<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 d-print-none">
		<div class="m-portlet m-portlet--bordered" id="mapPortlet">
			<div class="m-portlet__head">
				<div class="m-portlet__head-caption">
					<div class="m-portlet__head-title">
						<h3 class="m-portlet__head-text">
							Map
						</h3>
					</div>
				</div>
				<div class="m-portlet__head-tools">
					<ul class="m-portlet__nav">
						<!-- <myCloud  style="padding-top: 20px !important;"/> -->
						<li class="m-portlet__nav-item">
							<a @click="isOpen" class="m-portlet__nav-link m-portlet__nav-link--icon" data-toggle="collapse" href="#mapPanel" role="button" aria-expanded="false" aria-controls="mapPanel">
							    <i class="la la-angle-down" v-if="panel.open == 0"></i>
							    <i class="la la-angle-up" v-if="panel.open == 1"></i>
							</a>
						</li>
					</ul>
				</div>
			</div>
			<div class="m-portlet__body collapse" id="mapPanel">
				<div class="row">
					<div id="viewDiv"></div>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
	import { loadModules } from "esri-loader";
	export default { 
		props: [ 
			'property'
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
			createMap () {
				const options = {
					url: "https://js.arcgis.com/4.7/"
			    };

			    loadModules(
		        [
		        	"esri/Map",
					"esri/views/MapView",
					"esri/layers/FeatureLayer",
					"esri/tasks/QueryTask",
					"esri/tasks/support/Query",
					"esri/Graphic"
		        ], options)
			    .then(([Map, MapView, FeatureLayer, QueryTask, Query, Graphic]) => {

			    	const boroughs = { // MapPluto Borough URLs
					    manhattan: "https://services8.arcgis.com/xHG3VzKDNBrBbtz8/ArcGIS/rest/services/mn_mappluto_17v1_1/FeatureServer/0",
					   	bronx: "https://services8.arcgis.com/xHG3VzKDNBrBbtz8/arcgis/rest/services/bx_mappluto_17v1_1/FeatureServer/0",
					   	brooklyn: "https://services8.arcgis.com/xHG3VzKDNBrBbtz8/arcgis/rest/services/bk_mappluto_17v1_1/FeatureServer/0",
					   	queens: "https://services8.arcgis.com/xHG3VzKDNBrBbtz8/arcgis/rest/services/qn_mappluto_17v1_1/FeatureServer/0",
					   	staten_island: "https://services8.arcgis.com/xHG3VzKDNBrBbtz8/arcgis/rest/services/si_mappluto_17v1_1/FeatureServer/0",
				    }
				    // Building Footprints URL
					const building_footprints_url = 'https://services8.arcgis.com/xHG3VzKDNBrBbtz8/arcgis/rest/services/Building_Footprints/FeatureServer/0'

					var building_footprints = new FeatureLayer({
						url: building_footprints_url,
						outFields: ["*"]
					})

			    	var map = new Map({
				      basemap: "topo",
				      layers: [building_footprints]
				    })

				    var view = new MapView({
				      container: "viewDiv",
				      map: map,
				      center: [-73.982013,40.7572223],
      				  zoom: 16
				    })

				    /*view.on("drag", function(evt){
					  // prevents panning with the mouse drag event
					  evt.stopPropagation()
					})

					view.on("key-down", function(evt){
					  // prevents panning with the arrow keys
					  var keyPressed = evt.key
					  if(keyPressed.slice(0,5) === "Arrow"){
					    evt.stopPropagation()
					  }
					})*/

					view.on("pointer-move", pointerMoveEventHandler)

					function pointerMoveEventHandler(event) {
						view.hitTest(event)
						 .then(getGraphics)
					}

					function getGraphics(response) {
						if (response.results.length) {
						    var graphic = response.results.filter(function(result) {
						    	return result.graphic.layer === building_footprints
						    })[0].graphic

						    var attributes = graphic.attributes
						    var fid = attributes.FID

						    var renderer = {
						    	type: "unique-value",
						    	field: "FID",
						    	defaultSymbol: building_footprints.renderer.symbol || building_footprints.renderer.defaultSymbol,
						    	uniqueValueInfos: [{
						    		value: fid,
						    		symbol: {
						    			type: "simple-fill",
						    			color: "orange",
						    		}
						    	}]
						    }
						    building_footprints.renderer = renderer
						}
					}

				    let self = this
				    var searchedBin = this.property.bin

				    // query for the lat long from the building footprints featurelayer
				    var queryTask = new QueryTask({ url: building_footprints_url })
				    var query = new Query()
				    query.returnGeometry = true
				    query.outFields = ["*"]
				    query.where = "bin = " + searchedBin
				    queryTask.execute(query).then(function(results){
				    	var centroid = results.features[0].geometry.centroid
				    	view.center = [centroid.longitude, centroid.latitude]
				    	view.zoom = 17

				    	// create the geometry to place the Pin/Point over searched property
				    	var point = {
				    		type: "point", // autocasts as new Point()
					        longitude: centroid.longitude,
					        latitude: centroid.latitude
					    }

					    // Create a symbol for drawing the point
					    var markerSymbol = {
							type: "simple-marker", // autocasts as new SimpleMarkerSymbol()
					        color: [226, 119, 40],
					        outline: { // autocasts as new SimpleLineSymbol()
					          color: [255, 255, 255],
					          width: 2
					        }
					    }

					    // Create a graphic and add the geometry and symbol to it
					    var pointGraphic = new Graphic({
					        geometry: point,
					        symbol: markerSymbol
					    });

					    view.graphics.add(pointGraphic);
					})
			    })
			}
		},
		watch: { 
			'property': 'createMap'
		},
		mounted () {
			$('#mapPanel').collapse("show")
			this.isOpen()
		}
	}
</script>

<style>
	@import url("https://js.arcgis.com/4.7/esri/themes/light/main.css");
	#viewDiv {
		z-index: 1;
		//height: calc(100vh - 30vh);
		height: 325px;
  		width: 100%;
	}
</style>