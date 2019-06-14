<template>
    <div>
        <nav class="d-none navbar navbar-expand-md navbar-dark align-items-start">
            <Logo class="d-none d-print-inline-block"/>
        </nav>

		<nav class="navbar navbar-expand-md fixed-top" v-if="settings.web == 1">
			<router-link to="/" class="navbar-brand">
				<Logo />
			</router-link>
	      	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
	        	<i class="fa fa-bars" aria-hidden="true"></i>
	      	</button>

	      	<div class="collapse navbar-collapse" id="navbarsExampleDefault">
		        <ul class="navbar-nav ml-auto text-center">
			        <li class="nav-item">
			            <router-link v-if="!$auth.check()" to="/signin" class="nav-link">
			            	SIGN IN
			            </router-link>
			        </li>
			        <li class="nav-item">
			            <router-link v-if="!$auth.check()" to="/signup" class="nav-link">
			            	SIGN UP
			            </router-link>
			        </li>
			        <li class="nav-item">
			            <router-link v-if="$auth.check()" to="/dashboard" class="nav-link">
			            	GO TO DASHBOARD
			            </router-link>
			        </li>
		        </ul>
	      	</div>
	    </nav>
	    <nav class="navbar navbar-expand-md fixed-top navbar-dark bg-dark d-print-none" v-if="settings.web == 0">
			<router-link to="/" class="navbar-brand">
				<Logo
					:settings="settings"
				/>
			</router-link>
	      	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
	        	<i class="fa fa-bars" aria-hidden="true"></i>
	      	</button>

	      	<div class="collapse navbar-collapse" id="navbarsExampleDefault">
	      		<ul class="navbar-nav mr-auto text-center">
			    	<li class="nav-item">
			        	<router-link v-if="$auth.check() && path != '/dashboard'" to="/dashboard" class="nav-link">
			        		<i class="la la-desktop"></i> 
			        		Dashboard 
			        		<span class="sr-only">(current)</span>
			        	</router-link>
			    	</li>
			    </ul>
		        <ul class="navbar-nav ml-auto text-center">
		        	<li class="nav-item" id="searchTab">
		        		<Search v-if="display_width == false" />
		        	</li>
		        	<li class="nav-item">
			            <router-link v-if="!$auth.check()" to="/signin" class="nav-link">
			            	SIGN IN
			            </router-link>
			        </li>
			        <li class="nav-item">
			            <router-link v-if="!$auth.check()" to="/signup" class="nav-link">
			            	SIGN UP
			            </router-link>
			        </li>
			        <li class="nav-item dropdown" v-if="$auth.check()">
			        	<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			          		<i class="la la-user"></i>
			          		My Account
			        	</a>
			        	<div class="dropdown-menu" aria-labelledby="navbarDropdown" id="userDropdown">
			          		<a class="dropdown-item" data-toggle="modal" data-target="#userSettingsModal">
			          			<i class="la la-cogs"></i> 
			          			Settings
			          		</a>
			          		<!--<div class="dropdown-divider"></div>-->
			          		<a @click.prevent="$auth.logout()" class="dropdown-item">
				            	<i class="fa fa-sign-out"></i> 
				            	Sign out
				            </a>
			        	</div>
			      	</li>
		        </ul>
	      	</div>
	    </nav>
	    <UserSettings
	    	:user="user"
	    />
	</div>
</template>
<script>
	import Logo from './Logo.vue'
	import Search from './Search.vue'
	import UserSettings from './UserSettings.vue'
	export default { 
		props: [ 
			'settings', 
			'user'
		],
		components: { 
			Logo, 
			Search, 
			UserSettings
		},
		data () { 
			return { 
				path: this.$route.path, 
				display_width: window.matchMedia("(max-width: 812px)").matches
			}
		},  
		mounted () { 

		}
	}
</script>
<style scoped>
	* { 
		color: #fff;
	}

	.navbar-dark {
        background-color: #2c2e3e !important;
    }

	#userDropdown { 
		background-color: #2c2e3e !important;
		box-shadow: none !important; 
		-webkit-box-shadow: none !important;
		border: 0 !important;
	}

	.dropdown-menu > li > a:hover, .dropdown-menu > .dropdown-item:hover { 
		background-color: #484e5d !important;
	}

	.nav-item:nth-child(2) { 
		padding-left: 15px !important;
	}

	a, a:hover, a:focus, a:visited { 
		color: #fff;
		font-weight: 600;
		letter-spacing: 0.7px;
	}

	.navbar-toggler  { 
		outline: none !important;
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

		#searchTab { 
			display: none !important;
		}

		#searchTab .form-group { 
			display: none !important;
		}
	}

	/* iphone 5/5s/5c/5e - portrait */
	@media only screen 
	and (min-device-width: 320px) 
	and (max-device-width: 568px)
	and (-webkit-min-device-pixel-ratio: 2)
	and (orientation: portrait) {
		.nav-item:nth-child(2) { 
			padding-left: 0 !important;
		}

		#searchTab { 
			display: none !important;
		}

		#searchTab .form-group { 
			display: none !important;
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

		#searchTab { 
			display: none !important;
		}

		#searchTab .form-group { 
			display: none !important;
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

		#searchTab { 
			display: none !important;
		}

		#searchTab .form-group { 
			display: none !important;
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

		#searchTab { 
			display: none !important;
		}

		#searchTab .form-group { 
			display: none !important;
		}
	}


</style>