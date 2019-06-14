<template>
	<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
		<div class="m-portlet m-portlet--bordered" id="activityPortlet">
			<div class="m-portlet__head">
				<div class="m-portlet__head-caption">
					<div class="m-portlet__head-title">
						<h3 class="m-portlet__head-text">
							Activity
						</h3>
					</div>
				</div>
			</div>
			<div class="m-portlet__body">
				<div class="m-list-timeline m-list-timeline--skin-light">
					<div class="m-list-timeline__items">
						<div class="m-list-timeline__item">
							<span class="m-list-timeline__badge m-list-timeline__badge--success"></span>
							<span class="m-list-timeline__text">
								12 new users registered
							</span>
							<span class="m-list-timeline__time">
								Just now
							</span>
						</div>
						<div class="m-list-timeline__item">
							<span class="m-list-timeline__badge m-list-timeline__badge--info"></span>
							<span class="m-list-timeline__text">
								System shutdown
								<span class="m-badge m-badge--success m-badge--wide">
									pending
								</span>
							</span>
							<span class="m-list-timeline__time">
								14 mins
							</span>
						</div>
						<div class="m-list-timeline__item">
							<span class="m-list-timeline__badge m-list-timeline__badge--danger"></span>
							<span class="m-list-timeline__text">
								New invoice received
							</span>
							<span class="m-list-timeline__time">
								20 mins
							</span>
						</div>
						<div class="m-list-timeline__item">
							<span class="m-list-timeline__badge m-list-timeline__badge--accent"></span>
							<span class="m-list-timeline__text">
								DB overloaded 80%
								<span class="m-badge m-badge--info m-badge--wide">
									settled
								</span>
							</span>
							<span class="m-list-timeline__time">
								1 hr
							</span>
						</div>
						<div class="m-list-timeline__item">
							<span class="m-list-timeline__badge m-list-timeline__badge--warning"></span>
							<span class="m-list-timeline__text">
								System error -
								<a href="#" class="m-link">
									Check
								</a>
							</span>
							<span class="m-list-timeline__time">
								2 hrs
							</span>
						</div>
						<div class="m-list-timeline__item">
							<span class="m-list-timeline__badge m-list-timeline__badge--brand"></span>
							<span class="m-list-timeline__text">
								Production server down
							</span>
							<span class="m-list-timeline__time">
								3 hrs
							</span>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
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
	
</style>