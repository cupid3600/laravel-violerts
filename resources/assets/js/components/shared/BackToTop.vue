<template>
	<back-to-top>
		<button class="btn btn-metal btn-lg m-btn m-btn--icon m-btn--icon-only m-btn--custom m-btn--pill">
			<i class="la la-arrow-circle-o-up"></i>
		</button>
	</back-to-top>
</template>
<script>
	export default { 
		data () { 
			return { 

			}
		}
	}
</script>
<style scoped>
	button { 
		position: absolute !important;
		right: 130px !important;
		bottom: -31px !important;
		padding-top: 14px !important;
		padding-right: 14px !important;
		padding-left: 14px !important;
		padding-bottom: 14px !important;
	}

	/* iphone 4/4s - portrait */
	@media only screen 
  	and (min-device-width: 320px) 
  	and (max-device-width: 480px)
  	and (-webkit-min-device-pixel-ratio: 2)
  	and (orientation: portrait) {
	  		button { 
			position: absolute !important;
			right: 50px !important;
			bottom: -31px !important;
			padding: 12px !important;
		}
	}

	/* iphone 5/5s/5c - portrait */
	@media only screen 
	and (min-device-width: 320px) 
	and (max-device-width: 568px)
	and (-webkit-min-device-pixel-ratio: 2)
	and (orientation: portrait) {
		button { 
			position: absolute !important;
			right: 50px !important;
			bottom: -31px !important;
			padding: 12px !important;
		}

	}

	/* iphone 6/7 - portrait */
	@media only screen 
	and (min-device-width: 375px) 
	and (max-device-width: 667px) 
	and (-webkit-min-device-pixel-ratio: 2) { 
		button { 
			position: absolute !important;
			right: 50px !important;
			bottom: -31px !important;
			padding: 12px !important;
		}

	}

	/* iphone 6+/7+/8+ - portrait */
	@media only screen 
	and (min-device-width: 414px) 
	and (max-device-width: 736px) 
	and (-webkit-min-device-pixel-ratio: 3)
	and (orientation: portrait) { 
		button { 
			position: absolute !important;
			right: 50px !important;
			bottom: -31px !important;
			padding: 12px !important;
		}
	}

	/* iphone x - portrait */
	@media only screen 
	and (min-device-width: 375px) 
	and (max-device-width: 812px) 
	and (-webkit-min-device-pixel-ratio: 3)
	and (orientation: portrait) { 
		button { 
			position: absolute !important;
			right: 50px !important;
			bottom: -31px !important;
			padding: 12px !important;
		}
	}
</style>