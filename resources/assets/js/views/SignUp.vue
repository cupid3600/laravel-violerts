<template>
	<div>
		<Navbar
			:settings="Navbar"
		/>
		<div class="col-xl-2 offset-xl-5 col-lg-2 offset-lg-5 col-md-6 offset-md-3" id="main-content">
			<h3>
				<i class="fa fa-user-plus"></i>
				Sign Up
			</h3>
			<div class="alert alert-brand" v-if="error && !success">
	            <p>There was an error, unable to complete registration.</p>
	        </div>
	        <div class="alert alert-success" v-if="success">
	        	<strong>
	        		Welcome!
	        	</strong>
	            <p>We've sent an verification email to your account.</p>
	            <router-link to="/signin">Sign In</router-link>
	        </div>
	        <form autocomplete="off" @submit.prevent="signUp" v-if="!success" method="post">
	            <div class="form-group" v-bind:class="{ 'has-error': error && errors.name }">
	                <label for="name">Name</label>
	                <input type="text" id="name" class="form-control" v-model="name" required placeholder="full name" autocomplete="off">
	                <span class="help-block" v-if="error && errors.name" style="color: #ffb822 !important;">{{ errors.name }}</span>
	            </div>
	            <div class="form-group" v-bind:class="{ 'has-error': error && errors.email }">
	                <label for="email">E-mail</label>
	                <input type="email" id="email" class="form-control" placeholder="user@example.com" v-model="email" required autocomplete="off">
	                <span class="help-block" v-if="error && errors.email" style="color: #ffb822 !important;">{{ errors.email }}</span>
	            </div>
	            <div class="form-group" v-bind:class="{ 'has-error': error && errors.password }">
	                <label for="password">Password</label>
	                <input type="password" id="password" class="form-control" v-model="password" required placeholder="create password" autocomplete="off">
	                <span class="help-block" v-if="error && errors.password" style="color: #ffb822 !important;">{{ errors.password }}</span>
	            </div>
	            <button type="submit" class="btn btn-success btn-block" :disabled="isLoading == true">
	            	<i class="fa fa-spinner fa-spin" v-if="isLoading == true"></i>
	            	SIGN UP
	            </button>
	        </form>
		  	<router-link to="/signin">Already have an account? Sign In</router-link>
		</div>
	</div>
</template>
<script>
	import Navbar from '../components/shared/Navbar.vue'
	export default { 
		components: { 
			Navbar
		},
		data () { 
			return { 
				name: '', 
				email: '', 
				password: '',
				error: false, 
				errors: {}, 
				success: false,
				isLoading: false,
				Navbar: { 
					web: 1, 
					app: 0
				},
				images: [ 
					'/images/bg1.png', 
					'/images/bg2.png', 
					'/images/bg3.png'
				]

			}
		}, 
		methods: { 
			signUp() { 
				var app = this
				app.isLoading = true
				app.$auth.register({
					params: { 
						name: app.name, 
						email: app.email, 
						password: app.password
					}, 
					success () { 
						app.success = true
						app.isLoading = false
					}, 
					error (resp) { 
						app.error = true
						app.errors = resp.response.data.errors
						app.isLoading = false
					}, 
					redirect: null
				})
			},
			cycleImage () { 
				var image = this.images[Math.floor(Math.random() * this.images.length)]
				document.body.style.backgroundSize = 'cover'
				document.body.style.backgroundImage = `url('${image}')`
			}
		},
		mounted () { 
			this.cycleImage()
		}
	}
</script>
<style scoped>
	span.help-block { 
		color: #ffb822 !important;
	}

	/* main content styling */
	#main-content { 
		margin-top: 20vh;
	}

	#main-content  .form-group { 
		margin-top: 8px !important;
	}

	#main-content .btn { 
		margin-top: 10px !important;
	}

	#main-content label { 
		color: #fff !important;
		font-weight: 500 !important;
	}

	#main-content > h3 { 
		color: #fff;
		font-weight: 300;
		text-align: center;
		margin-bottom: 15px !important;
	}

	#main-content h3 > i { 
		font-size: 1.75rem;
		padding-right: 5px !important;
	}

	#main-content .btn { 
		font-weight: 500;
		letter-spacing: 0.5px;
		margin-bottom: 10px !important;
	}

	#main-content a, #main-content a:hover { 
		color: #fff !important;
		text-decoration: none !important;
		font-weight: 600 !important;
		text-align: center !important;
		margin-top: 15px !important;
	}

	#main-content .alert ul { 
		list-style: none !important;
		padding-left: 0 !important;
		margin-bottom: 0 !important;
	}

	/* iphone 4/4s - portrait */
	@media only screen 
  	and (min-device-width: 320px) 
  	and (max-device-width: 480px)
  	and (-webkit-min-device-pixel-ratio: 2)
  	and (orientation: portrait) {
  		#main-content h1 { 
  			font-size: 22px;
  		}
	}

	/* iphone 5/5s/5c - portrait */
	@media only screen 
	and (min-device-width: 320px) 
	and (max-device-width: 568px)
	and (-webkit-min-device-pixel-ratio: 2)
	and (orientation: portrait) {

	}

	/* iphone 6/7 - portrait */
	@media only screen 
	and (min-device-width: 375px) 
	and (max-device-width: 667px) 
	and (-webkit-min-device-pixel-ratio: 2) { 

	}

	/* iphone 6+/7+/8+ - portrait */
	@media only screen 
	and (min-device-width: 414px) 
	and (max-device-width: 736px) 
	and (-webkit-min-device-pixel-ratio: 3)
	and (orientation: portrait) { 
		#main-content h1 { 
  			font-size: 28px;
  		}
	}

	/* iphone x - portrait */
	@media only screen 
	and (min-device-width: 375px) 
	and (max-device-width: 812px) 
	and (-webkit-min-device-pixel-ratio: 3)
	and (orientation: portrait) { 
		#main-content h1 { 
  			font-size: 28px;
  		}
	}

</style>