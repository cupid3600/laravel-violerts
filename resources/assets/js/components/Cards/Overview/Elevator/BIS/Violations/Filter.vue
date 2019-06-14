<template>
	<div id="bisElevatorViolationFilter">
		<div class="input-group input-group-sm search-input">
			<input type="text" class="form-control" aria-describedby="basic-addon2" v-model="filterText" @keyup.enter="doFilter" placeholder="Device #, Type, Status">
			<div class="input-group-append">
				<button class="btn btn-default" @click="doFilter">
					<i class="la la-search"></i>
				</button>
				<button class="btn btn-default" @click="resetFilter">
					<i class="la la-times"></i>
				</button>
			</div>
		</div>
	</div>
</template>
<script>
	export default { 
		data () { 
			return { 
				filterText: ''
			}
		}, 
		methods: {
	    	doFilter () {
	        	this.$events.fire('bis-elevator-violations-filter-set', this.filterText)
	    	},
	    	resetFilter () {
	        	this.filterText = ''
	        	this.$events.fire('bis-elevator-violations-filter-reset')
	    	}
	    }
	}
</script>
<style scoped>
	#bisElevatorViolationFilter { 

	}

	.btn { 
		padding-top: 5px !important;
		padding-bottom: 2px !important;
	}

	/* iphone 4/4s - portrait */
	@media only screen 
  	and (min-device-width: 320px) 
  	and (max-device-width: 480px)
  	and (-webkit-min-device-pixel-ratio: 2)
  	and (orientation: portrait) {
  		#bisElevatorViolationFilter { 
  			display: none !important;
  		}
	}

	/* iphone 5/5s/5c - portrait */
	@media only screen 
	and (min-device-width: 320px) 
	and (max-device-width: 568px)
	and (-webkit-min-device-pixel-ratio: 2)
	and (orientation: portrait) {
		#bisElevatorViolationFilter { 
			display: none !important;
		}
	}

	/* iphone 6/7 - portrait */
	@media only screen 
	and (min-device-width: 375px) 
	and (max-device-width: 667px) 
	and (-webkit-min-device-pixel-ratio: 2) { 
		#bisElevatorViolationFilter { 
			display: none !important;
		}

	}

	/* iphone 6+/7+/8+ - portrait */
	@media only screen 
	and (min-device-width: 414px) 
	and (max-device-width: 736px) 
	and (-webkit-min-device-pixel-ratio: 3)
	and (orientation: portrait) { 
		#bisElevatorViolationFilter { 
			display: none !important;
		}

	}

	/* iphone x - portrait */
	@media only screen 
	and (min-device-width: 375px) 
	and (max-device-width: 812px) 
	and (-webkit-min-device-pixel-ratio: 3)
	and (orientation: portrait) { 

		#bisElevatorViolationFilter { 
			display: none !important;
		}
	}
</style>