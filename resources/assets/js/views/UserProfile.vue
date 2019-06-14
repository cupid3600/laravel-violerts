<template>
	<div>
		<Navbar
			:settings="Navbar"
		/>
		<div class="container" id="profile-content">
			<Search 
				id="searchBar" 
				v-if="display_width == true"
			/>
			<h5 class="text-muted">
				<i class="la la-user"></i> 
				User profile
			</h5>
			<h1>
				<button class="btn btn-warning pull-right" v-if="profile.isSuspended == false && user.id != profile.id">
					<i class="la la-user-times"></i> 
					Suspend
				</button>
				<button class="btn btn-warning pull-right" v-if="profile.isSuspended == true && user.id != profile.id">
					<i class="la la-unlock-alt"></i>  
					Restore
				</button>
				{{profile.name}}
			</h1>
			<hr>
			<Portfolio 
				:user="profile"
			/>
		</div>
	</div>
</template>
<script>
import Navbar from '../components/shared/Navbar.vue'
import Portfolio from '../components/shared/Portfolio/Panel.vue'
import Search from '../components/shared/Search.vue'

export default { 
	props: [ 
		'token'
	], 
	components: { 
		Navbar, 
		Portfolio, 
		Search
	},
	data () { 
		return { 
			Navbar: { 
				web: 0, 
				app: 1
			},
			user: {}, 
			profile: {},
			display_width: window.matchMedia("(max-width: 812px)").matches
		}
	},
	methods: { 
		getUser () { 
			var app = this
			axios.get('/api/auth/user')
				 .then((response) => { 
				 	app.user = response.data.data
				 })
		}, 
		getProfile (token) { 
			var app = this
			axios.get(`/api/admin/users/profile/${token}`)
				 .then((response) => { 
				 	app.profile = response.data.user
				 	console.log(app.profile)
				 })
		}

	}, 
	created () { 
		document.body.style.backgroundImage = 'none'
		document.body.style.backgroundColor = '#ebedf2'
		this.getUser()
		console.log(this.token)
		this.getProfile(this.token)
	} 
}
</script>
<style scoped>
	#profile-content { 
		padding-top: 20vh;
	}

	#searchBar { 
		display: none !important;
	}
	/* iphone 4/4s - portrait */
	@media only screen 
  	and (min-device-width: 320px) 
  	and (max-device-width: 480px)
  	and (-webkit-min-device-pixel-ratio: 2)
  	and (orientation: portrait) {
		.navbar-brand svg { 
			width: 50%;
		}

		.nav-item:nth-child(2) { 
			padding-left: 0 !important;
		}

		#searchBar { 
			display: inherit !important;
			margin-bottom: 25px !important;
			padding-left: 3px !important;
			padding-right: 3px !important;
		}
	}

	/* iphone 5/5s/5c - portrait */
	@media only screen 
	and (min-device-width: 320px) 
	and (max-device-width: 568px)
	and (-webkit-min-device-pixel-ratio: 2)
	and (orientation: portrait) {
		.nav-item:nth-child(2) { 
			padding-left: 0 !important;
		}

		#searchBar { 
			display: inherit !important;
			margin-bottom: 25px !important;
			padding-left: 3px !important;
			padding-right: 3px !important;
		}

	}

	/* iphone 6/7 - portrait */
	@media only screen 
	and (min-device-width: 375px) 
	and (max-device-width: 667px) 
	and (-webkit-min-device-pixel-ratio: 2) { 
		.nav-item:nth-child(2) { 
			padding-left: 0 !important;
		}

		#searchBar { 
			display: inherit !important;
			margin-bottom: 25px !important;
			padding-left: 3px !important;
			padding-right: 3px !important;
		}

	}

	/* iphone 6+/7+/8+ - portrait */
	@media only screen 
	and (min-device-width: 414px) 
	and (max-device-width: 736px) 
	and (-webkit-min-device-pixel-ratio: 3)
	and (orientation: portrait) { 
		.nav-item:nth-child(2) { 
			padding-left: 0 !important;
		}

		#searchBar { 
			display: inherit !important;
			margin-bottom: 25px !important;
			padding-left: 3px !important;
			padding-right: 3px !important;
		}

	}

	/* iphone x - portrait */
	@media only screen 
	and (min-device-width: 375px) 
	and (max-device-width: 812px) 
	and (-webkit-min-device-pixel-ratio: 3)
	and (orientation: portrait) { 
		.nav-item:nth-child(2) { 
			padding-left: 0 !important;
		}

		#searchBar { 
			display: inherit !important;
			margin-bottom: 25px !important;
			padding-left: 3px !important;
			padding-right: 3px !important;
		}

	}
	

</style>